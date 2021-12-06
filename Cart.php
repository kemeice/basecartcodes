<?php

/**
 * @author kemeice parson
 * @copyright 2021
 */
namespace Basket;
//use Settings;

class Cart 
{
  private $settings;
  
  public function __construct(Settings $settings) 
  {
    $this->settings = $settings;
  }
  
  private function addproduct($code)
  {
    $db = $this->settings->connect();
    //$sql ="SELECT * from products WHERE code = $code ";
    $stmt = $db->prepare("SELECT * from products WHERE code= ?");
    $stmt->execute([$code]);
    $arr = $stmt->fetch();
    if($arr) {
        $pr['quantity'] = 1;
        $pr['unitprice'] = $arr['price'];
        $pr['name']= $arr['name'];
        $pr['ispro'] = $arr['promo'];
        $pr['code'] = $code;
        $pr['price'] = $arr['price'];
        $this->settings->set("product" , $pr);
        $this->settings->set($code , $code);
        return true;
    }
    return false; // product not found we assume product is in stock as well
    
  }
  
  private function update($code)
  {
    $prod = $this->settings->get("product" , $code);
    $prod['quantity'] +=1;
    if($prod['ispro']) {
        if ($prod['quantity']%2 == 0)
        {
        $amt  = $prod['unitprice'] * $prod['quantity'];
        $prod['price'] = ($amt *.75); 
        }
        else {
         $amt = $prod['quantity'] -1;
         $next =$prod['unitprice'] * $amt ;
         $next = ($next *.75)+ $prod['unitprice']; 
         $prod['price'] = $next ;
        }
    }
    if(!$prod['ispro']) {
       $prod['price'] = $prod['unitprice'] * $prod['quantity']; 
        }
        
    $this->settings->remove("product" , $code);
    $this->settings->set("product" , $prod);
    return true;
        
  }
  
  public function total()
  {
    $final = 0;
    $products = $this->settings->getproducts();
    foreach ($products as $product =>$arr) {
       $final += $arr['price'];
    }
    if($final < 50 ) {
        $shiping = "4.95";
        
    }
    elseif ($final > 50 and $final < 90 ) {
      
      $shiping = "2.95";  
    }
    else {
     $shiping = "0.00";  
    }
     
    $res = ["total"=> $final ,"delivery" =>$shiping ];
    return json_encode($res);
  }
  
  public function products()
  {
    $products = $this->settings->getproducts;
    return json_encode($products);
  }
  
  public function add ($code)
  {
    if($this->settings->has("$code")) {
        $this->update($code);
    }
    else {
        $this->addproduct($code);
    }
    
  }
  
    
    
    
}


