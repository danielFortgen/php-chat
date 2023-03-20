<div class="new-chat">
    <div class="image-container new-chat-image">
        <img src="assets/img/hacker_zombie.jpg">
    </div>
    <h2>Chatroom Name:</h2>
    <br>
    <form method="post" action="/">
        <input type="hidden" id="key" name="key" value="<?php echo $app->chat->getKey() ?>">
        <input type="text" id="new_chat_room" name="new_chat_room" value="Very Important Meeting" required><br><br>
        <input class="button" type="submit" value="Create Chatroom">
    </form>
</div>