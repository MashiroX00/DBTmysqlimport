<?php
class Control {
    private $connect;

    public function __construct($PDOconnect)
    {
        $this->connect = $PDOconnect;
    }

    public function header($url,$page){
        header("Location: $url$page");
        exit;
    }
}
?>