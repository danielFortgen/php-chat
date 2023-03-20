<div class="enter-chat">
    <form method="post" action="/?<?php echo $app->chat->chatParams() ?>">
    <input type="hidden" id="key" name="key"  value="<?php echo $app->chat->getKey() ?>">
    <input type="hidden" id="chat_room" name="chat_room" value="<?php echo $app->chat->chatRoom ?>" >
    <input class="button" type="submit" value="Enter Chat">
    </form>
</div>
<?php $app->chat->chatMassage("Enters Chat")?>