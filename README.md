# basecartcodes
- A basket like demo of backend codes


Assumptions 
-User will only add one product at time.
-All products are in stock 
-Merchant currently has only one promotion 
-Promotion is set in the database in the  Products table  useing the field promo.
-Enviorment is a  useing LAMP (with php 7.4)
-The frontend will take response as json 

See sql file for my sample databse

To intialize try the following code 
include 'Settings.php';
include 'Cart.php';
$set = new Settings();
$cart = new Cart($set);
$cart->add('B01');
$cart->add('R01');

notes : This is not a production app not much considaration was given for security and error reporting 