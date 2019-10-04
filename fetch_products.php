<?php

	if ($_SERVER['REQUEST_METHOD'] !== 'GET') {
		exit();
	}

	include('db_api.php');

    if(isset($_GET['categories_num'])) {
        $result = get_categories_and_num();
        echo json_encode(array("categories" => $result));
        db_disconnect();
        exit();
    }

    // Find the current page number
    if (isset($_GET['page_number'])) {
        $page_number = $_GET['page_number'];
    } else {
        $page_number = 1;
    }

	// Find number of products per page
	if(isset($_GET['product_num'])) {
	    $num_of_products_per_page = $_GET['product_num'];
    } else {
        $num_of_products_per_page = 5;
    }

	$offset = ($page_number-1) * $num_of_products_per_page;


	// Check if livesearch is enabled
	if(isset($_GET['livesearch_term']) && isset($_GET['limit'])) {
		$livesearch_term = $_GET['livesearch_term'];
		$limit = $_GET['limit'];

		$result = livesearch_products_by_title($livesearch_term,$limit);
		// return result as JSON: {products: [...]}
		echo json_encode(array("products" => $result));
		exit();

	}

	// Check if list of ids is enabled (for products in the basket)
	if(isset($_GET['ids'])) {
		$ids = explode(",", $_GET['ids']);

		$result = get_products_with_ids($ids);
		// return result as JSON: {products: [...]}
		echo json_encode(array("products" => $result));
		exit();

	}

	// check for filters


	$search_term = null;
	// Check if search is enabled
	if(isset($_GET['search_term'])) {
		$search_term = $_GET['search_term'];
	}

	$price_from = null;
	$price_to = null;
	// Check if user filtered by prices (price_from=10&price_to=30)
	if (isset($_GET['price_from']) && isset($_GET['price_to'])) {
        $price_from = $_GET['price_from'];
        $price_to = $_GET['price_to'];
	}

	$rating_from = null;
	$rating_to = null;
	// Check if user filtered by ratings (rating_from=0&rating_to=3)
	if (isset($_GET['rating_from']) && isset($_GET['rating_to'])) {
        $rating_from = $_GET['rating_from'];
        $rating_to = $_GET['rating_to'];
	}

	$categories = null;
	// Check if user filtered by categories (categories='cat1','cat2')
	if (isset($_GET['categories'])) {
        $categories = explode(",", $_GET['categories']);
	}

	$orderby = null;
	$asc_or_desc = null;
	// Check if user wants order (orderby=name or orderby=priceup or orderby=pricedown)
	if (isset($_GET['orderby'])) {		
		switch($_GET['orderby']){
			case "priceup":
				$orderby = "end_price";
				$asc_or_desc = "ASC";
				break;
			case "pricedown":
				$orderby = "end_price";
				$asc_or_desc = "DESC";
				break;
			case "name":
				$orderby = "name";
				$asc_or_desc = "";				
				break;
			case "ratingup":
				$orderby = "avg_rating";
				$asc_or_desc = "ASC";
				break;
			case "ratingdown":
				$orderby = "avg_rating";
				$asc_or_desc = "DESC";
				break;
		}
	}

	$total_pages = count_product_pages_by_filters($num_of_products_per_page, $search_term, $price_from, $price_to, $rating_from, $rating_to, $categories, $orderby, $asc_or_desc);
	$result = get_products_of_page_by_filters($offset, $num_of_products_per_page, $search_term, $price_from, $price_to, $rating_from, $rating_to, $categories, $orderby, $asc_or_desc);


	// return result as JSON: {products: [...], total_pages: 3}
	echo json_encode(array("products" => $result, "total_pages" => $total_pages));

	db_disconnect();


?>