<!DOCTYPE html>
<html lang="ru">
    <head>
        <title><? echo $main.' | '.$journal; ?></title>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link href="/themes/default/css/bootstrap.css" rel="stylesheet" media="screen">
        <link href="/themes/default/css/style.css" rel="stylesheet" media="screen">
        <link href="/themes/default/datepicker/css/datepicker.css" rel="stylesheet" media="screen">
        <script src="http://code.jquery.com/jquery-latest.js"></script>
        <script src="/themes/default/js/bootstrap.js"></script>
    </head>
    <body>
        <header>
            <nav class="navbar navbar-inverse navbar-static-top">
                    <div class="navbar-header">
                        <a class="navbar-brand" href="/index.php">Contracts</a>
                        <ul class="nav navbar-nav">
                            <li class="disabled"><a href="#">Главная</a></li>
                            <li class="disabled"><a href="#">Заявки</a></li>
                            <li class="active"><a href="/index.php/Contracts">Контракты</a></li>
                            <li class="disabled"><a href="#">Счета</a></li>
                            <li class=""><a href="/index.php/Contents/help">Помощь</a></li>
                            <?
                            if (!empty($user)){
                                echo '<li class=""><a href="/index.php/Users/cabinet">Личный кабинет</a></li>';
                                //echo '<p class="navbar-text navbar-right"><a href="/index.php/Users/cabinet" class="navbar-link">'.$user.'</a></p>';
                            }
                            ?>
                        </ul>
                    </div>
            </nav>
        </header>
