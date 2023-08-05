Sistem Manajemen Logistik

Overview
This is a web-based logistics management system that provides various features to manage employees, orders, deliveries, shipment tracking, city-wise accounts receivable reports, and overall weekly reports. The system is built using Laravel framework with MySQL database, and AJAX, JavaScript, HTML, CSS, and jQuery for frontend interactivity.

Features
Manajemen Karyawan (Employee Management):

Add, edit, and delete employees.
View employee details, roles, and contact information.
Manajemen Order (Order Management):

Create, update, and delete customer orders.
Track the status of each order in real-time.
Assign employees to handle specific orders.
Manajemen Pengiriman (Delivery Management):

Schedule and manage deliveries.
Assign delivery routes to drivers.
Track delivery status and update in real-time.
Tracking Pengiriman (Shipment Tracking):

Provide a tracking mechanism for customers to track their shipments.
Send real-time updates on shipment status to customers.
Laporan Piutang Tiap Kota (City-wise Accounts Receivable Report):

Generate reports showing accounts receivable for each city served.
Monitor pending payments and outstanding balances.
Laporan Mingguan Keseluruhan (Overall Weekly Reports):

Generate weekly reports summarizing overall logistics operations.
View key performance metrics like orders processed, deliveries completed, and revenue generated.
Tech Stack
Laravel (Backend framework)
MySQL (Database)
AJAX (Asynchronous JavaScript and XML)
JavaScript (Frontend scripting)
HTML (Frontend markup)
CSS (Frontend styling)
jQuery (JavaScript library)
Installation
Clone the repository:

bash
Copy code
git clone https://github.com/your-username/logistics-management.git
cd logistics-management
Install PHP dependencies:

bash
Copy code
composer install
Create a .env file:

bash
Copy code
cp .env.example .env
Set up your database credentials in the .env file.

Generate an application key:

bash
Copy code
php artisan key:generate
Run migrations and seeders:

bash
Copy code
php artisan migrate --seed
Start the development server:

bash
Copy code
php artisan serve
Open your browser and access the application at http://localhost:8000.

Usage
Register as a new user or log in with existing credentials.

Navigate through the different sections of the logistics management system using the sidebar menu.

Perform various management tasks, such as adding employees, creating orders, scheduling deliveries, etc.

Generate reports for account receivables and overall weekly logistics operations.

Contributors
Achmad Rizal (@achmdrzl)
License
This project is licensed under the MIT License - see the LICENSE file for details.

Acknowledgments
Special thanks to the Laravel community and all the open-source contributors whose work has made this project possible.