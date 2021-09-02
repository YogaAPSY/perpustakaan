## Cara Install Laravel dari Github ke Local

Laravel is a web application framework with expressive, elegant syntax. We believe development must be an enjoyable and creative experience to be truly fulfilling. Laravel takes the pain out of development by easing common tasks used in many web projects, such as:

- git clone hhttps://github.com/YogaAPSY/perpustakaan atau download filenya dan arahkan ke folder htdocs atau sejenisnya.
- composer install.
- buat db di phpmyadmin/sejenis.
- cp .env.example .env.
- Setting db didalam .env sesuai nama db yg sudah dibuat.
- php artisan migrate.
- php artisan db:seed.
- Jalankan XAMPP/Sejenisnya.
- php artisan serve (jika ingin menjalankan denga url http://127.0.0.1:8000 atau http://localhost:8000 ).
- Jika tidak ingin menggunakan diatas bisa lewatkan step php artisan serve dan jalankan project denga localhost/nama_folder/public
- Fitur reset password hanya bisa menggunakan email yang valid

## Username dan Password Admin
- Username : admin@admin.com
- Password : password

## Username dan Password User
- Username : user@gmail.com
- Password : password
