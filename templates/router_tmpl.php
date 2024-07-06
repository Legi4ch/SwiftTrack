<!DOCTYPE html>
<html lang="en">
<head>
    <?php include_once(__DIR__ . "/include/header.php"); ?>
</head>
<body>
  <nav class="light-blue lighten-1" role="navigation">
    <div class="nav-wrapper container">
        <a id="logo-container" href="#" class="brand-logo">Swift Track</a>
    </div>
  </nav>

  <div class="section no-pad-bot" id="index-banner">
    <div class="container">
      <br><br>
      <h1 class="header center light-blue-text lighten-1">{{welcome}}</h1>
      <div class="row center">
        <h5 class="header col s12 light">
            Работать с маршрутами проще простого!
        </h5>
      </div>
      <br><br>

    </div>
  </div>

  <div class="container">
      <div class="row">
          <div class="col l12">
              <h4 class="header light-blue-text lighten-1">Что такое маршруты?</h4>
              <p class="blue-grey-text">
                  Под маршрутом в Swift Track следует понимать URL адрес страницы Вашего сайта, который определяет состояние приложения.<br/><br/>
                  Маршрутом является любой адрес, например: https://your-server.com/page/1/.<br/>
                  Получив URL адрес, фреймворк определят что с ним делать, какие контроллеры вызвать,
                  какие проверки произвести, какие данные взять из базы или записать, и что в итоге показать пользователю.<br/><br/>
                  Пути к существующим на web сервере файлам, например, assets/css/style.css, не являются маршрутами! И это важное для вашего понимания.
                  Маршрут всегда указывает на физически несуществующий путь на сервере!
              </p>
              <h4 class="header light-blue-text lighten-1">Как создать маршрут?</h4>
              <p class="blue-grey-text">
                  Точкой доступа в приложение Swift Track является файл <i>index.php</i>, расположенный в корне Вашего проекта.<br/>
                  Получив вызов, этот файл подключает все файлы, содержащиеся в папке <i>routes/</i>, которая также находится в корне проекта.<br/>
                  Мы рекомендуем создавать маршруты в отдельных файлах в папке <i>routes/</i>, где имя файла будет определять имя метода,
                  который используется в маршруте. Например: get.php - для методов GET, post.php - для POST и т.д.
              </p>
              <p class="blue-grey-text">
                  Любой файл, определяющий маршрут, должен возвращать анонимную функцию с единственным параметром, экземпляром класса <span class="method">App\Router</span>.<br/><br/>
<pre>
// файл routes/get.php
return function (Router $router) {
    // маршрут для главной страницы
    $router->get("/", "app\Controllers\HomeController");
};
</pre>

<pre>
// файл routes/post.php
return function (Router $router) {
    // маршрут для абстрактного метода setData принимающего данные методом POST
    $router->post("/setData", "app\Controllers\getDataController");
};
</pre>

              </p>
              <p class="blue-grey-text">
                  Для каждого маршрута должен быть обязательно определен контроллер, который будет обрабатывать маршрут.
                  Все контроллеры Swift Track являются наследниками абстрактного класса <span class="method">App/BaseController</span>.
                  О контроллерах рассказано в разделе <a href="{{root}}/docs/controllers/">Контроллеры</a>.<br/><br/>
                  При необходимости можно добавлять к маршрутам обработчики Middleware, для выполнения предварительных действий,
                  таких как проверки заголовков, логирования и т.д.
 <pre>
$router->get("/account", "app\Controllers\AccountController", [new AuthMiddleware()]);
</pre>
              Подробнее об обработчиках промежуточного слоя можно узнать из раздела <a href="{{root}}/docs/middleware/">Middleware</a>.
              </p>
              <p class="blue-grey-text">
                  Разумеется, есть ситуации, когда в маршруте Вам нужны динамические параметры. Например, для обработки пагинации или показа отдельной статьи.
                  Swift Track позволяет использовать регулярные выражения в маршрутах для решения этой задачи.
<pre>
$router->get("/articles/[a-zA-Z0-9-]{1,}/[a-zA-Z0-9-]{1,}/", "Core\Controllers\ArticlesController");

/*
    Такой маршрут может соответствовать такому URL
    articles/september-2024/routes-example/
*/
</pre>
              </p>
              <p class="blue-grey-text">
                  Разобрать параметры преданные в маршруте можно будет в Вашем контроллере с помощью метода <span class="method">getRequestChain()</span> класса <span class="method">App/Request</span>.
              </p>
              <p class="blue-grey-text">
                  Следующий раздел документации - <a href="{{root}}/docs/controllers/">Контроллеры</a>
              </p>
          </div>
      </div>
  </div>

  <?php include_once(__DIR__ . "/include/footer.php"); ?>

  </body>
</html>
