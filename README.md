## 😁 Проект Laravel-book-store сайт магазин с админкой!
Сайт магазин по продаже книг
## **Для развертывания поднадобится установить Docker**
После выполнить команду
```
docker compose up
```
Ниже представлен код Docker File
```
version: '3.1'
services:
    db:
        image: mysql
        restart: always
        environment:
            MYSQL_USER: root
            MYSQL_PASSWORD: root
            MYSQL_ROOT_PASSWORD: root
            MYSQL_DATABASE: book-store
        ports:
            - "3308:3306"
    phpmyadmin:
        image: phpmyadmin/phpmyadmin:latest
        restart: always
        environment:
            PMA_HOST: db
            PMA_USER: root
            PMA_PASSWORD: root
        ports:
            - "8080:80"
```
Затем заполнить базу данным данными
```
php artisan migrate
php artisan db:seed
```
Можно использовать проект!