MDRRMC MIS INSTALLATION GUIDE

Installation Steps:

1. Clone the repository:
   git clone https://github.com/exequieltahop/mdrrmc-mis.git

2. Copy the .env.example file into the root directory:
   cp .env.example .env

3. Rename .env.example to .env (if not already done).

4. Install dependencies:
   composer install
   npm install

5. Update dependencies:
   composer update
   npm update

6. Generate the application key:
   php artisan key:generate

7. Create a database in XAMPP, Laragon, or MySQL.

8. Open the .env file and:
   - Change DB_CONNECTION=sqlite to DB_CONNECTION=mysql
   - Set the correct database credentials:
     DB_DATABASE=your_database_name
     DB_USERNAME=your_username
     DB_PASSWORD=your_password

9. Run database migrations with seed data:
   php artisan migrate:fresh --seed

---

Requirements:

- Git
- Composer
- PHP 8.2 or above (Make sure XAMPP is updated)
- Node.js
- MySQL

---

Additional Notes:
- Ensure Apache and MySQL are running in XAMPP/Laragon before proceeding.
- If you encounter permission issues, try running the commands with sudo (for macOS/Linux).
