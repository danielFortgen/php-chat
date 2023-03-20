<?php

namespace ChatApp\Service;

use ChatApp\ChatApp;
use Defuse\Crypto\Crypto;
use Defuse\Crypto\Key;


class Chat
{
    /**
     * @var ChatApp
     */
    protected $app;

    /**
     * @var array
     */
    protected $config;

    /**
     * @var array
     */
    protected $postData;

    /**
     * @var Key
     */
    public $cryptoKey;


    /**
     * @var string
     */
    public $chatRoom;

    /**
     * @var string
     */
    public $chatTitle;

    /**
     * @var string
     */
    public $chatName;

    /**
     * @var bool
     */
    public $chatActive;

    /**
     * @var bool
     */
    public $chatCleared;

    /**
     * @var string
     */
    public $dateFormat;

    public function __construct(
        ChatApp $app
    ) {
        $this->app =  $app;
    }
    /**
     * get config value for attribute
     */
    public function start()
    {
        date_default_timezone_set('Europe/Berlin');
        $this->dateFormat = 'd.m.Y G:i';
        $this->loadChatRoom();
    }
    public function getKey()
    {
        return  $this->cryptoKey ? $this->cryptoKey->saveToAsciiSafeString() : "";
    }


    public function loadChatRoom()
    {
        $this->chatRoom = null;
        $this->chatActive = false;

        $clearChat = !empty($_POST["confirm_clear_chat"]) ? $_POST["confirm_clear_chat"] : null;


        if (isset($_GET["key"])) {
            $this->cryptoKey =  Key::loadFromAsciiSafeString(urldecode($_GET["key"]));
        } else {
            $this->cryptoKey = !empty($_POST["key"]) ? Key::loadFromAsciiSafeString($_POST["key"]) : Key::createNewRandomKey();
        }
        if (isset($_GET["chat_name"])) {
            $this->chatName =  $_GET["chat_name"];
        } else {
            $this->chatName = 'Anonymus-' . rand();
        }
        if (isset($_GET["chat_title"])) {
            $this->chatTitle =  $_GET["chat_title"];
        }
        if (isset($_GET["chat_room"])) {
            $this->chatActive = true;
            $this->chatRoom = $_GET["chat_room"];
        } else {
            $newChatRoomName = !empty($_POST["new_chat_room"]) ? $_POST["new_chat_room"] : null;
            if ($newChatRoomName) {
                $this->chatTitle = $newChatRoomName ? $newChatRoomName : 'Meeting';
                $this->chatRoom = $this->safeEncrypt($newChatRoomName);
            }
        }
        if ($this->chatRoom && $_GET["get_messages"]) {
            $messages = $this->chatMassages(false);
            $json = json_encode($messages);
            header('Content-Type: application/json');
            echo $json;
            die();
        }
        $message = !empty($_POST["chat_message"]) ? $_POST["chat_message"] : null;
        $this->chatName  = !empty($_POST["chat_name"]) ? $_POST["chat_name"] : $this->chatName;
        $this->chatTitle = !empty($_POST["chat_title"]) ? $_POST["chat_title"] : $this->chatTitle;
        // $this->chatRoom = !empty($_POST["chat_room"]) ? $_POST["chat_room"] : $this->chatTitle ? $this->safeEncrypt($this->chatTitle): $this->chatRoom;
        if ($message && $this->chatRoom) {
            $this->chatMassage($message);
        }

        if (isset($_GET["get_messages"])) {
            $this->chatName =  $_GET["chat_name"];
        }

        if ($clearChat !== null) {
            $this->clearChatroom();
        }
        if ($this->chatRoom || $_GET["new_chat"]) {
            $this->app->homeButtonVisible = true;
        }
    }

    public function chatParams()
    {
        $parems = ("chat_title=" . rawurlencode($this->chatTitle) . "&chat_room=" . rawurlencode($this->chatRoom) . "&key=" . rawurlencode($this->cryptoKey->saveToAsciiSafeString()));

        return $parems;
    }

    public function chatURL()
    {
        return  $this->app->getConfig("appDomain") . "?" . $this->chatParams();
    }

    /**
     * get config value for attribute
     */
    public function getConfig(string $attributeName)
    {
        return $this->config[$attributeName] ? $this->config[$attributeName] : null;
    }

