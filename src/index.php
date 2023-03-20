<?php

require_once('./ChatApp/ChatApp.php');

use ChatApp\ChatApp;

$appConfigJSON = file_get_contents(__DIR__ . "/app.config.json");
$appConfig = json_decode($appConfigJSON, true);

$app = new ChatApp($appConfig);
$app->chat->start();

$randomNumber = rand();
$title = $app->getConfig('appTitle');
$description = $app->getConfig('appDescription');

?>

<!DOCTYPE html>
<html>

<head>
    <title><?php echo $title; ?></title>
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="viewport" content="viewport-fit=cover, width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no" />
    <meta name="theme-color" content="#ffffff">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Source+Code+Pro" rel="stylesheet">



    <link rel="stylesheet" href="css/styles.css?v=<?php echo $randomNumber; ?>">


    <link href="assets/favicon.ico" rel="icon" type="image/x-icon" />
    <script src="/js/app.js?v=<?php echo $randomNumber; ?>"></script>

</head>
<bod id="body">

    <div id="background">
        <div class="image-container">
            <img src="assets/img/hacker_clowns.jpg">
        </div>
    </div>

    <div id="wrapper">
        <div id="header">
            <?php if ($app->chat->chatRoom) {
                include(__DIR__ . '/ChatApp/Components/Header.php');
            } ?>
        </div>
        <div id="content">
            <div id="left">
            </div>
            <div id="main">
                <div class="overlay">
                    <?php
                    include(__DIR__ . '/ChatApp/Components/Chat.php');
                    ?>
                    <p class="repo-link">
                        Source Code:<a href="https://github.com/danielFortgen/php-chat" target="_blank">https://github.com/danielFortgen/php-chat</a>
                    </p>
                </div>
            </div>
            <div id="right">
            </div>
        </div>
    </div>

    <?php
    $chatWidow = '<a></a>'
    ?>
    </body>

</html>