<?php

/**
 * @author kemeice parson
 * @copyright 2021
 */
namespace Basket;
use \PDO;
Class Settings 
  { 
    protected $host;
    
    protected $database;
    
    protected $user;
    
    Protected $password;
    
    protected $cacheExpire = null;
    
    protected $cacheLimiter = null;
    
    public  function __construct() 
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_cache_limiter($this->cacheLimiter);
            session_cache_expire($this->cacheExpire);
            session_start();
            }
       
            $this->host ="localhost"; // we will just hard code 
            $this->database ="";
            $this->user = "";
            $this->password = "";
        
    }
    
    public function connect()
    {
       try {
       
       $db =   new PDO("mysql:host=$this->host;dbname=$this->database", $this->user, $this->password, array(
       PDO::ATTR_PERSISTENT => true));
       
       return $db;
       }
       catch (PDOException $e) {
        // log error if we had a log  
        return false;
        
        }
        
    }
    
    public function getproducts ()
    {
       if ($this->has('product')) {
       return $_SESSION['product'];
       }
        
        //if ($this->has($key)) {
           //return $_SESSION[$key];
        //}
        
        return null;
            
    }
    
    
    public function get ($key , $code)
    {
       
       return $_SESSION['product'][$code];
      
        
        //if ($this->has($key)) {
           //return $_SESSION[$key];
        //}
        
        return null;
            
    }
    
    public function set($key, $value)
    {
       if($key === 'product')
       {
        $_SESSION['product'][$value['code']]= $value;
       }
       else
       {
        $_SESSION[$key] = $value;
        return $this;
        }
    }
    
    public function remove($key , $code)
    {
         if($key == 'product')
       {
         unset($_SESSION['product'][$code]);
       }
        
        //if ($this->has($key)) {
          // unset($_SESSION[$key]);
        //}
    }
    
    public function clear()
    {
        session_unset();
    }
    
    public function has($key)
    {
       return array_key_exists($key, $_SESSION); 
    }
    
    
}

