# <p align="center">Laravel filament template</p>
<p align="center">
<a href="https://github.com/DanielvdSpoel/filament-template/actions"><img src="https://github.com/DanielvdSpoel/filament-template/workflows/tests/badge.svg" alt="Build Status"></a>
</p>

## About this template
This template can be used to quickly setup a new Laravel project with [Filament](https://filamentphp.com) and [TailwindCSS](https://tailwindcss.com/). It includes packages like Filament Shield en Filament breezy. It also includes a basic testsuite to get you started on test driven development.
## How to use this template
- Make sure you have [PHP 8.1](https://windows.php.net/), [Composer](https://getcomposer.org/download/) and [Node.js](https://nodejs.org/en/) installed.
- Pull the master branch of this repo
- Install composer dependencies `composer install`
- Copy .env.example to .env and fill in the database and mail details
- Generate an encryption key using `php artisan key:generate`
- Create and seed the database using `php artisan migrate --seed`
- Install frontend dependencies using `npm install`
- Create frontend build using `npm run build` (One time) or `npm run dev` (watches for changes)

## Updating to new master version
- Pull possible new changes
- Update Composer and Node.js dependencies (`composer install` and `npm install`)
- Build a new frontend build (`npm run dev`)
- Migrate database (`php artisan migrate`)

## Working on a new feature, bugfix or other change
- Update your local master version
- Create a new branch from master, use a prefix to mention the type of change (feature/example-feature)
- Work on the change
- Make sure there is a test for each endpoint you changed things in
- Make sure the tests and linters don't fail (they will run when you create a merge request)
- Create an merge request:
- Ask for a review

