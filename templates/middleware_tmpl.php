<!DOCTYPE html>
<html lang="en">
<head>
    <?php include_once(__DIR__ . "/include/header.php"); ?>
</head>
<body>
  <nav class="light-blue lighten-1" role="navigation">
    <div class="nav-wrapper container">
        <a id="logo-container" href="#" class="brand-logo">SwiftTrack</a>
    </div>
  </nav>

  <div class="section no-pad-bot" id="index-banner">
    <div class="container">
      <br><br>
      <h1 class="header center light-blue-text lighten-1">{{welcome}}</h1>
      <div class="row center">
    </div>
  </div>

  <div class="container">
      <div class="row">
          <p class="col l12">
              <p class="blue-grey-text">
                  <b>Middleware</b> (промежуточное программное обеспечение) — это программный компонент,
                  который находится между двумя или более слоями программного обеспечения и обрабатывает входящие и исходящие запросы или данные.
              </p>
              <p class="blue-grey-text">
                  В SwiftTrack Вы можете создавать свои классы Middleware имплементируя интерфейс
                  <span class="method">App\Middleware\MiddlewareInterface</span>,<br/> который реализует
                  метод - <span class="method">handle(Request $request, callable $next)</span>. <br/><br/>
              </p>
          <p class="blue-grey-text">
              Мы также написали класс <span class="method">App\Middleware\AuthMiddleware</span>, который проверяет в запросе от пользователя,
              наличие необходимых для авторизации заголовков. Вот как это может работать:
          </p>
<pre>
    $router->get("/account/", "Core\Controllers\AccountController", [new AuthMiddleware()]);
</pre>
          <p class="blue-grey-text">
              Для маршрута <span class="type">/account/</span>, мы будем проверять наличие необходимых заголовков.
              Если их нет, то выполнение приложения  не дойдет до контроллера <span class="method">AccountController</span>.
          </p>
          <p class="blue-grey-text">
          Мы можем передать в роутер несколько классов Middleware и весь пользовательский запрос, обслуживаемый классом <span class="method">App\Request</span>,
          будет по цепочке обработан каждым Middleware. Если какую-то из проверок запрос не пройдет, то его обработка прервется до входа в контроллер.
          </p>
          <p class="blue-grey-text">
              Таким образом, нам не требуется проверять какие-то вещи непосредственно в контроллере и усложнять его код.
              А самое главное, что для всех контроллеров требующих предварительных проверок определенного типа, нам будет
              достаточно только одного обработчика Middleware!
          </p>
          <p class="blue-grey-text">
              <b>Где можно применять?</b><br/>
              <ul>
                <li>Проверка заголовков</li>
                <li>Проверка IP адресов</li>
                <li>Логирование запросов к определенным маршрутам</li>
                <li>Проверки приходящего json на наличие всех полей</li>
            </ul>
              Это лишь несколько возможных ситуаций. Вы можете совсем не использовать Middleware, если в Вашем проекте это не требуется!
          </p>
          <p class="blue-grey-text">
              Следующий раздел документации - <a href="{{root}}/docs/database/">База данных</a>
          </p>

          </div>
      </div>
  </div>

  <?php include_once(__DIR__ . "/include/footer.php"); ?>


  </body>
</html>
