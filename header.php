<?php

include("rating_converter.php");

$directoryURI = $_SERVER['REQUEST_URI'];
$path = parse_url($directoryURI, PHP_URL_PATH);
$components = explode('/', $path);
$first_part = $components[2];
?>

<div class="header">
  <a href="index.php" class="logo"><img src="images/icons/logo.png" alt="Logo"></a>
  <fieldset class="field-container">
  <input type="text" id="search_input" placeholder="Search..." onclick="showResult(this.value)" onkeyup="showResult(this.value)" class="field" 
  value="<?php if (isset($_GET["search_term"])) echo $_GET["search_term"];?>"/>
  <div id="livesearch"></div>
  <div class="icons-container">
    <div id="search_button" class="icon-search"></div>
    <div class="icon-close">
      <div class="x-up"></div>
      <div class="x-down"></div>
    </div>
  </div>
</fieldset>
  
  <div class="header-right">
    <a <?php if ($first_part == "index.php" || $first_part == "") {
        echo 'class="active"';
    } else {
        echo 'class="inactive"';
    }?> href="index.php">Αρχική</a>
    <a <?php if ($first_part == "products_show.php") {
        echo 'class="active"';
    } else {
        echo 'class="inactive"';
    } ?> href="products_show.php">Επιτραπέζια</a>
    <a  id="basket" href="#">
        <div class="notification"><div id="counter"><?php
                        // count items in the basket
                       
                        if(isset($_COOKIE['basket_items_cookie'])){
                            
                          $saved_cart_items = json_decode(stripslashes(trim($_COOKIE['basket_items_cookie'],'"')));
                          $total= 0;
                          foreach($saved_cart_items as $key=>$value){
                              $total = $total + $value;
                          }
                          echo $total;
                          
                      }
                      else {

                          echo("0");
                      }
                       
                        ?></div></div><img src="images/icons/basket.png" alt="Basket"/></a>
  </div>

  <div id="basket_list" class="modalbox">
      <!-- Modal content -->
    <div class="modal-content">
      <h2> Το καλάθι μου </h2>
        <span class="close">&times;</span>
        <div id = "cookie"></div>
    </div>
  </div>
</div>

<script src="js/rating_converter.js"></script>
<script src="js/basket.js"></script>
<script src="js/livesearch.js"></script>