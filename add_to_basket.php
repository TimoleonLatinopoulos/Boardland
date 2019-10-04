<?php
 
// get the product id
$id = isset($_GET['id']) ? $_GET['id'] : "";

// check if user has already basket_item_cookie
$cookie = isset($_COOKIE['basket_items_cookie']) ? $_COOKIE['basket_items_cookie'] : "";
$cookie = stripslashes($cookie);
$saved_basket_items = json_decode($cookie, true);
 
// if $saved_basket_items is null, prevent null error
if(!$saved_basket_items){
    $saved_basket_items=array();
}


// if basket has contents
if(count($saved_basket_items)>0){
    foreach($saved_basket_items as $key => $value){
        // add old item to array, it will prevent duplicate keys
        $basket_items[$key]= $value;
    }
}
 
// check if the item is in the basket, if it is, increase the quantity
if(array_key_exists($id, $basket_items)){
  
    $basket_items[$id]+=1;
    $action = "same";

}
else {
    // add new item on array
    $basket_items[$id]=1;
    $action = "new";

}



// put item to cookie
$json = json_encode($basket_items, true);
setcookie("basket_items_cookie", $json, time() + (86400 * 30), '/'); // 86400 = 1 day
$_COOKIE['basket_items_cookie']=$json;

// redirect to product list and tell the user it was added to basket
header('Location: product.php?id=' . $id . '&action='.$action);


?>
