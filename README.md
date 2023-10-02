# Slotegator
тестовое задание
### Постановка задачи

Вам предстоит разработать приложение, используя фреймворк Symfony (желательно актуальную
версию). Приложение должно реализовать следующие функциональности:
1. Простой CRUD (Создание, Чтение, Обновление, Удаление) Минимальные требования к
   отображения фронтовой части!
   Реализуйте функциональность для управления товарами. Каждый товар должен содержать
   следующие поля:
   Наименование
   Цена
   Фотография
   Описание
2. Парсер информации с любого маркетплейса любой страны
   Разработайте механизм, который позволит при создании товара вводить URL товара с сайта любого
   маркетплейса. При вводе URL этот механизм должен:
   Извлекать фотографию, наименование и цену товара с сайта любого маркетплейса Автоматически
   заполнять соответствующие поля товара в вашем приложении
   ОБЯЗАТЕЛЬНО реализуйте модели RequestDTO и ResponseDTO и десериализацию ответа в модель
   ResponseDTO с помощью serializer
3. Написание юнит-теста
   Напишите как минимум один юнит-тест для парсера, который проверит его работоспособность и
   корректность извлечения информации с сайта alza.cz.
   Пожалуйста, создайте репозиторий на GitHub (или аналогичной платформе) для вашего проекта и
   предоставьте нам доступ к нему по завершении. Также не забудьте приложить инструкцию по
   развертыванию приложения и запуску тестов. Успехов в выполнении задания

### Комментарий

1. По поводу "Парсер информации с любого маркетплейса любой страны"
Реализован селекторы для сайтов alza.cz amazon.es и для других — универсальный набор селекторов. 
Можно легко добавлять новые для любых сайтов. Подключаются через ParserFactory
2.    

### Среда разработки
WSL Windows 11, PHP 8.0, Postgres Docker (image: postgres:15-alpine)

###Установка

1. Склонируйте репозиторий: git clone https://github.com/vadaha/slotegrator.git
2. Установите зависимости: `composer install`
3. Создайте базу данных: `docker-compose.yaml`
4. Скопируйте .env в .env.local и настройте если нужно соединение с БД в `.env.local`
5. Выполните миграции: `php bin/console doctrine:migrations:migrate`
6. Запустите сервер: `symfony server:start`

###Использование
После установки открываем http://localhost:8000/product/ Откроется список товаров. 
Нажмем на кнопку "Create new", 
   1. можем заполнить поля нового товара и нажать Save.
   2. или заполнить урл для парсинга и нажать Parsing

###Тестирование
Тест в tests/Parser/ParserTest.php 
Запускаем: php ./bin/phpunit

###Возможные проблемы
"chromedriver" binary not found. 
Install it using the package manager of your operating system or by running 
"composer require --dev dbrekelmans/bdi && vendor/bin/bdi detect drivers".

в этом случае вписываем путь к драйверу в src/Parser/Parser.php на 31 строке

###Screenshot
В img.png
