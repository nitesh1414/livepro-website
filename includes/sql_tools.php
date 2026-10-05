<?php
/**
 * ============================================================================
 * LIVEpro Software Solutions - Portable SQL Toolkit
 * ----------------------------------------------------------------------------
 * Robust SQL statement splitter + small helpers used by the installers
 * (install.php / setup.php).
 *
 * WHY THIS FILE EXISTS
 * The installers used to split schema.sql with this heuristic:
 *
 *     preg_split("/;+(?=([^'|^\\']*['|\\'][^'|^\\']*['|\\'])*[^'|^\\']*$)/", $sql);
 *
 * That pattern only splits on a `;` when the REST of the file happens to
 * contain an even number of `'` / `|` characters. A single `|` inside a seeded
 * string (e.g. the announcement ticker) flips that parity, so every statement
 * before it - including `CREATE TABLE admin_users` and `CREATE TABLE
 * site_settings` - got merged into one chunk together with `CREATE DATABASE`.
 * The installer skips chunks containing `CREATE DATABASE`, so those tables were
 * never created and the install crashed with:
 *     SQLSTATE[42S02]: Base table or view not found: 1146
 *     Table 'livepro_cms_db.admin_users' doesn't exist
 *
 * The splitter below is a deterministic single-pass scanner (O(n)) that
 * understands strings, escapes, identifiers and comments, so it can never
 * mis-handle quotes, emoji, `|` characters or any other content in the dump.
 * ============================================================================
 */

/**
 * Split a raw SQL dump into individual statements.
 *
 * Understands:
 *   - single quoted strings  ('...') with backslash escapes and '' doubling
 *   - double quoted strings  ("...") with backslash escapes and "" doubling
 *   - backtick identifiers   (`...`) with `` doubling
 *   - line comments          (-- ... and # ...)
 *   - block comments         (/* ... *\/)
 *   - routine bodies         (BEGIN ... END; is treated like plain SQL)
 *
 * @param  string $sql
 * @return array<int,string> Statements without their trailing semicolon.
 */
function livepro_split_sql($sql) {
    $statements = [];
    $buffer = '';
    $length = strlen($sql);
    $i = 0;

    while ($i < $length) {
        $ch = $sql[$i];
        $next = ($i + 1 < $length) ? $sql[$i + 1] : '';

        // --- single quoted string -------------------------------------------
        if ($ch === "'") {
            $buffer .= $ch;
            $i++;
            while ($i < $length) {
                $c = $sql[$i];
                if ($c === '\\' && $i + 1 < $length) {          // \' \" \\ ...
                    $buffer .= $c . $sql[$i + 1];
                    $i += 2;
                    continue;
                }
                if ($c === "'") {
                    if ($i + 1 < $length && $sql[$i + 1] === "'") {  // '' escape
                        $buffer .= "''";
                        $i += 2;
                        continue;
                    }
                    $buffer .= $c;                                // closing quote
                    $i++;
                    break;
                }
                $buffer .= $c;
                $i++;
            }
            continue;
        }

        // --- double quoted string / identifier -------------------------------
        if ($ch === '"') {
            $buffer .= $ch;
            $i++;
            while ($i < $length) {
                $c = $sql[$i];
                if ($c === '\\' && $i + 1 < $length) {
                    $buffer .= $c . $sql[$i + 1];
                    $i += 2;
                    continue;
                }
                if ($c === '"') {
                    if ($i + 1 < $length && $sql[$i + 1] === '"') {  // "" escape
                        $buffer .= '""';
                        $i += 2;
                        continue;
                    }
                    $buffer .= $c;
                    $i++;
                    break;
                }
                $buffer .= $c;
                $i++;
            }
            continue;
        }

        // --- backtick identifier --------------------------------------------
        if ($ch === '`') {
            $buffer .= $ch;
            $i++;
            while ($i < $length) {
                $c = $sql[$i];
                if ($c === '`') {
                    if ($i + 1 < $length && $sql[$i + 1] === '`') {   // `` escape
                        $buffer .= '``';
                        $i += 2;
                        continue;
                    }
                    $buffer .= $c;
                    $i++;
                    break;
                }
                $buffer .= $c;
                $i++;
            }
            continue;
        }

        // --- line comments (-- and #) ---------------------------------------
        if (($ch === '-' && $next === '-') || $ch === '#') {
            if ($ch === '-' && $next === '-') {
                $buffer .= '--';
                $i += 2;
            } else {
                $buffer .= $ch;
                $i++;
            }
            while ($i < $length && $sql[$i] !== "\n") {
                $buffer .= $sql[$i];
                $i++;
            }
            continue;   // the newline (if any) is handled by the main loop
        }

        // --- block comment --------------------------------------------------
        if ($ch === '/' && $next === '*') {
            $buffer .= '/*';
            $i += 2;
            while ($i < $length) {
                if ($sql[$i] === '*' && ($i + 1) < $length && $sql[$i + 1] === '/') {
                    $buffer .= '*/';
                    $i += 2;
                    break;
                }
                $buffer .= $sql[$i];
                $i++;
            }
            continue;
        }

        // --- statement terminator -------------------------------------------
        if ($ch === ';') {
            $statements[] = $buffer;
            $buffer = '';
            $i++;
            continue;
        }

        $buffer .= $ch;
        $i++;
    }

    if (trim($buffer) !== '') {
        $statements[] = $buffer;
    }

    // Drop empty / comment-only statements
    $clean = [];
    foreach ($statements as $statement) {
        if (livepro_sql_strip_comments($statement) !== '') {
            $clean[] = trim($statement);
        }
    }
    return $clean;
}

