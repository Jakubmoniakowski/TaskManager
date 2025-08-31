<p align="center">
    <a href="https://laravel.com" target="_blank">
        <img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo">
    </a>
</p>

<h1 align="center">TaskManager</h1>

<p align="center">
Aplikacja do zarządzania zadaniami (Laravel 12 + Livewire).
</p>

---

## Wymagania

- **Docker** + **Docker Compose**
- **Git** do klonowania repozytorium

---

## Klonowanie repozytorium

```bash
git clone https://github.com/Jakubmoniakowski/TaskManager.git
cd TaskManager
``` 
## Uruchomienie kontenerów w folderze projektu- poza kontenerem
```bash
docker compose up -d --build
``` 
## Instalowanie zależności PHP- wewnątrz kontenera
```bash
composer install
``` 
## Instalowanie paczek Node.js- wewnątrz kontenera
```bash
npm install
npm run build
``` 
## Migracja bazy danych- wewnątrz kontenera
```bash
php artisan migrate
``` 
## Uruchomienie testów jednostkowych- wewnątrz kontenera
```bash
php artisan test lub ./vendro/bin/pest


