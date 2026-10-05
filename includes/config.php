<?php
/**
 * LIVEpro Software Solutions x TCS Enterprise Theme (LP Geometric Logo Theme)
 * Complete Multipage CMS Portal - Database Configuration & Initialization
 * Pure Corporate IT Consulting, Website & Mobile App Dev, & Client Projects
 */

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// ============================================================================
// 1. DATABASE CONFIGURATION (MySQL / MariaDB Primary)
// ============================================================================
define('DB_HOST', 'localhost');
define('DB_NAME', 'livepro_cms_db');
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_CHARSET', 'utf8mb4');

// Fallback SQLite file for zero-config local development if MySQL is offline
define('SQLITE_FALLBACK_FILE', __DIR__ . '/../data/livepro_fallback.sqlite');

// Site Constants
define('SITE_NAME', 'LIVEpro Software Solutions');
define('ADMIN_DEMO_USER', 'admin');
define('ADMIN_DEMO_PASS', 'livepro2026');

/**
 * Get Singleton PDO Database Connection
 */
function get_db_connection() {
    static $pdo = null;
    if ($pdo !== null) {
        return $pdo;
    }

    // Attempt MySQL Connection
    try {
        $dsn = "mysql:host=" . DB_HOST . ";dbname=" . DB_NAME . ";charset=" . DB_CHARSET;
        $options = [
            PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES   => false,
        ];
        $pdo = new PDO($dsn, DB_USER, DB_PASS, $options);
        return $pdo;
    } catch (PDOException $e) {
        // MySQL connection failed - use SQLite fallback for local testing
        try {
            if (!file_exists(dirname(SQLITE_FALLBACK_FILE))) {
                mkdir(dirname(SQLITE_FALLBACK_FILE), 0777, true);
            }
            $is_new_sqlite = !file_exists(SQLITE_FALLBACK_FILE);
            $pdo = new PDO("sqlite:" . SQLITE_FALLBACK_FILE, null, null, [
                PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
            ]);

            if ($is_new_sqlite) {
                seed_sqlite_fallback($pdo);
            }
            return $pdo;
        } catch (PDOException $sqlite_e) {
            die("<div style='font-family:sans-serif; padding:30px; background:#fef2f2; color:#991b1b; border:1px solid #f87171; border-radius:8px; max-width:600px; margin:50px auto;'>
                <h2 style='margin-top:0;'>🟢 Database Connection Error</h2>
                <p>Could not connect to MySQL database (<code>" . DB_NAME . "</code>) and SQLite fallback also failed.</p>
                <p><strong>MySQL Error:</strong> " . htmlspecialchars($e->getMessage()) . "</p>
                <hr style='border:none; border-top:1px solid #fca5a5;'>
                <p style='font-size:0.9em;'>Please run <code>install.php</code> or import <code>schema.sql</code> into your MySQL server.</p>
            </div>");
        }
    }
}

/**
 * Helper: Seed SQLite database if MySQL is unavailable (All 14 Tables - bg_image included)
 */
function seed_sqlite_fallback($pdo) {
    // Create all 14 tables
    $pdo->exec("
        CREATE TABLE IF NOT EXISTS admin_users (id INTEGER PRIMARY KEY AUTOINCREMENT, username TEXT UNIQUE, password_hash TEXT, email TEXT, full_name TEXT, role TEXT DEFAULT 'superadmin', created_at DATETIME DEFAULT CURRENT_TIMESTAMP);
        CREATE TABLE IF NOT EXISTS site_settings (id INTEGER PRIMARY KEY AUTOINCREMENT, setting_key TEXT UNIQUE, setting_value TEXT, setting_group TEXT DEFAULT 'general');
        CREATE TABLE IF NOT EXISTS hero_banners (id INTEGER PRIMARY KEY AUTOINCREMENT, badge_text TEXT, title TEXT, subtitle TEXT, cta_text TEXT, cta_url TEXT, bg_image TEXT DEFAULT 'assets/images/banner1.jpg', bg_gradient TEXT DEFAULT 'navy-blue', display_order INTEGER DEFAULT 0, status TEXT DEFAULT 'active');
        CREATE TABLE IF NOT EXISTS feature_panels (id INTEGER PRIMARY KEY AUTOINCREMENT, panel_group TEXT, title TEXT, description TEXT, icon TEXT, link_text TEXT, link_url TEXT, display_order INTEGER DEFAULT 0, status TEXT DEFAULT 'active');
        CREATE TABLE IF NOT EXISTS case_studies (id INTEGER PRIMARY KEY AUTOINCREMENT, title TEXT, client_industry TEXT, metric_highlight TEXT, summary TEXT, full_details TEXT, display_order INTEGER DEFAULT 0, status TEXT DEFAULT 'active');
        CREATE TABLE IF NOT EXISTS services (id INTEGER PRIMARY KEY AUTOINCREMENT, title TEXT, category TEXT, short_desc TEXT, full_desc TEXT, icon TEXT, featured INTEGER DEFAULT 1, status TEXT DEFAULT 'active', display_order INTEGER DEFAULT 0);
        CREATE TABLE IF NOT EXISTS industries (id INTEGER PRIMARY KEY AUTOINCREMENT, name TEXT, description TEXT, display_order INTEGER);
        CREATE TABLE IF NOT EXISTS blog_posts (id INTEGER PRIMARY KEY AUTOINCREMENT, title TEXT, slug TEXT UNIQUE, category TEXT, author TEXT, publish_date TEXT, excerpt TEXT, content TEXT, status TEXT DEFAULT 'published', views INTEGER DEFAULT 0);
        CREATE TABLE IF NOT EXISTS testimonials (id INTEGER PRIMARY KEY AUTOINCREMENT, name TEXT, role TEXT, quote TEXT, rating INTEGER DEFAULT 5, type TEXT DEFAULT 'Enterprise Client');
        CREATE TABLE IF NOT EXISTS inquiries (id INTEGER PRIMARY KEY AUTOINCREMENT, name TEXT, email TEXT, phone TEXT, subject TEXT, message TEXT, status TEXT DEFAULT 'new', created_at DATETIME DEFAULT CURRENT_TIMESTAMP);
        CREATE TABLE IF NOT EXISTS job_openings (id INTEGER PRIMARY KEY AUTOINCREMENT, title TEXT, department TEXT DEFAULT 'Software Engineering', location TEXT DEFAULT 'Nagpur / Hybrid', type TEXT DEFAULT 'Full-Time', experience TEXT DEFAULT '2-5 Years', salary TEXT DEFAULT 'Best in Industry', description TEXT, requirements TEXT, status TEXT DEFAULT 'active', display_order INTEGER DEFAULT 0);
        CREATE TABLE IF NOT EXISTS job_applications (id INTEGER PRIMARY KEY AUTOINCREMENT, job_id INTEGER, job_title TEXT, applicant_name TEXT, email TEXT, phone TEXT, resume_link TEXT, cover_letter TEXT, status TEXT DEFAULT 'new', created_at DATETIME DEFAULT CURRENT_TIMESTAMP);
        CREATE TABLE IF NOT EXISTS projects_portfolio (id INTEGER PRIMARY KEY AUTOINCREMENT, title TEXT, client_name TEXT, category TEXT DEFAULT 'Web & Cloud Portals', industry TEXT, tech_stack TEXT, challenge TEXT, solution TEXT, results TEXT, featured INTEGER DEFAULT 1, status TEXT DEFAULT 'active', display_order INTEGER DEFAULT 0);
        CREATE TABLE IF NOT EXISTS expertise_areas (id INTEGER PRIMARY KEY AUTOINCREMENT, title TEXT, category TEXT DEFAULT 'Core Engineering', description TEXT, tech_list TEXT, icon TEXT DEFAULT 'code', proficiency INTEGER DEFAULT 95, status TEXT DEFAULT 'active', display_order INTEGER DEFAULT 0);
        CREATE TABLE IF NOT EXISTS leaders_mentors (id INTEGER PRIMARY KEY AUTOINCREMENT, name TEXT NOT NULL, designation TEXT NOT NULL, member_type TEXT DEFAULT 'Leader', bio TEXT DEFAULT '', photo TEXT DEFAULT '', expertise TEXT DEFAULT '', experience_years TEXT DEFAULT '', email TEXT DEFAULT '', phone TEXT DEFAULT '', linkedin_url TEXT DEFAULT '', twitter_url TEXT DEFAULT '', status TEXT DEFAULT 'active', display_order INTEGER DEFAULT 0, created_at DATETIME DEFAULT CURRENT_TIMESTAMP);
    ");

    // Insert Default Settings
    $settings = [
        ['company_name', 'LIVEpro Software Solutions', 'branding'],
        ['tagline', 'RIGHT TIME... RIGHT PLACE... RIGHT PEOPLE...', 'branding'],
        ['sub_tagline', 'We provide a wide range of solutions and services across various verticals in Information Technologies like Website Development, Mobile App Development, Customized Software Solutions, Testing, Onsite Service and Support, Platform Delivery, Networking, Outsourcing and Application Management AMC Support.', 'branding'],
        ['announcement_active', '1', 'announcement'],
        ['announcement_text', '🚀 LP Geometric Theme | Custom Website Development, Mobile Apps & 24/7 AMC Maintenance Services in Nagpur & Global', 'announcement'],
        ['announcement_url', 'expertise.php', 'announcement'],
        ['office_address', 'G-9B, Sidhhesh Sai Darshan Apartment, Raghuji Nagar, Nagpur, Maharashtra, India', 'contact'],
        ['phone_numbers', '+91-712-274-0470, +91-940-448-4560, +91-956-107-9560', 'contact'],
        ['email_addresses', 'admin@liveprosolutions.com, niteshg@liveprosolutions.com', 'contact'],
        ['operating_hours', 'Mon - Sat: 9:30 AM to 7:30 PM (Sunday Closed)', 'contact'],
        ['copyright_year', '2026', 'general'],
        ['stat_years', '15+', 'stats'],
        ['stat_projects', '500+', 'stats'],
        ['stat_engineers', '120+', 'stats'],
        ['stat_industries', '16+', 'stats']
    ];
    $stmt = $pdo->prepare("INSERT OR IGNORE INTO site_settings (setting_key, setting_value, setting_group) VALUES (?, ?, ?)");
    foreach ($settings as $row) { $stmt->execute($row); }

    // Insert Default Admin
    $stmt = $pdo->prepare("INSERT OR IGNORE INTO admin_users (id, username, password_hash, email, full_name, role) VALUES (1, 'admin', ?, 'admin@liveprosolutions.com', 'System Administrator', 'superadmin')");
    $stmt->execute(['$2y$10$e8w.xZ0M4F5P7E3rU9qN1e8w.xZ0M4F5P7E3rU9qN1u/a1B2c3D4e']);

    // Seed Banners with bg_image
    $pdo->exec("INSERT INTO hero_banners (badge_text, title, subtitle, cta_text, cta_url, bg_image, bg_gradient, display_order, status) VALUES 
    ('PERPETUALLY ADAPTIVE IT', 'Building on Belief: Custom Website & Mobile App Dev', 'Transforming corporate business models through enterprise web applications, native & hybrid mobile apps, and cloud-native software architecture.', 'Explore Our Expertise', 'expertise.php', 'assets/images/banner1.jpg', 'navy-blue', 10, 'active'),
    ('END-TO-END IT CONSULTING', 'Custom Software Projects & Systems Integration', 'We deliver comprehensive software solutions from architectural requirement analysis to full-cycle development, cloud deployment, and legacy re-engineering.', 'View Clients & Projects', 'projects.php', 'assets/images/banner2.jpg', 'emerald-teal', 20, 'active'),
    ('ZERO DOWNTIME RE-ENGINEERING', '24/7 AMC & Infrastructure Maintenance Support', 'Ensure continuous business uptime with scheduled hardware diagnostics, database tuning, API integration, and proactive security patching AMCs.', 'Request Consultation', 'contact.php', 'assets/images/banner3.jpg', 'purple-indigo', 30, 'active');");

    // Seed Feature Panels
    $pdo->exec("INSERT INTO feature_panels (panel_group, title, description, icon, link_text, link_url, display_order, status) VALUES 
    ('why_us', 'Flexible Client Engagement', 'Tailored pricing models, agile team scaling, and adaptable delivery sprints designed around your core business KPIs.', 'refresh', 'Read Engagement Model', 'about.php', 10, 'active'),
    ('why_us', 'Well-Defined Methodologies', 'Rigorous SDLC methodologies, DevOps automated testing, and CI/CD pipelines ensuring high code quality and rapid market delivery.', 'code', 'Explore Methodologies', 'about.php', 20, 'active'),
    ('why_us', 'Rigorous Project Management', 'Achieving the optimal combination of cost, quality, and speed through ISO-certified quality practices and milestone governance.', 'award', 'View Quality Assurance', 'about.php', 30, 'active'),
    ('why_us', 'Global & Domestic Perspective', 'A perfect blend of Indian engineering excellence and international business insight to tackle domestic and global IT challenges.', 'globe', 'Our Global Reach', 'about.php', 40, 'active'),
    ('capabilities', 'Website & Web Apps', 'Custom enterprise web portals, progressive web apps (PWAs), e-commerce systems, and high-performance cloud web architectures.', 'code', 'Explore Web Dev', 'expertise.php', 10, 'active'),
    ('capabilities', 'Mobile App Development', 'Native iOS & Android apps, cross-platform Flutter & React Native enterprise mobile solutions, and field sales tracking tools.', 'cpu', 'Explore Mobile Apps', 'expertise.php', 20, 'active'),
    ('capabilities', 'Systems Integration & Re-Engineering', 'Modernization of monolithic legacy systems, seamless REST API integration, database migration, and enterprise workflow restructuring.', 'refresh', 'Re-Engineering', 'services.php', 30, 'active'),
    ('capabilities', '24/7 AMC Maintenance & Support', 'Proactive hardware diagnostics, software version management, database tuning, and continuous uptime monitoring AMCs.', 'server', 'View AMC Services', 'services.php', 40, 'active');");

    // Seed Case Studies
    $pdo->exec("INSERT INTO case_studies (title, client_industry, metric_highlight, summary, full_details, display_order, status) VALUES 
    ('Core Banking System Re-Engineering & Web Portal Dev', 'Banking & Financial Services', '40% Speed Boost', 'Modernized a monolithic core banking platform for Vidarbha Financial Services into agile cloud microservices and responsive web apps.', 'LIVEpro engineering team conducted a comprehensive architectural audit, refactored legacy database schemas, and built a modern React.js web banking portal with secure RESTful payment gateway integrations. Transaction throughput increased by 40% while annual infrastructure maintenance costs dropped by 25%.', 10, 'active'),
    ('Enterprise Mobile Fleet Tracking App & AMC Maintenance', 'Logistics & Supply Chain', '99.99% Uptime AMC', 'Deployed 24/7 AMC maintenance and built a native mobile fleet tracking app for over 200 cargo vehicles across Central India.', 'Through proactive database tuning, automated patch management, and real-time GPS mobile app API orchestration, LIVEpro eliminated system downtime for Central Logistics, ensuring 24/7 operational continuity and mobile driver compliance.', 20, 'active');");

    // Seed Services
    $services = [
        ['Website Development & Web Portals', 'Web & Mobile', 'Custom enterprise website development, e-commerce web applications, progressive web apps (PWAs), and scalable cloud web architectures.', 'We deliver full-cycle website development services from requirement analysis and UI/UX design to robust backend coding and cloud deployment. Our team builds high-concurrency web portals using React, Angular, Node.js, PHP, Python Django, and Java Spring Boot.', 'code', 1, 'active', 10],
        ['Mobile App Development (iOS & Android)', 'Web & Mobile', 'Native iOS & Android mobile applications, cross-platform Flutter & React Native enterprise mobile solutions, and field sales tools.', 'Engage your customers and workforce on the go. We architect secure, user-friendly mobile applications integrated with enterprise ERPs, payment gateways, GPS geolocation tracking, and real-time cloud push notifications.', 'cpu', 1, 'active', 20],
        ['Hardware & Software Maintenance AMC', 'Corporate IT', '24/7 Annual Maintenance Contracts (AMC), proactive infrastructure upkeep, system optimization, database tuning, and security patching.', 'Ensure continuous uptime and optimal performance for your business-critical systems. We provide scheduled hardware diagnostics, software version management, database tuning, and immediate incident troubleshooting to eliminate operational downtime.', 'server', 1, 'active', 30],
        ['Systems Integration & Re-Engineering', 'Corporate IT', 'Modernization of legacy systems, seamless API integration, database migration, and enterprise workflow restructuring without downtime.', 'Transform your legacy IT infrastructure into modern, agile systems without business disruption. We specialize in API orchestration, ERP/CRM integrations, cloud migration, and refactoring monolithic architectures into cloud-ready microservices.', 'refresh', 1, 'active', 40],
        ['Network Services & Cybersecurity', 'Corporate IT', 'Secure network design, corporate LAN/WAN implementation, VPN administration, firewall configuration, and cybersecurity audits.', 'Build a resilient and high-speed network backbone for your enterprise. Our network engineers handle routing, switching, wireless enterprise setup, network virtualization, and multi-layer firewall defense against cyber threats.', 'network', 1, 'active', 50],
        ['AI & Cognitive Business Operations', 'AI & Platforms', 'Empowering enterprises with artificial intelligence, machine learning data pipelines, LLM integration, and automated workflow intelligence.', 'Harness the power of enterprise AI. We build data lakes, train predictive models, and integrate generative AI assistants into your operational workflows to automate repetitive tasks and generate deep business insights.', 'cpu', 1, 'active', 60],
        ['Custom Software & Desktop Applications', 'Corporate IT', 'Tailored desktop software, warehouse management systems (WMS), inventory tracking ERPs, and bespoke business automation suites.', 'We design and program customized standalone desktop applications for Windows, macOS, and Linux that integrate seamlessly with local hardware peripherals, barcode scanners, and central databases.', 'code', 1, 'active', 70]
    ];
    $stmt = $pdo->prepare("INSERT INTO services (title, category, short_desc, full_desc, icon, featured, status, display_order) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
    foreach ($services as $srv) { $stmt->execute($srv); }

    // Seed Industries
    $industries = ['Banking & Financial Services', 'eCommerce & Retail', 'Healthcare & Medical', 'Entertainment & Media', 'Embedded Systems', 'Logistics & Supply Chain', 'Human Resource & Staffing', 'Insurance Services', 'IT Enabled Services (ITES)', 'Networking & Telecomm', 'Pharmaceuticals', 'Real Time Control Systems', 'Travel & Transportation', 'Recruiting Firms', 'Education & Academic Enablement', 'Government & PSU'];
    $stmt = $pdo->prepare("INSERT INTO industries (name, display_order) VALUES (?, ?)");
    foreach ($industries as $idx => $name) { $stmt->execute([$name, $idx + 1]); }

    // Seed Blog
    $pdo->exec("INSERT INTO blog_posts (title, slug, category, author, publish_date, excerpt, content, status, views) VALUES 
    ('Why Modern Website Development Architecture Requires API Decoupling', 'why-modern-website-development-requires-api-decoupling', 'Web Development', 'Nitesh G.', '2026-06-15', 'Discover how separating frontend UI presentation from backend database logic transforms corporate website performance and security.', 'At LIVEpro Software Solutions, we recognize that traditional monolithic website architectures struggle under modern traffic demands.', 'published', 245),
    ('The Rise of Cross-Platform Mobile App Development in Enterprise IT', 'rise-of-cross-platform-mobile-app-development', 'Mobile Apps', 'Tech Solutions Team', '2026-05-28', 'How Flutter and React Native are allowing corporate organizations to deploy high-performance iOS and Android mobile apps in half the time.', 'In today mobile-first business environment, corporate clients require native-quality mobile applications for both iOS and Android without doubling their engineering budgets.', 'published', 189);");

    // Seed Testimonials
    $pdo->exec("INSERT INTO testimonials (name, role, quote, rating, type) VALUES 
    ('Rajeshwar Rao', 'IT Director, Vidarbha Financial Services', 'LIVEpro Software Solutions handled our core banking web portal development and API re-engineering with exceptional professionalism. Their Nagpur team delivered on time and within budget, improving transaction processing speed by 40%.', 5, 'Enterprise Client'),
    ('Amitabh Sharma', 'Operations Manager, Central Logistics', 'We rely on LIVEpro for our 24/7 Hardware & Software Maintenance AMC and mobile fleet tracking app. Their proactive response time and technical depth give us complete peace of mind.', 5, 'Enterprise Client');");

    // Seed Job Openings
    $pdo->exec("INSERT INTO job_openings (title, department, location, type, experience, salary, description, requirements, status, display_order) VALUES 
    ('Senior Full Stack Web Architect', 'Website Development', 'Nagpur HQ / Hybrid', 'Full-Time', '5-8 Years', '₹12L - ₹18L PA', 'Lead the architectural design and full-cycle coding for custom enterprise web applications and e-commerce web portals.', 'Expertise in React.js, Next.js, Node.js, PHP, or Java Spring Boot.', 'active', 10),
    ('Senior Mobile App Lead (iOS & Android)', 'Mobile Development', 'Nagpur HQ / Hybrid', 'Full-Time', '4-7 Years', '₹10L - ₹16L PA', 'Architect and develop native iOS/Android apps and cross-platform enterprise mobile applications using Flutter and React Native.', 'Proven portfolio of published apps on Apple App Store and Google Play.', 'active', 20);");

    // Seed Applications
    $pdo->exec("INSERT INTO job_applications (job_id, job_title, applicant_name, email, phone, resume_link, cover_letter, status, created_at) VALUES 
    (1, 'Senior Full Stack Web Architect', 'Rohan Kulkarni', 'rohan.k@techmail.com', '+91 98221 33445', 'https://linkedin.com/in/rohan-demo-resume', 'I have 6 years of experience building high-performance web applications in React and Java Spring Boot.', 'new', '2026-06-29 11:20:00');");

    // Seed Projects
    $pdo->exec("INSERT INTO projects_portfolio (title, client_name, category, industry, tech_stack, challenge, solution, results, featured, status, display_order) VALUES 
    ('Vidarbha Financial Core Banking Web Portal Re-Engineering', 'Vidarbha Financial Services', 'Web & Cloud Portals', 'Banking & Finance', 'React.js, Spring Boot, Microservices, PostgreSQL, Docker, AWS', 'Monolithic core banking platform struggling under heavy mobile transaction volume and experiencing high latency during peak hours.', 'Refactored the core monolithic database into microservices, built a modern responsive React web banking portal, and deployed automated CI/CD deployment pipelines on AWS.', '40% increase in transaction processing speed, 99.999% uptime during fiscal quarter close, and 25% reduction in cloud server costs.', 1, 'active', 10),
    ('Central Logistics Mobile Fleet Tracking App & AMC Support', 'Central Logistics & Transport', 'Mobile Enterprise Apps', 'Logistics & Supply Chain', 'Flutter, React Native, Node.js, GPS REST APIs, MySQL', 'Legacy fleet tracking required manual database intervention and lacked native mobile apps for field drivers across 200 cargo vehicles.', 'Built a cross-platform Flutter mobile app for drivers with real-time GPS telemetry, offline SQLite sync, and provided 24/7 AMC hardware/software maintenance.', 'Real-time live tracking for 200+ trucks, zero security incidents over 3 fiscal years, and 30% increase in fleet delivery efficiency.', 1, 'active', 20),
    ('Omnichannel E-Commerce POS Web System', 'Retail Omnichannel Corp', 'Web & Cloud Portals', 'eCommerce & Retail', 'Next.js, TypeScript, PHP Laravel, MySQL, Redis, Stripe API', 'Fragmented inventory databases between 15 physical retail store locations and online e-commerce website, causing frequent out-of-stock errors.', 'Developed a centralized e-commerce web portal with real-time inventory synchronization across all store POS terminals and lightning-fast Redis product caching.', '35% increase in online web sales conversion rate within six months and 100% real-time inventory accuracy across 15 store locations.', 1, 'active', 30);");

    // Seed Expertise
    $pdo->exec("INSERT INTO expertise_areas (title, category, description, tech_list, icon, proficiency, status, display_order) VALUES 
    ('Website Development & Web Applications', 'Core Engineering', 'Custom enterprise web portals, e-commerce platforms, progressive web apps (PWAs), and scalable cloud web systems built for high traffic and top security.', 'React.js, Next.js, Angular, Node.js, PHP Laravel, Python Django, Java Spring Boot, MySQL', 'code', 98, 'active', 10),
    ('Mobile App Development (iOS & Android)', 'Core Engineering', 'Native iOS & Android apps and cross-platform enterprise mobile solutions featuring GPS geolocation, offline sync, and bank-grade encryption.', 'Flutter, Dart, React Native, Swift, Kotlin, SQLite Offline Sync, Firebase, REST APIs', 'cpu', 96, 'active', 20),
    ('Custom Software & Desktop Applications', 'Core Engineering', 'Tailored standalone desktop applications, inventory ERPs, warehouse management systems (WMS), and bespoke business automation suites.', 'Java FX, Electron, C#, Python PyQt, Windows .NET, Linux Standalone Apps, MySQL', 'code', 95, 'active', 30),
    ('Cloud Architecture & DevOps Automation', 'Cloud DevOps', 'Architecting automated CI/CD deployment pipelines, container orchestration grids, and serverless cloud ecosystems for continuous availability.', 'AWS (EC2, S3, RDS, EKS), Azure, Google Cloud, Docker, Kubernetes, Terraform, Jenkins', 'cloud', 94, 'active', 40),
    ('Systems Integration & Re-Engineering', 'Core Engineering', 'Modernization of monolithic legacy systems, API decoupling, database migration, and enterprise middleware integration without downtime.', 'REST & GraphQL APIs, Microservices, Middleware Orchestration, Legacy DB Migration', 'refresh', 96, 'active', 50),
    ('Artificial Intelligence & Cognitive Operations', 'AI & Intelligence', 'Deploying machine learning predictive models, custom data pipelines, and integrating Generative AI assistants into operational software.', 'Python, PyTorch, Scikit-Learn, Pandas, OpenAI API, Claude Anthropic, Vector DBs', 'cpu', 92, 'active', 60),
    ('Embedded Systems & Industrial IoT', 'Embedded Hardware', 'Programming ARM Cortex microcontrollers, RTOS firmware, and wireless MQTT sensor telemetry for industrial manufacturing automation.', 'Embedded C/C++, ARM Cortex AVR, FreeRTOS, MQTT, BLE, Wi-Fi Sensor Interfacing', 'cpu', 96, 'active', 70),
    ('24/7 Hardware & Software AMC Maintenance', 'Managed Support', 'Scheduled system diagnostics, database performance tuning, security patch management, and continuous uptime AMC infrastructure contracts.', 'Proactive Health Monitoring, Database Indexing, Patch Management, AMC SLA Contracts', 'server', 98, 'active', 80);");

    // Seed Leaders & Mentors (About Us page)
    $pdo->exec("INSERT INTO leaders_mentors (name, designation, member_type, bio, photo, expertise, experience_years, email, phone, linkedin_url, twitter_url, status, display_order) VALUES 
    ('Nitesh G.', 'Founder & Chief Executive Officer', 'Leader', 'Founded LIVEpro Software Solutions in Nagpur with a simple belief - the right people, at the right time, in the right place can transform how an enterprise runs. Nitesh leads corporate strategy, client partnerships and the long-term technology roadmap across domestic and international engagements.', '', 'Enterprise Strategy, Client Partnerships, Solution Architecture', '18+ Years', 'niteshg@liveprosolutions.com', '+91-940-448-4560', 'https://www.linkedin.com/company/livepro-solutions', '', 'active', 10),
    ('Priya Deshmukh', 'Chief Technology Officer', 'Leader', 'Priya owns the LIVEpro engineering practice - technology standards, architecture reviews and the delivery of high-concurrency web and mobile platforms for corporate clients. She drives the adoption of microservices, cloud-native tooling and secure coding practices across every project pod.', '', 'Java Spring Boot, Microservices, Cloud Architecture (AWS / Azure)', '15+ Years', 'priya.d@liveprosolutions.com', '+91-712-274-0470', 'https://www.linkedin.com/company/livepro-solutions', '', 'active', 20),
    ('Amit Sharma', 'Head of Delivery & Client Success', 'Leader', 'Amit leads delivery governance and client success - sprint planning, risk mitigation, transparent progress reporting and 24/7 AMC support operations. He is the single point of accountability for on-time, on-budget enterprise rollouts.', '', 'Agile Delivery, Project Governance, AMC Support Operations', '13+ Years', 'amit.s@liveprosolutions.com', '+91-956-107-9560', 'https://www.linkedin.com/company/livepro-solutions', '', 'active', 30),
    ('Dr. Sneha Kulkarni', 'Principal Enterprise Architecture Mentor', 'Mentor', 'Dr. Kulkarni mentors senior engineers and architects through live architecture reviews, system design clinics and domain-driven design workshops. She anchors the LIVEpro campus-to-corporate incubator, guiding graduates into production-grade engineering roles.', '', 'System Design, Domain-Driven Design, Architecture Reviews', '20+ Years', 'sneha.k@liveprosolutions.com', '+91-712-274-0470', 'https://www.linkedin.com/company/livepro-solutions', '', 'active', 40),
    ('Rajesh Iyer', 'Cloud & DevOps Mentorship Lead', 'Mentor', 'Rajesh coaches delivery teams on containerization, CI/CD automation, infrastructure-as-code and observability. Under his mentorship, LIVEpro squads ship to production multiple times a day with zero-downtime release pipelines.', '', 'Docker, Kubernetes, Terraform, CI/CD Pipelines', '14+ Years', 'rajesh.i@liveprosolutions.com', '+91-940-448-4560', 'https://www.linkedin.com/company/livepro-solutions', '', 'active', 50),
    ('Farhan Qureshi', 'Mobile & Full-Stack Engineering Mentor', 'Mentor', 'Farhan guides the mobile and full-stack engineering guild - code reviews, API design standards and cross-platform delivery patterns. He runs the internal LIVEpro upskilling bootcamps on Flutter, React Native and Node.js.', '', 'Flutter, React Native, Node.js, API Design', '11+ Years', 'farhan.q@liveprosolutions.com', '+91-956-107-9560', 'https://www.linkedin.com/company/livepro-solutions', '', 'active', 60);");
}
?>