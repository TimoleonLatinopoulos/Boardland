<!DOCTYPE html>
<html lang="el" xmlns="http://www.w3.org/1999/xhtml">
<head>
    <title>Boardland: Online shopping for board games</title>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="css/stylesheet.css">
    <link rel="icon" type="image/png" sizes="192x192"  href="images/icons/favicon/android-icon-192x192.png">
    <link rel="icon" type="image/png" sizes="32x32" href="images/icons/favicon/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="96x96" href="images/icons/favicon/favicon-96x96.png">
    <link rel="icon" type="image/png" sizes="16x16" href="images/icons/favicon/favicon-16x16.png">
    <link rel="manifest" href="images/icons/favicon/manifest.json">
</head>

<body>

<?php

include("header.php");

function parse_input($data)
{
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

include('db_api.php');


// Get product id
if (isset($_GET['id'])) {
    $product_id = $_GET['id'];
} else {
    header('Location: index.php');
}

// Insert comment
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $insert_succesfully = true;
    if (!empty($_POST["username"]) && !empty($_POST["comment"])) {
        $username = $_POST["username"];
        $comment = $_POST["comment"];
        $rating = $_POST["rating"];

        $success = insert_comment_to_product($product_id, $username, $comment, $rating);

        if (!$success) {
            $insert_succesfully = false;
        }
    } else {
        $insert_succesfully = false;
    }

    if (!$insert_succesfully) {
        echo "Αποτυχία αποθήκευσης σχολίου";
    }

}

?>

<main>

    <div class='box'>

        <div class='container col'>
        <div class='container row start'>
        
    <?php
    $product = get_product($product_id);
            // Check if product exists
        if (empty($product)) {
            header('Location: index.php');
        }

            // Show product information

         echo "
            <div class='container col'>
            <div class=\"product_name\">".$product['name']."</div>
            <div class=\"product-image\"><img src='images/".$product['picture_name']."' alt=\"".$product['name']."\"></div>
        </div>
         <div class='container col'>
            <div class=\"product_price\">".$product['end_price'] . " €<em> από <span class='oldprice'>".$product['start_price']."€</span></em></div>
            <div class='first_col'>Αναγνωριστικό προϊόντος: ".$product['product_id']."</div>
            <div class='first_col'>Βαθμολογία προϊόντος: <img src=\"images/icons/".convert_rating_to_image_name($product['avg_rating']).".png\" alt=\"Rating\" width='70' height='44'> (".(number_format($product['avg_rating'], 2) + 0)."/5)</div>
            <div class='calathes'><button class='btn' onclick=\"add_to_basket(" . $product['product_id'] . ")\">Προσθήκη στο καλάθι</button></div>
            <div class=\"descript\">" . $product['description'] . "</div>
            </div>
            </div>";

            // Show comments

        $comments = get_comments_of_product($product_id);

        echo "<br/><div class='Nocomments'><div class='Bigcom'>Σχόλια (".count($comments)."):</div><br/>";

            if (empty($comments)) {
                echo "<div class='withoutcom'>Δεν υπάρχουν σχόλια</div><br/>";
            } else {
                foreach ($comments as $row) {
                    echo "<div class='Bigcom'>".$row['username'] . " </div>" . $row['text'] . "<div class='Bigcom'>Βαθμολογία: <img src=\"images/icons/".convert_rating_to_image_name($row['rating']).".png\" alt=\"Rating\" width='70' height='44'> (" . $row['rating'] . "/5)</div><br/>";
                    echo "<br/>";
                }
            }


            db_disconnect();


            ?>
            

            <div class="addcom">
            <h1>Νέο σχόλιο</h1>
            <form method="post">
                <input placeholder="Όνομα χρήστη" class="comment-input" type="text" name="username" required>
                <br>
                <textarea placeholder="Σχόλιο" name="comment" required></textarea>
                
                <br><br>
				
                <fieldset id="stars" class="rating_comment">
                    <input type="radio" id="star5" name="rating" value="5" /><label class = "full" for="star5" title="Τέλειο"></label>
                    <input type="radio" id="star4" name="rating" value="4" /><label class = "full" for="star4" title="Αρκετά καλό"></label>
                    <input type="radio" id="star3" name="rating" value="3" /><label class = "full" for="star3" title="Έτσι και έτσι"></label>
                    <input type="radio" id="star2" name="rating" value="2" /><label class = "full" for="star2" title="Όχι και πολύ καλό"></label>
                    <input type="radio" id="star1" name="rating" value="1" /><label class = "full" for="star1" title="Χάλια"></label>
					<input type="radio" id="star0" name="rating" value="0" checked /><button class="zero_rating" onclick="document.getElementById('star0').checked = true; return false;">&#10007;</button>
				</fieldset>
				
				<br><br><br><br><br>
                <button class="btn" type="submit" name="submit">Προσθήκη σχολίου</button>
            </form>
            </div>
            </div>
            </div>
        </div>

</main>
<?php
require "footer.php";
?>
</body>

</html>