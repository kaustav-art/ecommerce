# CodeIgniter 3 Materialize Admin Template (Full Version)

The entire **Materialize Vertical Menu Template (all 147 HTML pages)** has been fully converted into **CodeIgniter 3**.

---

## 📁 Project Structure

```
admin-template/
├── application/
│   ├── config/
│   │   ├── config.php          # Dynamic base_url & blank index_page configured
│   │   ├── autoload.php        # Autoloads 'url', 'file', 'form', 'html' helpers
│   │   └── routes.php          # Dynamic routing for all 147 template pages
│   ├── controllers/
│   │   ├── Dashboard.php       # Modular Dashboard controller
│   │   ├── Starter.php         # Clean starter boilerplate controller
│   │   ├── Auth.php            # Authentication (Login / Logout) controller
│   │   └── Pages.php           # Dynamic controller serving all 147 pages
│   ├── core/
│   │   └── MY_Controller.php   # Base Controller with layout rendering helpers
│   └── views/
│       ├── layouts/            # Modular Layout Components
│       │   ├── header.php      # HTML Head, Meta, CSS links, and scripts
│       │   ├── sidebar.php     # Vertical menu with dynamic CI3 routes
│       │   ├── navbar.php      # Top navbar (search, notifications, profile)
│       │   ├── footer.php      # Footer and core JavaScript libraries
│       │   ├── auth_header.php # Head & styling for Auth / Blank pages
│       │   └── auth_footer.php # Scripts for Auth / Blank pages
│       ├── pages/              # ALL 147 CONVERTED TEMPLATE PAGES
│       │   ├── dashboards-analytics.php
│       │   ├── dashboards-crm.php
│       │   ├── app-ecommerce-dashboard.php
│       │   ├── app-ecommerce-product-list.php
│       │   ├── app-ecommerce-product-add.php
│       │   ├── app-ecommerce-order-list.php
│       │   ├── app-chat.php
│       │   ├── app-calendar.php
│       │   ├── app-kanban.php
│       │   ├── app-invoice-list.php
│       │   ├── app-user-list.php
│       │   ├── tables-datatables-basic.php
│       │   ├── form-validation.php
│       │   ├── auth-login-basic.php
│       │   ├── auth-register-basic.php
│       │   └── ... (all 147 pages)
│       ├── auth/
│       │   └── login.php
│       ├── dashboard.php
│       └── starter.php
├── assets/                     # Complete template assets (vendor, css, js, img, fonts)
├── .htaccess                   # Clean URL rewriting (removes index.php)
└── index.php                   # Front controller
```

---

## 🌐 How to Browse Pages

You can access any page directly via your browser:

* **Dashboard**: `http://localhost/ecommerce/admin-template/` or `http://localhost/ecommerce/admin-template/dashboard`
* **Starter Page**: `http://localhost/ecommerce/admin-template/starter`
* **Login**: `http://localhost/ecommerce/admin-template/login`
* **Any Template Page**:
  - Products List: `http://localhost/ecommerce/admin-template/app-ecommerce-product-list`
  - Add Product: `http://localhost/ecommerce/admin-template/app-ecommerce-product-add`
  - Orders: `http://localhost/ecommerce/admin-template/app-ecommerce-order-list`
  - Chat: `http://localhost/ecommerce/admin-template/app-chat`
  - Calendar: `http://localhost/ecommerce/admin-template/app-calendar`
  - DataTables: `http://localhost/ecommerce/admin-template/tables-datatables-basic`
  - Forms: `http://localhost/ecommerce/admin-template/forms-basic-inputs`
  - Register: `http://localhost/ecommerce/admin-template/auth-register-basic`
  - *(All 147 pages are accessible by their filename without `.html`)*

All sidebar and navbar links are automatically mapped to CodeIgniter routes, so you can simply click through the navigation menu.

---

## 🛠️ How to Use in Future Projects

### 1. Reusing Converted Pages
All 147 template pages are located in [`application/views/pages/`](file:///C:/xampp/htdocs/ecommerce/admin-template/application/views/pages/).
Every page has its asset paths (`<?= base_url('assets/...'); ?>`) and navigation links (`<?= site_url('...'); ?>`) already configured. You can copy any page or its components (cards, forms, tables, wizards) directly into your future project views.

### 2. Building New Pages with the Modular Layout
Extend `MY_Controller` and call `$this->render('your_view', $data)`:

```php
<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Orders extends MY_Controller {

    public function index()
    {
        $data['title'] = 'Orders | Admin';
        $data['active_menu'] = 'ecommerce';
        $this->render('orders/index', $data);
    }
}
```
