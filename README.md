An application for creating travel packages by the admin and making reservations by users and admin
(HTML5, CSS, Bootstrap 5, PHP, SQL, Laravel).

<h3 align="left">Description</h3>

Admin has a 'Settings' option in the navigation bar, allowing them to create, delete, and modify destinations, hotels, and blogs. The admin can delete reviews but cannot post them. They have the authority to create reservations for unregistered users and access all reservation information. Admin can create and/or delete reservations. They also have a list of all users and can modify their roles. The roles include 'user' and 'admin'.

Logged-in users can reserve desired trips, ensuring they don't reserve the same trip multiple times. In their profile, they have access to all their reservation details. They can create blogs, edit, and delete their own blogs. Users can comment on blogs and can modify or delete their comments. For completed trips, they can leave feedback, with the provision that only one feedback submission is allowed per trip.

An unauthenticated user can view all available trips but cannot create reservations. They can also see reviews and blogs but are unable to leave comments.

You can chack this app on YT: https://www.youtube.com/watch?v=Eu-vALg9YKo

<h3 align="left">Iinstallation and settings</h3>

1. Clone the repository
2. composer install
3. Copy env.example to .env file and configure the database settings.
4. php artisan key:generate
5. Run npm install (you may need to run npm audit and npm audit fix if the installed versions are outdated and require updating).
6. npm run build
7. Run php artisan migrate (ensure that the database settings in the .env file are configured and that the database is created in phpMyAdmin or a similar tool).
8. php artisan serve







