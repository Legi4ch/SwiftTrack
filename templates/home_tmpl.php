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
        <h5 class="header col s12 light">
            SwiftTrack был разработан с акцентом на минимализм и эффективность,
            чтобы вы могли сосредоточиться на создании функциональности!
        </h5>
      </div>
      <br><br>

    </div>
  </div>


  <div class="container">
    <div class="section">

      <!--   Icon Section   -->
      <div class="row">
        <div class="col s12 m4">
          <div class="icon-block">
            <h2 class="center light-blue-text"><i class="material-icons">flash_on</i></h2>
            <h5 class="center">Мгновенное развертывание</h5>
            <p class="light">
                С SwiftTrack вы можете начать работу практически мгновенно.
                Все, что нужно, это назначить маршруты и определить необходимые для проекта контроллеры.
            </p>
          </div>
        </div>

        <div class="col s12 m4">
          <div class="icon-block">
            <h2 class="center light-blue-text"><i class="material-icons">all_inclusive</i></h2>
            <h5 class="center">Универсальность</h5>
            <p class="light">
                SwiftTrack идеальный инструмент для небольших и средних проектов,
                где скорость и простота имеют ключевое значение. Создавайте лендинги, сайты, REST API, тестируйте MPV и прототипы будущих продуктов.
            </p>
          </div>
        </div>

        <div class="col s12 m4">
          <div class="icon-block">
            <h2 class="center light-blue-text"><i class="material-icons">settings</i></h2>
            <h5 class="center">Легкий старт</h5>
            <p class="light">
                Большие фреймворки требуют времени на изучение функциональности и могут быть избыточными для небольших проектов.
                SwiftTrack предлагает всего несколько базовых сущностей, которые вам точно понадобятся.
            </p>
          </div>
        </div>
      </div>

    </div>
    <br><br>
  </div>

  <?php include_once(__DIR__ . "/include/footer.php"); ?>


  </body>
</html>
