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
              <h4 class="header light-blue-text lighten-1">Как устроены шаблоны?</h4>
              <p class="blue-grey-text">
                  Файлы html шаблонов хранятся в папке <span class="type">templates/</span> в корне проекта.<br/>
                  Имена шаблонов должны использовать Snake Case и называться по правилу: <span class="type"><i>template</i>-tmpl.php</span>
              </p>
              <p class="blue-grey-text">
                  Разрабатывая SwiftTrack мы не стали делать в нем специальный отдельный шаблонизатор для html страниц.
                  Но это не значит, что мы совсем ничего не предусмотрели! Мы уже чуть-чуть касались шаблонов в предыдущих разделах.
                  И как было сказано, в шаблонах Вам доступны переменные, которые могут быть определены в контроллерах. <br/><br/>
<pre>
class HomeController extends BaseController
{
    protected string $template = "home";

        $tmplVars = [
            "page-title" => "SwiftTrack Demo starter page",
            "welcome-msg" => "Starter Page",
            "show" => true,
            "varsAr" => ["zero", "one", "two"]
        ];

    public function init(Request $request): void {
        $this->loadTemplate($tmplVars);
    }
}
</pre>
            </p>
            <p class="blue-grey-text">
              <blockquote>
                  Обратите внимание, как задано имя шаблона в коде контроллера <span class="type">$template = "home";</span><br/>
                  Вы должны задавать в контроллере только первую часть имени шаблона. Postfix <span class="type">-tmpl.php</span> будет добавлен контроллером автоматически.
              </blockquote>
                Мы определили несколько переменных в массиве <span class="type">$tmplVars</span> и передали его в
                метод <span class="method">loadTemplate()</span>.<br/><br/>
                Теперь в шаблоне <span class="type">templates/home_tmpl.php</span> Вы можете вывести эти переменные в виде статических значений:<br/>
                <span class="type">{{page-title}}</span>, <span class="type">{{welcome-msg}}</span>. <br/><br/>
                К элементам массива <span class="type">varsAr</span> можно обратиться так:<br/>
                <span class="type">{{VаrsAr[0]}}</span> или <span class="type">{{VаrsAr.0}}</span></span><br/><br/>

                Можно использовать их как обычные включения php кода:<br/><br/>
                <span class="method">&lt;?php echo $pаge-title; ?&gt;</span><br/>
                <span class="method">&lt;?php echo $varsAr[0]; ?&gt;</span><br/>
                <span class="method">&lt;?php print_r ($varsAr); ?&gt;</span><br/><br/>

                Можно обойти массив без всяких проблем:<br/><br/>
                <span class="method">&lt;?php foreach ($varsAr as $item) {echo $item;} ?&gt;</span><br/><br/>

                Обработать условие:<br/><br/>
                <span class="method">
                    &lt;?php if ($show) { ?&gt;</span> <br/>
                    &nbsp;&nbsp;&nbsp;&nbsp;Some html code here... <br/>
                <span class="method">&lt;?php } ?&gt;</span>
            </p>
          <br/>
              <h4 class="header light-blue-text lighten-1">Пример более сложного шаблона.</h4>
              <p class="blue-grey-text">
                  Описанная выше структура массива переменных очень простая. Часто бывает необходимо что-то более сложное и больше переменных.
                  Посмотрим, как это делается в SwiftTrack.

<pre>
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
</pre>
                Вот как можно получить значения:<br/><br/>
          <span class="type">{{user.name}}</span>, <span class="type">{{user.name.contact}}</span>, <span class="type">{{user.name.phone}}</span>
          <blockquote>
              Для циклов и ветвлений Вам потребуется использовать включения php кода!
          </blockquote>
          </p>
          <p class="blue-grey-text">
              И конечно у Вас есть возможность подключить другие файлы в Ваш шаблон через <span class="method">include</span>.<br/>
              Это удобно для включения в шаблоны html кода, который всегда статичен: шапки страниц, нижние блоки и т.д.
          </p>
          <p class="blue-grey-text">
              Как Вы смогли убедиться, SwiftTrack вовсе не оставляет Вас с голыми руками при работе с html шаблонами. Фреймворк обеспечивает достаточную
              для небольших и средних проектов гибкость шаблонизации, не перегружая разработчика изучением лишних деталей и синтаксиса.
          </p>
          <p class="blue-grey-text">
              Это последний раздел нашей документации. Мы постарались изложить все максимально кратко, но в то же время в объеме достаточном для старта.
              Надеемся, что Вам понравится работать с SwiftTrack!
          </p>
          </div>
      </div>
  </div>

  <?php include_once(__DIR__ . "/include/footer.php"); ?>

  </body>
</html>
