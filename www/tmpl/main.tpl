<!DOCTYPE html>

<html>
<head>
    <title>%title%</title>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="%address%/css/main.css" type="text/css">
    <meta name="description" content="%meta_description%">
    <meta name="keywords" content="%meta_key%">
</head>
<body>
<div id="content">
    <div id="header">
        <h1><img src="%address%/images/php_logo.png" alt="php">Шапка сайта</h1>
    </div>
    <hr>
    <div id="main-content">
        <div id="left">
            <h2><img src="%address%/images/menu-icon.png" alt="menu"> Меню</h2>
            <ul>%menu%</ul>
            %auth_user%
            </div>
        <div id="right">
            <form name="search" action="%address%" method="get">
                <p>
                    Поиск: <input type="text" name="words">
                </p>
                <p>
                    <input type="hidden" name="view" value="search">
                    <input type="submit" name="search" value="Искать">
                </p>
            </form>
            <h2>Реклама</h2>
            %banners%
        </div>
        <div id="center">
            %top%
            %middle%
            %bottom%
        </div>
        <div class="clear"></div>
    </div>
    <div id="footer">
        <p>Все права защищены &copy; 2017</p>
    </div>
</div>
</body>
</html>