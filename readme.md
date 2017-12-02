About CRUD App
========================
These project is a simple CRUD example for using laravel, js, and JQuery; with simple encryption algorithm .

Creating Project Steps
========================
1) Clone Project.
2) Open the terminal then type : `composer install`.
3) Copy the `.env.example` file in the same directory.
4) Rename it to `.env` .
5) Generate application key using `php artisan key:generate` .
6) Set Your environment into the `.env` file .
7) Create your DB and then set DB info into the `.env` file .
8) Open the terminal then type `php artisan migrate` .
9) Into the file `public/js/main.js` in the `Config` method change the `base_url` variable.

Security in Requests
=========================
1) We call the encryption functions from the servr side 
  - these script is ``obfuscated`` script;
2) In each create/update request we encrypt data
3) In each set for data `loadItems` action
4) For more details you can see `sec.sec.true` file into `puplic/storage` directory.
  - These file ``obfuscated`` file;

