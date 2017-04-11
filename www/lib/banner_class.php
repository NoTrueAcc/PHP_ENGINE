<?php
/**
 * Created by PhpStorm.
 * User: Alex
 * Date: 11.04.2017
 * Time: 9:16
 */

require_once "global_class.php";

class Banner extends globalClass
{
    public function __construct($db)
    {
        parent::__construct("banners", $db);
    }
}