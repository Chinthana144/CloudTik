## \## CloudTik – ISP Management System (Web Application)

## CloudTik is a full-featured Internet Service Provider (ISP) Management System designed for labor camps and shared internet environments.

## The system supports customer registration, subscription management, invoicing, MikroTik integration, and multi-camp operations.

## 

## \## Features

## \### Customer Management

## &nbsp;- Create, edit, and manage customers

## &nbsp;- Track device MAC addresses

## &nbsp;- Customer activity logs

## &nbsp;- Account status \& expiry tracking

## 

## \### Subscription \& Package Management

## &nbsp;- Create customizable packages (any number of days + price)

## &nbsp;- Categorize packages by customer type

## &nbsp;- Subscription renewal and recharge

## &nbsp;- View active, upcoming, and expired subscriptions

## 

## \### Invoice \& Payment System

## &nbsp;- Web-based invoice creation

## &nbsp;- Supports voucher and subscription invoices

## &nbsp;- Customer invoice history

## &nbsp;- Integrated with mobile application (CloudTik Sales)

## 

## \### MikroTik Integration

## &nbsp;- RouterOS API integration

## &nbsp;- Automatic hotspot user creation

## &nbsp;- MAC binding

## &nbsp;- Session login tracking

## 

## \### Multi-Camp Support

## &nbsp;- Manage different labor camps

## &nbsp;- Assign customers to camps

## &nbsp;- Camp-level reports

## &nbsp;- Camp-level package configuration

## 

## \### User Access Control

## &nbsp;- Role-based permissions \& gate policies

## &nbsp;- Admin, Manager, Salesperson roles

## &nbsp;- Access controlled by designation

## 

## \### Dashboard \& Reports

## &nbsp;- Daily/weekly/monthly sales

## &nbsp;- Active customers

## &nbsp;- Upcoming expiries

## &nbsp;- Package-based statistics

## 

## \## Tech Stack

## \- \*\*Backend:\*\* Laravel 10

## \- \*\*Frontend:\*\* Blade, jQuery, Bootstrap

## \- \*\*Database:\*\* MySQL

## \- \*\*API Integration:\*\* MikroTik RouterOS API

## \- \*\*Auth:\*\* Laravel Breeze / Sanctum

## \- \*\*Other Tools:\*\* Postman

## 

## \## Connected Mobile Application

## The CloudTik Sales mobile app (Flutter) integrates with this backend to allow sales teams to:

## &nbsp;- Register customers

## &nbsp;- Create subscriptions

## &nbsp;- Reset MAC address

## &nbsp;- View sales performance

## (Separate README will cover the mobile app.)

## 

## \## Screenshots

## !\[Dashboard](screenshots/dashboard.png)

## !\[Customer List](screenshots/subscriptions.png)

## !\[Invoice Page](screenshots/logged.png)

## 

## \## Installation Guide

## Follow the steps below to install and run the CloudTik web application on your local environment.

## 

## \### Clone the Repository

## &nbsp;   git clone https://github.com/your-username/CloudTik.git

## &nbsp;   cd CloudTik

## 

## \### Install PHP Dependencies

## &nbsp;   composer install

## 

## \### Install Frontend Dependencies

## &nbsp;   npm install

## &nbsp;   npm run build

## (Or use npm run dev during development.)

## 

## \### Environment Setup

## Copy the example environment file:

## 

## &nbsp;   cp .env.example .env

## 

## Generate application key:

## 

## &nbsp;   php artisan key:generate

## 

## Now update your .env file with:

## \- \*\*Database credentials\*\*

## \- \*\*MikroTik API settings\*\*

## \- \*\*Stripe keys (if using payments)\*\*

## \- \*\*APP\_URL\*\*

## 

## \## Run Migrations

## &nbsp;   php artisan migrate

## 

## \*\*Note: After migration is completed run the 'initialize.sql' file in database to initialize settings and access\*\*

## 

## \## Start the Development Server

## &nbsp;   php artisan serve

## 

## The CloudTik web system should now be running locally.

## 

## \## Deployment Instructions for cloud

## &nbsp;- add the files in hotspot folder to the files in Mikrotik (login is executed by API, change the API link in login.html as necessary)

## &nbsp;- add Walled Garden rule to Mikrotik depending on the hosting domain.

## &nbsp;- add schedule to hosting platform to execute expired users, \*\*subscriptions:check-expired\*\*

## 

## \## Future Improvements

## &nbsp;- Implement voucher issue for none registered customers

## &nbsp;- Advanced analytics and reporting

## &nbsp;- Auto-expiry notifications via WhatsApp / SMS

## &nbsp;- Complete multi-language support

## &nbsp;- More detailed hotspot user analytics

## 

## \## Connect with me  

## \- LinkedIn: \*www.linkedin.com/in/chinthana-edirisinghe-42399321a\*  

## \- Email: \*chinthana144@gmail.com\*  

## 

## Thanks for visiting my profile!



