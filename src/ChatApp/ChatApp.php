<?php

namespace ChatApp;

require_once __DIR__ . '/Config/Autoload.php';

use \ChatApp\Service\Chat;

class ChatApp
{
    /**
     * @var array
     */
    protected $config;

    /**
     * @var array
     */
    public $postData;

    /**
     * @var array
     */
    public $getData;

    /**
     * @var Chat
     */
    public $chat;
    
    /**
     * @var bool
     */
    public $homeButtonVisible = false;

    public function __construct(
        array $config
    ) {
        $this->config = $config;
        $this->chat = new Chat($this);
        $this->getData = $_GET;
        $this->postData = $_POST;
     
    }
  

     /** get config value for attribute
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

    public function payToMollie($amount)
    {
        $redirectUrl = $this->mollie->pay($amount, 10, "Test Transaction", [
            "additionalData" => "Test Datza"
        ]);
        return $redirectUrl;
    }

}
