<?php
/**
 * Created by PhpStorm.
 * User: Alex
 * Date: 13.04.2017
 * Time: 8:52
 */

require_once "modules_class.php";
require_once "config_class.php";

class  restorePassContent extends Modules
{
    private $messageTitle;
    private $messageText;

    public function __construct($db)
    {
        parent::__construct($db);
    }

    protected function getTitle()
    {
        $this->messageTitle = "Восстановление пароля";
        return $this->messageTitle;
    }

    protected function getDescription()
    {
        $this->messageText = "Для восстановления пароля введите Ваш email.";
        return $this->messageText;
    }

    protected function getKeyWords()
    {
        return mb_strtolower($this->messageTitle);
    }

    protected function getMiddle()
    {
        $str['message'] = $this->getMessage();
        $str['title'] = $this->messageTitle;
        $str['text'] = $this->messageText;
        return $this->getReplaceTemplate($str, 'restore_pass');
    }
}