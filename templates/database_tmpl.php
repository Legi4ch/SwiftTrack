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
    </div>
  </div>

  <div class="container">
      <div class="row">
          <p class="col l12">
              <p class="blue-grey-text">
              </p>
              <p class="blue-grey-text">
                  Swift Track не предоставляет полноценной ORM. Для нашего микрофреймворка это избыточно.<br/>
                  Для работы с базами данных фреймворк использует простые модели данных и два класса для запросов к базе.
              </p>
          <p class="blue-grey-text">
              <b>Подключение</b><br/>
              За подключение отвечают классы:  <span class="method">App\Database\SqliteConnection</span> и
              <span class="method">App\Database\MysqlConnection</span><br/>
              В стандартной поставке Swift Track умеет работать с Sqlite и MySql базами.
          </p>
          <p class="blue-grey-text">
              <b>Модели</b><br/>
              Модели наследуются от абстрактного класса:  <span class="method">App\Database\Abstract\BaseModel</span><br/>
              Пример модели описывающей таблицу  <span class="type">test_table</span>:
          </p>
<pre>
class SampleModel extends BaseModel
{
    /*
     * id не нужен в наборе полей, подразумевается что это всегда id и всегда autoincrement
     */


    protected string $tableName = "test_table";
    protected array $fields = array(
        "name" => "string",
        "value" => "string",
    );


    //you can define own methods for model if you need
    public static function getUid($length = 5) {
        $bytes = random_bytes($length);
        return substr(bin2hex($bytes), 0, $length);
    }
}
</pre>
          <br/><br/>
          <p class="blue-grey-text">
              <span class="method">App\Database\QueryBuilder</span><br/>
            Этот класс служит для выполнения запросов к конкретной таблице. При создании ему передается имя класса модели для нужной таблицы и
              имя класса реализующего подключение к базе данных. <br/><br/>
              Класс содержит набор методов реализующих минимальный sql-функционал: SELECT, UPDATE, DELETE, INSERT.
              Рекомендуем Вам ознакомится с кодом этого класса для получения полного представления о доступных методах.
          </p>
<pre>
$qb = new QueryBuilder(SampleModel::class, SqliteConnection::class);
$dataAr = $qb->getAll();
</pre>
           <br/><br/>
          <p class="blue-grey-text">
              <span class="method">App\Database\FreeBuilder</span><br/>
              Этот класс служит для выполнения любых sql-запросов к Вашей базе данных. При создании ему передается только
              имя класса реализующего подключение к базе данных.
          </p>
<pre>
$fb = new FreeBuilder(SqliteConnection::class);
$dataAr = $fb->getAll();
</pre>
          <p class="blue-grey-text">
              Этот класс не содержит готовых методов для запросов, а позволяет разработчику определить их самостоятельно.
          </p>
<pre>
public function getAll(int $id = 0): array {
    $sql = "SELECT * FROM test_table WHERE id > :id";
    $query = $this->instance->prepare($sql);
    $query->execute([":id" => $id]);
    return $query->fetchAll(PDO::FETCH_ASSOC);
}
</pre>

          <p class="blue-grey-text">
              Как видите, нет никаких проблем выполнить даже очень сложный запрос к базе данных. Вы можете дополнить <span class="method">App\Database\FreeBuilder</span>
              любыми методами, которые Вам необходимы в проекте.
          </p>

          <p class="blue-grey-text">
              <blockquote>
                  Если Вы правильно указали путь к базе Sqlite в файле <span class="type">config/DbConfig.php</span>, то ниже Вы должны увидеть
                  данные выбранные из комплектной базы данных: <br/><br/>
                <pre>
                Value 1: {{data.0.value}}
                Value 2: {{data.1.value}}
                Value 3: {{data.2.value}}
                </pre>
               </blockquote>
        </p>


          <p class="blue-grey-text">
              Следующий раздел документации - <a href="{{root}}/docs/templates/">Шаблоны</a>
          </p>

          </div>
      </div>
  </div>

  <?php include_once(__DIR__ . "/include/footer.php"); ?>



  </body>
</html>
