<?php
/**
 * Created by PhpStorm.
 * User: Alex
 * Date: 13.04.2017
 * Time: 8:52
 */

require_once "modules_class.php";

class messageContent extends Modules
{
    private $messageTitle;
    private $messageText;
    public function __construct($db)
    {
        parent::__construct($db);
        $this->messageTitle = $this->message->getTitle($_SESSION['page_message']);
        $this->messageText = $this->message->getText($_SESSION['page_message']);
    }


    protected function getTitle()
    {
        return $this->messageTitle;
    }

    protected function getDescription()
    {
        return $this->messageText;
    }

    protected function getKeyWords()
    {
        return mb_strtolower($this->messageText);
    }

    protected function getMiddle()
    {
        $str['title'] = $this->messageTitle;
        $str['text'] = $this->messageText;
        return $this->getReplaceTemplate($str, 'message');
    }
}