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
require_once "lib/articlecontent_class.php";
require_once "lib/regcontent_class.php";
require_once "lib/messagecontent_class.php";
require_once "lib/mailcontent_class.php";
require_once "lib/restorepasscontent_class.php";
require_once "lib/restorepassonemailcontent_class.php";
require_once "lib/searchcontent_class.php";

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
    case "article" :
        $content = new ArticleContent($db);
        break;
    case "reg" :
        $content = new RegContent($db);
        break;
    case "message" :
        $content = new messageContent($db);
        break;
    case "checkmailpage" :
        $content = new mailContent($db);
        break;
    case "restorepass" :
        $content = new restorePassContent($db);
        break;
    case "restoremailpage" :
        $content = new restorePassOnEmailContent($db);
        break;
    case "search" :
        $content = new searchContent($db);
        break;
    default : exit;
}

echo $content->getContent();