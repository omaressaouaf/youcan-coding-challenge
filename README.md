## YouCan Coding Challenge Software Engineer application by Omar Essaouaf

The coding challenge implements the 2 required features:
1. Ability to create a product (from web and cli)
2. A listing products with ability to sort by price, filter by a category (from web)

![web version](https://lh3.googleusercontent.com/55_5XeWggLqAZrn5-wjBXaxqGt-ynEUytsZNbZt0LVOx-7L2N8JLv2y9ovqxhZctJEE4IYa4M_t43sN9dxwOjTygFXCxrgMF1xtnIr3Hb9rhWYMtNdywycpDeD_TpJmY3O0fbefkxg=w2400)

![cli version](https://lh3.googleusercontent.com/7mqbbF5vTWwKdpnnKJ061XpabfislElFyzr2seuP1ELWN_kbazDWBaZ-VM_qEblNrL0kcMA_4Fb21map0jGR5ns1nH2fNqL6JWsmkM1mnEcr2F0QJrFjQPELrz6-cOoqPekHnK_YiQ=w2400)


-----

### How to use

- Clone the project with `git clone`
- Copy `.env.example` file to `.env` and edit database credentials there
- Run `composer install`
- Run `php artisan key:generate`
- Run `php artisan migrate --seed` (it has sample testing data)
- Run `php artisan storage:link`
- Run `npm install`
- Launch the main URL to use the web version
- Launch `php artisan products:create` to use the cli version


---

That's it. Thank you for taking the time to review my coding challenge
