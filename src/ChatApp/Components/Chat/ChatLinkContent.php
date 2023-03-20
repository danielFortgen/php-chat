<script>
    function copyToClipboard() {
        var tempInput = document.createElement("input");
        tempInput.type = "text";
        var value = "<?php echo $app->chat->chatURL() ?>";
        tempInput.value = value;
        document.body.appendChild(tempInput);
        tempInput.select();
        document.execCommand("copy");
        document.body.removeChild(tempInput);
        alert("Chat link has been copied to clipboard: \n\n" + value + " \n");
    }
</script>
<div class="link-preview">
    <b>Link:</b>
    <p>
        <?php echo $app->chat->chatURL() ?>
    </p>
    <b>Share the link to invite friends</b><br>
    <i>Attantion: this link is used to decrypt the messages, be careful who you share it with</i>
</div>
<button id="copyToClipboard" onclick="copyToClipboard()">Copy link to clipboard</button>