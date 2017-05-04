<?php
/**
 * Created by PhpStorm.
 * User: Alex
 * Date: 13.04.2017
 * Time: 8:52
 */

require_once "modules_class.php";

class searchContent extends Modules
{
    private $words;

    public function __construct($db)
    {
        parent::__construct($db);
        $this->words = $this->data['words'];
    }


    protected function getTitle()
    {
        return "Результаты поиска: " . $this->words;
    }

    protected function getDescription()
    {
        return $this->words;
    }

    protected function getKeyWords()
    {
        return mb_strtolower($this->words);
    }

    protected function getMiddle()
    {
        $results = $this->article->searchArticles($this->words);
        $text = "";

        if($results === false)
        {
            return $this->getTemplate('search_notfound');
        }

        $words = explode(" ", $this->words);

        for($i = 0; $i < count($results); $i++)
        {
            $str['link'] = $this->config->address . "?view=article&amp;id=" . $results[$i]['id'];
            $str['title'] = $results[$i]['title'];

            foreach ($words as $key => $value)
            {
                $results[$i]['full_text'] = str_replace($value, "<b>" . $value . "</b>", $results[$i]['full_text']);
            }

            $str['text'] = $results[$i]['full_text'];

            $text .= $this->getReplaceTemplate($str, 'search_item');
        }

        $str['search_items'] = $text;

        return $this->getReplaceTemplate($str, 'search_result');
    }
}