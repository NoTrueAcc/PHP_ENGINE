<?php
/**
 * Created by PhpStorm.
 * User: Alex
 * Date: 11.04.2017
 * Time: 9:20
 */

require_once "global_class.php";

class User extends globalClass
{
    public function __construct($db)
    {
        parent::__construct("users", $db);
    }

    public function addUser($login, $password, $regDate)
    {
        if(!$this->checkValid($login, $password,$regDate))
        {
            return false;
        }
        else
        {
            return $this->add(array("login" => $login, "password" => $password, "regdate" => $regDate));
        }

    }

    public function editUser($id, $login, $password, $regDate)
    {
        if(!$this->checkValid($login, $password, $regDate))
        {
            return false;
        }
        else
        {
            return $this->edit($id, array("login" => $login, "password" => $password, "regdate" => $regDate));
        }
    }

    public function isExistsLogin($login)
    {
        return $this->isExists("login", $login);
    }

    public function getUserOnLogin($login)
    {
        $id = $this->getField("id", "login", $login);

        return $this->get($id);
    }

    private function checkValid($login, $password, $regDate)
    {
        if(!$this->valid->validLogin($login) || !$this->valid->validHash($password) || !$this->valid->validTimeStamp($regDate))
        {
            return false;
        }

        return true;
    }
}