## 📦 Installation

Follow these steps to get the project up and running:

```bash
# 1. Clone the repository
git clone https://github.com/protex121/test_tirtakencana.git
cd test_tirtakencana

# 2. Install PHP dependencies
composer install

# 3. Install JavaScript dependencies
npm install

# 4. Create .env file and set up your DB credentials
cp .env.example .env (linux/mac os) or copy .env.example .env (windows)
php artisan key:generate

# 5. Link storage
php artisan storage:link

# 6. Import table SQL (the test table) in folder sql

# 7. Run migrations
php artisan migrate

# 8. Run Seeder
php artisan db:seed

## 📦 Runnning Project
Follow these steps to get the project up and running:

# Start the Laravel development server
php artisan serve

# Start the frontend build process
npm run dev

# for the example import file is on folder 'test_import_example_file'

# Example user that can be used
# email : admin@argon.com
# password: secret
