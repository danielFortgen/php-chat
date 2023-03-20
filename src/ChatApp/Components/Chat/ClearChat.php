<div class="clear-chat">
    <form method="post" action="/?<?php echo $app->chat->chatParams() ?>">
        <input type="hidden" id="key" name="key" value="<?php echo $app->chat->getKey() ?>">
        <input type="hidden" id="chat_room" name="chat_room" value="<?php echo $app->chat->chatRoom ?>">
        <input type="hidden" id="confirm_clear_chat" name="confirm_clear_chat" value="1">
        <input class="button" type="submit" value="Clear Chat">
    </form>
    <h1>Are you sure?</h1>
    <p><i>All chat history is lost forever...</i></p>
</div>