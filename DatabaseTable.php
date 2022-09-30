<?php 

    class DatabaseTable {

        public function __construct(PDO $pdo, string $table, $primaryKey) {
            $this->PDO = $pdo;
            $this->table = $table;
            $this->$primaryKey = $primaryKey;
        }

        private function query($sql, $pars=[]) {
            $query = $this->PDO->prepare($sql);
            $query->exec($pars);
            return $query;
        }

        public function findById($id) {
            $pars = [];
            $sql = 'SELECT * FROM ';
        }
    }