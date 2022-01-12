# задание

Необходимо написать одностраничную веб-программу, для хранения карточек по коллекционным аудио CD.

Использовать для обработки и вывода стек - HTML, CSS, JS, PHP, а данные хранить в MySQL.
Для оформления фронтенда допускается использование кода только из библиотек jQuery, и Bootstrap или самописные личные наработки.

Для формирования бекенда нельзя использовать какие-либо PHP фреймворки или любые другие сторонние разработки, кроме самописного фреймворка, или самостоятельно написанного нотивного PHP. Но при этом код должен быть оформлен по принципам ООП.

Сама программа это одна страница со списком из карточек с информацией по аудио CD,
с возможностью добавления/редактирования/удаления. Пока без "админки".

Каждая карточка содержит следующие поля:
- Обложка альбома,                                
  -Название альбома,     
  -Название артиста,
  -Год выпуска,
  -Длительность альбома (минут),
  -Дата покупки,
  -Стоимость покупки,
  -Код хранилища (номер комнаты : номер стойки : номер полки)

Список карточек можно сортировать и фильтровать.
Например, можно выбрать все альбомы определенного артиста, отсортированные по году альбома.

## структура бд
album:
    - id : bigint
    - title : varchar
    - artist : varchar
    - year : varchar
    - duration : float
    - bought_at : timestamp
    - created_at : timestamp
    - price : float
    - vault : json
    - album_cover_id

## структура приложения
Приложение реализовано по принципу модель-вид-контроллер, структурно состоит из SPA на вью 3 (/view) и API (/app).