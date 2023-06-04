# Project Name

Brief description of your project.

## Table of Contents

- [Project Overview](#project-overview)
- [Installation](#installation)
- [Usage](#usage)


## Project Overview

Provide a brief overview of your project. Explain what it does and why it is useful or interesting.

## Installation

Provide step-by-step instructions on how to install and set up your project. Include any dependencies that need to be installed and any additional configuration that needs to be done.

1. Clone repositori ini ke mesin lokal:
 ```bash
   git clone https://github.com/sulistyop/recap-app.git
```
2. Masuk ke direktori project
 ```bash
   cd repo
```
3. Instal semua dependensi menggunakan Composer dan NPM:
```bash
  composer install
  npm install
```
4. Salin berkas .env.example menjadi .env dan sesuaikan pengaturan database dan konfigurasi lain yang dibutuhkan:
```bash
  cp .env.example .env
```

5. Generate key aplikasi:
```bash
  php artisan key:generate
```

6. Migrasikan basis data beserta seeder yang sudah disediakan:
```bash
  php artisan migrate:fresh --seed
```

7. Generate kunci enkripsi Passport:
```bash
  php artisan passport:install
```




## Usage

Jalankan server pengembangan menggunakan perintah :

```bash
  php artisan serve
```
