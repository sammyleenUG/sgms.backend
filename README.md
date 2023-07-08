<center>API DOCUMENTATION</center>

**Setting up**
To set up the project, run the following artisan commands.
These commands assume you have your database setup (MYSQL)

- composer install
- php artisan migrate
- php artisan optimize:clear


**Running background processes**
The system is complete when the following cron jobs are running.

- php artisan bins:binEmptied ( set to run every minute)
- php artisan bins:binFull (set to run every minute)
- php artisan bins:update_status (set to run every 30 seconds)
- php artisan bins:recommendation (set to run every 6 hours)


