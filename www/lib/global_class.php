<?php

    require_once "database_class.php";
    require_once "check_class.php";
    require_once "config_class.php";

    abstract class globalClass
    {

        private $db;
        private $tableName;
        protected $config;
        protected $valid;

        protected function __construct($tableName, $db)
        {
            $this->db = $db;
            $this->tableName = $tableName;
            $this->config = new Config();
            $this->valid = new checkValid();
        }

        protected function add($newValues)
        {
            return $this->db->insert($this->tableName, $newValues);
        }

        protected function edit($id, $updateFields)
        {
            return $this->db->updateOnID($this->tableName, $id, $updateFields);
        }

        public function delete($id)
        {
            return $this->db->deleteOnId($this->tableName, $id);
        }

        public function setField($field, $value, $fieldIn, $valueIn)
        {
            return $this->db->setField($this->tableName, $field, $value, $fieldIn, $valueIn);
        }

        public function deleteAll()
        {
            return $this->db->deleteAll($this->tableName);
        }

        protected function getField($fieldOut, $fieldIn, $valueIn)
        {
            return $this->db->getField($this->tableName, $fieldOut, $fieldIn, $valueIn);
        }

        protected function getFieldOnId($id, $field)
        {
            return $this->db->getFieldOnId($this->tableName, $id, $field);
        }

        protected function setFieldOnId($id, $field, $value)
        {
            return $this->db->setFieldOnId($this->tableName, $id, $field, $value);
        }

        public function get($id)
        {
            return $this->db->getElementOnID($this->tableName, $id);
        }

        public function getAll($order = "", $up = true)
        {
            return $this->db->getAll($this->tableName, $order, $up);
        }

        public function getAllOnField($field, $value, $order = "", $up = true)
        {
            return $this->db->getAllOnField($this->tableName, $field, $value, $order, $up);
        }

        public function getRandomElement($count)
        {
            return $this->db->getRandomElement($this->tableName, $count);
        }

        public function getLastId()
        {
            return $this->db->getLastId($this->tableName);
        }

        public function getCount()
        {
            return $this->db->getCount($this->tableName);
        }

        protected function isExists($field, $value)
        {
            return $this->db->isExists($this->tableName, $field, $value);
        }
    }

?>