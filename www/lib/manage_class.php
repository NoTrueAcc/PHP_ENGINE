<?php
/**
 * Created by PhpStorm.
 * User: Alex
 * Date: 18.04.2017
 * Time: 9:10
 */

require_once "config_class.php";
require_once "user_class.php";
require_once "mail_class.php";

class Manage
{
    private $config;
    private $user;
    private $data;

    public function __construct($db)
    {
        session_start();
        $this->config = new Config();
        $this->user = new User($db);
        $this->data = $this->secureData(array_merge($_GET, $_POST));
    }

    private function secureData($data)
    {
        foreach ($data as $key => $value)
        {
            if(is_array($value))
            {
                $this->secureData($value);
            }
            else
            {
                $data[$key] = htmlspecialchars($value);
            }
        }

        return $data;
    }

    public function redirect($link)
    {
        header("Location: $link");
        exit;
    }

    public function regUser()
    {
        $linkReg = $this->config->address . "?view=reg";
        $captcha = $this->data['captcha'];
        if(!isset($_SESSION['rand']) || ($_SESSION['rand'] != $captcha) || empty($_SESSION['rand']))
        {
            return $this->returnMessage("ERROR_CAPTCHA", $linkReg);
        }

        $login = $this->data['login'];
        if($this->user->isExistsLogin($login))
        {
           return $this->returnMessage("EXISTS_LOGIN", $linkReg);
        }
        $password = $this->data['password'];
        if(empty($password))
        {
            return $this->returnMessage("EMPTY_PASSWORD", $linkReg);
        }
        $password = $this->hashPassword($password);
        $email = $this->data['email'];

        if($this->user->isExistsEmail($email))
        {
            return $this->returnMessage("EXISTS_EMAIL", $linkReg);
        }

        $email_hash = md5($email . $login);

        $result = $this->user->addUser($login, $password, time(), $email, $email_hash);

        if($result)
        {
            $checkMailPage = $this->config->address . "?view=checkmailpage";
            //mail::sendCheckMail($email, $login, $checkMailPage);

            return $this->returnPageMessage("SUCCESS_REG", $this->config->address . "?view=message");
        }
        else
        {
            return $this->unknownError($linkReg);
        }
    }

    public function login()
    {
        $login = $this->data['login'];
        $password = $this->data['password'];
        $password = $this->hashPassword($password);
        $r = $_SERVER['HTTP_REFERER'];

        if($this->user->checkUser($login, $password))
        {
            $_SESSION['login'] = $login;
            $_SESSION['password'] = $password;

            if(!$this->user->emailIsChecked($login))
            {
                $_SESSION['error_auth'] = 2;
            }

            return $r;
        }
        else
        {
            $_SESSION['error_auth'] = 1;

            return $r;
        }
    }

    public function logout()
    {
        unset($_SESSION['login']);
        unset($_SESSION['password']);
        unset($_SESSION['error_auth']);

        return $_SERVER['HTTP_REFERER'];
    }

    private function hashPassword($password)
    {
        return md5($password . $this->config->secret);
    }

    private function unknownError($r)
    {

        return $this->returnMessage("UNKNOWN_ERROR", $r);
    }

    private function returnMessage($message, $r)
    {
        $_SESSION['message'] = $message;

        return $r;
    }

    private function returnPageMessage($page_message, $r)
    {
        $_SESSION['page_message'] = $page_message;

        return $r;
    }
}