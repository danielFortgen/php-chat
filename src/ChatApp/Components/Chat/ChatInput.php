<div class="chat-input">
    <form method="post" action="/?<?php echo $app->chat->chatParams() ?>">
        <input type="hidden" id="chat_room" name="chat_room" value="<?php echo $app->chat->chatRoom ?>" >
        <input type="hidden" id="key" name="key"  value="<?php echo $app->chat->getKey() ?>">
        <div class="chat-name">
            <label for="chat_name">Name:</label>
            <input type="text" id="chat_name" name="chat_name" value="<?php echo $app->chat->chatName ?>" required>
        </div>
        <div class="chat-massage">
            <textarea id="chat_message" name="chat_message" required></textarea>
        </div>
        <div class="chat-action">
            <input class="button" type="submit" value="Send">
        </div>
    </form>
</div>
