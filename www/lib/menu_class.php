<?php
/**
 * Created by PhpStorm.
 * User: Alex
 * Date: 11.04.2017
 * Time: 9:19
 */

require_once "global_class.php";

class Menu extends globalClass
{
    public function __construct($db)
    {
        parent::__construct("menu", $db);
    }
}