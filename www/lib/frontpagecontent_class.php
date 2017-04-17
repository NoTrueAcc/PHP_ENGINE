<?php
/**
 * Created by PhpStorm.
 * User: Alex
 * Date: 13.04.2017
 * Time: 8:52
 */

require_once "modules_class.php";

class FrontPageContent extends Modules
{
    private $articles;
    private $page;

    public function __construct($db)
    {
        parent::__construct($db);
        $this->articles = $this->article->getAllSortDate();
        $this->page = isset($this->data["page"]) ? $this->data["page"] : 1;
    }


    protected function getTitle()
    {
        if($this->page > 1)
        {
            return "Справочник по PHP, страница " . $this->page;
        }

        return "Справочник по PHP";
    }

    protected function getDescription()
    {
        return "Справочник функуций по PHP";
    }

    protected function getKeyWords()
    {
        return "справочник функций php";
    }

    protected function getMiddle()
    {
        return $this->getBlogArticles($this->articles, $this->page);
    }

    protected function getTop()
    {
        return $this->getTemplate("main_article");
    }

    protected function getBottom()
    {
        return $this->getPagination(count($this->articles), $this->config->countBlog, $this->config->address);
    }
}