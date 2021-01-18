

=== Установка на чистую базу данных (если удалить содержимое папку db\data)

ВАЖНО! Перед запуском необходимо создать базу данных: automarket
Либо любую другую и указать её в файле .env в настройке DATABASE_URL

Выполнить комманду:
php bin/console doctrine:schema:create

Для добавления тестовых данных выполнить комманду:
php bin/console doctrine:fixtures:load



=== Использование:

API end point поиска по параметрам
http://127.0.0.1/filter
Параметры:
{"new":1} - Новые
{"new":0} - Подержанные
{"price_from":X} - Машины с ценой начиная от X
{"price_to":X} - Машины с ценой не более X
{"release_year_from":X} - Машины с годом выпуска больше X
{"release_year_to":X} - Машины с годом выпуска меньше X
{"rain_sensor":1} - Есть сенсор дождя
{"rain_sensor":0} - Нету сенсора дождя
{"brand":X} - Машины с ID бренда X (Ford - 1, Audi - 2)

Пример JSON:
{
    "new":1,
    "brand":1,
    "price_from":10000000
}

API endpoint "свежих" авто
http://127.0.0.1/fresh


Комманда креативного маркетинга:
php bin/console app:creative-sales