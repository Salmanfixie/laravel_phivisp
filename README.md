<h3 align="center">PhiViSp</h3>

---

<p align="center"> Social Engineering Quiz System using Laravel and Filament.
    <br> 
</p>

## 📝 Table of Contents

- [About](#about)
- [Installation](#installation)
- [Usage](#usage)

## 🧐 About <a name = "about"></a>

Complete project to educates about social engineering, with quiz module, phishing emails simulation, social engineering news, to improve cybersecurity awareness, built with Laravel & Filament.

### Installation

Clone the repo:
```
$ git clone https://github.com/Salmanfixie/laravel_phivisp.git
```

Install PHP dependencies:
```
composer install
```

Setup .env file:
```
cp .env.example .env
```

Generate application key:
```
php artisan key:generate
```

Run database migrations:
```
php artisan migrate
```

Run database seeder:
```
php artisan db:seed
```

Create a symlink to the storage:
```
php artisan storage:link
```

Run the development server:
```
php artisan serve
```

## 🎈 Usage <a name="usage"></a>

Create topics, questions, and quizzes using the admin account. Answer the quizzes using the user account.
Create, send, and educate people by sending phishing email using admin account.