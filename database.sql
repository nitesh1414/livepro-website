-- LIVEpro Software Solutions - CMS Database Schema
-- PHP Core + MySQL
-- Run this file to create the database and required tables

CREATE DATABASE IF NOT EXISTS livepro_cms CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE livepro_cms;

-- Users table (admin panel authentication + roles)
CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) UNIQUE NOT NULL,
    email VARCHAR(100) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    role ENUM('admin','editor') DEFAULT 'editor',
    is_active TINYINT(1) DEFAULT 1,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Pages table (content for each webpage)
CREATE TABLE IF NOT EXISTS pages (
    id INT AUTO_INCREMENT PRIMARY KEY,
    slug VARCHAR(50) UNIQUE NOT NULL,
    title VARCHAR(255) NOT NULL,
    meta_description TEXT,
    meta_keywords TEXT,
    content LONGTEXT,
    is_active TINYINT(1) DEFAULT 1,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Carousel / Hero slider images (homepage)
CREATE TABLE IF NOT EXISTS carousel (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255),
    subtitle VARCHAR(255),
    description TEXT,
    image VARCHAR(255) NOT NULL,
    button_text VARCHAR(100),
    button_link VARCHAR(255),
    order_sort INT DEFAULT 0,
    is_active TINYINT(1) DEFAULT 1,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Services table
CREATE TABLE IF NOT EXISTS services (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    description TEXT,
    icon VARCHAR(100),
    order_sort INT DEFAULT 0,
    is_active TINYINT(1) DEFAULT 1,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Products table
CREATE TABLE IF NOT EXISTS products (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    short_description VARCHAR(500),
    description LONGTEXT,
    image VARCHAR(255),
    price VARCHAR(100),
    category VARCHAR(100),
    features TEXT,
    button_text VARCHAR(100) DEFAULT 'Learn More',
    button_link VARCHAR(255),
    order_sort INT DEFAULT 0,
    is_active TINYINT(1) DEFAULT 1,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Contact form submissions
CREATE TABLE IF NOT EXISTS contact_messages (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL,
    phone VARCHAR(20),
    subject VARCHAR(255),
    message TEXT NOT NULL,
    status ENUM('new','read','replied','archived') DEFAULT 'new',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Site settings (logo, contact info, social links, etc.)
CREATE TABLE IF NOT EXISTS settings (
    id INT AUTO_INCREMENT PRIMARY KEY,
    setting_key VARCHAR(100) UNIQUE NOT NULL,
    setting_value TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Seed default admin user (change password after first login!)
-- Password: admin123
INSERT INTO users (username, email, password, role, is_active) VALUES
('admin', 'admin@liveprosolutions.com', '$2b$12$cdZrRn4VXgY3mBIdlCVtseoYzpLbvoWRTVKE2.k228BQxjjzOj59e', 'admin', 1);

-- Seed default pages with rich content
INSERT INTO pages (slug, title, meta_description, meta_keywords, content, is_active) VALUES
('home', 'LIVEpro Software Solutions - Home', 'LIVEpro provides best IT solutions across the globe. Right Time, Right Place, Right People.', 'IT solutions, software development, Nagpur, India, mobile apps, digital marketing', '<h2>Welcome to LIVEpro Software Solutions</h2><p>At LIVEpro, we believe that technology should work for your business, not against it. Our team of experienced developers, designers, and consultants deliver tailor-made IT solutions that help organizations grow, automate, and stay ahead of the competition.</p><p>With a perfect blend of Indian and international perspective, we serve clients across the globe from our headquarters in Nagpur. Our mission is simple: deliver the right solution at the <strong>right time</strong>, in the <strong>right place</strong>, with the <strong>right people</strong>.</p><p>Whether you need a custom software application, a mobile app, a digital marketing strategy, IT consultancy, robust security, or a smart home solution, LIVEpro is your trusted technology partner.</p>', 1),
('about', 'About Us - LIVEpro Software Solutions', 'Learn about LIVEpro Software Solutions and our commitment to delivering world-class IT services.', 'about livepro, IT company Nagpur, software company', '<h2>Welcome to LIVEpro Software Solutions</h2><p>Founded with a vision to bridge the gap between business needs and technology, LIVEpro Software Solutions provides a wide range of IT services across various verticals. Our offerings include project development, implementation and customization, testing, onsite support, platform delivery, networking, training, outsourcing, and application management support.</p><p>We have zeroed-in to serve two basic sectors:</p><h3>Industry Clients</h3><p>We are dedicated to maintaining the highest level of customer satisfaction by offering world-class services. Our in-depth engineering and industry knowledge enable us to understand our clients business needs and deliver solutions that create real value. We serve clients across banking, finance, eCommerce, education, healthcare, insurance, real estate, retail, telecom, and more.</p><p>Our goal is to achieve the best combination of cost, quality, and speed through flexible client engagement models, well-defined development methodologies, and a rigorous project management approach.</p><h3>Student Community</h3><p>As India becomes a global center for the IT industry, LIVEpro provides versatile training courses designed to equip students and professionals with hands-on, cutting-edge technology skills. We groom students of B.E, MCA, MCM, BCA, M.Sc., B.Sc., and Diploma engineering backgrounds to become industry-ready professionals.</p>', 1),
('services', 'Our Services - LIVEpro Software Solutions', 'Explore the wide range of IT services offered by LIVEpro Software Solutions.', 'software services, system development, training, networking', '<h2>Our Services</h2><p>We provide a variety of software services to help our customers in any part of the globe using the best of existing and new technologies, according to their requirements. Our customer service business unit handles the business-critical IT needs of corporate organizations, delivering end-to-end solutions that build, manage, and support our customers.</p><p>Our expert services span across industries such as banking and finance, eCommerce, education, entertainment, embedded systems, healthcare, human resources, insurance, IT enabled services, networking, pharmaceuticals, real-time systems, retail, recruiting, travel, transportation, and telecom.</p><p>From concept to deployment and ongoing support, LIVEpro ensures adaptability to client needs and brings out the most innovative solutions in every business and technology domain.</p>', 1),
('contact', 'Contact Us - LIVEpro Software Solutions', 'Get in touch with LIVEpro Software Solutions for your IT project needs.', 'contact livepro, IT company Nagpur', '<h2>Contact Us</h2><p>Have an idea, project, or question? We would love to hear from you. Reach out to our team and let us discuss how LIVEpro can help your business thrive in the digital age.</p><p>You can visit our office in Nagpur, call us on any of the numbers below, send an email, or simply fill out the contact form. Our team is ready to assist you with software development, mobile apps, digital marketing, IT consultancy, security solutions, and home automation.</p>', 1),
('careers', 'Careers & Training - LIVEpro Software Solutions', 'Join LIVEpro Software Solutions. We offer training and career opportunities in IT.', 'careers, training, IT jobs, software internship', '<h2>Careers &amp; Training</h2><p>We provide hands-on training and relevant cutting-edge technology courses to our trainees in order to stay ahead with the dynamically changing requirements of the IT industry. Our special modules are designed to cater to incumbent software trainees and groom students of B.E, MCA, MCM, BCA, M.Sc., B.Sc., and Diploma engineering backgrounds to take up challenging roles in the industry.</p><p>Beyond training, LIVEpro offers career opportunities for passionate developers, designers, marketers, and IT consultants. Join a team that values innovation, learning, and excellence.</p>', 1),
('products', 'Our Products - LIVEpro Software Solutions', 'Explore innovative software products by LIVEpro Software Solutions.', 'software products, web applications, mobile apps, enterprise solutions', '<h2>Our Products</h2><p>At LIVEpro Software Solutions, we build robust, scalable, and user-friendly software products designed to solve real business challenges. From enterprise management systems to customer-facing mobile applications, our products are built with cutting-edge technology and industry best practices.</p><p>Each product is crafted with attention to detail, security, and performance. Whether you need an off-the-shelf solution or a customized product tailored to your workflows, we have you covered.</p>', 1);

-- Seed default carousel images from the original LIVEpro website
INSERT INTO carousel (title, subtitle, description, image, button_text, button_link, order_sort, is_active) VALUES
('Welcome to LIVEpro', 'Software Solutions', 'Delivering the right IT solutions at the right time with the right people. From software development to home automation, we help businesses grow.', 'https://liveprosolutions.com/images/a01.jpg', 'Explore Services', 'services.php', 1, 1),
('Innovative Technology', 'For Modern Businesses', 'Transform your operations with custom software, mobile apps, cloud solutions, and smart digital marketing strategies.', 'https://liveprosolutions.com/images/a02.jpg', 'Contact Us', 'contact.php', 2, 1),
('Expert IT Training', 'Build Your Career', 'Hands-on training for BE, MCA, BCA, and diploma engineers. Learn the skills that the industry demands today.', 'https://liveprosolutions.com/images/a03.jpg', 'Learn More', 'careers.php', 3, 1),
('Reliable IT Support', 'Always On Time', 'Onsite service, support, and maintenance to keep your IT infrastructure running smoothly and securely.', 'https://liveprosolutions.com/images/a04.jpg', 'Get Support', 'contact.php', 4, 1),
('Digital Marketing', 'Grow Your Brand', 'SEO, social media, and paid campaigns that increase visibility, engagement, and conversions for your business.', 'https://liveprosolutions.com/images/a05.jpg', 'Start Now', 'services.php', 5, 1),
('Home Automation', 'Smart Living', 'Modern IoT solutions for connected, secure, and energy-efficient homes and offices.', 'https://liveprosolutions.com/images/a06.jpg', 'Discover More', 'services.php', 6, 1);

-- Seed detailed services
INSERT INTO services (title, description, icon, order_sort, is_active) VALUES
('Software Development', 'We design and develop custom web, desktop, and enterprise applications tailored to your business workflows. Our development process covers requirement analysis, UI/UX design, coding, testing, deployment, and ongoing support. Technologies include PHP, MySQL, JavaScript, Python, and modern frameworks.', 'code', 1, 1),
('Mobile App Development', 'Native and cross-platform mobile applications for iOS and Android. We build user-friendly apps for business automation, eCommerce, education, healthcare, and on-demand services using Flutter, React Native, and native technologies.', 'mobile', 2, 1),
('Digital Marketing', 'End-to-end digital marketing services including SEO, social media marketing, content marketing, email campaigns, PPC advertising, and analytics. We help you build a strong online presence and reach the right audience.', 'trending_up', 3, 1),
('IT Consultancy', 'Strategic technology consulting to align your IT investments with business goals. We offer digital transformation roadmaps, cloud migration advice, system architecture review, and process automation consulting.', 'support', 4, 1),
('IT Security', 'Protect your business with vulnerability assessments, security audits, network security, data protection, malware prevention, and compliance guidance. We help organizations build robust cybersecurity defenses.', 'security', 5, 1),
('Home Automation', 'Smart home and IoT solutions including lighting control, security systems, climate control, energy monitoring, and remote access. We turn ordinary homes into intelligent, connected living spaces.', 'home', 6, 1),
('Training & Internship', 'Industry-oriented training programs and internships for students and professionals in software development, web technologies, mobile apps, networking, digital marketing, and cybersecurity.', 'school', 7, 1),
('Cloud & Hosting', 'Reliable cloud deployment, server setup, domain registration, web hosting, and ongoing maintenance services to keep your applications online and performing optimally.', 'cloud', 8, 1);

-- Seed sample products
INSERT INTO products (title, short_description, description, image, price, category, features, button_text, button_link, order_sort, is_active) VALUES
('LIVEpro ERP Suite', 'Complete enterprise resource planning solution for mid-size businesses.', '<h3>LIVEpro ERP Suite</h3><p>A comprehensive ERP solution designed to streamline your business operations. Manage inventory, sales, purchases, accounting, HR, and payroll from a single unified platform.</p><p>Built with modern technology and responsive design, LIVEpro ERP Suite works seamlessly on desktop, tablet, and mobile devices.</p>', '', 'Contact for Pricing', 'Enterprise', 'Inventory Management\nSales & Purchase Orders\nAccounting & Finance\nHR & Payroll\nReports & Analytics\nMulti-user Access\nRole-based Permissions\nCloud & On-Premise Deployment', 'Request Demo', 'contact.php', 1, 1),
('LIVEpro CRM', 'Customer relationship management tool to boost sales and engagement.', '<h3>LIVEpro CRM</h3><p>Manage your leads, customers, and sales pipeline efficiently. LIVEpro CRM helps you track interactions, automate follow-ups, and close deals faster.</p><p>With built-in email integration, task management, and detailed analytics, your sales team will always be on top of their game.</p>', '', 'Contact for Pricing', 'Sales & Marketing', 'Lead Management\nSales Pipeline\nContact Database\nEmail Integration\nTask & Activity Tracking\nCustom Reports\nMobile Access\nAPI Integration', 'Request Demo', 'contact.php', 2, 1),
('LIVEpro LMS', 'Learning management system for training institutes and corporates.', '<h3>LIVEpro LMS</h3><p>Deliver engaging online courses with LIVEpro LMS. Create, manage, and track learning content for students, employees, or trainees. Supports video lessons, quizzes, certificates, and progress tracking.</p>', '', 'Contact for Pricing', 'Education', 'Course Builder\nVideo & Document Upload\nQuizzes & Assessments\nCertificates\nProgress Tracking\nStudent Dashboard\nBatch Management\nPayment Gateway Integration', 'Request Demo', 'contact.php', 3, 1),
('LIVEpro E-Commerce', 'Ready-to-deploy e-commerce platform with payment gateway integration.', '<h3>LIVEpro E-Commerce</h3><p>Launch your online store quickly with LIVEpro E-Commerce. Feature-rich, SEO-friendly, and mobile-responsive with support for multiple payment gateways and shipping providers.</p>', '', 'Contact for Pricing', 'eCommerce', 'Product Catalog\nShopping Cart\nPayment Gateway\nOrder Management\nInventory Tracking\nDiscount Coupons\nCustomer Reviews\nMulti-vendor Support', 'Get Started', 'contact.php', 4, 1),
('LIVEpro HR Portal', 'Human resource management system with attendance, leave, and payroll.', '<h3>LIVEpro HR Portal</h3><p>Automate your HR processes from recruitment to retirement. Track attendance, manage leaves, process payroll, and maintain employee records with ease.</p>', '', 'Contact for Pricing', 'Human Resource', 'Employee Database\nAttendance Tracking\nLeave Management\nPayroll Processing\nRecruitment Module\nPerformance Reviews\nDocument Management\nSelf-Service Portal', 'Request Demo', 'contact.php', 5, 1),
('LIVEpro SmartHome App', 'Mobile app to control and monitor home automation devices.', '<h3>LIVEpro SmartHome App</h3><p>Control your smart home devices from anywhere. LIVEpro SmartHome App integrates with popular IoT devices for lighting, security, climate, and energy management.</p>', '', 'Contact for Pricing', 'Mobile App', 'Device Control\nScheduling & Automation\nEnergy Monitoring\nSecurity Alerts\nVoice Control\nMulti-device Support\nReal-time Status\nCustom Scenes', 'Learn More', 'contact.php', 6, 1);

-- Seed default settings
INSERT INTO settings (setting_key, setting_value) VALUES
('site_name', 'LIVEpro Software Solutions'),
('site_tagline', 'Right Time... Right Place... Right People...'),
('logo', 'images/livelogo.webp'),
('contact_phone', '+91-940484560'),
('contact_phone2', '0712-2740470'),
('contact_phone3', '+91-9561079560'),
('contact_email', 'info@liveprosolutions.com'),
('contact_address', 'G7, G8, G9-A, Siddhesh Sai Apartment, Raghuji Nagar, Nagpur-440024'),
('facebook_url', 'https://facebook.com'),
('twitter_url', 'https://twitter.com'),
('youtube_url', 'https://youtube.com'),
('instagram_url', 'https://instagram.com'),
('linkedin_url', 'https://linkedin.com'),
('whatsapp_number', '91940484560'),
('announcement_text', ''),
('announcement_url', ''),
('google_maps_url', 'https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3721.1!2d79.08!3d21.14!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0x0!2zMjHCsDA4JzI0LjAiTiA3OcKwMDQnNDguMCJF!5e0!3m2!1sen!2sin!4v1');
