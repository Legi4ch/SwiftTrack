<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1.0"/>
    <title>Swift Track - <?php echo $handlerMessage; ?></title>
    <link href="<?php echo $root; ?>/assets/css/materialize.min.css" type="text/css" rel="stylesheet" media="screen,projection"/>
    <link href="<?php echo $root; ?>/assets/css/style.css" type="text/css" rel="stylesheet" media="screen,projection"/>
</head>
<body>

<div class="section no-pad-bot" id="index-banner">
    <div class="container">
        <div class="row center">
            <h2 class="header col s12 blue-grey-text">
                <?php echo $handlerMessage; ?>
            </h2>
            <h5 class="header col s12 red-text"><?php echo $systemMessage; ?></h5>
        </div>
    </div>
</div>

<div class="section no-pad-bot" id="index-banner">
    <div class="container">
        <div class="row center">
            <a class="btn-large waves-effect waves-light blue" onclick="goBack();">Вернуться</a>
        </div>
    </div>
</div>


<script>
    function goBack() {
        window.history.back();
    }
</script>
</body>
</html>

