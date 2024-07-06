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
          <p class="col l12">
              <p class="blue-grey-text">
                  Контроллеры - это важная часть Swift Track. Почти всю основную работу выполняют они и разрабатывая Ваш продукт на SwiftTrack, Вы
                  будете взаимодействовать в основном именно с ними.
              </p>
              <p class="blue-grey-text">
                  Абсолютно все контроллеры фреймворка являются наследниками абстрактного класса <span class="method">App/BaseController</span>.<br/><br/>
                  Результатом успешной обработки любого маршрута приложения, является вызов метода <span class="method">init()</span> Вашего контроллера, куда передается экземпляр класса <span class="method">App\Request</span>.
                  Для подробного знакомства с классом <span class="method">App\Request</span> в документации есть отдельный <a href="{{root}}/docs/request/">раздел</a>, а сейчас Вам просто достаточно знать, что
                  экземпляры этого класса содержат всю информацию о запросе и методы для ее обработки.
              </p>
              <p class="blue-grey-text">
                  <b>Простой контроллер</b><br/><br/>
<pre>
class HomeController extends BaseController
{
    protected string $template = "home";

    public function init(Request $request): void {
        $this->loadTemplate();
    }
}
</pre>
              </p>
              <p class="blue-grey-text">
                  Разберемся. <br/>
                  Контроллер в примере - <span class="method">HomeController</span> - очень простой. Он почти ничего не делает, а только выводит html страницу, код который
                  содержится в файле <i>templates/home_tmpl.php</i>.
                  <blockquote>
                  Обратите внимание, что имена файлов html шаблонов должны использовать
                  Snake Case и всегда заканчиваться на *_tmpl.php. В то время как все контроллеры фреймворка используют Pascal Case и всегда заканчиваются
                  на *Controller.php
                </blockquote>
              </p>
              <p class="blue-grey-text">
                  Конечно, для многих проектов этого мало. Но используя методы из <i>App/Request</i>,<i>App/Database</i> или свои собственные,
                  вы всегда можете более гибко работать над ответом.
              </p>

              <p class="blue-grey-text">
                  В вызове метода <i>loadTemplate()</i> Вашего контроллера, Вы можете передать массив переменных, которые будут подставлены в код шаблона.

              </p>
              <p class="blue-grey-text">
                  Таким образом, переменная <i>$tmplVars["title"]</i> станет {{titlе}} в коде шаблона. С остальными переменными произойдет тоже самое.<br/>
                  Вы также можете использовать преданные в <i>loadTemplate()</i> переменные, как обычные переменные php. Например: $title, $welcome. <br/><br/>
                  Более подробно о работе с шаблонами читайте в разделе <a href="{{root}}/docs/templates/">Шаблоны</a>.
              </p>
              <p class="blue-grey-text">
                  Вы можете реализовать в методе <i>init()</i> Вашего контроллера любую логику, необходимую для приложения. Это не обязательно должен быть
                  вывод html страницы. Вы можете отдать JSON данные, JS код, простой текст или отрендерить jpg изображение с помощью
                  дополнительных библиотек.
              </p>
              <p class="blue-grey-text">
              <blockquote>
                  Разрабатывая Swift Track мы не стали решать за Вас, что именно будут отдавать контроллеры.<br/> Вы всегда можете реализовать необходимые
                  методы добавив их к Вашим наследникам абстрактного класса <span class="method">App/BaseController</span>.
                  </blockquote>
              </p>
              <p class="deep-orange-text darken-4">
                  Разумеется вы можете создать собственное абстрактное представление контроллера, например для обработки json - <span class="method">Api/Abstract/JsonBaseController</span>.
                  Вам потребуется имплементировать интерфейс <span class="method">App\Controllers\Interfaces\ControllerInterface</span> в классе Вашем <span class="method">Api/Abstract/JsonBaseController</span>.
                  Каждый наследник Вашего класса должен будет реализовать собственный метод <span class="method">init()</span>.
              </p>
              <p class="blue-grey-text">
                  Следующий раздел документации - <a href="{{root}}/docs/request/">Request</a>
              </p>
          </div>
      </div>
  </div>

  <?php include_once(__DIR__ . "/include/footer.php"); ?>

  </body>
</html>
