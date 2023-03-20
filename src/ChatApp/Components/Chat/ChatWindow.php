<!DOCTYPE html>
<html>

<head>
    <title><?php echo $title; ?></title>
    <link rel="stylesheet" href="../../../css/styles.css?v=<?php echo $randomNumber; ?>">
    <link href="../../../assets/favicon.ico" rel="icon" type="image/x-icon" />
    <script src="../../../js/app.js?v=<?php echo $randomNumber; ?>"></script>
    <script>
        var messages = [];
        var checked = false;
        var checkMessages = function(url) {
            fetch(url)
                .then((response) => response.json())
                .then((data) => {
                    if (checked && messages.length !== data.length) {
                        var sound = document.getElementById('messageSound');
                        if(sound){
                            sound.play();
                        }
                        setTimeout(()=>{
                            location.reload();
                        }, 1000);
                    } else {
                        messages = data;
                        checked = true;
                        setTimeout(() => {
                            checkMessages(url);
                        }, 5000);
                    }
                });
        };
    </script>
</head>

<body id="chat">
    <div class="chat-output-window">
        <div id="chatView" class="scrollable chat-output-container">

            <div class="chat-messages">
                <?php

                require_once('../../ChatApp.php');

                use ChatApp\Components\ChatMessage;
                use ChatApp\ChatApp;


                $appConfigJSON = file_get_contents("../../../app.config.json");
                $appConfig = json_decode($appConfigJSON, true);

                $app = new ChatApp($appConfig);
                $app->chat->start();

                $messageUrl = $app->chat->chatURL() . '&get_messages=1';


                $messages = $app->chat->chatMassages(true);

                foreach ($messages as $message) {
                    include('ChatMassage.php');
                }

                ?>
            </div>
            <script>
                checkMessages("<?php echo $messageUrl; ?>");
            </script>
            <div class="hidden">
            <audio id="messageSound" class="hidden-audio" preload="none">
                <source src="/assets/audio/message_sound.wav" type="audio/wav">
            </audio>
            </div>

        </div>
    </div>
</body>

</html>