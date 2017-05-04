<?php
/**
 * Created by PhpStorm.
 * User: Alex
 * Date: 13.04.2017
 * Time: 8:52
 */

require_once "modules_class.php";

class notFoundContent extends Modules
{
    public function __construct($db)
    {
        parent::__construct($db);
        header("HTTP/1.0 404 Not Found");
    }


    protected function getTitle()
    {
        return "404 - страница не найдена";
    }

    protected function getDescription()
    {
        return "404";
    }

    protected function getKeyWords()
    {
        return "not found";
    }

    protected function getMiddle()
    {
        return $this->getTemplate('notfound');
    }
}