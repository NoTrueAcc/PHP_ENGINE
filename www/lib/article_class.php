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

    public function getTitle($id)
    {
        return $this->getFieldOnId($id, 'title');
    }

    public function setTitle($id, $value)
    {
        if(!$this->valid->validTitle($value))
        {
            return false;
        }

        return $this->setFieldOnId($id, "title", $value);
    }

    public function getIntroText($id)
    {
        return $this->getFieldOnId($id, 'intro_text');
    }

    public function setIntroText($id, $value)
    {
        if(!$this->valid->validIntroText($value))
        {
            return false;
        }

        return $this->setFieldOnId($id, "intro_text", $value);
    }

    public function getFullText($id)
    {
        return $this->getFieldOnId($id, 'full_text');
    }

    public function setFullText($id, $value)
    {
        if(!$this->valid->validFullText($value))
        {
            return false;
        }

        return $this->setFieldOnId($id, 'full_text', $value);
    }

    public function getMetaDesc($id)
    {
        return $this->getFieldOnId($id, 'meta_desc');
    }

    public function setMetaDesc($id, $value)
    {
        if(!$this->valid->validMetaDesc($value))
        {
            return false;
        }

        return $this->setFieldOnId($id, 'meta_desc', $value);
    }

    public function getMetaKey($id)
    {
        return $this->getFieldOnId($id, 'meta_key');
    }

    public function setMetaKey($id, $value)
    {
        if(!$this->valid->validMetaKey($value))
        {
            return false;
        }

        return $this->setFieldOnId($id, 'meta_key', $value);
    }

    public function getDate($id)
    {
        $unixTimeStamp = $this->getFieldOnId($id, 'date');

        return $unixTimeStamp;
    }

    public function setDate($id, $value)
    {
        if(!$this->valid->validTimeStamp($value))
        {
            return false;
        }

        return $this->setFieldOnId($id, 'date', $value);
    }

    public function getImageSrc($id)
    {
        return $this->getFieldOnId($id, 'img_src');
    }

    public function setImageSrc($id, $value)
    {
        if(!$this->valid->validImageSrc($value))
        {
            return false;
        }

        return $this->setFieldOnId($id, 'img_src', $value);
    }
}