This is a to-do app made to sharpen my Vue JS and Laravel 8 skills
The app is made with Laravel as the backend that serves the app's APIs for the Vue Js frontend

*Set up procedure
----------------
1. Clone this project to your local storage
2. Run `composer install`
3. Run `npm install`
4. Create a new db for the app in your MySQL and name it `todoapp` or import the `todoapp.sql` in the file directory where you cloned this project 
5. Change the `.env.example` file to `.env` 
6. Edit the new `.env` file and update `DB_DATABASE = todoapp`
7. If you decided to make your own database,run `php artisan migrate` to set up the tables in the db else ignore this step if you imported mine
8. Then run `php artisan serve` to launch the application 
