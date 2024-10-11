<?php

    class LOG {
        private $message; 

        public function Alert($Log) {
            $_SESSION['Alert'] = $Log;
            return $Log;
        }
        public function showalert() {
            if (isset($_SESSION['Alert'])) {
                echo '<div class="alert alert-primary d-flex align-items-center" role="alert">';
                echo '<i class="fa-solid fa-circle-info"></i>';
                echo '<div>' ."&nbsp". $_SESSION['Alert'].'</div>';
                echo '</div>';
                unset($_SESSION['Alert']);
            }
        }
        public function writeLog ($Log) {
            $files = fopen("log.txt","a");
            fputs($files,$Log.PHP_EOL);
            fclose($files);
        }
    }
?>