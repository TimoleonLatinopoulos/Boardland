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
</head>

<body>

<?php
include("header.php");
?>

<main>
    <div class="search_content">
        <div class="leftside">
            <div class="filter_view">
                <p class="big_title">Φίλτρα</p>
                <a class='delete_filter' href='' onclick='uncheck("all"); return false;'>✖ Κατάργηση όλων</a>

                <form id="form1">
                    <div class="section">
                        <p class="medium_title">Κατηγορία</p>
                        <a class='delete_small' href='' onclick='uncheck("checkbox_categories"); return false;'>✖ Κατάργηση</a>
                        <div id="categories">
                            <?php

                            include("db_api.php");

                            $result = get_categories_and_num();

                            foreach ($result as $category) {
                                echo "<label class='container_check'>" . $category["category"] . "<em>(" . $category["count"] . ")</em>";
                                echo "<input name='checkbox_categories' value='" . $category["category"] . "' type='checkbox' onClick='update_by_categories()'>";
                                echo "<span class='checkmark'></span></label>";
                            }
                            ?>
                        </div>
                    </div>
                    <div class="section">
                        <p class="medium_title">Τιμή</p>
                        <a class='delete_small' href='' onclick='uncheck("checkbox_prices"); return false;'>✖ Κατάργηση</a>
                        <div id="prices">
                            <label class='container_check'>0€ - 20€
                                <input name='checkbox_prices' value='0,20' type='radio' onClick='update_by_prices()'>
                                <span class='checkmark'></span>
                            </label>

                            <label class='container_check'>20€ - 40€
                                <input name='checkbox_prices' value='20,40' type='radio' onClick='update_by_prices()'>
                                <span class='checkmark'></span>
                            </label>

                            <label class='container_check'>40€ - 100€
                                <input name='checkbox_prices' value='40,100' type='radio' onClick='update_by_prices()'>
                                <span class='checkmark'></span>
                            </label>
                        </div>
                    </div>
                    <div class="section">
                        <p class="medium_title">Βαθμολογία</p>
                        <a class='delete_small' href='' onclick='uncheck("checkbox_ratings"); return false;'>✖ Κατάργηση</a>
                        <div id="ratings">
                            <label class='container_check'>0 - 1
                                <input name='checkbox_ratings' value='0,1' type='radio' onClick='update_by_ratings()'>
                                <span class='checkmark'></span>
                            </label>

                            <label class='container_check'>1 - 2
                                <input name='checkbox_ratings' value='1,2' type='radio' onClick='update_by_ratings()'>
                                <span class='checkmark'></span>
                            </label>

                            <label class='container_check'>2 - 3
                                <input name='checkbox_ratings' value='2,3' type='radio' onClick='update_by_ratings()'>
                                <span class='checkmark'></span>
                            </label>

                            <label class='container_check'>3 - 4
                                <input name='checkbox_ratings' value='3,4' type='radio' onClick='update_by_ratings()'>
                                <span class='checkmark'></span>
                            </label>

                            <label class='container_check'>4 - 5
                                <input name='checkbox_ratings' value='4,5' type='radio' onClick='update_by_ratings()'>
                                <span class='checkmark'></span>
                            </label>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <div class="rightside">

            <div class="options">
                <p class="page_count"></p>
                <form>
                    <p class="separator">
                        <label for="showpages">Ανά σελίδα:</label>
                        <select id="showpages" class="shadow" onChange="update_product_num()">
                            <option>5</option>
                            <option>10</option>
                            <option>20</option>
                        </select>
                    </p>
                    <p class="sort">
                        <label for="orderby">Ταξινόμηση:</label>
                        <select id="orderby" class="shadow" name="orderby" onChange="update_orderby()">
                            <option value="1">Τιμή Αύξουσα</option>
                            <option value="2">Τιμή Φθίνουσα</option>
                            <option value="3">Βαθμολογία Αύξουσα</option>
                            <option value="4">Βαθμολογία Φθίνουσα</option>
                            <option value="5">Αλφαβητικά</option>
                        </select>
                    </p>
                </form>
            </div>

            <div id="products_div"></div>

            <div class="options">
                <form><p class="page_count"></p></form>
                <div class="buttons">
                    <button id="first_page_button" onclick="first_page_click()">First</button>
                    <button id="prev_page_button" onclick="prev_page_click()">Prev</button>
                    <button id="next_page_button" onclick="next_page_click()">Next</button>
                    <button id="last_page_button" onclick="last_page_click()">Last</button>
                </div>
            </div>

        </div>
    </div>
</main>

<?php
require "footer.php";
?>

<script src="js/filter.js"></script>

</body>
</html>