# Laravel Role & Permission Management System

A complete, reusable Role and Permission management system for Laravel 11 using Spatie Permission v6.

## 📺 Tutorials & Resources
- **Tutorial Playlist:** [YouTube Link](https://www.youtube.com/playlist?list=PLRheCL1cXHrvudrJ1NyNsF4Rw_1qhsG7X)
- **Spatie Documentation:** [Laravel Permission Docs](https://spatie.be/docs/laravel-permission/v6/introduction)
- **Helpful Article:** [ITSolutionStuff Tutorial](https://www.itsolutionstuff.com/post/laravel-11-user-roles-and-permissions-tutorialexample.html)

## 🚀 Quick Start (Installation)

### Prerequisites
- PHP 8.2+
- Composer
- Node.js & NPM

### Steps
1. **Clone the Repository**
   ```bash
   git clone https://github.com/Tauhid219/Laravel_Role_Permission_Management_Reza.git
   cd Laravel_Role_Permission_Management_Reza
   ```

2. **Install Dependencies**
   ```bash
   composer install
   npm install && npm run build
   ```

3. **Environment Setup**
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```

4. **Database Configuration**
   - Create a database (e.g., `laravel_role_permission`)
   - Update `.env` with your database credentials.

5. **Migrate and Seed**
   ```bash
   php artisan migrate
   php artisan db:seed
   ```
   > **Default Super Admin:**
   > - **Name:** Ahmad
   > - **Email:** ahmad@gmail.com
   > - **Password:** 12345678

6. **Run the Server**
   ```bash
   php artisan serve
   ```

---

## 📦 Export to Another Project (Key Feature)

Safely export this entire Role & Permission system to any existing or new Laravel project using a single command.

### Step 1: Clone & Export
Clone this repository alongside your target project and run the export command:

```bash
# In this project's terminal
php artisan role-permission:export "C:/path/to/your/target-project"
```

This command will automatically copy:
- ✅ Controllers (Role, Permission, User, Product)
- ✅ Views (Blade files)
- ✅ Routes (`web.php`)
- ✅ Seeders
- ✅ Requests (Validation logic)

### Step 2: Configure Target Project
After exporting, switch to your **target project** terminal and follow these steps:

1. **Install Spatie Package**
   ```bash
   composer require spatie/laravel-permission
   ```

2. **Publish Configuration**
   ```bash
   php artisan vendor:publish --provider="Spatie\Permission\PermissionServiceProvider"
   ```

3. **Run Migrations**
   ```bash
   php artisan migrate
   ```

4. **Add Trait to User Model**
   Open `app/Models/User.php` and add the `HasRoles` trait:
   ```php
   use Spatie\Permission\Traits\HasRoles;

   class User extends Authenticatable
   {
       use HasRoles, Notifiable; // Add 'HasRoles' here
       // ...
   }
   ```

5. **Update Database Seeder**
   Open `database/seeders/DatabaseSeeder.php` and register the seeders:
   ```php
   public function run(): void
   {
       $this->call([
           PermissionSeeder::class,
           RoleSeeder::class,
           UserSeeder::class,
       ]);
   }
   ```

6. **Seed Database**
   ```bash
   php artisan db:seed
   ```

🎉 **Done!** Your project now has a fully functional Role & Permission management system.