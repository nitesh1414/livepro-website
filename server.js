const express = require('express');
const fs = require('fs');
const path = require('path');
const cors = require('cors');

const app = express();
const PORT = process.env.PORT || 3000;
const DATA_FILE = path.join(__dirname, 'data', 'defaultData.json');
const DB_FILE = path.join(__dirname, 'data', 'database.json');

// Middleware
app.use(cors());
app.use(express.json({ limit: '10mb' }));
app.use(express.urlencoded({ extended: true }));
app.use(express.static(__dirname));

// Helper: Read Database
function readDatabase() {
  const fileToRead = fs.existsSync(DB_FILE) ? DB_FILE : DATA_FILE;
  try {
    const rawData = fs.readFileSync(fileToRead, 'utf8');
    return JSON.parse(rawData);
  } catch (error) {
    console.error("Error reading database:", error);
    return null;
  }
}

// Helper: Save Database
function saveDatabase(data) {
  try {
    if (!fs.existsSync(path.dirname(DB_FILE))) {
      fs.mkdirSync(path.dirname(DB_FILE), { recursive: true });
    }
    fs.writeFileSync(DB_FILE, JSON.stringify(data, null, 2), 'utf8');
    return true;
  } catch (error) {
    console.error("Error saving database:", error);
    return false;
  }
}

// ================= API ENDPOINTS =================

// GET full database
app.get('/api/db', (req, res) => {
  const db = readDatabase();
  if (!db) return res.status(500).json({ error: "Failed to read database" });
  res.json(db);
});

// PUT full database (Import / Reset)
app.put('/api/db', (req, res) => {
  const success = saveDatabase(req.body);
  if (!success) return res.status(500).json({ error: "Failed to save database" });
  res.json({ message: "Database updated successfully", db: req.body });
});

// GET / PUT Settings
app.get('/api/settings', (req, res) => {
  const db = readDatabase();
  res.json(db.settings);
});
app.put('/api/settings', (req, res) => {
  const db = readDatabase();
  db.settings = { ...db.settings, ...req.body };
  saveDatabase(db);
  res.json(db.settings);
});

// GET / POST / PUT / DELETE Services
app.get('/api/services', (req, res) => {
  const db = readDatabase();
  res.json(db.services);
});
app.post('/api/services', (req, res) => {
  const db = readDatabase();
  const newService = { id: `srv-${Date.now()}`, ...req.body };
  db.services.unshift(newService);
  saveDatabase(db);
  res.status(201).json(newService);
});
app.put('/api/services/:id', (req, res) => {
  const db = readDatabase();
  const idx = db.services.findIndex(s => s.id === req.params.id);
  if (idx === -1) return res.status(404).json({ error: "Service not found" });
  db.services[idx] = { ...db.services[idx], ...req.body };
  saveDatabase(db);
  res.json(db.services[idx]);
});
app.delete('/api/services/:id', (req, res) => {
  const db = readDatabase();
  db.services = db.services.filter(s => s.id !== req.params.id);
  saveDatabase(db);
  res.json({ message: "Service deleted successfully" });
});

// GET / POST / PUT / DELETE Courses
app.get('/api/courses', (req, res) => {
  const db = readDatabase();
  res.json(db.courses);
});
app.post('/api/courses', (req, res) => {
  const db = readDatabase();
  const newCourse = { id: `crs-${Date.now()}`, ...req.body };
  db.courses.unshift(newCourse);
  saveDatabase(db);
  res.status(201).json(newCourse);
});
app.put('/api/courses/:id', (req, res) => {
  const db = readDatabase();
  const idx = db.courses.findIndex(c => c.id === req.params.id);
  if (idx === -1) return res.status(404).json({ error: "Course not found" });
  db.courses[idx] = { ...db.courses[idx], ...req.body };
  saveDatabase(db);
  res.json(db.courses[idx]);
});
app.delete('/api/courses/:id', (req, res) => {
  const db = readDatabase();
  db.courses = db.courses.filter(c => c.id !== req.params.id);
  saveDatabase(db);
  res.json({ message: "Course deleted successfully" });
});

// GET / POST / PUT / DELETE Blog Posts
app.get('/api/posts', (req, res) => {
  const db = readDatabase();
  res.json(db.posts);
});
app.post('/api/posts', (req, res) => {
  const db = readDatabase();
  const newPost = { id: `pst-${Date.now()}`, ...req.body };
  db.posts.unshift(newPost);
  saveDatabase(db);
  res.status(201).json(newPost);
});
app.put('/api/posts/:id', (req, res) => {
  const db = readDatabase();
  const idx = db.posts.findIndex(p => p.id === req.params.id);
  if (idx === -1) return res.status(404).json({ error: "Post not found" });
  db.posts[idx] = { ...db.posts[idx], ...req.body };
  saveDatabase(db);
  res.json(db.posts[idx]);
});
app.delete('/api/posts/:id', (req, res) => {
  const db = readDatabase();
  db.posts = db.posts.filter(p => p.id !== req.params.id);
  saveDatabase(db);
  res.json({ message: "Post deleted successfully" });
});

