<?php

    namespace PathsCode;

    class DatabaseTable {

        private $PDO;
        private $table;
        private $primaryKey;
        private $className;
        private $constructorArgs;

        public function __construct(\PDO $PDO, string $table, $primaryKey, string $className = '\stdClass', array $constructorArgs = []) {
            $this->PDO = $PDO;
            $this->table = $table;
            $this->primaryKey = is_array($primaryKey) ? $primaryKey : [$primaryKey];
            $this->className = $className;
            $this->constructorArgs = $constructorArgs;
        }

        private function adjustId($id) {
            return is_array($id) ? $id : [$this->primaryKey[0] => $id];
        }

        public function getPrimaryKey() {
            return count($this->primaryKey) == 1 ? $this->primaryKey[0] : $this->primaryKey;
        }

        private function query($sql, $pars=[]) {

            $query = $this->PDO->prepare($sql);
            $query->execute($pars);
    
            return $query;
        }

        public function total($field = null, $value = null) {
            
            $parameters = [];
            $sql = 'SELECT COUNT(*) FROM `' . $this->table . '`';

            if (!empty($field)) {
                $sql .= ' WHERE `' . $field . '` = :value';
                $parameters = ['value' => $value];
            }

            $query = $this->query($sql, $parameters);
            $total = ($query->fetch())[0];
    
            return $total;
        }
    
        public function findAll($orderBy = null, $limit = null, $offset = null) {
    
            $query = 'SELECT * FROM `' . $this->table . '`';

            if ($orderBy != null) {
                $query .= ' ORDER BY ' . $orderBy;
            }    

            if ($limit != null) {
                $query .= ' LIMIT ' . $limit;
            }

            if ($offset != null) {
                $query .= ' OFFSET ' . $offset;
            }

            $result = $this->query($query);

            return $result->fetchAll(\PDO::FETCH_CLASS, $this->className, $this->constructorArgs);
        }

        public function findById($id) {
    
            $id = $this->adjustId($id);

            $pars = [];
            $sql = 'SELECT * FROM `' . $this->table . '` 
                WHERE ';
 
            for ($i = 0; $i < count($this->primaryKey); $i++) {
                $pk = $this->primaryKey[$i];
                
                $sql .= '`' . $pk . '` = :primaryKey' . $i;
                $sql .= ' AND ';

                $pars['primaryKey' . $i] = $id[$pk];
            }

            $sql = rtrim($sql, ' AND ');

            $query = $this->query($sql, $pars);
    
            return $query->fetchObject($this->className, $this->constructorArgs);  
        }

        public function find($column, $value, $orderBy = null, $limit = null, $offset = null) {

            $pars = [':value' => $value];
            $sql = 'SELECT * FROM `' . $this->table . '` 
                WHERE `' . $column . '` = :value';

            if ($orderBy != null) {
                $sql .= ' ORDER BY ' . $orderBy;
            }

            if ($limit != null) {
                $sql .= ' LIMIT ' . $limit;
            }

            if ($offset != null) {
                $sql .= ' OFFSET ' . $offset;
            }

            $result = $this->query($sql, $pars);
    
            return $result->fetchAll(\PDO::FETCH_CLASS, $this->className, $this->constructorArgs);

        }

        public function findMinMax($column, $min, $max, $orderBy = null, $limit = null, $offset = null) {

            if (!(gettype($min) == gettype($max) && gettype($max) == gettype(16))) {
                return [];
            }

            $pars = [':min' => $min, ':max' => $max];
            $sql = 'SELECT * FROM `' . $this->table . '` 
                WHERE :min <= `' . $column . '` && `' . $column . '` <= :max';

            if ($orderBy != null) {
                $sql .= ' ORDER BY ' . $orderBy;
            }

            if ($limit != null) {
                $sql .= ' LIMIT ' . $limit;
            }

            if ($offset != null) {
                $sql .= ' OFFSET ' . $offset;
            }

            $result = $this->query($sql, $pars);
    
            return $result->fetchAll(\PDO::FETCH_CLASS, $this->className, $this->constructorArgs);

        }

        public function findLastData() {
            
            if (is_array($this->getPrimaryKey())) return;

            $sql = 'SELECT * FROM `' . $this->table . '` ORDER BY `' . $this->getPrimaryKey() . '` DESC LIMIT 1';
            $query = $this->query($sql);
    
            return $query->fetchObject($this->className, $this->constructorArgs) ?? null; 
        
        }

        public function findMinMaxNum($column, $min, $max) {
            
            if (!(gettype($min) == gettype($max) && gettype($max) == gettype(16))) {
                return 0;
            }

            if (is_array($this->getPrimaryKey())) return 0;

            $pars = [':min' => $min, ':max' => $max];
            $sql = 'SELECT COUNT(`' . $this->getPrimaryKey() . '`) AS total FROM `' . $this->table . '` 
                WHERE :min <= `' . $column . '` && `' . $column . '` <= :max';

            $query = $this->query($sql, $pars);

            return ($query->fetchObject($this->className, $this->constructorArgs))->total ?? null; 

        }
    
        public function insert($fields) {
    
            $sql = 'INSERT INTO `' . $this->table . '` (';
    
            foreach ($fields as $key => $value) {
                $sql .= '`' . $key . '`, ';
            }
    
            $sql = rtrim($sql, ', ');
            $sql .= ') VALUES (';
    
            foreach ($fields as $key => $value) {
                $sql .= ':' . $key . ', ';
            }
    
            $sql = rtrim($sql, ', ');
            $sql .= ')';
    
            $fields = $this->processDates($fields);
    
            $this->query($sql, $fields);

            return (count($this->primaryKey) == 1) ? $this->PDO->lastInsertId() : null; 
        }
    
        public function update($fields) {
    
            $sql = 'UPDATE `' . $this->table . '` SET ';
    
            foreach ($fields as $key => $value) {
                $sql .= '`' . $key . '` = :' . $key . ","; 
            }
    
            $sql = rtrim($sql, ',');

            $sql .= ' WHERE ';
            for ($i = 0; $i < count($this->primaryKey); $i++) {
                $pk = $this->primaryKey[$i];

                $sql .= '`' . $pk . '` = :primaryKey' . $i;
                $sql .= ' AND ';

                $fields['primaryKey' . $i] = $fields[$pk];
            }

            $sql = rtrim($sql, ' AND ');
        
            $fields = $this->processDates($fields);

            $this->query($sql, $fields);
        }

        public function save($record) {
            $entity = new $this->className(...$this->constructorArgs);

            foreach ($record as $key => $value) {
                if ($value == '') {
                    $record[$key] = null;
                }
            }

            try {

                foreach ($this->primaryKey as $pk) {
                    if (!isset($record[$pk]) || $record[$pk] == '') {
                        $record[$pk] = null;
                    }
                }
                
                $insertId = $this->insert($record);

                if (count($this->primaryKey) == 1) {
                    $entity->{$this->primaryKey[0]} = $insertId;
                }
            
            } catch (\PDOException $e) {
                $this->update($record);
            }

            foreach ($record as $key => $value) {
                if (!empty($value)) {
                    $entity->$key = $value;
                }
            }

            return $entity;
        }

        public function delete($id) {
    
            $id = $this->adjustId($id);

            $sql = 'DELETE FROM `' . $this->table . '` WHERE ';
            $pars = [];

            for ($i = 0; $i < count($this->primaryKey); $i++) {
                $pk = $this->primaryKey[$i];
                
                $sql .= '`' . $pk . '` = :primaryKey' . $i;
                $sql .= ' AND ';

                $pars['primaryKey' . $i] = $id[$pk];
            }

            $sql = rtrim($sql, ' AND ');
    
            $this->query($sql, $pars);
        }

        public function deleteWhere($column, $value) {

            $pars = [':value' => $value];
            $sql = 'DELETE FROM `' . $this->table . '` 
                WHERE `' . $column . '` = :value';
    
            $this->query($sql, $pars);
        }

        private function processDates($fields) {
    
            foreach ($fields as $key => $value) {
                if ($value instanceof \DateTime) {
                    $fields[$key] = $value->format('Y-m-d H:i:s');
                }
            }
    
            return $fields;
        }

    }