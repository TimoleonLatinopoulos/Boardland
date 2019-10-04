<?php
include('db_connect.php');

// alternative of mysqli_fetch_all because it needs mysqlnd driver
function my_fetch_all($result_data){
	$results_array = array();
	while ($row = $result_data->fetch_assoc()) {
		$results_array[] = $row;
	}
	return $results_array;
}

function count_product_pages_by_filters($num_of_products_per_page, $search_term, $price_from, $price_to, $rating_from, $rating_to, $categories, $orderby, $asc_or_desc){
	
	global $conn;
	
	$condition = "";
	
	// search filter
	if (!is_null($search_term)){
		$condition .= "WHERE ";		
		$condition .= "(name LIKE '%".$search_term."%')";
	}
	
	// price filter
	if (!is_null($price_from) && !is_null($price_to)){
		if ($condition !== ""){
			$condition .= " AND ";
		} else {
			$condition .= "WHERE ";			
		}	
		$condition .= "(end_price BETWEEN $price_from AND $price_to)";
	}
	
	// rating filter
	if (!is_null($rating_from) && !is_null($rating_to)){
		if ($condition !== ""){
			$condition .= " AND ";
		} else {
			$condition .= "WHERE ";			
		}
		$condition .= "(avg_rating BETWEEN $rating_from AND $rating_to)";
		
	}
	
	// categories filter
	if (!is_null($categories)){
		if ($condition !== ""){
			$condition .= " AND ";
		} else {
			$condition .= "WHERE ";			
		}
		$condition .= "(category = ".implode($categories, " OR category = ").")";
	}
	
	$query_order = "";	
	// orderby filter	
	if (!is_null($orderby) && !is_null($asc_or_desc)){
		$query_order = " ORDER BY ".$orderby." ".$asc_or_desc;
	}
	
    $total_pages_sql = "SELECT COUNT(*) FROM products ".$condition.$query_order;
    $result = mysqli_query($conn,$total_pages_sql);
    $total_rows = mysqli_fetch_array($result)[0];
    $total_pages = ceil($total_rows / $num_of_products_per_page);
	
	return $total_pages;
	
}
function get_products_of_page_by_filters($offset, $num_of_products_per_page, $search_term, $price_from, $price_to, $rating_from, $rating_to, $categories, $orderby, $asc_or_desc){
	
	global $conn;
	
	$condition = "";
	
	
	// search filter
	if (!is_null($search_term)){
		$condition .= "WHERE ";		
		$condition .= "(name LIKE '%".$search_term."%')";
	}
	
	// price filter
	if (!is_null($price_from) && !is_null($price_to)){
		if ($condition !== ""){
			$condition .= " AND ";
		} else {
			$condition .= "WHERE ";			
		}	
		$condition .= "(end_price BETWEEN $price_from AND $price_to)";
	}
	
	// rating filter
	if (!is_null($rating_from) && !is_null($rating_to)){
		if ($condition !== ""){
			$condition .= " AND ";
		} else {
			$condition .= "WHERE ";			
		}
		$condition .= "(avg_rating BETWEEN $rating_from AND $rating_to)";
		
	}
	
	// categories filter
	if (!is_null($categories)){
		if ($condition !== ""){
			$condition .= " AND ";
		} else {
			$condition .= "WHERE ";			
		}
		$condition .= "(category = ".implode($categories, " OR category = ").")";
	}
	
	
	$query_order = "";	
	// orderby filter	
	if (!is_null($orderby) && !is_null($asc_or_desc)){
		$query_order = " ORDER BY ".$orderby." ".$asc_or_desc;
	}
	
	$sql = "SELECT * FROM products ".$condition.$query_order." LIMIT $offset, $num_of_products_per_page";
	$result_data = mysqli_query($conn,$sql);
	$result = my_fetch_all($result_data);
	mysqli_free_result($result_data);
	
	return $result;	
	
}
function livesearch_products_by_title($title, $limit){
	
	global $conn;
	
	$sql = "SELECT * FROM products WHERE name LIKE '%".$title."%' LIMIT $limit";
	$result_data = mysqli_query($conn,$sql);
	$result = my_fetch_all($result_data);
	mysqli_free_result($result_data);
	
	return $result;	
	
}
function get_overated($limit){
	global $conn;
	$sql = "SELECT * FROM products ORDER BY avg_rating DESC LIMIT $limit";
	$result_data = mysqli_query($conn,$sql);
	$result = my_fetch_all($result_data);
	mysqli_free_result($result_data);
	return $result;
}
function get_newID($limit){
	global $conn;
	$sql = "SELECT * FROM products ORDER BY product_id DESC LIMIT $limit";
	$result_data = mysqli_query($conn,$sql);
	$result = my_fetch_all($result_data);
	mysqli_free_result($result_data);
	return $result;
}
function get_product($product_id){
	
	global $conn;
	
	$sql = "SELECT * FROM products WHERE product_id = $product_id";
	$result_data = mysqli_query($conn,$sql);
	$result = mysqli_fetch_array($result_data);
	mysqli_free_result($result_data);
	
	return $result;	
	
}
function get_products_with_ids($ids){
	
	global $conn;
	
	$condition = "(product_id = ".implode($ids, " OR product_id = ").")";
	$sql = "SELECT * FROM products WHERE ".$condition;
	$result_data = mysqli_query($conn,$sql);
	$result = my_fetch_all($result_data);
	mysqli_free_result($result_data);
	
	return $result;	
	
}

function get_comments_of_product($product_id){
	
	global $conn;
	
	$sql = "SELECT * FROM comments WHERE product_id = $product_id";
	$result_data = mysqli_query($conn,$sql);
	$result = my_fetch_all($result_data);
	mysqli_free_result($result_data);
	
	return $result;	
	
}


function get_last_comments($number){
	
	global $conn;
	
	$sql = "SELECT comments.username,comments.text,products.product_id,products.name FROM comments,products WHERE comments.product_id = products.product_id ORDER BY comment_id DESC LIMIT $number ";
	$result_data = mysqli_query($conn,$sql);
	$result = my_fetch_all($result_data);
	mysqli_free_result($result_data);
	
	return $result;	
	
}

function insert_comment_to_product($product_id, $username, $comment, $rating){
	
	global $conn;
	$username = mysqli_real_escape_string($conn,$username);
	$comment = mysqli_real_escape_string($conn,$comment);

	$sql = "INSERT INTO comments (`username`, `text`, `rating`, `product_id`) VALUES ('$username', '$comment', '$rating', '$product_id')";
	$result_data = mysqli_query($conn,$sql);	
	if ($result_data === TRUE) {
		return true;
	} else {
		return false;
	}
	
}
function get_categories(){
	
	global $conn;
	
	$sql = "SELECT category FROM `products` GROUP BY category";
	$result_data = mysqli_query($conn,$sql);
	$result = my_fetch_all($result_data);
	mysqli_free_result($result_data);
	
	return $result;	
	
}
function get_categories_and_num(){

	global $conn;

	$sql = "SELECT category, count(category) AS count FROM `products` GROUP BY category";
	$result_data = mysqli_query($conn,$sql);
	$result = my_fetch_all($result_data);
	mysqli_free_result($result_data);

	return $result;

}
// Close database connection
function db_disconnect(){	
	
	global $conn;
	mysqli_close($conn);
	
}
?>
