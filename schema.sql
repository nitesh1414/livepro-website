-- ============================================================================
-- LIVEpro Software Solutions x TCS Enterprise Theme (Facebook Color Scheme)
-- Complete Multipage CMS Portal Database Schema (14 Relational Tables)
-- Pure Corporate IT Consulting, Website & Mobile App Dev, & Client Projects
-- Database Name: livepro_cms_db
-- ============================================================================

CREATE DATABASE IF NOT EXISTS `livepro_cms_db` 
DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;

USE `livepro_cms_db`;

-- 1. admin_users
DROP TABLE IF EXISTS `admin_users`;
CREATE TABLE `admin_users` (
  `id` INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `username` VARCHAR(50) NOT NULL UNIQUE,
  `password_hash` VARCHAR(255) NOT NULL,
  `email` VARCHAR(100) NOT NULL,
  `full_name` VARCHAR(100) NOT NULL DEFAULT 'System Administrator',
  `role` ENUM('superadmin', 'editor') DEFAULT 'superadmin',
  `last_login` DATETIME NULL,
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `admin_users` (`id`, `username`, `password_hash`, `email`, `full_name`, `role`) VALUES
(1, 'admin', '$2y$10$e8w.xZ0M4F5P7E3rU9qN1e8w.xZ0M4F5P7E3rU9qN1u/a1B2c3D4e', 'admin@liveprosolutions.com', 'System Administrator', 'superadmin');

-- 2. site_settings
DROP TABLE IF EXISTS `site_settings`;
CREATE TABLE `site_settings` (
  `id` INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `setting_key` VARCHAR(100) NOT NULL UNIQUE,
  `setting_value` TEXT NOT NULL,
  `setting_group` VARCHAR(50) DEFAULT 'general',
  `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `site_settings` (`setting_key`, `setting_value`, `setting_group`) VALUES
('company_name', 'LIVEpro Software Solutions', 'branding'),
('tagline', 'RIGHT TIME... RIGHT PLACE... RIGHT PEOPLE...', 'branding'),
('sub_tagline', 'We provide a wide range of solutions and services across various verticals in Information Technologies like Website Development, Mobile App Development, Customized Software Solutions, Testing, Onsite Service and Support, Platform Delivery, Networking, Outsourcing and Application Management AMC Support.', 'branding'),
('announcement_active', '1', 'announcement'),
('announcement_text', '🚀 Facebook Enterprise Theme | Custom Website Development, Mobile Apps & 24/7 AMC Maintenance Services in Nagpur & Global', 'announcement'),
('announcement_url', 'expertise.php', 'announcement'),
('office_address', 'G-9B, Sidhhesh Sai Darshan Apartment, Raghuji Nagar, Nagpur, Maharashtra, India', 'contact'),
('phone_numbers', '+91-712-274-0470, +91-940-448-4560, +91-956-107-9560', 'contact'),
('email_addresses', 'admin@liveprosolutions.com, niteshg@liveprosolutions.com', 'contact'),
('operating_hours', 'Mon - Sat: 9:30 AM to 7:30 PM (Sunday Closed)', 'contact'),
('copyright_year', '2026', 'general'),
('stat_years', '15+', 'stats'),
('stat_projects', '500+', 'stats'),
('stat_engineers', '120+', 'stats'),
('stat_industries', '16+', 'stats'),
('seo_meta_desc', 'Best IT Solutions, Website Development, Mobile App Development, Custom Software & AMC Maintenance in Nagpur, India.', 'seo'),
('google_maps_url', 'https://maps.google.com/?q=21.125351,79.112734', 'contact');

-- 3. hero_banners (Updated with bg_image for Admin changeable background images)
DROP TABLE IF EXISTS `hero_banners`;
CREATE TABLE `hero_banners` (
  `id` INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `badge_text` VARCHAR(100) NOT NULL,
  `title` VARCHAR(200) NOT NULL,
  `subtitle` TEXT NOT NULL,
  `cta_text` VARCHAR(50) NOT NULL,
  `cta_url` VARCHAR(150) NOT NULL,
  `bg_image` VARCHAR(255) DEFAULT 'assets/images/banner1.jpg',
  `bg_gradient` VARCHAR(100) DEFAULT 'navy-blue',
  `display_order` INT(11) DEFAULT 0,
  `status` ENUM('active', 'draft') DEFAULT 'active',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `hero_banners` (`id`, `badge_text`, `title`, `subtitle`, `cta_text`, `cta_url`, `bg_image`, `bg_gradient`, `display_order`, `status`) VALUES
(1, 'PERPETUALLY ADAPTIVE IT', 'Building on Belief: Custom Website & Mobile App Dev', 'Transforming corporate business models through enterprise web applications, native & hybrid mobile apps, and cloud-native software architecture.', 'Explore Our Expertise', 'expertise.php', 'assets/images/banner1.jpg', 'navy-blue', 10, 'active'),
(2, 'END-TO-END IT CONSULTING', 'Custom Software Projects & Systems Integration', 'We deliver comprehensive software solutions from architectural requirement analysis to full-cycle development, cloud deployment, and legacy re-engineering.', 'View Clients & Projects', 'projects.php', 'assets/images/banner2.jpg', 'emerald-teal', 20, 'active'),
(3, 'ZERO DOWNTIME RE-ENGINEERING', '24/7 AMC & Infrastructure Maintenance Support', 'Ensure continuous business uptime with scheduled hardware diagnostics, database tuning, API integration, and proactive security patching AMCs.', 'Request Consultation', 'contact.php', 'assets/images/banner3.jpg', 'purple-indigo', 30, 'active');

-- 4. feature_panels
DROP TABLE IF EXISTS `feature_panels`;
CREATE TABLE `feature_panels` (
  `id` INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `panel_group` VARCHAR(50) NOT NULL,
  `title` VARCHAR(150) NOT NULL,
  `description` TEXT NOT NULL,
  `icon` VARCHAR(50) DEFAULT 'check',
  `link_text` VARCHAR(50) DEFAULT 'Learn more',
  `link_url` VARCHAR(150) DEFAULT 'about.php',
  `display_order` INT(11) DEFAULT 0,
  `status` ENUM('active', 'draft') DEFAULT 'active',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `feature_panels` (`id`, `panel_group`, `title`, `description`, `icon`, `link_text`, `link_url`, `display_order`, `status`) VALUES
(1, 'why_us', 'Flexible Client Engagement', 'Tailored pricing models, agile team scaling, and adaptable delivery sprints designed around your core business KPIs.', 'refresh', 'Read Engagement Model', 'about.php', 10, 'active'),
(2, 'why_us', 'Well-Defined Methodologies', 'Rigorous SDLC methodologies, DevOps automated testing, and CI/CD pipelines ensuring high code quality and rapid market delivery.', 'code', 'Explore Methodologies', 'about.php', 20, 'active'),
(3, 'why_us', 'Rigorous Project Management', 'Achieving the optimal combination of cost, quality, and speed through ISO-certified quality practices and milestone governance.', 'award', 'View Quality Assurance', 'about.php', 30, 'active'),
(4, 'why_us', 'Global & Domestic Perspective', 'A perfect blend of Indian engineering excellence and international business insight to tackle domestic and global IT challenges.', 'globe', 'Our Global Reach', 'about.php', 40, 'active'),
(5, 'capabilities', 'Website & Web Apps', 'Custom enterprise web portals, progressive web apps (PWAs), e-commerce systems, and high-performance cloud web architectures.', 'code', 'Explore Web Dev', 'expertise.php', 10, 'active'),
(6, 'capabilities', 'Mobile App Development', 'Native iOS & Android apps, cross-platform Flutter & React Native enterprise mobile solutions, and field sales tracking tools.', 'cpu', 'Explore Mobile Apps', 'expertise.php', 20, 'active'),
(7, 'capabilities', 'Systems Integration & Re-Engineering', 'Modernization of monolithic legacy systems, seamless REST API integration, database migration, and enterprise workflow restructuring.', 'refresh', 'Re-Engineering', 'services.php', 30, 'active'),
(8, 'capabilities', '24/7 AMC Maintenance & Support', 'Proactive hardware diagnostics, software version management, database tuning, and continuous uptime monitoring AMCs.', 'server', 'View AMC Services', 'services.php', 40, 'active');

-- 5. case_studies
DROP TABLE IF EXISTS `case_studies`;
CREATE TABLE `case_studies` (
  `id` INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `title` VARCHAR(200) NOT NULL,
  `client_industry` VARCHAR(100) NOT NULL,
  `metric_highlight` VARCHAR(100) NOT NULL,
  `summary` TEXT NOT NULL,
  `full_details` TEXT NOT NULL,
  `display_order` INT(11) DEFAULT 0,
  `status` ENUM('active', 'draft') DEFAULT 'active',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `case_studies` (`id`, `title`, `client_industry`, `metric_highlight`, `summary`, `full_details`, `display_order`, `status`) VALUES
(1, 'Core Banking System Re-Engineering & Web Portal Dev', 'Banking & Financial Services', '40% Speed Boost', 'Modernized a monolithic core banking platform for Vidarbha Financial Services into agile cloud microservices and responsive web apps.', 'LIVEpro engineering team conducted a comprehensive architectural audit, refactored legacy database schemas, and built a modern React.js web banking portal with secure RESTful payment gateway integrations. Transaction throughput increased by 40% while annual infrastructure maintenance costs dropped by 25%.', 10, 'active'),
(2, 'Enterprise Mobile Fleet Tracking App & AMC Maintenance', 'Logistics & Supply Chain', '99.99% Uptime AMC', 'Deployed 24/7 AMC maintenance and built a native mobile fleet tracking app for over 200 cargo vehicles across Central India.', 'Through proactive database tuning, automated patch management, and real-time GPS mobile app API orchestration, LIVEpro eliminated system downtime for Central Logistics, ensuring 24/7 operational continuity and mobile driver compliance.', 20, 'active'),
(3, 'Smart Industrial Automation IoT Grid & Desktop Software', 'Manufacturing & Control Systems', '35% Cost Reduction', 'Interfaced wireless industrial IoT sensor networks with ARM Cortex microcontrollers and real-time desktop monitoring software.', 'Our specialized embedded firmware division in Raghuji Nagar, Nagpur deployed RTOS telemetry nodes across assembly lines, streaming real-time machine health data to custom desktop software and cloud web dashboards.', 30, 'active');

-- 6. services
DROP TABLE IF EXISTS `services`;
CREATE TABLE `services` (
  `id` INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `title` VARCHAR(150) NOT NULL,
  `category` VARCHAR(50) NOT NULL DEFAULT 'Corporate IT',
  `short_desc` TEXT NOT NULL,
  `full_desc` TEXT NOT NULL,
  `icon` VARCHAR(50) DEFAULT 'code',
  `featured` TINYINT(1) DEFAULT 1,
  `status` ENUM('active', 'draft') DEFAULT 'active',
  `display_order` INT(11) DEFAULT 0,
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `services` (`id`, `title`, `category`, `short_desc`, `full_desc`, `icon`, `featured`, `status`, `display_order`) VALUES
(1, 'Website Development & Web Portals', 'Web & Mobile', 'Custom enterprise website development, e-commerce web applications, progressive web apps (PWAs), and scalable cloud web architectures.', 'We deliver full-cycle website development services from requirement analysis and UI/UX design to robust backend coding and cloud deployment. Our team builds high-concurrency web portals using React, Angular, Node.js, PHP, Python Django, and Java Spring Boot.', 'code', 1, 'active', 10),
(2, 'Mobile App Development (iOS & Android)', 'Web & Mobile', 'Native iOS & Android mobile applications, cross-platform Flutter & React Native enterprise mobile solutions, and field sales tools.', 'Engage your customers and workforce on the go. We architect secure, user-friendly mobile applications integrated with enterprise ERPs, payment gateways, GPS geolocation tracking, and real-time cloud push notifications.', 'cpu', 1, 'active', 20),
(3, 'Hardware & Software Maintenance AMC', 'Corporate IT', '24/7 Annual Maintenance Contracts (AMC), proactive infrastructure upkeep, system optimization, database tuning, and security patching.', 'Ensure continuous uptime and optimal performance for your business-critical systems. We provide scheduled hardware diagnostics, software version management, database tuning, and immediate incident troubleshooting to eliminate operational downtime.', 'server', 1, 'active', 30),
(4, 'Systems Integration & Re-Engineering', 'Corporate IT', 'Modernization of legacy systems, seamless API integration, database migration, and enterprise workflow restructuring without downtime.', 'Transform your legacy IT infrastructure into modern, agile systems without business disruption. We specialize in API orchestration, ERP/CRM integrations, cloud migration, and refactoring monolithic architectures into cloud-ready microservices.', 'refresh', 1, 'active', 40),
(5, 'Network Services & Cybersecurity', 'Corporate IT', 'Secure network design, corporate LAN/WAN implementation, VPN administration, firewall configuration, and cybersecurity audits.', 'Build a resilient and high-speed network backbone for your enterprise. Our network engineers handle routing, switching, wireless enterprise setup, network virtualization, and multi-layer firewall defense against cyber threats.', 'network', 1, 'active', 50),
(6, 'AI & Cognitive Business Operations', 'AI & Platforms', 'Empowering enterprises with artificial intelligence, machine learning data pipelines, LLM integration, and automated workflow intelligence.', 'Harness the power of enterprise AI. We build data lakes, train predictive models, and integrate generative AI assistants into your operational workflows to automate repetitive tasks and generate deep business insights.', 'cpu', 1, 'active', 60),
(7, 'Custom Software & Desktop Applications', 'Corporate IT', 'Tailored desktop software, warehouse management systems (WMS), inventory tracking ERPs, and bespoke business automation suites.', 'We design and program customized standalone desktop applications for Windows, macOS, and Linux that integrate seamlessly with local hardware peripherals, barcode scanners, and central databases.', 'code', 1, 'active', 70);

-- 7. industries
DROP TABLE IF EXISTS `industries`;
CREATE TABLE `industries` (
  `id` INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(100) NOT NULL,
  `description` VARCHAR(255) DEFAULT NULL,
  `display_order` INT(11) DEFAULT 0,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `industries` (`id`, `name`, `description`, `display_order`) VALUES
(1, 'Banking & Financial Services', 'Core banking web portals, payment gateways, and secure financial mobile apps.', 1),
(2, 'eCommerce & Retail', 'Omnichannel e-commerce websites, inventory management, and POS integrations.', 2),
(3, 'Healthcare & Medical', 'Hospital management web systems, telemedicine mobile apps, and diagnostic data.', 3),
(4, 'Entertainment & Media', 'Digital content distribution, video streaming web apps, and media asset management.', 4),
(5, 'Embedded Systems', 'Microcontroller firmware, RTOS development, and industrial automation hardware.', 5),
(6, 'Logistics & Supply Chain', 'Mobile fleet GPS tracking apps, warehouse management ERPs, and cargo tracking.', 6),
(7, 'Human Resource & Staffing', 'Applicant tracking systems (ATS), payroll web software, and HR automation tools.', 7),
(8, 'Insurance Services', 'Claims processing portals, policy underwriting workflows, and risk analytics.', 8),
(9, 'IT Enabled Services (ITES)', 'BPO infrastructure, customer CRM suites, and enterprise workflow automation.', 9),
(10, 'Networking & Telecomm', 'Network administration, VoIP systems, firewall setup, and telecom infrastructure.', 10),
(11, 'Pharmaceuticals', 'Laboratory information web systems, drug supply chain tracking, and compliance.', 11),
(12, 'Real Time Control Systems', 'Mission-critical real-time processing software for manufacturing and defense.', 12),
(13, 'Travel & Transportation', 'Ticketing web engines, route optimization, and travel mobile applications.', 13),
(14, 'Recruiting Firms', 'Talent acquisition portals, candidate database matching, and interview automation.', 14),
(15, 'Education & Academic Enablement', 'Virtual learning management web portals (LMS), campus ERPs, and digital classrooms.', 15),
(16, 'Government & PSU', 'E-governance web portals, public utility management, and municipal software.', 16);

-- 8. blog_posts
DROP TABLE IF EXISTS `blog_posts`;
CREATE TABLE `blog_posts` (
  `id` INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `title` VARCHAR(255) NOT NULL,
  `slug` VARCHAR(255) NOT NULL UNIQUE,
  `category` VARCHAR(100) NOT NULL,
  `author` VARCHAR(100) NOT NULL DEFAULT 'Nitesh G.',
  `publish_date` DATE NOT NULL,
  `excerpt` TEXT NOT NULL,
  `content` LONGTEXT NOT NULL,
  `status` ENUM('published', 'draft') DEFAULT 'published',
  `views` INT(11) DEFAULT 0,
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `blog_posts` (`id`, `title`, `slug`, `category`, `author`, `publish_date`, `excerpt`, `content`, `status`, `views`) VALUES
(1, 'Why Modern Website Development Architecture Requires API Decoupling', 'why-modern-website-development-requires-api-decoupling', 'Web Development', 'Nitesh G.', '2026-06-15', 'Discover how separating frontend UI presentation from backend database logic transforms corporate website performance and security.', 'At LIVEpro Software Solutions, we recognize that traditional monolithic website architectures struggle under modern traffic demands. By decoupling frontend web applications built in React or Next.js from backend microservices running in Spring Boot or Node.js, enterprises achieve instant page loads, robust DDoS protection, and seamless mobile app integration.\n\nOur engineering division in Nagpur specializes in migrating legacy corporate websites to modern cloud-native web architectures.', 'published', 245),
(2, 'The Rise of Cross-Platform Mobile App Development in Enterprise IT', 'rise-of-cross-platform-mobile-app-development', 'Mobile Apps', 'Tech Solutions Team', '2026-05-28', 'How Flutter and React Native are allowing corporate organizations to deploy high-performance iOS and Android mobile apps in half the time.', 'In today\'s mobile-first business environment, corporate clients require native-quality mobile applications for both iOS and Android without doubling their engineering budgets.\n\nLIVEpro\'s Mobile App Development division utilizes modern cross-platform frameworks like Flutter and React Native to build unified codebases that deliver native performance, GPS hardware access, offline synchronization, and bank-grade encryption.', 'published', 189);

-- 9. testimonials
DROP TABLE IF EXISTS `testimonials`;
CREATE TABLE `testimonials` (
  `id` INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(100) NOT NULL,
  `role` VARCHAR(150) NOT NULL,
  `quote` TEXT NOT NULL,
  `rating` INT(1) DEFAULT 5,
  `type` VARCHAR(50) NOT NULL DEFAULT 'Client',
  `display_order` INT(11) DEFAULT 0,
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `testimonials` (`id`, `name`, `role`, `quote`, `rating`, `type`, `display_order`) VALUES
(1, 'Rajeshwar Rao', 'IT Director, Vidarbha Financial Services', 'LIVEpro Software Solutions handled our core banking web portal development and API re-engineering with exceptional professionalism. Their Nagpur team delivered on time and within budget, improving transaction processing speed by 40%.', 5, 'Enterprise Client', 1),
(2, 'Amitabh Sharma', 'Operations Manager, Central Logistics', 'We rely on LIVEpro for our 24/7 Hardware & Software Maintenance AMC and mobile fleet tracking app. Their proactive response time and technical depth give us complete peace of mind.', 5, 'Enterprise Client', 2),
(3, 'Sunita Deshmukh', 'VP of Operations, Retail Omnichannel Corp', 'LIVEpro developed our e-commerce web platform and mobile shopping app from scratch. The seamless POS database integration and clean UI/UX boosted our online conversion rate by 35% in just six months!', 5, 'Enterprise Client', 3);

-- 10. inquiries
DROP TABLE IF EXISTS `inquiries`;
CREATE TABLE `inquiries` (
  `id` INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(100) NOT NULL,
  `email` VARCHAR(100) NOT NULL,
  `phone` VARCHAR(50) NOT NULL,
  `subject` VARCHAR(150) NOT NULL,
  `message` TEXT NOT NULL,
  `status` ENUM('new', 'read', 'contacted', 'replied') DEFAULT 'new',
  `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `inquiries` (`id`, `name`, `email`, `phone`, `subject`, `message`, `status`, `created_at`) VALUES
(101, 'Vikramaditya Patil', 'v.patil@enterprise-tech.in', '+91 98230 11223', 'Website Development & Web Portals', 'We need to develop a custom B2B e-commerce website portal with ERP inventory synchronization. Requesting a technical proposal and estimated timeline.', 'new', '2026-06-29 14:30:00'),
(102, 'Anil Mehta', 'a.mehta@vidarbha-logistics.com', '+91 712 255 8899', 'Hardware & Software AMC Maintenance', 'We need an Annual Maintenance Contract (AMC) for our corporate office network (40 PCs, 2 servers, firewall). Requesting a technical consultation visit.', 'contacted', '2026-06-25 16:45:00'),
(103, 'Siddharth Joshi', 'siddharth@joshi-group.com', '+91 94220 55667', 'Mobile App Development (iOS & Android)', 'Looking for an experienced team to develop a cross-platform field sales tracking mobile app with GPS logging and offline database synchronization.', 'replied', '2026-06-24 11:15:00');

-- 11. job_openings (Careers Portal)
DROP TABLE IF EXISTS `job_openings`;
CREATE TABLE `job_openings` (
  `id` INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `title` VARCHAR(150) NOT NULL,
  `department` VARCHAR(100) NOT NULL DEFAULT 'Software Engineering',
  `location` VARCHAR(100) NOT NULL DEFAULT 'Nagpur / Hybrid',
  `type` VARCHAR(50) NOT NULL DEFAULT 'Full-Time',
  `experience` VARCHAR(50) NOT NULL DEFAULT '2-5 Years',
  `salary` VARCHAR(100) NOT NULL DEFAULT 'Best in Industry',
  `description` TEXT NOT NULL,
  `requirements` TEXT NOT NULL,
  `status` ENUM('active', 'closed') DEFAULT 'active',
  `display_order` INT(11) DEFAULT 0,
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `job_openings` (`id`, `title`, `department`, `location`, `type`, `experience`, `salary`, `description`, `requirements`, `status`, `display_order`) VALUES
(1, 'Senior Full Stack Web Architect', 'Website Development', 'Nagpur HQ / Hybrid', 'Full-Time', '5-8 Years', '₹12L - ₹18L PA', 'Lead the architectural design and full-cycle coding for custom enterprise web applications and e-commerce web portals.', 'Expertise in React.js, Next.js, Node.js, PHP, or Java Spring Boot.\nExperience leading Agile engineering squads and designing RESTful APIs.\nStrong database architecture skills in MySQL and PostgreSQL.', 'active', 10),
(2, 'Senior Mobile App Lead (iOS & Android)', 'Mobile Development', 'Nagpur HQ / Hybrid', 'Full-Time', '4-7 Years', '₹10L - ₹16L PA', 'Architect and develop native iOS/Android apps and cross-platform enterprise mobile applications using Flutter and React Native.', 'Proven portfolio of published apps on Apple App Store and Google Play.\nDeep expertise in Flutter, Dart, React Native, Swift, or Kotlin.\nExperience integrating mobile GPS geolocation, offline SQLite sync, and push notifications.', 'active', 20),
(3, 'Python AI / ML Engineer', 'AI & Data Science', 'Nagpur HQ', 'Full-Time', '2-5 Years', '₹8L - ₹14L PA', 'Develop predictive models, data ingestion pipelines, and integrate Generative AI assistants into corporate enterprise workflows.', 'Proficiency in Python, PyTorch, Scikit-Learn, Pandas, and FastAPI.\nExperience with LLM fine-tuning and OpenAI / Claude API integration.\nBackground in statistical analysis and REST API development.', 'active', 30),
(4, 'Embedded Firmware R&D Engineer', 'Embedded Hardware', 'Nagpur R&D Lab', 'Full-Time', '2-5 Years', '₹6L - ₹10L PA', 'Design and program real-time firmware for ARM Cortex microcontrollers and industrial automation sensor networks.', 'Strong programming skills in Embedded C and C++.\nHands-on experience with FreeRTOS, MQTT, BLE, and Wi-Fi sensor interfacing.\nDegree in Electronics / Telecommunications Engineering.', 'active', 40);

-- 12. job_applications (Careers CRM)
DROP TABLE IF EXISTS `job_applications`;
CREATE TABLE `job_applications` (
  `id` INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `job_id` INT(11) UNSIGNED NOT NULL,
  `job_title` VARCHAR(150) NOT NULL,
  `applicant_name` VARCHAR(100) NOT NULL,
  `email` VARCHAR(100) NOT NULL,
  `phone` VARCHAR(50) NOT NULL,
  `resume_link` VARCHAR(255) NOT NULL,
  `cover_letter` TEXT NULL,
  `status` ENUM('new', 'reviewed', 'shortlisted', 'rejected') DEFAULT 'new',
  `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `job_applications` (`id`, `job_id`, `job_title`, `applicant_name`, `email`, `phone`, `resume_link`, `cover_letter`, `status`, `created_at`) VALUES
(1, 1, 'Senior Full Stack Web Architect', 'Rohan Kulkarni', 'rohan.k@techmail.com', '+91 98221 33445', 'https://linkedin.com/in/rohan-demo-resume', 'I have 6 years of experience building high-performance web applications in React and Java Spring Boot. Highly interested in joining the LIVEpro Nagpur engineering team!', 'new', '2026-06-29 11:20:00');

-- 13. projects_portfolio (Clients & Projects Showcase)
DROP TABLE IF EXISTS `projects_portfolio`;
CREATE TABLE `projects_portfolio` (
  `id` INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `title` VARCHAR(200) NOT NULL,
  `client_name` VARCHAR(150) NOT NULL,
  `category` VARCHAR(100) NOT NULL DEFAULT 'Web & Cloud Portals',
  `industry` VARCHAR(100) NOT NULL,
  `tech_stack` VARCHAR(200) NOT NULL,
  `challenge` TEXT NOT NULL,
  `solution` TEXT NOT NULL,
  `results` TEXT NOT NULL,
  `featured` TINYINT(1) DEFAULT 1,
  `status` ENUM('active', 'draft') DEFAULT 'active',
  `display_order` INT(11) DEFAULT 0,
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `projects_portfolio` (`id`, `title`, `client_name`, `category`, `industry`, `tech_stack`, `challenge`, `solution`, `results`, `featured`, `status`, `display_order`) VALUES
(1, 'Vidarbha Financial Core Banking Web Portal Re-Engineering', 'Vidarbha Financial Services', 'Web & Cloud Portals', 'Banking & Finance', 'React.js, Spring Boot, Microservices, PostgreSQL, Docker, AWS', 'Monolithic core banking platform struggling under heavy mobile transaction volume and experiencing high latency during peak hours.', 'Refactored the core monolithic database into microservices, built a modern responsive React web banking portal, and deployed automated CI/CD deployment pipelines on AWS.', '40% increase in transaction processing speed, 99.999% uptime during fiscal quarter close, and 25% reduction in cloud server costs.', 1, 'active', 10),
(2, 'Central Logistics Mobile Fleet Tracking App & AMC Support', 'Central Logistics & Transport', 'Mobile Enterprise Apps', 'Logistics & Supply Chain', 'Flutter, React Native, Node.js, GPS REST APIs, MySQL', 'Legacy fleet tracking required manual database intervention and lacked native mobile apps for field drivers across 200 cargo vehicles.', 'Built a cross-platform Flutter mobile app for drivers with real-time GPS telemetry, offline SQLite sync, and provided 24/7 AMC hardware/software maintenance.', 'Real-time live tracking for 200+ trucks, zero security incidents over 3 fiscal years, and 30% increase in fleet delivery efficiency.', 1, 'active', 20),
(3, 'Butibori Smart Industrial Automation IoT Grid', 'Vidarbha Manufacturing Corp', 'Industrial IoT & Automation', 'Embedded Systems', 'ARM Cortex, FreeRTOS, MQTT, Node.js, TimescaleDB', 'Lack of real-time machine telemetry and predictive maintenance on the manufacturing assembly floor, leading to unexpected equipment downtime.', 'Interfaced wireless IoT sensor nodes with ARM Cortex microcontrollers running custom RTOS firmware, broadcasting live telemetry over MQTT to a centralized desktop software dashboard.', 'Eliminated unpredicted assembly line stoppages, reduced machinery maintenance costs by 35%, and provided real-time OEE metrics.', 1, 'active', 30),
(4, 'Omnichannel E-Commerce POS Web System', 'Retail Omnichannel Corp', 'Web & Cloud Portals', 'eCommerce & Retail', 'Next.js, TypeScript, PHP Laravel, MySQL, Redis, Stripe API', 'Fragmented inventory databases between 15 physical retail store locations and online e-commerce website, causing frequent out-of-stock errors.', 'Developed a centralized e-commerce web portal with real-time inventory synchronization across all store POS terminals and lightning-fast Redis product caching.', '35% increase in online web sales conversion rate within six months and 100% real-time inventory accuracy across 15 store locations.', 1, 'active', 40);

-- 14. expertise_areas (Technological Expertise & Methodologies)
DROP TABLE IF EXISTS `expertise_areas`;
CREATE TABLE `expertise_areas` (
  `id` INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `title` VARCHAR(150) NOT NULL,
  `category` VARCHAR(100) NOT NULL DEFAULT 'Core Engineering',
  `description` TEXT NOT NULL,
  `tech_list` VARCHAR(255) NOT NULL,
  `icon` VARCHAR(50) DEFAULT 'code',
  `proficiency` INT(3) DEFAULT 95,
  `status` ENUM('active', 'draft') DEFAULT 'active',
  `display_order` INT(11) DEFAULT 0,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `expertise_areas` (`id`, `title`, `category`, `description`, `tech_list`, `icon`, `proficiency`, `status`, `display_order`) VALUES
(1, 'Website Development & Web Applications', 'Core Engineering', 'Custom enterprise web portals, e-commerce platforms, progressive web apps (PWAs), and scalable cloud web systems built for high traffic and top security.', 'React.js, Next.js, Angular, Node.js, PHP Laravel, Python Django, Java Spring Boot, MySQL', 'code', 98, 'active', 10),
(2, 'Mobile App Development (iOS & Android)', 'Core Engineering', 'Native iOS & Android apps and cross-platform enterprise mobile solutions featuring GPS geolocation, offline sync, and bank-grade encryption.', 'Flutter, Dart, React Native, Swift, Kotlin, SQLite Offline Sync, Firebase, REST APIs', 'cpu', 96, 'active', 20),
(3, 'Custom Software & Desktop Applications', 'Core Engineering', 'Tailored standalone desktop applications, inventory ERPs, warehouse management systems (WMS), and bespoke business automation suites.', 'Java FX, Electron, C#, Python PyQt, Windows .NET, Linux Standalone Apps, MySQL', 'code', 95, 'active', 30),
(4, 'Cloud Architecture & DevOps Automation', 'Cloud DevOps', 'Architecting automated CI/CD deployment pipelines, container orchestration grids, and serverless cloud ecosystems for continuous availability.', 'AWS (EC2, S3, RDS, EKS), Azure, Google Cloud, Docker, Kubernetes, Terraform, Jenkins', 'cloud', 94, 'active', 40),
(5, 'Systems Integration & Re-Engineering', 'Core Engineering', 'Modernization of monolithic legacy systems, API decoupling, database migration, and enterprise middleware integration without downtime.', 'REST & GraphQL APIs, Microservices, Middleware Orchestration, Legacy DB Migration', 'refresh', 96, 'active', 50),
(6, 'Artificial Intelligence & Cognitive Operations', 'AI & Intelligence', 'Deploying machine learning predictive models, custom data pipelines, and integrating Generative AI assistants into operational software.', 'Python, PyTorch, Scikit-Learn, Pandas, OpenAI API, Claude Anthropic, Vector DBs', 'cpu', 92, 'active', 60),
(7, 'Embedded Systems & Industrial IoT', 'Embedded Hardware', 'Programming ARM Cortex microcontrollers, RTOS firmware, and wireless MQTT sensor telemetry for industrial manufacturing automation.', 'Embedded C/C++, ARM Cortex AVR, FreeRTOS, MQTT, BLE, Wi-Fi Sensor Interfacing', 'cpu', 96, 'active', 70),
(8, '24/7 Hardware & Software AMC Maintenance', 'Managed Support', 'Scheduled system diagnostics, database performance tuning, security patch management, and continuous uptime AMC infrastructure contracts.', 'Proactive Health Monitoring, Database Indexing, Patch Management, AMC SLA Contracts', 'server', 98, 'active', 80);

-- ============================================================================
-- END OF DATABASE SCHEMA AND SEEDING (14 TABLES TOTAL - BG_IMAGE ADDED)
-- ============================================================================
