# MLE Inventory Tool

The **MLE Inventory Tool** is a web-based inventory management system designed for tracking, assigning, returning, and maintaining assets within the MLE (Monitoring, Learning, and Evaluation) department. Built using **Mini-PHP (MVC framework)**, it features authentication, role-based access control, and a streamlined workflow for managing inventory items.

## Key Features:
- **User Authentication & Role Management**  
  Secure login system with access control for IT, QA/QC, and MLE teams.

- **Inventory Tracking**  
  Log, view, assign, and return items with real-time updates.

- **Item Assignment & Acknowledgment**  
  Assign inventory to users, requiring them to acknowledge receipt.

- **Return & Approval Workflow**  
  Users can return items, and admins can approve and update asset statuses (functional, damaged, lost).

- **Repair & Disposal Management**  
  Track repairable and unrepairable items, ensuring proper asset management.

- **Search & Reporting**  
  Easily filter inventory based on category, status, and assigned user.

## Tech Stack:
- **Backend:** PHP (Mini-PHP MVC)
- **Database:** MySQL
- **Frontend:** HTML, Bootstrap, JavaScript (for interactivity)
- **Authentication:** Session-based login system

## Installation:
1. Clone the repository:  
   ```bash
   https://github.com/EvidenceActionAfrica/mle_inventory_tool.git
   ```
2. Configure database connection in `app/config/database.php`:  
   ```php
   define('DB_HOST', 'localhost');
   define('DB_NAME', 'mini');
   define('DB_USER', 'root');
   define('DB_PASS', '');
   define('DB_CHARSET', 'utf8');
   ```
3. Import the database schema from `database/schema.sql`.
4. Start a local development server:  
   ```bash
   php -S localhost:8000 -t public
   ```
5. Access the tool at: **http://localhost:8000**

Accessing Credentials...
admin@test.com - super admin....password-p@55word
tech@test.com - IT..............password-mle2025
quality@test.com - QA/QC........password-mle2025
staff@test.com - Mle user.......password-mle2025