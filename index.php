<!DOCTYPE html>
<html lang="el">

<head>
    <title>Boardland: Online shopping for board games</title>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="css/stylesheet.css">
    <link rel="icon" type="image/png" sizes="192x192"  href="images/icons/favicon/android-icon-192x192.png">
    <link rel="icon" type="image/png" sizes="32x32" href="images/icons/favicon/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="96x96" href="images/icons/favicon/favicon-96x96.png">
    <link rel="icon" type="image/png" sizes="16x16" href="images/icons/favicon/favicon-16x16.png">
    <link rel="manifest" href="images/icons/favicon/manifest.json">
    <script src="js/infoguest.js"></script>
</head>

<body>

 <?php 
 include("header.php");?>
<main>
<div class="container col">
<?php 

 if(!isset($_COOKIE["guest_agree"])) {
     echo "
<div id=\"infoguest\" class=\"info\">
        <h2> Γεια σου επισκέπτη,</h2>
        <div>
        Το Boardland είναι ένα ηλεκτρονικό κατάστημα για online αγορές επιτραπέζιων παιχνιδιών.
        Μπορείς να αναζητήσεις παιχνίδια στην πλατφόρμα μας , να διαβάσεις και να γράψεις κριτικές
        για κάποιο επιτραπέζιο παιχνίδι και να κάνεις τις αγορές σου εύκολα και γρήγορα.
        <br/>
        <br/>
        Για οποιοδήποτε πρόβλημα <a href=\"#\">επικοινώνησε μαζί μας</a>.
        <div class=\"container row end\"><button class=\"btn\" onclick=\"agree()\">Εντάξει</button></div>
        </div>
   </div>
   ";
 }
 ?>
   

<div class="container row space-bt">

<div class="card-container">
 

 <h1> Δημοφιλέστερα παιχνίδια </h1>

 <div class="container row space-bt wrap">
   <?php
 include("db_api.php");
$res = get_overated(8);
foreach($res as $product){
    echo "<div class=\"box\">";
    echo "<div class=\"image_container\">";
    echo "<a href='product.php?id=".$product['product_id']."'><img src=\"images/".$product['picture_name']."\"
alt=\"".$product['name']."\"></a>";
    echo "</div>";
    echo "<div class='card-info'><a href='product.php?id=".$product['product_id']."'><h2>".$product['name']."</h2></a>";
    echo "<div class='description'>".$product['description']."</div>";
    echo "<div class=\"container row space-bt\">";
    echo "<a href='product.php?id=".$product['product_id']."'> Περισσότερα ▼</a>";
    echo "<div class=\"livesearch_rating\"><img src=\"images/icons/".convert_rating_to_image_name($product['avg_rating']).".png\" alt=\"Rating\"></div>";
    echo "</div>";
    echo "</div>";
    echo "</div>";
}

 ?>
 </div>


<h1> Νέες κυκλοφορίες </h1>

<div class="container row space-bt wrap">
<?php 
$res =get_newID(8);
foreach($res as $product){
    echo "<div class=\"box\">";
    echo "<div class=\"image_container\">";
    echo "<a href='product.php?id=".$product['product_id']."'><img src=\"images/".$product['picture_name']."\" alt=\"".$product['name']."\"></a>";
    echo "</div>";
    echo "<div class='card-info'><a href='product.php?id=".$product['product_id']."'><h2>".$product['name']."</h2></a>";
    echo "<div class='description'>".$product['description']."</div>";
    echo "<div class=\"container row space-bt\">";
    echo "<a href='product.php?id=".$product['product_id']."'> Περισσότερα ▼</a>";
    echo "<div class=\"livesearch_rating\"><img src=\"images/icons/".convert_rating_to_image_name($product['avg_rating']).".png\" alt=\"Rating\"></div>";
    echo "</div>";
    echo "</div>";
    echo "</div>";
}

?>
</div>
<h1> Πρόσφατες κριτικές </h1>
<div class="box">
   
   <?php

   $res = get_last_comments(6);
   foreach($res as $comment) {
       echo "<div class=\"last_comment\"><div class=\"bold\">Ο χρήστης ".$comment["username"]." για το παιχνίδι <a href=\"product.php?id=".
       $comment["product_id"]."\">".$comment["name"]."</a> είπε:</div><i>"
       .$comment["text"]."</i></div>" ;

   }
   
   ?>
</div>


</div>


</div>
</div>
</main>
<?php 
include("footer.php");
db_disconnect();
?>
</body>
</html>