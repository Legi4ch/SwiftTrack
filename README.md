# Swift Track


Swift Track - PHP микрофреймворк, 
который выделяется на фоне более массивных и сложных фреймворков благодаря своему упору на минимальные 
требования к настройке сервера и легкость освоения. 

Swift Track разработан так, чтобы позволить вам приступить к работе над проектом в 
кратчайшие сроки, не теряя времени на длительное изучение его основ или сложные конфигурации.


### Для чего подойдет фреймворк?
1. **Для построения простого REST API.**
    Определите эндпойнты в маршрутах, укажите их методы и опишите контроллеры. 
    Добавьте Middleware для проверки авторизации и запрашивайте данные из базы проекта. 
    Swift Track работает со всеми методами маршрутов GET, POST, PUT, DELETE, OPTION.


2. **Для создания лендингов и промо-сайтов.**
    С помощью фреймворка легко создать сайт с любой версткой и логикой. 
    Вы можете использовать полностью статичные шаблоны страниц или добавить динамику при необходимости. 
    Выбирайте данные из базы и сохраняйте результаты форм. Потребуется минимум php кода и Вы сможете полностью сосредоточиться на визуальной части страниц и js.

   
3. **Тестирование MVP и различных гипотез продуктов.** 

   Создайте свой MPV проект на базе фреймворка.Это займет минимум времени, 
   а Вы сможете вложить больше усилий в привлечение клиентов и маркетинг. 
   Что-то идет не так? Правки будут очень быстрыми. А благодаря простой архитектуре Swift Track, 
   Вы легко смените фреймворк на другой, когда Ваш продукт до этого дорастет.

## Как устроен Swift Track?
Фреймворк реализует паттерн MVC и контроллеры являются его главной компонентной частью. Все вызовы приложения рано или 
поздно попадают в определенный контроллер. Контроллер в свою очередь обращается за данными и выводит их.

Рендер шаблона не является единственно возможным результатом работы контроллера. 
Разработчик полностью и самостоятельно определяет, что именно в итоге должен сделать контроллер.

При разработке Swift Track во главе угла стояла идея о максимально быстром запуске приложения, 
чтобы можно было сосредоточиться на отдельных частях и проработке главной идеи разрабатываемого сервиса или сайта. 

>Самым лучшим способом Вашего знакомства будет установка Swift Track и запуск первого приложения! 
Посмотрев демо сайт поставляемый вместе с фреймворком, Вы легко разберетесь как работать с Swift Track, 
даже если Вы не слишком опытны в php разработке.

## Основные сущности фреймворка

**App/Controllers**

Содержит файлы контроллеров. В Swift Track все завязано на контроллеры, 
которые являются наследниками от абстрактного класса BaseController. 
Назначение контроллеров - обработка конечной точки маршрута вашего приложения. 

Пример простого контроллера с данными для рендера html страницы:
```php
class HomeController extends BaseController
{
    protected string $template = "home";

    $tmplVars = [
        "user" => [
            "name" => "John",
            "contacts" => [
                "email" => "john@example.com",
                "phone" => "123-456-7890"
            ]
        ],
        "page-title" => "User Profile"
    ];

    public function init(Request $request): void {
        $this->loadTemplate($tmplVars);
    }
}
```
Контроллеры, в зависимости от назначения, могут выводить подготовленные шаблоны страниц, отдавать json/xml, либо что-то еще. 
Рендер отличный от html кода остается на усмотрение разработчика и не реализован в Swift Track.


**App/Database**

Содержит классы для подключения к базе данных, базовый абстрактный класс модели таблицы данных, 
а также простейшие построители запросов. Фреймворк не предоставляет полноценную ORM, но в то же время, 
у разработчика есть возможность работать с SQL запросами любой сложности с помощью класса FreeBuilder.

**App\Database\QueryBuilder**

Этот класс служит для выполнения запросов к конкретной таблице. 
При создании ему передается имя класса модели для нужной таблицы и имя класса реализующего подключение 
к базе данных. Класс содержит набор методов реализующих минимальный sql-функционал: 
SELECT, UPDATE, DELETE, INSERT. 



```php
$qb = new QueryBuilder(SampleModel::class, SqliteConnection::class);
$dataAr = $qb->getAll();
```

**App\Database\FreeBuilder**

Этот класс служит для выполнения любых sql-запросов к Вашей базе данных. 
При создании ему передается только имя класса реализующего подключение к базе данных.

```php
$fb = new FreeBuilder(SqliteConnection::class);
$dataAr = $fb->getAll();
```
Собственная реализация метода `getAll();` в классе `FreeBuilder`
```php
public function getAll(int $id = 0): array {
    $sql = "SELECT * FROM test_table WHERE id > :id";
    $query = $this->instance->prepare($sql);
    $query->execute([":id" => $id]);
    return $query->fetchAll(PDO::FETCH_ASSOC);
}
```

**App/Middleware**

Классы для реализации промежуточного слоя. Например, для проверки аутентификации пользователя, перед отдачей контента.
```php
    // назначаем Middleware маршруту. Возможно передать несколько классов,
    // которые будут применены последовательно
    $router->get("/account", "App\Controllers\AccountController", [new AuthMiddleware()]);
```

**App/Request**

Класс Request используется в маршрутах, контроллерах и промежуточных слоях для обработки запросов. Содержит всю информацию 
о запросе пользователя и предоставляет методы для работы с ней. 

**App/Router**

Класс Router используется для обработки маршрутов. 
Swift Track позволяет разделять запросы к маршрутам по http методам и внедрять обработчики промежуточного слоя в маршруты. 
Это позволяет быстро строить полноценные Rest API приложения.

```php
return function (Router $router) {

    // простой маршрут для главной страницы
    $router->get("/", "App\Controllers\HomeController");
    
    // маршрут с Middleware
    $router->get("/account", "App\Controllers\AccountController", [new AuthMiddleware()]);
    
    // маршрут с регулярным выражением
    $router->get("/articles/[a-zA-Z0-9-]{1,}/[a-zA-Z0-9-]{1,}/", "Core\Controllers\ArticlesController");
    
    // маршрут принимающий данные POST
    $router->post("/setRecord", "App\Controllers\PostController");
};
```

## Шаблоны и работа с ними

```php

    $tmplVars = [
        "user" => [
            "name" => "John",
            "contacts" => [
                "email" => "john@example.com",
                "phone" => "123-456-7890"
            ]
        ],
        "page-title" => "User Profile",
        "items" => ["zero", "one", "two"],
        "isVisible" => true
    ];

    public function init(Request $request): void {
        // передаем переменные в шаблон
        $this->loadTemplate($tmplVars);
    }
```
Получить значения переменных в шаблоне можно так: 

`{{user.name}}, {{user.name.contact}}, {{user.name.phone}}, {{page-title}}`

Можно использовать их как обычные включения php кода:


`<?php echo $pаge-title; ?>`
`<?php print_r ($user); ?>`

Можно обойти массив без всяких проблем:

`<?php foreach ($items as $item) {echo $item;} ?>`

Обработать условие:

```php
<?php if ($isVisible) { ?>
    Some html code here...
<?php } ?>
```

Для циклов и ветвлений Вам потребуется использовать включения php кода!

И конечно у Вас есть возможность подключить другие файлы в Ваш шаблон через `include`.

Это удобно для включения в шаблоны html кода, который всегда статичен: шапки страниц, нижние блоки и т.д.