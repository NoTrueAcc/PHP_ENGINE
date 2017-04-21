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

    public function addUser($login, $password, $regDate, $email, $email_hash)
    {
        if(!$this->checkValid($login, $password, $regDate))
        {
            return false;
        }
        else
        {
            return $this->add(array("login" => $login, "password" => $password, "regdate" => $regDate, "email" => $email, "email_hash" => $email_hash));
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

    public function isExistsEmail($email)
    {
        return $this->isExists("email", $email);
    }

    public function validMailHash($hash)
    {
        if($this->isExists("email_hash", $hash))
        {
            $this->setField("email_hash", "", "email_hash", $hash);

            return true;
        }

        return false;
    }

    public function checkUser($login, $password)
    {
        $user = $this->getUserOnLogin($login);

        return empty($user) ? false : ($user['password'] === $password);
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