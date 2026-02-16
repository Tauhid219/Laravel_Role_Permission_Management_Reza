Useful Link: https://www.youtube.com/playlist?list=PLRheCL1cXHrvudrJ1NyNsF4Rw_1qhsG7X

Useful Link: https://spatie.be/docs/laravel-permission/v6/introduction

Useful Link for Help: https://www.itsolutionstuff.com/post/laravel-11-user-roles-and-permissions-tutorialexample.html

Fisrt Migration, Then Seeding. 
Seeding Super Admin: php artisan db:seed 
Credential-- Name: Ahmad, Email: ahmad@gmail.com, Password: 12345678 . 

Steps: 

1. git clone https://github.com/Tauhid219/Laravel_Role_Permission_Management_Reza.git
2. cd Laravel_Role_Permission_Management_Reza 
3. composer install 
4. npm install && npm run build 
5. cp .env.example .env 
6. php artisan key:generate
7. php artisan migrate 
8. php artisan db:seed 
9. php artisan serve 

## 🚀 Export to Another Project (New Feature)
If you have another Laravel project and want to add Role & Permission Management to it:

1. Clone this repository alongside your target project.
2. Run the export command from this project:
   ```bash
   php artisan role-permission:export "C:/path/to/your/target-project"
   ```
3. Follow the instructions shown in the terminal (install Spatie, migrate, seed). 