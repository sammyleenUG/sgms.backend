<center>API DOCUMENTATION</center>

**Setting up**
<p>To set up the project, run the following artisan commands.</p>
<p>These commands assume you have your database setup (MYSQL)</p>

- composer install
- php artisan migrate
- php artisan optimize:clear


**Running background processes**
<p>The system is complete when the following cron jobs are running.</p>

- php artisan bins:binEmptied ( set to run every minute)
- php artisan bins:binFull (set to run every minute)
- php artisan bins:update_status (set to run every 30 seconds)
- php artisan bins:recommendation (set to run every 6 hours)


