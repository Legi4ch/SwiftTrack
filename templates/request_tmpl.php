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

        </h5>
      </div>
      <br><br>

    </div>
  </div>

  <div class="container">
      <div class="row">
          <div class="col l12">
              <h4 class="header light-blue-text lighten-1">Для чего этот класс?</h4>
              <p class="blue-grey-text">
                  Если заглянуть в файл <i>index.php</i>, то в нем можно увидеть такой вызов:
<pre>
$router->handle(new Request());
</pre>
              </p>
              <p class="blue-grey-text">
                  Объекты класса <span class="method">Api\Request</span> содержат в себе всю информацию о запросе пользователя к приложению: http заголовки, тело запроса и т.д.
                  Эти объекты используются в Маршрутизаторе, Контроллерах и Middleware для того, чтобы взаимодействовать с пользовательскими данными.<br/><br/>
                  Экземпляр объекта этого класса всегда передается в маршрутизатор и проходит без изменений по всей цепочке вызовов до контроллера.
                  Взаимодействуя с Request вы можете определить необходимую Вам логику обработки запроса от пользователя.
              </p>
              <p class="blue-grey-text">
              <h4 class="header light-blue-text lighten-1">Публичные методы класса Request</h4>
              </p>
              <p class="blue-grey-text">
                <span class="method">getBody()</span>:<span class="type">string</span><br/>
                  Возвращает весь текст переданный в body запроса. Чаще всего таким способом передается JSON в запросах к REST API.<br/>
                  Фактически это просто содержимое потока php://input.
              </p>
              <p class="blue-grey-text">
                <span class="method">getHeaders()</span>: <span class="type">array</span><br/>
                  Возвращает массив всех заголовков запроса.
              </p>
              <p class="blue-grey-text">
                <span class="method">getMethod()</span>: <span class="type">string</span><br/>
                  Возвращает метод которым сделан запрос. Например: GET, POST и т.д.
              </p>
              <p class="blue-grey-text">
                <span class="method">getPostData()</span>: <span class="type">array</span><br/>
                  Возвращает php массив $_POST.
              </p>
              <p class="blue-grey-text">
                <span class="method">getRequestChain()</span>: <span class="type">array</span><br/>
                  Возвращает массив ключей маршрута из URL.<br/>
                  Например, для вашего маршрута <span class="type">/some/route/</span> метод вернет массив:<br/>
                  Array ( [0] => "some" [1] => "route" )
              </p>
              <p class="blue-grey-text">
                <span class="method">getRequestKeys()</span>: <span class="type">array</span><br/>
                Возвращает массив параметров из URL.<br/>
                  Например, для вашего маршрута <span class="type">/some/route/?id=1&amp;parent=2</span> метод вернет массив:<br/>
                Array ( [id] => 1 [parent] => 2 )
              </p>
              <p class="blue-grey-text">
                <span class="method">getUri()</span>:<span class="type">string</span><br/>
                  Возвращает URI string.<br/>
                  Например, для вашего маршрута <span class="type">/some/route/?id=1&amp;parent=2</span> метод вернет строку:<br/>
                  /some/route/?id=1&amp;parent=2
              </p>


              <p class="blue-grey-text">
                  <br/><br/>
                  Следующий раздел документации - <a href="{{root}}/docs/middleware/">Middleware</a>
              </p>
          </div>
      </div>
  </div>

  <?php include_once(__DIR__ . "/include/footer.php"); ?>


  </body>
</html>
