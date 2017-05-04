<?php
/**
 * Created by PhpStorm.
 * User: Alex
 * Date: 13.04.2017
 * Time: 8:52
 */

require_once "modules_class.php";

class SectionContent extends Modules
{
    private $articles;
    private $section_info;
    private $page;

    public function __construct($db)
    {
        parent::__construct($db);
        $this->articles = $this->article->getAllSectionId($this->data["id"]);
        $this->section_info = $this->section->get($this->data["id"]);
        if(!$this->section_info)
        {
            $this->notFound();
        }
        $this->page = isset($this->data["page"]) ? $this->data["page"] : 1;
        $this->pageNotFound($this->page, count($this->articles));
    }


    protected function getTitle()
    {
        if($this->page > 1)
        {
            return $this->section_info["title"] . " - Cтраница " . $this->page;
        }

        return $this->section_info['title'];
    }

    protected function getDescription()
    {
        return $this->section_info["meta_desc"];
    }

    protected function getKeyWords()
    {
        return $this->section_info['meta_key'];
    }

    protected function getMiddle()
    {
        return $this->getBlogArticles($this->articles, $this->page);
    }

    protected function getTop()
    {
        $str['title'] = $this->section_info['title'];
        $str['description'] = $this->section_info['description'];
        $str['image_section'] = $this->config->dirImages . $this->section_info['img_src'];
        return $this->getReplaceTemplate($str, 'section');
    }

    protected function getBottom()
    {
        return $this->getPagination(count($this->articles), $this->config->countBlog, $this->config->address . "/?view=section&amp;id=" . $this->data["id"]);
    }
}