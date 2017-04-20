<?php
/**
 * Created by PhpStorm.
 * User: Alex
 * Date: 13.04.2017
 * Time: 8:52
 */

require_once "modules_class.php";

class ArticleContent extends Modules
{
    private $article_info;

    public function __construct($db)
    {
        parent::__construct($db);
        $this->article_info = $this->article->get($this->data["id"]);
    }


    protected function getTitle()
    {
        return $this->article_info['title'];
    }

    protected function getDescription()
    {
        return $this->article_info["meta_desc"];
    }

    protected function getKeyWords()
    {
        return $this->article_info['meta_key'];
    }

    protected function getMiddle()
    {
        return $this->getArticle();
    }

    private function getArticle()
    {
        $str['title'] = $this->article_info['title'];
        $str['full_text'] = $this->article_info['full_text'];
        $str['date'] = $this->formatDate($this->article_info['date']);
        $str['article_image'] = $this->config->dirImages . $this->article_info['img_src'];

        return $this->getReplaceTemplate($str, 'article');
    }
}