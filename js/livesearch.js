var livesearch_div = document.getElementById('livesearch');
var search_button = document.getElementById("search_button");
var search_input = document.getElementById("search_input");

window.addEventListener('click', function(e){   
    if (livesearch_div.contains(e.target)){
      // Clicked in box
    } else{
      livesearch_div.style.display="none";
    }
});

function search(){
    window.location.href = "products_show.php?search_term="+search_input.value;
}
  
search_button.addEventListener('click', search);
  
document.getElementById('search_input').addEventListener("keyup", function(event) {
	// Cancel the default action, if needed
	event.preventDefault();
	// Number 13 is the "Enter" key on the keyboard
	if (event.keyCode === 13) {
		search();
	}
}); 


function showResult(sterm) {
	if (sterm.length==0) {
		livesearch_div.innerHTML="";
		livesearch_div.style.display="none";
		return;
	}
	if (window.XMLHttpRequest) {

	  xmlhttp=new XMLHttpRequest();
	} 
	xmlhttp.onreadystatechange=function() {
	  if (this.readyState==4 && this.status==200) {
		  
		var json = JSON.parse(this.responseText);
		livesearch_div.innerHTML= "";
		
		if (json.products.length != 0){

		  //var livesearch = livesearch_div;

		  json.products.forEach(
			  function(product) {

				/*
				   var a_tag = document.createElement("a");
				   a_tag.href = "product_php?id=" + product.product_id;

				   var div_tag_item = document.createElement("div");
				   div_tag_item.className = "searchlist_item";
				   
				   var img_tag_item = document.createElement("img");
				   img_tag_item.src = "images/" + product.picture_name;

				   var div_tag_title = document.createElement("div");
				   div_tag_title.className = "livesearch_title";
				   div_tag_title.appendChild(document.createTextNode(product.name));

				   var div_tag_rating = document.createElement("div");
				   div_tag_title.className = "livesearch_rating";


				   var img_tag_rating = document.createElement("img");
				   img_tag_rating.src = "images/icons/star_rating_"+product.avg_rating+".png";

				   div_tag_rating.appendChild(img_tag_rating);

				   div_tag_item.appendChild(img_tag_item);
				   div_tag_item.appendChild(div_tag_title);
				   div_tag_item.appendChild(div_tag_rating);
				   a_tag.appendChild(div_tag_item);
				   livesearch.appendChild(a_tag);
				   livessearch.appendChild(document.createElement("br"));*/

				   livesearch_div.innerHTML+= 
				   "<a href=\"product.php?id=" + product.product_id +"\"><div class=\"searchlist_item\"><img src=\"images/" + product.picture_name + "\"/><div class=\"livesearch_title\">" +  product.name + "</div><div class=\"livesearch_rating\"><img src=\"images/icons/"+ convert_rating_to_image_name(product.avg_rating)+".png\"/></div></div></a><br/>";
	   
				  }
				  );        
		  livesearch_div.style.display="block";  
	  }
	 

	   
	  }
	}
	xmlhttp.open("GET","fetch_products.php?livesearch_term="+sterm+"&limit="+5,true);
	xmlhttp.send();
}
