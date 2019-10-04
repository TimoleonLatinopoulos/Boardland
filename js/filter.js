
function find_get_parameter(parameter_name) {
	// code from https://stackoverflow.com/a/5448595
	var result = null, tmp = [];
	location.search.substr(1).split("&").forEach(function (item) {
		  tmp = item.split("=");
		  if (tmp[0] === parameter_name) result = decodeURIComponent(tmp[1]);
		});
	return result;
}

var page_number = 1;
var total_pages;

var products_div = document.getElementById('products_div');

var page_count = document.getElementsByClassName('page_count');
var first_page_button = document.getElementById('first_page_button');
var prev_page_button = document.getElementById('prev_page_button');
var next_page_button = document.getElementById('next_page_button');
var last_page_button = document.getElementById('last_page_button');

var product_num = null;

var	price_from = null;
var	price_to = null;
var	rating_from = null;
var rating_to = null;
var	categories = null;
var	orderby = "priceup";

var search_term = find_get_parameter("search_term");

filter_data();

uncheck("all");

function filter_data()
{
	products_div.innerHTML = "Loading";

	var xhttp = new XMLHttpRequest();
	xhttp.onreadystatechange = function() {
		if (this.readyState == 4 && this.status == 200) {
			var result = JSON.parse(this.responseText);
			products_div.innerHTML = ""
			result.products.forEach(function(product) {
				productHTML = "<div class='list_item'><div class='photo'><a href='product.php?id=" + product.product_id + "'>";
				productHTML += "<img class='image' src='images/"+product.picture_name+"' alt='" + product.name + "' /></div>";
				productHTML += "</a><div class='product_details'><a href='product.php?id=" + product.product_id + "'><h4>" + product.name + "</h4></a>";
				productHTML += "<div class='description'>"+ product.description + "</div><div class='more'><a href='product.php?id=" + product.product_id + "'>Περισσότερα ▼</a></div></div>";
				productHTML += "<div class='buy_prod'><div class='price_tag'>" + product.end_price + " € <em> από <span class='oldprice'>" + product.start_price + "€</span></em></div>";
				productHTML += "<button class='btn' onclick='add_to_basket(" + product.product_id + ")'>Προσθήκη στο καλάθι</button>";
				productHTML += "<div class='grade'>Βαθμολογία: <br><img src='images/icons/"+convert_rating_to_image_name(product.avg_rating)+".png' width='70px' height='44px'/> (" + parseFloat(parseFloat(product.avg_rating).toFixed(2)).toString()  + "/5)</div></div></div>";
				products_div.innerHTML += productHTML;
			});

			total_pages = result.total_pages;
			update_pagination_buttons();
			update_page_count();
		}
	};

	// pagination parameters
	parameters = "page_number=" + page_number;
	if (product_num != null){
		parameters += "&product_num=" + product_num;
	}

	// filter parameters
	if ((price_from != null) && (price_to != null)){
		parameters += "&price_from="+price_from+"&price_to="+price_to;
	}
	if ((rating_from != null) && (rating_to != null)){
		parameters += "&rating_from="+rating_from+"&rating_to="+rating_to;
	}
	if (categories != null){
		parameters += "&categories="+categories;
	}
	if (search_term != null){
		parameters += "&search_term="+search_term;
	}
	if (orderby != null){
		parameters += "&orderby="+orderby;
	}

	xhttp.open("GET", "fetch_products.php?" + parameters, true);
	xhttp.send();
}

// ============ Filter functions ============


function update_orderby(){
	orderby_selection = document.getElementById("orderby");
	orderby_selection = orderby_selection.selectedIndex;

	page_number = 1;
	switch(orderby_selection) {
		case 0: //Τιμή Αύξουσα
			orderby = "priceup";
			break;
		case 1: //Τιμή Φθίνουσα
			orderby = "pricedown";
			break;
		case 2: //Βαθμολογία Αύξουσα
			orderby = "ratingup";
			break;
		case 3: //Βαθμολογία Φθίνουσα
			orderby = "ratingdown";
			break;
		case 4: // Αλφαβητικά
			orderby = "name";
			break;
	}
	filter_data();
}


// ============ Pagination ============