/**
 * Remove SQL comments (line + block) while keeping string literals intact.
 *
 * @param  string $sql
 * @return string
 */
function livepro_sql_strip_comments($sql) {
    $out = '';
    $length = strlen($sql);
    $i = 0;

    while ($i < $length) {
        $ch = $sql[$i];
        $next = ($i + 1 < $length) ? $sql[$i + 1] : '';

        // Keep string / identifier contents exactly as they are
        if ($ch === "'" || $ch === '"' || $ch === '`') {
            $quote = $ch;
            $out .= $ch;
            $i++;
            while ($i < $length) {
                $c = $sql[$i];
                if ($c === '\\' && $i + 1 < $length) {
                    $out .= $c . $sql[$i + 1];
                    $i += 2;
                    continue;
                }
                if ($c === $quote) {
                    if ($i + 1 < $length && $sql[$i + 1] === $quote) {  // doubled
                        $out .= $quote . $quote;
                        $i += 2;
                        continue;
                    }
                    $out .= $c;
                    $i++;
                    break;
                }
                $out .= $c;
                $i++;
            }
            continue;
        }

        if (($ch === '-' && $next === '-') || $ch === '#') {
            while ($i < $length && $sql[$i] !== "\n") {
                $i++;
            }
            continue;
        }

        if ($ch === '/' && $next === '*') {
            $i += 2;
            while ($i < $length && !($sql[$i] === '*' && ($i + 1) < $length && $sql[$i + 1] === '/')) {
                $i++;
            }
            $i += 2;
            continue;
        }

        $out .= $ch;
        $i++;
    }

    return trim($out);
}

/**
 * First keyword(s) of a statement, e.g. "CREATE TABLE", "INSERT INTO", "USE".
 * Comments and leading whitespace are skipped.
 *
 * @param  string $statement
 * @return string
 */
function livepro_sql_first_keyword($statement) {
    $clean = ltrim(livepro_sql_strip_comments($statement));
    if ($clean === '') {
        return '';
    }

    if (!preg_match('/^([A-Za-z_]+)(?:\s+([A-Za-z_]+))?/', $clean, $m)) {
        return '';
    }

    $first = strtoupper($m[1]);
    $second = isset($m[2]) ? strtoupper($m[2]) : '';

    $multi_word = [
        'CREATE'   => ['DATABASE', 'SCHEMA', 'TABLE', 'INDEX', 'VIEW', 'TRIGGER', 'PROCEDURE', 'FUNCTION'],
        'DROP'     => ['TABLE', 'DATABASE', 'SCHEMA', 'VIEW'],
        'INSERT'   => ['INTO'],
        'REPLACE'  => ['INTO'],
        'DELETE'   => ['FROM'],
        'TRUNCATE' => ['TABLE'],
        'ALTER'    => ['TABLE'],
        'SET'      => ['NAMES', 'FOREIGN_KEY_CHECKS', 'SQL_MODE'],
        'LOCK'     => ['TABLES'],
        'UNLOCK'   => ['TABLES'],
    ];

    if (isset($multi_word[$first]) && in_array($second, $multi_word[$first], true)) {
        return $first . ' ' . $second;
    }

    return $first;
}

/**
 * Statements that only configure the connection / environment and must not be
 * executed by the installer (the connection already selects the target DB).
 *
 * @param  string $keyword Result of livepro_sql_first_keyword()
 * @return bool
 */
function livepro_sql_is_environment_statement($keyword) {
    return in_array($keyword, ['CREATE DATABASE', 'CREATE SCHEMA', 'USE', 'SET NAMES', 'SET SQL_MODE', 'LOCK TABLES', 'UNLOCK TABLES'], true);
}

/**
 * Cross-driver check whether a table exists in the current database.
 *
 * @param  PDO    $pdo
 * @param  string $table
 * @return bool
 */
function livepro_table_exists($pdo, $table) {
    try {
        $driver = $pdo->getAttribute(PDO::ATTR_DRIVER_NAME);

        if ($driver === 'sqlite') {
            $stmt = $pdo->prepare("SELECT name FROM sqlite_master WHERE type IN ('table','view') AND name = ?");
            $stmt->execute([$table]);
            return (bool) $stmt->fetchColumn();
        }

        // MySQL / MariaDB
        $stmt = $pdo->prepare("SELECT COUNT(*) FROM information_schema.tables WHERE table_schema = DATABASE() AND table_name = ?");
        $stmt->execute([$table]);
        return intval($stmt->fetchColumn()) > 0;
    } catch (PDOException $e) {
        return false;
    }
}
