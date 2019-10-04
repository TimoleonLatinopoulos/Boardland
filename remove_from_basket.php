<?php
// get the product id
$id = isset($_GET['id']) ? $_GET['id'] : "";
 
// read
$cookie = $_COOKIE['basket_items_cookie'];
$cookie = stripslashes($cookie);
$saved_basket_items = json_decode($cookie, true);
 
// remove the item from the array
unset($saved_basket_items[$id]);
 
// delete cookie value
unset($_COOKIE["basket_items_cookie"]);
 
// empty value and expiration one hour before
setcookie("basket_items_cookie", "", time() - 3600);
 
// enter new value
$json = json_encode($saved_basket_items, true);
setcookie("basket_items_cookie", $json, time() + (86400 * 30), '/'); // 86400 = 1 day
$_COOKIE['basket_items_cookie']=$json;


?>