    /**
     * set config value for attribute
     */
    public function setConfig(string $attributeName, $value)
    {
        return $this->config[$attributeName] = $value;
    }

    public function mail($email, $subject, $message)
    {
        $message = wordwrap($message, 70);
        echo "MailSend to: " . $email . ", Subject: " . $subject . " <br><br> Message: <br>\"" . $message . "\"<br><br>";
        mail($email, $subject, $message);
    }

    /**
     * Encrypt a message
     * 
     * @param string $message - message to encrypt
     * @param Key $key - encryption key
     * @return string
     * @throws RangeException
     */
    function safeEncrypt(string $message): string
    {
        $ciphertext = "";
        if ($this->cryptoKey) {

            try {
                $ciphertext = Crypto::Encrypt($message, $this->cryptoKey);
            } catch (\TypeError $e) {
                print_r($e->getMessage());
            }
        }
        return $ciphertext;
    }

    /**
     * Decrypt a message
     * 
     * @param string $encrypted - message encrypted with safeEncrypt()
     * @return string
     * @throws Exception
     */
    function safeDecrypt(string $encrypted): string
    {

        $plain = Crypto::Decrypt($encrypted, $this->cryptoKey);
        return $plain;
    }

    public function chatMassage(string $message)
    {
        $filePath = 'csv/' . $this->chatRoom . '.csv';
        if (!file_exists($filePath)) {
            touch($filePath);
        }
        // Define a regular expression to match any inline scripts
        $script_regex = "/<script\b[^<]*(?:(?!<\/script>)<[^<]*)*<\/script>/i";

        // Use the PHP preg_replace() function to remove any inline scripts
        $message = preg_replace($script_regex, "", $message);

        // Use the PHP filter_var() function with the FILTER_SANITIZE_STRING flag to remove any HTML tags and special characters
        $message = filter_var($message, FILTER_SANITIZE_STRING);

        // Use the PHP htmlspecialchars() function to encode any special characters to prevent XSS attacks
        $message = htmlspecialchars($message, ENT_QUOTES, 'UTF-8');



        $date = new \DateTime('now');
        $new_row = array($this->safeEncrypt($date->format($this->dateFormat)), $this->safeEncrypt($this->chatName), $this->safeEncrypt($message));

        // Open the CSV file for writing (appending)
        $file = fopen($filePath, 'a');

        // Write the new row to the file
        fputcsv($file, $new_row);

        // Close the file
        fclose($file);
    }

    public function chatMassages($fromIfame)
    {
        $filePath = ($fromIfame ? '../../../' : '') . 'csv/' . $this->chatRoom . '.csv';

        if (!file_exists($filePath)) {
            touch($filePath);
        }

        // Open the CSV file for reading
        $file = fopen($filePath, 'r');

        // Read the first line (header) and discard it
        fgetcsv($file);



        // Initialize an empty array to store the data
        $messages = array();

        // Read each line of the CSV file and add it to the data array
        while ($row = fgetcsv($file)) {

            $message = $this->safeDecrypt($row[2]);

            // Define a regular expression to match URLs in the message
            $url_regex = '/((?:https?|ftp):\/\/[\w\-]+(?:\.[\w\-]+)+(?:[\w.,@?^=%&amp;:/~+#-]*[\w@?^=%&amp;/~+#-])?)/i';
            // Use the PHP preg_replace() function to replace any URLs in the message with a link wrapper
            $message = preg_replace('/(http)+(s)?:(\/\/)((\w|\.)+)(\/)?(\S+)?/i', '<a href="\0" target="_blank" class="message-link">\0</a>', $message);
            //  $message  = emoji_unified_to_html($message );
            $message = preg_replace('/([^-\p{L}\x00-\x7F]+)/u', '', $message);

            $messages[] = [
                "time" => $this->safeDecrypt($row[0]),
                "name" => $this->safeDecrypt($row[1]),
                "text" => $message
            ];
        }

        // Close the file
        fclose($file);

        return  $messages;
    }

    public function clearChatroom()
    {

        $filePath = 'csv/' . $this->chatRoom . '.csv';
        // Open the CSV file for writing
        $fp = fopen($filePath, 'w');

        // Clear the contents of the CSV file
        ftruncate($fp, 0);


        // Close the CSV file
        fclose($fp);
        $this->chatCleared = true;
        $this->chatMassage("Cleared the chat");
    }
}
