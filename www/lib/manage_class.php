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

            if(!$this->user->emailIsChecked('login', $login))
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

    public function restorePassword()
    {
        $linkRestore = $this->config->address . "?view=restorepass";
        $captcha = $this->data['captcha'];

        if(!isset($_SESSION['rand']) || ($_SESSION['rand'] != $captcha) || empty($_SESSION['rand']))
        {
            return $this->returnMessage("ERROR_CAPTCHA", $linkRestore);
        }

        $email = $this->data['email'];

        if(!$this->user->isExistsEmail($email))
        {
            return $this->returnMessage("EMAIL_IS_NOT_EXISTS_ON_RESTORE", $linkRestore);
        }
        elseif (!$this->user->emailIsChecked('email', $email))
        {
            return $this->returnMessage("ERROR_RESTORE_PASS_ON_EMAIL_CHECKED", $linkRestore);
        }
        else
        {
            $this->user->setRestorePassField($email);
            $restoreMailPage = $this->config->address . "?view=restoremailpage";
            mail::sendRestoreMail($email, $restoreMailPage);

            return $this->returnMessage("SUCCESS_RESTORE_PASS_ON_EMAIL", $linkRestore);
        }
    }

    public function restorePassOnEmail()
    {
        $linkRestoreOnEmail = $this->config->address . "?view=restoremailpage&checkdatamail=" . $this->data['secret'];
        $linkMessage = $this->config->address . "?view=message";

        $pass_1 = isset($this->data['pass_1']) ? $this->data['pass_1'] : "";
        $pass_2 = isset($this->data['pass_2']) ? $this->data['pass_2'] : "";

        if(empty($pass_1) || empty($pass_2))
        {
            return $this->returnMessage("ANY_FIELD_EMPTY", $linkRestoreOnEmail);
        }

        if($pass_1 != $pass_2)
        {
            return $this->returnMessage("ERROR_PASS_EQUABILITY_ON_EMAIL_RESTORE", $linkRestoreOnEmail);
        }

        if($pass_1 == $pass_2)
        {
            if(empty($this->data['secret']) || !$this->user->restorePassIsExists($this->data['secret']))
            {
                return $this->returnPageMessage('UNKNOWN_ERROR', $linkMessage);
            }
            else{
                $password = $this->hashPassword($pass_1);
                $this->user->setField('password', $password, 'restore_pass', $this->data['secret']);
                $this->user->setField('restore_pass', "", 'restore_pass', $this->data['secret']);

                return $this->returnPageMessage("RESTORE_PASS_ON_EMAIL_SUCCESS", $linkMessage);
            }
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