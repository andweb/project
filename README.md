Тестовое задание
================

## Инструкция по установке

1. Скачать репозиторий:

  ```bash
  git clone http://github.com/andweb/project
  ```

2. Установить зависимости командой:
  ```bash
  composer update
  ```

3. Установить параметры для подключения к БД в файле parameters.yml.dist

database_host database_port database_name database_user database_password

4. Переименовать файл parameters.yml.dist в parameters.yml

5. Создать базу данных командой в консоли
  ```bash
  php app/console doctrine:database:create
  ```

6. Создать таблицы в базе данных командой
  ```bash
  php app/console doctrine:schema:create
  ```

7. Загрузить тестовые данные из дампа
  ```bash
  php app/console doctrine:fixtures:load
  ```
  
  либо загрузить данные из дампа
  dump_sql/dump_lite.sql - содержит 61724 записей (предпочтительнее)

8. Запустить тестовый сервер
  ```bash
  php app/console server:run
  ```