function first_page_click(){
	page_number = 1;
	filter_data();
}
function prev_page_click(){
	page_number--;
	filter_data();
}
function next_page_click(){
	page_number++;
	filter_data();
}
function last_page_click(){
	page_number = total_pages;
	filter_data();
}

function update_product_num(){
	product_num_selection = document.getElementById("showpages");
	product_num_selection = product_num_selection.selectedIndex;

	page_number = 1;
	switch(product_num_selection) {
		case 0:
			product_num = 5;
			break;
		case 1:
			product_num = 10;
			break;
		case 2:
			product_num = 20;
			break;
	}

	filter_data();
}

function uncheck($val){
    if($val == "checkbox_categories"){
        checkboxes = document.getElementsByName('checkbox_categories');
        categories = null;
    } else if ($val == "checkbox_prices"){
        checkboxes = document.getElementsByName('checkbox_prices');
        price_from = null;
        price_to = null;
    } else if ($val == "checkbox_ratings"){
        checkboxes = document.getElementsByName('checkbox_ratings');
        rating_from = null;
        rating_to = null;
    } else {
        checkboxes = document.querySelectorAll('[name="checkbox_categories"], [name="checkbox_prices"], [name="checkbox_ratings"]');
        price_from = null;
        price_to = null;
        rating_from = null;
        rating_to = null;
        categories = null;
    }
    for(var i=0, n=checkboxes.length;i<n;i++) {
        checkboxes[i].checked = false;
    }

	page_number = 1;

    filter_data();
}

function update_by_categories(){
	product_category_selection = document.getElementsByName('checkbox_categories');
	categories = "";

	page_number = 1;
	for (var i = 0, n = product_category_selection.length; i < n ; i++)
	{
		if (product_category_selection[i].checked)
		{
            categories += ",'"+ product_category_selection[i].value + "'";
		}
	}
	if (categories) categories = categories.substring(1);
    if (categories == ""){
        categories = null;
    }
    filter_data();
}

function update_by_prices(){
    product_price_selection = document.getElementsByName('checkbox_prices');
    prices = "";

	page_number = 1;
    for (var i = 0, n = product_price_selection.length; i < n ; i++)
    {
        if (product_price_selection[i].checked)
        {
            prices += ","+ product_price_selection[i].value;
        }
    }
    if (prices) prices = prices.substring(1);

    if (prices == ""){
        price_from = null;
        price_to = null;
    } else {
        prices = prices.split(',');
        price_from = prices[0];
        price_to = prices[prices.length - 1];
    }

    filter_data();
}

function update_by_ratings(){
    product_ratings_selection = document.getElementsByName('checkbox_ratings');
    ratings = "";

	page_number = 1;
    for (var i = 0, n = product_ratings_selection.length; i < n ; i++)
    {
        if (product_ratings_selection[i].checked)
        {
            ratings += ","+ product_ratings_selection[i].value;
        }
    }
    if (ratings) ratings = ratings.substring(1);

    if (ratings == ""){
        rating_from = null;
        rating_to = null;
    } else {
        ratings = ratings.split(',');
        rating_from = ratings[0];
        rating_to = ratings[ratings.length - 1];
    }

    filter_data();
}

function update_pagination_buttons(){
	if (total_pages <= 1){
		first_page_button.disabled = true;
		prev_page_button.disabled = true;
		next_page_button.disabled = true;
		last_page_button.disabled = true;
	} else {
		if (page_number == 1){
			first_page_button.disabled = true;
			prev_page_button.disabled = true;
			next_page_button.disabled = false;
			last_page_button.disabled = false;
		} else if (page_number == total_pages){
			first_page_button.disabled = false;
			prev_page_button.disabled = false;
			next_page_button.disabled = true;
			last_page_button.disabled = true;
		} else {
			first_page_button.disabled = false;
			prev_page_button.disabled = false;
			next_page_button.disabled = false;
			last_page_button.disabled = false;
		}
	}
}

function update_page_count(){
	if (total_pages > 0){
		for(var i = 0; i < page_count.length; i++){
			page_count[i].innerText = "Σελίδα " + page_number + " από " + total_pages;
		}
	} else {
		for(var i = 0; i < page_count.length; i++){
			page_count[i].innerText = "Δεν βρέθηκαν προϊόντα";
		}
	}
}


