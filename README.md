<p align="center">
    <a href="https://github.com/sandinur157" target="_blank"><img src="https://media.tenor.com/GfSX-u7VGM4AAAAC/coding.gif" width="400"></a>
</p>

## Tentang Aplikasi

Aplikasi e-Book ini didesain menggunakan laravel dan vue.js sebagai backendnya serta tailwind.css sebagai frontend utamanya. dalam aplikasi e-book ini diharapkan users dapat membaca segala banyak judul buku dan memesan buku yang ingin dibaca melalu aplikasi ini yang bisa diakses setiap saat.

## Instalasi
#### Via Git
```bash
git clone https://github.com/Team-Laravel-Apps/e-book.git
```

### Download ZIP
[Link](https://github.com/Team-Laravel-Apps/e-book/archive/refs/heads/master.zip)

### Setup Aplikasi
Jalankan perintah 
```bash
composer update
```
atau:
```bash
composer install
```
Copy file .env dari .env.example
```bash
cp .env.example .env
```
Konfigurasi file .env
```bash
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=e-book
DB_USERNAME=root
DB_PASSWORD=
```
Opsional
```bash
APP_NAME=Laravel
APP_ENV=local
APP_KEY=base64:gW2rmF4baCPsJ+kgutwrYRAtUVwBFpXeOMeDM7WrOJc=
APP_DEBUG=true
APP_URL=http://e-book
```
Generate key
```bash
php artisan key:generate
```
Migrate database
```bash
php artisan migrate
```
Seeder table User, Pengaturan
```bash
php artisan db:seed
```
Menjalankan aplikasi
```bash
php artisan serve
```

## License

[MIT license](https://opensource.org/licenses/MIT)
