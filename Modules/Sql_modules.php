<?php
    class SQL_Import {
        private $connection;

        public function __construct($SqlConnect)
        {
            $this->connection = $SqlConnect;
        }
    }
    
?>