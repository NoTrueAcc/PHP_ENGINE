<?php
/**
 * Created by PhpStorm.
 * User: Alex
 * Date: 18.04.2017
 * Time: 19:30
 */

require_once "lib/manage_class.php";
require_once "lib/database_class.php";

$db = new dataBase();
$manage = new Manage($db);
$config = new Config();

if(isset($_POST['reg']))
{
    $r = $manage->regUser();
}
elseif(isset($_POST['auth']))
{
    $r = $manage->login();
}
elseif (isset($_GET['logout']))
{
    $r = $manage->logout();
}
elseif(isset($_POST['restorepass']))
{
    $r = $manage->restorePassword();
}
elseif(isset($_POST['restorepassonemail']))
{
    $r = $manage->restorePassOnEmail();
}
else
{
    exit();
}

$manage->redirect($r);