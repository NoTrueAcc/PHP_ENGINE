<?php
/**
 * Created by PhpStorm.
 * User: Alex
 * Date: 19.04.2017
 * Time: 8:28
 */

class mail
{
    public static function sendMail($message, $to, $from, $subject)
    {
        $subject = "=?windows-1251?B?" . base64_encode($subject) . "?=";
        $headers = "From: " . $from . "\r\nReply-to: " . $from . "\r\nContent-type: text/plain; charset=windows-1251\r\n";

        mail($to, $subject, $message, $headers);
    }

    public static function sendCheckMail($to, $login, $checkMailPage)
    {
        $link = $checkMailPage . "&checkdata=" . md5($to . $login);
        $message = "Для подтверждения почты пройдите по ссылке $link";
        $from = "alextest.local";
        $subject = "Подтверждение почты";
        $subject = "=?windows-1251?B?" . base64_encode($subject) . "?=";
        $headers = "From: " . $from . "\r\nReply-to: " . $from . "\r\nContent-type: text/plain; charset=windows-1251\r\n";

        mail($to, $subject, $message, $headers);
    }
}