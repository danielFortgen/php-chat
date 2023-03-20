<div class="menu content-wrapper transparent-background">
    <?php echo ($app->homeButtonVisible ?  '<div class="menu-item"><a href="/">New Chat</a></div>' : null); ?>
    <?php echo (!$app->chat->chatRoom && !$_GET["new_chat"] ?  '<div class="menu-item"><a href="/?new_chat=1">Chat</a></div>' : null); ?>
    <?php echo (($app->chat->chatRoom && $app->chat->chatActive && !$_GET["clear_chat"]) ?  '<div class="menu-item"><a href="/?clear_chat=1&' . $app->chat->chatParams() . '">Clear Chat Hystory</a></div>' : null); ?>
    <?php echo (($app->chat->chatRoom && $app->chat->chatActive && $_GET["clear_chat"]) ?  '<div class="menu-item"><a href="/?' . $app->chat->chatParams() . '">Chat</a></div>' : null); ?>

</div>