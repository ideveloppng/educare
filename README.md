EduCare SaaS | Multi-Tenant School Management System

Laravel TailwindCSS MySQL PHP

Engineered by: Codecraft Developers Limited

EduCare is a high-fidelity, multi-tenant Software-as-a-Service (SaaS) platform
designed for primary and secondary institutions. It streamlines academic
operations, financial management, and institutional communication into a
unified, mobile-responsive ecosystem.

🚀 Key Features

💎 Super Admin (The Provider)

  - Institution Management: Full lifecycle control of subscribed schools
    (Create, Edit, Suspend, Delete).
  - Subscription Architecture: Automated 30-day free trials and tiered
    monthly/yearly plans.
  - Revenue Audit: Real-time tracking of subscription payments and verified
    proof-of-payment.
  - Bank Setup: Global management of receiving bank accounts for SaaS
    subscriptions.
  - Global Support: Configuration of help channels (WhatsApp, Email, Social
    Media) for all clients.

🏫 School Admin (The Manager)

  - Self-Onboarding: Generation of unique registration keys for public
    enrollment of students and staff.
  - Academic Setup: Management of Class Arms (e.g., JSS 1A, JSS 1B) and Subject
    mapping.
  - Timetable Master: Drag-and-drop style grid for scheduling lessons and school
    activities (Breaks, Assembly).
  - Parent-Student Linking: Centralized hub for approving parent requests to
    link student profiles.
  - Financial Oversight: Executive view of total revenue, operating expenses,
    and payroll commitments.

👨‍🏫 Teacher Persona

  - Attendance Registry: Daily digital roll call with "Present/Absent/Late"
    tracking.
  - Assessment Terminal: Specialized Marks Entry for 3 Continuous Assessments
    (10 marks each) and Exams (70 marks).
  - Classroom Management: Access to assigned class registries and personal
    teaching schedules.
  - Task Distribution: Create and distribute assignments with file attachments
    (PDF/Docs).

🎓 Student & Parent Portal

  - Mobile-First Design: "App-like" floating pill navigation for an immersive
    mobile experience.
  - Result Checker: Secure gateway requiring Serial Number and PIN (locked to
    student and term upon first use).
  - Fee Management: Itemized class billings and manual bank transfer proof
    upload system.
  - Academic Hub: Access to personal timetables, assignments, and school-wide
    announcements.

💰 Accountant Persona

  - General Ledger: Comprehensive audit trail of all institutional credits
    (Income) and debits (Expenses).
  - Verification Pipeline: Interface to verify student payment proofs and sync
    them with the ledger.
  - Payroll Engine: Monthly salary processing with automated statutory
    deductions (Pension & PAYE Tax).

🛠 Tech Stack & Architecture

  - Backend: PHP 8.2+ with Laravel 11 Framework.
  - Frontend: Tailwind CSS for high-fidelity UI and Alpine.js for reactive
    components.
  - Database: MySQL (Structured for Multi-tenancy using school_id scoping).
  - Security: Role-based access control (RBAC) and Subscription-based Middleware
    protection.
  - Storage: Secure local/cloud disk integration for student passports and
    payment proofs.
  - Identity: Unified users table for authentication with separate profiles for
    data isolation.

📦 Installation Guide

1.  Clone the Repository:

    git clone https://github.com/your-username/edunexus.git
    cd edunexus

2.  Install Dependencies:

    composer install
    npm install && npm run build

3.  Environment Setup:

    cp .env.example .env
    php artisan key:generate

4.  Database Configuration:

      - Create a MySQL database named edunexus.
      - Update .env with your DB credentials.

    php artisan migrate --seed

5.  Initialize Storage:

    php artisan storage:link

6.  Run the App:

    php artisan serve

🎨 UI/UX Standards

  - Typography: Inter / Sans-Serif, Font-Black (900), All-Caps headers for an
    authoritative feel.
  - Components: Custom-built 3rem rounded cards, glass-morphism overlays, and
    backdrop-blur modals.
  - Responsiveness: Desktop sidebar transition to Mobile Floating Pill
    navigation.
  - Terminology: Simple, straightforward language (e.g., "Password" instead of
    "Security Key").

📄 License & Attribution

This software is the intellectual property of Codecraft Developers Limited.

Unauthorized copying, modification, or distribution of this core infrastructure
is strictly prohibited.

Copyright © 2024 Codecraft Developers Limited. All Rights Reserved.

📬 Contact the Developers

For technical inquiries or system management, visit the Help Center within the
portal or contact us at support@codecraft.com.
