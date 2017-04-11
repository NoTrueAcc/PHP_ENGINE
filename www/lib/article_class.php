<?php
/**
 * Created by PhpStorm.
 * User: Alex
 * Date: 11.04.2017
 * Time: 9:10
 */

require_once "global_class.php";

class Article extends globalClass
{
    public function __construct($db)
    {
        parent::__construct("articles", $db);
    }

    public function getAllSortDate()
    {
        return $this->getAll("date", false);
    }

    public function getAllSectionId($sectionId)
    {
        return $this->getAllOnField("section_id", $sectionId, "date", false);
    }
}