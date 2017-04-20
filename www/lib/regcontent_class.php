<?php
/**
 * Created by PhpStorm.
 * User: Alex
 * Date: 13.04.2017
 * Time: 8:52
 */

require_once "modules_class.php";

class RegContent extends Modules
{
    public function __construct($db)
    {
        parent::__construct($db);
    }


    protected function getTitle()
    {
        return "Регистрация на сайте";
    }

    protected function getDescription()
    {
        return "Регистрация пользователя на сайте";
    }

    protected function getKeyWords()
    {
        return "регистрация сайт, регистрация пользователя сайт";
    }

    protected function getMiddle()
    {
        $str['message'] = $this->getMessage();
        $str['login'] = isset($_SESSION['login']) ? $_SESSION['login'] : "";
        return $this->getReplaceTemplate($str, 'form_reg');
    }
}