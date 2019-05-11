<?php

namespace Mbira;

class DbConnection {
 
    public static function getInstance(){
        return  new \PDO('mysql:host=db;dbname=products;charset=utf8mb4', 'products', 'products');
    }

}

class Config{

    public static function get($namespace){
        if ($namespace == 'FancyService'){
            return ['username', 'password'];
        }
    }

}