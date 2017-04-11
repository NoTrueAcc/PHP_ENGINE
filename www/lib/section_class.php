<?php
/**
 * Created by PhpStorm.
 * User: Alex
 * Date: 11.04.2017
 * Time: 9:07
 */

require_once "global_class.php";

class Section extends globalClass
{
    public function __construct($db)
    {
        parent::__construct("sections", $db);
    }
}