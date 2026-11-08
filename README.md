# 🍔 FoodExpress – Online Food Ordering & Delivery Management System

FoodExpress is a web-based food ordering and delivery management system developed to simplify the process of ordering food, managing restaurant orders, and handling deliveries through a single platform.

The system provides separate dashboards and functionalities for customers, restaurant administrators, and delivery personnel.

## ✨ Features

### 👤 Customer
- Customer registration and login.
- Browse available food items and categories.
- Add food items to the shopping cart.
- Place food orders.
- View order history and order status.
- Manage personal profile information.

### 🛠️ Restaurant Admin
- Admin authentication and dashboard.
- Add, edit, and manage food menu items.
- Manage food categories.
- View incoming customer orders.
- Accept or reject orders.
- Update order preparation and processing status.

### 🚚 Delivery Person
- Dedicated delivery dashboard.
- View assigned delivery orders.
- Update delivery status.
- Track ongoing deliveries.
- View completed delivery history.

## 🧰 Technologies Used

| Technology | Purpose |
|---|---|
| PHP | Backend development |
| MySQL | Database management |
| HTML5 | Web page structure |
| CSS3 | Styling and layout |
| JavaScript | Client-side functionality |
| AJAX | Asynchronous communication |
| XAMPP | Local development environment |

## 📁 Project Structure

```text
FoodExpress/
│
├── admin/
│   ├── dashboard.php
│   ├── menu.php
│   └── orders.php
│
├── ajax/
│   ├── admin.php
│   ├── auth.php
│   ├── customer.php
│   ├── delivery.php
│   └── profile.php
│
├── config/
│   └── database.php
│
├── customer/
│   ├── cart.php
│   ├── dashboard.php
│   ├── menu.php
│   └── orders.php
│
├── database/
│   └── foodExpress.sql
│
├── delivery/
│   ├── dashboard.php
│   ├── deliveries.php
│   └── history.php
│
├── includes/
│   ├── auth.php
│   ├── config.php
│   ├── footer.php
│   └── header.php
│
├── js/
│   ├── admin.js
│   ├── auth.js
│   ├── customer.js
│   ├── delivery.js
│   └── main.js
│
├── index.php
├── login.php
├── logout.php
├── profile.php
├── register.php
├── setup.php
└── style.css
```

## ⚙️ Installation and Setup

Follow these steps to run FoodExpress locally.

### Prerequisites
- XAMPP (Apache and MySQL)
- PHP
- MySQL database
- Web browser

### Step 1: Clone the Repository

```bash
git clone https://github.com/YOUR-USERNAME/FoodExpress.git
```

### Step 2: Move the Project

Copy the project folder into your XAMPP `htdocs` directory.

```text
C:\xampp\htdocs\FoodExpress
```

### Step 3: Start XAMPP

Start the following services:
- Apache
- MySQL

### Step 4: Import the Database

1. Open phpMyAdmin: `http://localhost/phpmyadmin`
2. Go to the Import section.
3. Select `database/foodExpress.sql`.
4. Import the SQL file.

This will create the `foodExpress` database and its required tables.

### Step 5: Configure Database Connection

Open `config/database.php` and configure your database credentials if necessary.

Default XAMPP configuration:

```php
$host = "localhost";
$db   = "foodExpress";
$user = "root";
$pass = "";
```

### Step 6: Configure the Base URL

Open `includes/config.php` and ensure the base URL matches your project folder.

```php
define('BASE_URL', '/FoodExpress');
```

### Step 7: Run the Setup Script

Visit:

```text
http://localhost/FoodExpress/setup.php
```

This creates demo accounts and sample food menu items.

### Step 8: Launch FoodExpress

Open your browser and visit:

```text
http://localhost/FoodExpress/
```

You can now register as a customer or log in using a demo account.

## 🔑 Demo Login Credentials

All demo accounts use the same password.

**Password:** `123456`

| Role | Email |
|---|---|
| Customer | customer@foodexpress.com |
| Admin | admin@foodexpress.com |
| Delivery Person | delivery@foodexpress.com |

## 🔄 Order Management Workflow

1. A customer browses the food menu and adds items to the cart.
2. The customer places an order.
3. The restaurant admin reviews and processes the order.
4. A delivery person handles assigned deliveries.
5. The delivery status is updated until the order is delivered.

## 🎯 Project Objective

The primary objective of FoodExpress is to develop an integrated online food ordering platform that connects customers, restaurant administrators, and delivery personnel while demonstrating practical web development, database management, and role-based access control.

## 👩‍💻 Contributors

Developed as an academic Web Technologies project.

---

**FoodExpress – Order Food. Manage Orders. Deliver Happiness.** 🍔
