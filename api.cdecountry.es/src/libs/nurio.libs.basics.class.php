<?php

class NL_MySqlClass {
    
    public $pdo;
    
    public function __construct($address, $port, $database, $username, $password){
        try {
            $this->pdo = new PDO('mysql:host='.$address.';port='.$port.';dbname='.$database, $username, $password, array(PDO::ATTR_PERSISTENT => true));
        } catch (PDOException $e) {
            if(true)echo '<script>alert("'.$e->getMessage().'");</script>';
            return false;
        }
    }
    
    public function isConnected()
    {
        try {
            return (bool) $this->pdo->query('SELECT 1+1');
        } catch (PDOException $e) {
            return false;
        }
    }
    
    public function disconnect(){
        $this->pdo = null;
    }
    
    public function getPDO(){
        return $this->pdo;
    }
    
    public function query($query){
        return $this->pdo->query($query);
    }
    
}

class NL_BASE {
    
    public static function getCurrentTimeMillis(){
        return microtime(true)*1000;
    }
    
    public static function reportError($txt){
        $myfile = fopen("logs.txt", "a");
        fwrite($myfile, "\n". $txt);
        fclose($myfile);
    }
   
    public static function generateSalt(){
        return md5(rand(999999,9999999));
    }
    
    public static function encryptSHA256($content){
        return hash("sha256", $content);
    }
    
}
?>