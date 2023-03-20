<?php
echo '<div class="chat-wrapper content-wrapper">';
echo $app->chat->chatTitle ? '<h2 class="chat-title">' . $app->chat->chatTitle . '</h3>' : null;

if ($_GET["clear_chat"]) {
    include(__DIR__ . '/Chat/ClearChat.php');
} else if ($app->chat->chatRoom && $app->chat->chatActive) {
    include(__DIR__ . '/Chat/ChatLink.php');
    include(__DIR__ . '/Chat/ChatRoom.php');
    include(__DIR__ . '/Chat/ChatInput.php');
} else if ($app->chat->chatRoom && !$app->chat->chatActive) {
    include(__DIR__ . '/Chat/ChatLinkContent.php');
    include(__DIR__ . '/Chat/EnterChat.php');
} else {
    include(__DIR__ . '/Chat/NewChat.php');
}
echo '</div>';
