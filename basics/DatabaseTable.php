<?php

    class DatabaseTable {

        private $PDO;
        private $table;
        private $primaryKey;
        private $className;
        private $constructorArgs;

        public function __construct(\PDO $PDO, string $table, $primaryKey, string $className = '\stdClass', array $constructorArgs = []) {
            $this->PDO = $PDO;
            $this->table = $table;
            $this->primaryKey = $primaryKey;
            $this->className = $className;
            $this->constructorArgs = $constructorArgs;
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

            $pars = [];
            $sql = 'SELECT * FROM `' . $this->table . '` 
                WHERE ';
 
            $sql .= '`' . $this->primaryKey . '` = :primaryKey';
            $pars['primaryKey'] = $id;

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
    
            print_r($fields);
            echo $sql;

            $this->query($sql, $fields);

            return $this->PDO->lastInsertId(); 
        }
    
        public function update($fields) {
    
            $sql = 'UPDATE `' . $this->table . '` SET ';
    
            foreach ($fields as $key => $value) {
                $sql .= '`' . $key . '` = :' . $key . ","; 
            }
    
            $sql = rtrim($sql, ',');

            $sql .= ' WHERE ';
            $sql .= '`' . $this->primaryKey . '` = :primaryKey';
            $fields['primaryKey'] = $fields[$this->primaryKey];
        
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

                if (!isset($record[$this->primaryKey]) || $record[$this->primaryKey] == '') {
                    $record[$this->primaryKey] = null;
                }
                
                $insertId = $this->insert($record);

                $entity->{$this->primaryKey} = $insertId;
            
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

            $sql .= '`' . $this->primaryKey . '` = :primaryKey';
            $pars['primaryKey'] = $id;

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