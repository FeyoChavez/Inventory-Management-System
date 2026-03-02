# Inventory Management System | Laravel & Livewire

A high-performance, robust administrative platform designed to manage complex inventory logistics, branch synchronization, and supplier procurement. This project focuses on relational data integrity and a seamless user experience using the TALL stack (Bootstrap, Alpine, Laravel, Livewire).

## 🖥️ Key Features
- Multi-Branch Synchronization: Manage stock levels across different physical locations with N:N relational mapping.
- Complex Categorization: Dynamic product classification with hierarchical support.
- Supplier & Purchase Tracking: Full lifecycle management of purchase orders and supplier lots.
- Real-time Interactivity: Built with Livewire to provide a reactive, SPA-like feel without leaving the Laravel ecosystem.
- Advanced Data Relations:
     * Products linked to multiple branches with independent stock counts.Provider lots associated with specific categories and procurement dates.
     * Referential integrity enforced at the database level.


## 🛠️ Tech Stack
- Framework: Laravel 12 (Latest stable)Frontend: Livewire, Alpine.js, AdminLTE 3 (Dashboard Template)
- Database: MySQLORM/Data Layer: Eloquent & Sequelize (Data modeling and migrations)
- Styling: Tailwind CSS / Bootstrap (via AdminLTE)

## 📊 Database Architecture
The core of this system is its relational schema, designed to handle complex business logic:
- Many-to-Many (N:N): Products $\leftrightarrow$ Branches.
- One-to-Many (1:N): Suppliers $\leftrightarrow$ Lots; Categories $\leftrightarrow$ Products.
- Integrity: Uses foreign keys and cascading constraints to ensure data consistency across all modules (Purchases, Inventory, and Sales).

## 🚀 Local Setup
git clone https://github.com/FeyoChavez/Sistema-Gestion-Inventario.git

composer install

npm install && npm run dev

php artisan key:generate

php artisan migrate --seed

php artisan serve


## Preview
<img width="1920" height="993" alt="sisinventario" src="https://github.com/user-attachments/assets/c1fedee5-74e9-42a0-b1be-82f60e55acb3" />