// GET / POST / PUT / DELETE Testimonials
app.get('/api/testimonials', (req, res) => {
  const db = readDatabase();
  res.json(db.testimonials);
});
app.post('/api/testimonials', (req, res) => {
  const db = readDatabase();
  const newTestimonial = { id: `tst-${Date.now()}`, ...req.body };
  db.testimonials.unshift(newTestimonial);
  saveDatabase(db);
  res.status(201).json(newTestimonial);
});
app.put('/api/testimonials/:id', (req, res) => {
  const db = readDatabase();
  const idx = db.testimonials.findIndex(t => t.id === req.params.id);
  if (idx === -1) return res.status(404).json({ error: "Testimonial not found" });
  db.testimonials[idx] = { ...db.testimonials[idx], ...req.body };
  saveDatabase(db);
  res.json(db.testimonials[idx]);
});
app.delete('/api/testimonials/:id', (req, res) => {
  const db = readDatabase();
  db.testimonials = db.testimonials.filter(t => t.id !== req.params.id);
  saveDatabase(db);
  res.json({ message: "Testimonial deleted successfully" });
});

// GET / POST / PUT / DELETE Leaders & Mentors (About Us section)
app.get('/api/leaders', (req, res) => {
  const db = readDatabase();
  res.json(db.leaders || []);
});
app.post('/api/leaders', (req, res) => {
  const db = readDatabase();
  if (!db.leaders) db.leaders = [];
  const newLeader = { id: `ldr-${Date.now()}`, photo: "", status: "active", order: 10, ...req.body };
  db.leaders.push(newLeader);
  db.leaders.sort((a, b) => (a.order || 0) - (b.order || 0));
  saveDatabase(db);
  res.status(201).json(newLeader);
});
app.put('/api/leaders/:id', (req, res) => {
  const db = readDatabase();
  const idx = (db.leaders || []).findIndex(l => l.id === req.params.id);
  if (idx === -1) return res.status(404).json({ error: "Leader / Mentor not found" });
  db.leaders[idx] = { ...db.leaders[idx], ...req.body };
  saveDatabase(db);
  res.json(db.leaders[idx]);
});
app.delete('/api/leaders/:id', (req, res) => {
  const db = readDatabase();
  db.leaders = (db.leaders || []).filter(l => l.id !== req.params.id);
  saveDatabase(db);
  res.json({ message: "Leader / Mentor profile deleted successfully" });
});

// GET / POST / PUT / DELETE Inquiries
app.get('/api/inquiries', (req, res) => {
  const db = readDatabase();
  res.json(db.inquiries);
});
app.post('/api/inquiries', (req, res) => {
  const db = readDatabase();
  const newInquiry = { 
    id: `inq-${Date.now()}`, 
    date: new Date().toISOString().slice(0,10) + " " + new Date().toTimeString().slice(0,5),
    status: "new",
    ...req.body 
  };
  db.inquiries.unshift(newInquiry);
  saveDatabase(db);
  res.status(201).json(newInquiry);
});
app.put('/api/inquiries/:id', (req, res) => {
  const db = readDatabase();
  const idx = db.inquiries.findIndex(i => i.id === req.params.id);
  if (idx === -1) return res.status(404).json({ error: "Inquiry not found" });
  db.inquiries[idx] = { ...db.inquiries[idx], ...req.body };
  saveDatabase(db);
  res.json(db.inquiries[idx]);
});
app.delete('/api/inquiries/:id', (req, res) => {
  const db = readDatabase();
  db.inquiries = db.inquiries.filter(i => i.id !== req.params.id);
  saveDatabase(db);
  res.json({ message: "Inquiry deleted successfully" });
});

// Default Route: Serve Index.html
app.get('*', (req, res) => {
  res.sendFile(path.join(__dirname, 'index.html'));
});

// Start Server
app.listen(PORT, () => {
  console.log(`\n🟢 [LIVEpro CMS Server] running on http://localhost:${PORT}`);
  console.log(`📁 Serving frontend: index.html`);
  console.log(`🗄️ Database file: ${fs.existsSync(DB_FILE) ? DB_FILE : DATA_FILE}\n`);
});
