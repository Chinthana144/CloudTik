## CloudTik – ISP Management System (Web Application)
CloudTik is a full-featured Internet Service Provider (ISP) Management System designed for labor camps and shared internet environments.
The system supports customer registration, subscription management, invoicing, MikroTik integration, and multi-camp operations.

## Features
### Customer Management
 - Create, edit, and manage customers
 - Track device MAC addresses
 - Customer activity logs
 - Account status & expiry tracking

### Subscription & Package Management
 - Create customizable packages (any number of days + price)
 - Categorize packages by customer type
 - Subscription renewal and recharge
 - View active, upcoming, and expired subscriptions

### Invoice & Payment System
 - Web-based invoice creation
 - Supports voucher and subscription invoices
 - Customer invoice history
 - Integrated with mobile application (CloudTik Sales)

### MikroTik Integration
 - RouterOS API integration
 - Automatic hotspot user creation
 - MAC binding
 - Session login tracking

### Multi-Camp Support
 - Manage different labor camps
 - Assign customers to camps
 - Camp-level reports
 - Camp-level package configuration

### User Access Control
 - Role-based permissions & gate policies
 - Admin, Manager, Salesperson roles
 - Access controlled by designation

### Dashboard & Reports
 - Daily/weekly/monthly sales
 - Active customers
 - Upcoming expiries
 - Package-based statistics

## Tech Stack
**Backend:** Laravel 10
**Frontend:** Blade, jQuery, Bootstrap
**Database:** MySQL
**API Integration:** MikroTik RouterOS API
**Auth:** Laravel Breeze / Sanctum
**Other Tools:** Postman

## Connected Mobile Application
The CloudTik Sales mobile app (Flutter) integrates with this backend to allow sales teams to:
 - Register customers
 - Create subscriptions
 - Reset MAC address
 - View sales performance
(Separate README will cover the mobile app.)


 - Reset MAC address
View sales performance
(Separate README will cover the mobile app.)
