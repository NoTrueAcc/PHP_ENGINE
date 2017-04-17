<?php
/**
 * Created by PhpStorm.
 * User: Alex
 * Date: 07.04.2017
 * Time: 9:01
 */

require_once "config_class.php";

class checkValid {

    private $config;

    public function __construct()
    {
        $this->config = new Config();
    }

    public function validId($id)
    {
        if(!$this->isIntNumber($id) || $id <= 0)
        {
            return false;
        }
        return true;
    }

    public function validLogin($login)
    {
        if($this->isContainQuotes($login) || preg_match("/^\d*$/", $login))
        {
            return false;
        }

        return $this->validString($login, $this->config->minLogin, $this->config->naxLogin);
    }

    public function validHash($hash)
    {
        if($this->validString($hash, 32, 32) || !$this->isOnlyLettersAndDigits($hash))
        {

            return false;
        }

        return true;
    }

    public function validTimeStamp($time)
    {
        return $this->isNoNegativeNumber($time);
    }

    private function isIntNumber($number)
    {
        if(!is_int($number) && !is_string($number))
        {
            return false;
        }
        elseif(!preg_match('/^\-?([1-9][0-9]*)|0$/', $number))
        {
            return false;
        }

        return true;
    }

    private function isNoNegativeNumber($number)
    {
        if(!$this->isIntNumber($number) || ($number < 0))
        {
            return false;
        }

        return true;
    }

    private function isOnlyLettersAndDigits($string)
    {
        if(!is_int($string) && !is_string($string))
        {
            return false;
        }

        if(!preg_match("/^[a-zа-я0-9]*$/i", $string))
        {
            return false;
        }

        return true;
    }

    private function validString($string, $minLength, $maxLength)
    {
        if(!is_string($string) || (strlen($string) < $minLength) || (strlen($string) > $maxLength))
        {
            return false;
        }

        return true;
    }

    private function isContainQuotes($string)
    {
        $array = array("\"", "'", "`", "&quot;", "&apos;");

        foreach($array as $key => $value)
        {
            if(strpos($string, $value) !== false)
            {
                return true;
            }

            return false;
        }

    }

    public function validTitle($value)
    {
        if(!is_string($value) || !$this->validString($value,3,255))
        {
            return false;
        }

        return true;
    }

    public function validIntroText($value)
    {
        if(!is_string($value))
        {
            return false;
        }

        return true;
    }

    public function validFullText($value)
    {
        if(!is_string($value))
        {
            return false;
        }

        return true;
    }

    public function validMetaDesc($value)
    {
        if(!is_string($value) || !$this->validString($value, 3, 255))
        {
            return false;
        }

        return true;
    }

    public function validMetaKey($value)
    {
        if(!is_string($value) || !$this->validString($value, 3, 255))
        {
            return false;
        }

        return true;
    }

    public function validImageSrc($value)
    {
        if(!is_string($value) || !$this->validString($value, 3, 255))
        {
            return false;
        }

        return true;
    }


}