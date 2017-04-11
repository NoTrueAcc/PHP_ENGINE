<?php
/**
 * Created by PhpStorm.
 * User: Alex
 * Date: 11.04.2017
 * Time: 20:25
 */

require_once "globalmessage_class.php";

class Message extends globalMessage
{
    public function __construct()
    {
        parent::__construct("messages");
    }
}