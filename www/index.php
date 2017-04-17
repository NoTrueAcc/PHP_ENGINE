<?php
/**
 * Created by PhpStorm.
 * User: Alex
 * Date: 13.04.2017
 * Time: 8:23
 */

mb_internal_encoding("UTF-8");

require_once "lib/database_class.php";
require_once "lib/frontpagecontent_class.php";
require_once "lib/sectioncontent_class.php";

$db = new dataBase();
$view = isset($_GET['view']) ? $_GET['view'] : "";

switch ($view)
{
    case "" :
        $content = new FrontPageContent($db);
        break;
    case "section" :
        $content = new SectionContent($db);
        break;
    default : exit;
}

echo $content->getContent();