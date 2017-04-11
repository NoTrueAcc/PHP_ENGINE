<?php

    require_once "config_class.php";

    abstract class globalMessage
    {

        private $data;

        public function __construct($fileName)
        {
            $config = new Config();
            $this->data = parse_ini_file($config->dirText . $fileName . ".ini");
        }

        public function getTitle($name)
        {
            return $this->data[$name . "_TITLE"];
        }

        public function getText($name)
        {
            return $this->data[$name . "_TEXT"];
        }
    }

?>