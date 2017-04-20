<?php
/**
 * Created by PhpStorm.
 * User: Alex
 * Date: 13.04.2017
 * Time: 8:52
 */

require_once "modules_class.php";
require_once "config_class.php";

class mailContent extends Modules
{
    private $messageTitle;
    private $messageText;

    public function __construct($db)
    {
        parent::__construct($db);
    }


    protected function getTitle()
    {
        $this->messageTitle = "Проверка почты";
        return $this->messageTitle;
    }

    protected function getDescription()
    {
        if($this->getCheckMailResult())
        {
            $this->messageText = "Email успешно прошел проверку";
        }
        else
        {
            $this->messageText = "Неизвестная ошибка";
        }

        $this->messageText .= "<br><a href='" . $this->config->address . "'>Вернуться на шлавную страницу</a>";
        return $this->messageText;
    }

    protected function getKeyWords()
    {
        return mb_strtolower($this->messageTitle);
    }

    protected function getMiddle()
    {
        $str['title'] = $this->messageTitle;
        $str['text'] = $this->messageText;
        return $this->getReplaceTemplate($str, 'checkmail');
    }
}