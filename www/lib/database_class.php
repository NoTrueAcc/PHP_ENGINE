<?php
/**
 * Created by PhpStorm.
 * User: Alex
 * Date: 10.04.2017
 * Time: 8:27
 */

    include_once "check_class.php";
    include_once "config_class.php";

    class dataBase {
        private $config;
        private $mysqli;
        private $valid;

        public function __construct()
        {
            $this->config = new Config();
            $this->valid = new checkValid();
            $this->mysqli = new mysqli($this->config->host, $this->config->user, $this->config->password, $this->config->db);
            $this->mysqli->query('SET NAMES UTF8');
        }

        private function query($query)
        {
            return $this->mysqli->query($query);
        }

        private function select($tableName, $fields, $where = '', $order = '', $up = true, $limit = "")
        {
            for($i = 0; $i < count($fields); $i++)
            {
                if((strpos($fields[$i], "(") === false) && ($fields[$i] != "*"))
                {
                    $fields[$i] = "`" . $fields[$i] . "`";
                }
            }

            $fields = implode(",", $fields);
            $tableName = $this->config->db_prefix . $tableName;

            if(!$order)
            {
                $order = " ORDER BY `id`";
            }
            elseif($order != 'RAND()')
            {
                $order = " ORDER BY `$order`";
                if(!$up)
                {
                    $order .= ' DESC';
                }
            }
            else
            {
                $order = "ORDER BY $order";
            }

            if($limit)
            {
                $limit = " LIMIT $limit";
            }

            if($where)
            {
                $query = "SELECT $fields FROM $tableName WHERE $where $order $limit";
            }
            else
            {
                $query = "SELECT $fields FROM $tableName $order $limit";
            }

            $resultSet = $this->query($query);

            if(!$resultSet)
            {
                return false;
            }
            $i = 0;
            $data = array();
            while($row = $resultSet->fetch_assoc())
            {
                $data[$i] = $row;
                $i++;
            }

            $resultSet->close();

            return $data;
        }

        public function insert($tableName, $newValues)
        {
            $tableName = $this->config->db_prefix . $tableName;
            $query = "INSERT INTO `$tableName` (";
                foreach ($newValues as $field => $value)
                {
                    $query .= "`" . $field . "`,";
                }

                $query = substr($query, 0, -1);
                $query .= ") VALUES (";
                    foreach ($newValues as $value)
                    {
                        $query .= "'" . addslashes($value) . "',";
                    }

                    $query = substr($query, 0, -1);
                    $query .= ")";

                    return $this->query($query);
        }

        public function update($tableName, $updateFields, $where)
        {
            $tableName = $this->config->db_prefix . $tableName;

            $query = "UPDATE `$tableName` SET ";
            foreach ($updateFields as $field => $value)
            {
                $query .= "`$field` = '" . addslashes($value) . "',";
            }

            $query = substr($query, 0, -1);

            if($where)
            {
                $query .= " WHERE $where";

                 return $this->query($query);
            }

            return false;
        }

        public function updateOnId($tablename, $id, $updateFields)
        {
            if(!$this->valid->validId($id))
            {
                return false;
            }

            return $this->update($tablename, $updateFields, "`id` = $id");
        }

        public function delete($tableName, $where)
        {
            $tableName = $this->config->db_prefix . $tableName;

            if($where)
            {
                $query = "DELETE FROM $tableName WHERE $where";
                return $this->query($query);
            }
            else
            {
                return false;
            }
        }

        public function deleteAll($tableName)
        {
            $tableName = $this->config->db_prefix . $tableName;
            $query = "TRUNCATE TABLE `$tableName`";

            return $this->query($query);
        }

        public function getField($tableName, $fieldOut, $fieldIn, $valueIn)
        {
            $data = $this->select($tableName, array($fieldOut), "`$fieldIn` = '" . addslashes($valueIn) . "'");
            if(count($data) != 1)
            {
                return false;
            }

            return $data[0][$fieldOut];
        }

        public function getFieldOnId($tableName, $id, $fieldOut)
        {
            if(!$this->existsId($tableName, $id))
            {
                return false;
            }
            else
            {
                return $this->getField($tableName, $fieldOut, "id", $id);
            }
        }

        public function getAll($tableName, $order, $up)
        {
            return $this->select($tableName, array("*"), "", $order, $up);
        }

        public function getAllOnField($tableName, $field, $value, $order, $up)
        {
            return $this->select($tableName, array("*"), "$field = '" . addslashes($value) . "'", $order, $up);
        }

        public function getLastId($tableName)
        {
            $data = $this->select($tableName, array("MAX(`id`)"));

            return $data[0]["MAX(`id`)"];
        }

        public function getFieldMaxValue($tableName, $field)
        {
            $data = $this->select($tableName, array("MAX(`$field`)"));

            return $data[0]["MAX[`$field`]"];
        }

        public function getFieldMinValue($tableName, $field)
        {
            $data = $this->select($tableName, array("MIN[`$field`]"));

            return $data[0]["MIN[`$field`]"];
        }

        public function getFieldsOnInterval($tableName, $field, $intervalFrom, $intervalTo)
        {
            $where = "`$field` BETWEEN '$intervalFrom' AND '$intervalTo'";
            $data = $this->select($tableName, array("*"), $where, $field);

            return $data;
        }

        protected function checkFieldType($tableName, $field)
        {
            $query = "SELECT `$field` FROM `$tableName`";

            return $this->mysqli->field_type($this->query($query));
        }

        public function deleteOnId($tableName, $id)
        {
            if(!$this->existsId($tableName, $id))
            {
                return false;
            }

            return $this->delete($tableName, "`id` = '$id'");
        }

        public function setField($tableName, $field, $value, $fieldIn, $valueIn)
        {
            return $this->update($tableName, array($field => $value), " `$fieldIn` = '" . addslashes($valueIn) . "'");
        }

        public function setFieldOnId($tableName, $id, $field, $value)
        {
            if(!$this->existsId($tableName, $id))
            {
                return false;
            }
            else
            {
                return $this->setField($tableName, $field, $value, "id", $id);
            }
        }

        public function getElementOnId($tableName, $id)
        {
            if(!$this->existsId($tableName, $id))
            {
                return false;
            }
            else
            {
                $array = $this->select($tableName, array("*"), "`id` = '$id'");

                return $array[0];
            }
        }

        public function getRandomElements($tableName, $count)
        {
            return $this->select($tableName, array("*"), "", "RAND()", true, $count);
        }

        public function getCount($tableName)
        {
            $data = select($tableName, array("count(`id`)"));

            return $data[0]["count(`id`)"];
        }

        public function isExists($tableName, $field, $value)
        {
            $data = $this->select($tableName, array("id"), "`$field` = '" . addslashes($value) . "'");
            if(count($data) === 0)
            {
                return false;
            }
            else
            {
                return true;
            }
        }

        private function existsId($tableName, $id)
        {
            if(!$this->valid->validId($id))
            {
                return false;
            }
            else
            {
                $data = $this->select($tableName, array("id"), "`id` = '" . addslashes($id) . "'");
                if(count($data) === 0)
                {
                    return false;
                }

                return true;
            }
        }

        public function __destruct()
        {
            if($this->mysqli)
            {
                $this->mysqli->close();
            }
        }
    }
?>