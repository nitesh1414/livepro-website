# Complete Multipage CMS Website Portal in PHP + MySQL & Standalone SPA
## LIVEpro Software Solutions x TCS Enterprise Theme
### Pure Corporate IT Consulting, Website & Mobile App Development, & Client Projects

Welcome to the **Complete Enterprise CMS Portal Suite** engineered for **LIVEpro Software Solutions** (reference: [https://liveprosolutions.com/](https://liveprosolutions.com/)) with architectural design from **Tata Consultancy Services (TCS.com)** and visual styling harmonized around your **Uploaded Geometric Logo (`logo-LP.png`)** and typographic banner (`logo.png`).

This workspace delivers an enterprise web application structured into **Two Complete Deployment Architectures**, where **EVERY element, section, stat, job posting, project, hero banner image, expertise domain, and leadership profile is 100% manageable via the 14-module CMS Admin Suite**:

---

## 🌟 What's New in v6.0 (Uploaded Logo-LP.png & Matching Typography Theme)

1. **🖼️ Uploaded Geometric Logo Integration (`logo-LP.png`)**: Faithfully integrated your standalone geometric "LP" icon (`assets/images/logo-LP.png`) across the public header navbar, footer branding column, CMS admin sidebar, admin login box, and as the browser favicon (`<link rel="icon" href="assets/images/logo-LP.png">`)!
2. **🔤 Matching Typography from `logo.png`**: We replicated the exact typography and styling of your banner logo image across the header and footer brand displays:
   - **"LIVE"**: Styled in bold, uppercase 3D Slab / Bold Sans-Serif font (`Arial Black`, `Impact`, `Trebuchet MS`, sans-serif) with text shadow in bright Tech Blue (`#1a85e8`).
   - **"pro"**: Styled in bold Serif font (`Times New Roman`, `Georgia`, serif) in deep Crimson Red (`#c92020`).
   - **"Software Solutions"**: Styled below in an elegant Cursive / Italic Script font (`Monotype Corsiva`, `Apple Chancery`, `Lucida Calligraphy`, `Brush Script MT`, cursive) in vibrant Emerald Green (`#22a316`).
   - **"Right People, Right Time, Right Place"**: Displayed as the hero tagline and top ticker in a vibrant Cursive Brush Script font (`Brush Script MT`, `Monotype Corsiva`, cursive) in Crimson Red and Gold!
3. **🎨 Harmonized 4-Color Theme**: Modernized the entire visual palette around the exact colors of your uploaded logos:
   - **Bright Tech Blue (`#1a85e8`)**: Taken from the bold down-stroke "L" for primary buttons, navbar accents, and header highlights.
   - **Vibrant Emerald Green (`#22a316`)**: Taken from the geometric outer square border and "Software Solutions" text for secondary action buttons and badges.
   - **Crimson Red (`#c92020`)**: Taken from the triangular loop "p" and "pro" text for callouts and danger actions.
   - **Sunny Gold Yellow (`#f2c10d`)**: Taken from the center diamond dot for star ratings and highlight alerts.
   - **Deep Black / Dark Navy Background (`#05080e` to `#090d16`)**: Replicating the deep black background of `logo.png` across footers, admin sidebars, and hero carousels to make the bright blue, green, and red pop vibrantly!
4. **🖼️ Complete 100% Viewport-Width Hero Background Images**: The Hero Carousel slides span **100% complete width edge-to-edge across the monitor screen** (`width: 100%; min-height: 650px; background-size: cover; background-position: center;`).
5. **🖼️ Admin-Changeable Hero Background Images**: You can upload custom background image files directly from your computer OR enter relative/external image URL paths for each Hero Carousel slide!
   - In PHP Server Mode (`admin/banners.php`), simply select a file under **"Upload New Background Image File"** and click Save. PHP stores your image in `assets/images/banners/` and applies it live to `index.php`!
   - In Standalone Browser Mode (`index.html`), selecting a file converts it to a Base64 data URI in your browser's localStorage and instantly applies it to the live carousel!
   - Seeded with 3 high-definition, AI-generated corporate tech backgrounds out of the box (`assets/images/banner1.jpg`, `banner2.jpg`, `banner3.jpg`).
6. **⚡ High-Impact User Interaction Widgets ("more user interaction")**:
   - **🧮 Interactive Project Cost & Timeline Estimator Calculator**: Potential corporate clients select their service requirements (*Website Dev / Mobile App / AI / AMC*), project scale (*Startup MVP / Mid-Size Enterprise / Global MNC*), and timeline speed. As they click option pills, the widget dynamically calculates an estimated investment range (e.g. *₹8L - ₹14L*) and delivery timeline, with an instant 1-click **"Lock In Estimate & Book Consultation"** button that pre-fills the CRM form!
   - **🔍 Real-Time Instant Live Search & Filter**: On **Projects Showcase (`projects.php`)**, **Careers (`careers.php`)**, and **Expertise (`expertise.php`)**, users can type into instant live search boxes to dynamically filter client case studies, job openings, or technology stacks without reloading the page!
   - **❓ Interactive FAQ Accordions**: Expandable questions on common corporate IT concerns on `about.php` and `services.php`.
7. **🚫 Pure Corporate IT Focus (All Student Courses Removed)**: Removed all course-related pages (`courses.php`), database tables, and student training references. LIVEpro Software Solutions is now presented as a pure **100% corporate enterprise software development, IT consulting, and client project solutions firm**.
8. **🧠 Technological Expertise & Methodologies Portal (`expertise.php`)**: Showcases LIVEpro's mastery across high-demand corporate IT domains:
   - **Website Development & Web Portals** (React, Angular, Next.js, Node.js, PHP Laravel, Java Spring Boot).
   - **Mobile App Development** (Native iOS & Android, cross-platform Flutter & React Native enterprise apps).
   - **Custom Software & Desktop Applications** (ERP, CRM, WMS inventory tracking, business automation suites).
   - **Cloud Architecture & DevOps Automation** (AWS, Azure, Docker, Kubernetes, CI/CD automated deployment).
   - **Systems Integration & Legacy Re-Engineering** (API decoupling, database migration, microservices architecture).
   - **Artificial Intelligence & Cognitive Business Operations** (Machine learning pipelines, Generative AI & LLM integration).
   - **Embedded Systems & Industrial IoT Engineering** (ARM Cortex firmware, RTOS development, MQTT telemetry).
   - **24/7 Hardware & Software AMC Maintenance** (Scheduled diagnostics, database tuning, security patch AMCs).
9. **🏛️ Clients & Projects Portfolio Showcase (`projects.php`)**: Showcases enterprise client deliverables and case studies (*Vidarbha Financial Core Banking Re-Engineering*, *Central Logistics Mobile Fleet Tracking App*, *Butibori Smart Industrial IoT Grid*, *Omnichannel E-Commerce POS Web System*). Features category tabs, client badges, technology stack tags, challenge vs solution breakdowns, and measurable impact results!
10. **💼 Careers & Job Seekers Portal (`careers.php`)**: A dedicated recruitment portal for job seekers. Lists open corporate engineering positions (Senior Full Stack Web Architect, Senior Mobile App Lead, Python AI Engineer, Embedded R&D Engineer). Includes department filtering and an interactive popup modal with a **1-click Job Application Form** (`name`, `email`, `phone`, `resume_link`, `cover_letter`) that submits directly into the MySQL database!
11. **👥 Leaders & Mentors Module on the About Us Page (`about.php` + `admin/leaders.php`)**: The About Us page now renders a fully CMS-driven **“The Leaders & Mentors Behind LIVEpro”** section. Add, edit, re-order, publish/unpublish, and delete profiles from the new **Leaders & Mentors** admin module — each card supports a profile photo upload (or automatic initials avatar), designation, type (Leader / Mentor), experience badge, biography, expertise tags, email, phone, LinkedIn and X/Twitter links. Visitors can filter the grid between **All Profiles / Leaders / Mentors**, and only `active` profiles are published to the live site.

---

## 🚀 1-Click Automated Database Installer (`install.php`)

We have created an automated system installer, **`install.php`**, designed to set up your entire server environment, create the relational database, execute the 15-table schema, and seed all LIVEpro corporate IT content in seconds!

### How to Run `install.php`:
1. Upload the workspace files to your web server root (e.g., `htdocs/livepro/` in XAMPP, `www/` in WAMP/MAMP, or `/var/www/html/` on Linux servers).
2. Open your web browser and navigate to: **`http://localhost/livepro/install.php`** (or your domain name).
3. **Step 1 — Environment Verification**: The installer will automatically verify your PHP version (>= 7.4), PDO database extensions (`pdo_mysql` and `pdo_sqlite`), and directory write permissions. Click **"Proceed to Database Configuration"**.
4. **Step 2 — Database & Admin Setup**:
   - Select your database mode: **MySQL / MariaDB Production Server** or **SQLite Local Offline Development**.
   - Enter your database host (`localhost`), database name (`livepro_cms_db`), and MySQL username/password.
   - Configure your initial Admin Account (Default demo: Username `admin` / Password `livepro2026`).
   - Leave **"Seed Database with Complete LIVEpro Corporate IT Content"** checked to populate all 15 tables!
5. Click **"🚀 Install Schema & Seed Database Now"**. The installer will:
   - Create database `livepro_cms_db` if missing.
   - Create all 15 relational tables (`admin_users`, `site_settings`, `hero_banners`, `feature_panels`, `case_studies`, `projects_portfolio`, `expertise_areas`, `services`, `careers`, `job_applications`, `industries`, `blog_posts`, `testimonials`, `inquiries`, `leaders_mentors`).
   - Seed all banners (with background image paths!), capabilities, case studies, client projects, expertise domains, job openings, and site branding.
   - Automatically write and secure your `includes/config.php` file!
6. **Step 3 — Launch**: You will be presented with a celebration summary screen with direct links to **Launch Public Portal (`index.php`)** or **Enter CMS Admin Suite (`admin/login.php`)**.

---

## 🛠️ Troubleshooting: `Table 'livepro_cms_db.admin_users' doesn't exist` (FIXED)

**Symptom:** `install.php` / `setup.php` finished with
`Installation Failed: SQLSTATE[42S02]: Base table or view not found: 1146 Table 'livepro_cms_db.admin_users' doesn't exist`.

**Cause (fixed in this revision):** the installers split `schema.sql` with a fragile regex
(`preg_split("/;+(?=([^'|^\']*['|\'][^'|^\']*['|\'])*[^'|^\']*$)/", ...)`) that only breaks the file on `;`
when the **rest of the file contains an even number of `'` / `|` characters**. A single `|` inside a seeded string
(the announcement ticker: *"🚀 LP Geometric Theme | Custom Website Development…"*) flipped that parity, so everything
before it — including `CREATE TABLE admin_users` and `CREATE TABLE site_settings` — was merged into the same chunk as
`CREATE DATABASE …`, which the installer skips. Result: those two tables were never created and the very next query
(inserting the admin user) crashed with error 1146.

**What changed:**
1. New `includes/sql_tools.php` with `livepro_split_sql()` — a deterministic single-pass scanner that understands
   strings, escaped quotes / `''` doubling, backticks, `--` / `#` / `/* */` comments, so quotes, emoji and `|` characters can
   never break the import. `install.php` and `setup.php` now both use it (no more `preg_split`).
2. The installer now **verifies all 15 tables exist before seeding the admin account** and, if any are missing,
   stops with an actionable message instead of a confusing SQL error.
3. The **“Seed Database with content” checkbox** is now honoured (previously, unchecking it made the admin insert
   fail because the table was empty; SQLite mode ignored it too).
4. Installer success screen reports how many tables/statements were executed; re-running on an existing SQLite
   file no longer duplicates the seeded demo rows.

**If your database is already half-installed, do this:**
1. Upload the updated `install.php`, `setup.php`, `schema.sql` and `includes/sql_tools.php`.
2. Re-run `install.php`, and on step 2 tick **“Re-Create / Overwrite Existing Tables (Clean Install)”**, then click
   **🚀 Install Schema & Seed Database Now**.
3. (Alternative, no installer) In phpMyAdmin select the `livepro_cms_db` database → **Import** → choose `schema.sql`
   → Go, then log in with the admin account you created.

---

## 👥 Leaders & Mentors Module (About Us page, CMS driven)

The About Us page (`about.php`) contains a dedicated **“The Leaders & Mentors Behind LIVEpro”** section that is populated **100% from the admin panel** — no HTML editing required.

### Managing Profiles (Admin Panel)
Open **Admin &rarr; 👥 Leaders & Mentors (About)** (`admin/leaders.php`) to:

| Action | Details |
| --- | --- |
| **Add / Edit / Delete** | Full CRUD over every profile, with instant success toasts. |
| **Profile Type** | `Leader` (blue accent) or `Mentor` (green accent) — drives the badge, card colour and visitor filter. |
| **Profile Photo** | Upload `jpg / jpeg / png / webp / gif` (stored in `assets/images/leaders/`) **or** paste a relative/external URL. Leave empty for an automatic **initials avatar**. |
| **Fields** | Full name, designation, experience badge (e.g. `15+ Years`), biography, comma-separated expertise tags, email, phone, LinkedIn URL, X/Twitter URL. |
| **Publishing** | `Active` publishes the profile on the live About page, `Draft` hides it. Click the status badge in the list to toggle instantly. |
| **Ordering** | `Display Order` controls the position of the card in the section (lower number = first). |

### Database
A new 15th table `leaders_mentors` is created by `schema.sql` / `install.php` and seeded with 6 sample profiles (3 Leaders + 3 Mentors) that you can edit or replace.

Existing installations are upgraded automatically: `ensure_leaders_mentors_table()` runs an idempotent `CREATE TABLE IF NOT EXISTS` migration on first use, so no manual SQL import is needed — **just open the new admin module and start adding profiles**.

### Front-end behaviour
- Active profiles render as responsive cards (photo/initials avatar, name, designation, experience badge, bio, expertise tags and contact buttons).
- Visitors can filter between **All Profiles / Leaders / Mentors** with a single click.
- Cards are ordered by `display_order`, and the section gracefully hides itself for visitors until at least one profile is published (logged-in admins always see it, including an empty-state hint).

---

## 🏛️ Architecture 1: PHP + MySQL Multipage CMS Portal

Engineered for traditional hosting environments (Apache/Nginx, PHP 7.4/8.x, MySQL 5.7+ / MariaDB 10.2+).

### 📁 Directory & File Structure
```text
├── install.php                 # 🚀 3-Step Automated System & Database Installer Wizard
├── setup.php                   # ⚡ Alternate Quick Setup Helper
├── schema.sql                  # 🗄️ Complete MySQL Database Dump (15 tables + all default content)
├── index.php                   # 🏠 Public Portal: Home Page (Estimator Calculator, Hero Carousel, Projects)
├── about.php                   # 🏢 Public Portal: About Us (Two Corporate Sectors, SDLC Methodologies & Leaders/Mentors)
├── expertise.php               # 🧠 Public Portal: Tech Expertise & Agile Methodologies (Live Search & Bars)
├── services.php                # 🛠️ Public Portal: Complete IT Capabilities Catalog (Estimator Widget)
├── projects.php                # 🏛️ Public Portal: Enterprise Clients & Projects Portfolio Showcase (Impact)
├── careers.php                 # 💼 Public Portal: Job Seekers Portal & Engineering Roles (Modal Form)
├── industries.php              # 🌐 Public Portal: 16 Industry & Domain Verticals Served (TCS Scale)
├── blog.php & post.php         # 📰 Public Portal: Thought Leadership Insights, News, & Single Article View
├── contact.php                 # 📥 Public Portal: Office Location in Nagpur & Interactive PHP POST CRM Form
├── includes/
│   ├── config.php              # ⚙️ PDO Database Connection Wrapper (with smart offline SQLite fallback!)
│   ├── functions.php           # 📚 Core Library: Settings, 15-table CRUD helpers, Auth, Flash Toasts
│   ├── header.php              # 🧩 Reusable HTML Header & Navbar (with logo-LP.png & active highlighting)
│   └── footer.php              # 🧩 Reusable HTML Footer & Modals
├── admin/                      # 🔐 14-Module CMS Admin Management Suite
│   ├── login.php & logout.php  # 🔑 Secure Admin Authentication (Demo: admin / livepro2026)
│   ├── index.php               # 📊 KPI Dashboard Overview & Recent CRM Leads Feed
│   ├── settings.php            # ⚙️ Live Site Branding, What's New Ticker, Address, & Hero Stat Manager
│   ├── banners.php             # 🎠 Hero Carousel Banners CRUD Manager (BG Image Uploads, Slides, Buttons)
│   ├── panels.php              # 🧩 Feature & Value Panels CRUD Manager (Why Choose Us, Capabilities)
│   ├── casestudies.php         # 📈 Enterprise Case Studies CRUD Manager (Analyst Reports, Metrics)
│   ├── projects.php            # 🏛️ Enterprise Client Projects CRUD Manager (Impact & Tech Stack)
│   ├── expertise.php           # 🧠 Technological Expertise CRUD Manager (Proficiency levels)
│   ├── leaders.php             # 👥 Leaders & Mentors CRUD Manager (About Us page: photos, bios, socials)
│   ├── services.php            # 🛠️ IT Capabilities CRUD Manager (Add, Edit, Delete, Toggle Status)
│   ├── careers.php             # 💼 Careers & Job Openings CRUD Manager (Salary, Experience)
│   ├── applications.php        # 📄 Job Applications CRM (Review candidates, Mailto, WhatsApp)
│   ├── blog.php                # 📰 Thought Leadership Articles CRUD Manager (Publishing, Slug generation)
│   ├── testimonials.php        # 💬 Client & Partner Reviews CRUD Manager
│   ├── inquiries.php           # 📥 Customer CRM Leads Suite (Status update, Mailto, WhatsApp)
│   └── includes/               # 🧩 Admin Sidebar Navigation & Topbar
└── assets/
    ├── images/
    │   ├── logo-LP.png         # 🖼️ Uploaded Standalone Geometric LP Monogram Icon Logo
    │   ├── logo-full.png       # 🖼️ Uploaded Full Banner Logo Image
    │   ├── banner1.jpg         # 🌌 Deep Tech Enterprise AI & Network Background Banner
    │   ├── banner2.jpg         # 🟢 Custom Software Engineering & Systems Integration Banner
    │   └── banner3.jpg         # 🟣 24/7 AMC Server Maintenance & Cloud Infrastructure Banner
    ├── css/style.css           # Master CSS3 (Harmonized Palette, Flex/Grid, Glassmorphism, Animations)
    └── js/main.js              # Interactivity (Estimator Calculator, Live Search, Modals, Tabs, Toasts)
```

---

## 🔐 13-Module CMS Admin Management Suite (`/admin/login.php`)

To access the backend admin control panel:
- **URL**: Navigate to `http://localhost/livepro/admin/login.php` or click **"🛡️ Admin Login"** in the top navigation bar.
- **Admin Username**: `admin`
- **Password**: `livepro2026`

### Every Element & Panel is Manageable in the CMS:
1. **📊 KPI Dashboard Overview**: Monitor live counters for active carousel banners, IT capabilities, case studies, client projects, job openings, job applicants, expertise areas, blog articles, and unread CRM leads.
2. **⚙️ Live Branding & Top Ticker Manager**: Live-edit the Company Name, Header Tagline, Top News Ticker ("What's New Bar"), Office Address in Raghuji Nagar Nagpur, Phones, Emails, Copyright Year, and Hero Stats.
3. **🎠 Hero Banners Carousel Manager (WITH COMPLETE-WIDTH BG IMAGE UPLOADS)**: Add, edit, reorder, or delete slides in the hero showcase carousel. You can now upload background image files directly from your computer or specify custom image URLs!
4. **🧩 Feature & Value Panels Manager**: Manage section panels for "Why Choose Us" methodologies and cutting-edge capabilities.
5. **📈 Enterprise Case Studies Manager**: Create and publish analyst transformation reports highlighting client industry domains and metric benchmarks.
6. **🏛️ Projects & Clients Portfolio Manager**: Create and update enterprise client deliverables, manage tech stack tags, challenge vs solution breakdowns, and measurable impact results.
7. **🧠 Technological Expertise Manager**: Add and update technology domains (Website Dev, Mobile Dev, Cloud DevOps, AI, AMC Maintenance), tools list, and proficiency percentages.
8. **🛠️ IT Capabilities & Services Manager**: Create custom enterprise services, edit summaries and full descriptions.
9. **💼 Careers & Job Openings Manager**: Manage engineering job postings, salaries, experience requirements, and toggle status between active and closed.
10. **📄 Job Applications Recruitment CRM**: Review candidate submissions from `careers.php`. View resumes, cover letters, and update candidate status (`NEW` ➔ `REVIEWED` ➔ `SHORTLISTED` ➔ `REJECTED`). Send 1-click email replies or open direct WhatsApp client chats.
11. **📰 Thought Leadership Blog Manager**: Publish articles on software engineering architectures and industry trends.
12. **💬 Testimonials & Reviews Manager**: Manage client feedback quotes, roles, and star ratings.
13. **📥 Customer CRM Leads Engine**: Review incoming inquiries sent from `contact.php`. Update lead status, send email replies, or open WhatsApp chats.

---

## 🌐 Architecture 2: Standalone Browser Mode (`index.html`)

For immediate interactive evaluation without running any PHP web server:
- Open `index.html` directly in any web browser or Arena viewer.
- Features the exact same **Uploaded Logo-LP.png + Matching Typography + Harmonized LP Color Theme + TCS Enterprise Theme + Complete-Width Background Images + LIVEpro Corporate IT content** across ALL portals (including Expertise, Projects, and Careers) and includes the complete **14-module CMS Admin Dashboard** operating via reactive HTML5, CSS3, and JavaScript with localStorage data persistence (`livepro_lp_logo_cms_db_v6`).

---
*Developed for LIVEpro Software Solutions • Copyright © 2026 All Rights Reserved.*
