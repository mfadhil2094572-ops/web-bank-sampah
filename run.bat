@echo off
cd /d %~dp0
echo Running seeders...
php database\seed\seed_admin.php
php database\seed\seed_waste_types.php
echo Starting PHP built-in server on http://localhost:8000
php -S localhost:8000 -t public
