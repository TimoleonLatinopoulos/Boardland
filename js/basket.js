
function getCookie(cname) {
  var name = cname + "=";
  var decodedCookie = decodeURIComponent(document.cookie);
  var ca = decodedCookie.split(';');
  for(var i = 0; i <ca.length; i++) {
    var c = ca[i];
    while (c.charAt(0) == ' ') {
      c = c.substring(1);
    }
    if (c.indexOf(name) == 0) {
      return c.substring(name.length, c.length);
    }
  }
  return "{}";
}

function refresh_basket() {

  var arr = JSON.parse(getCookie("basket_items_cookie"));
  cookie.innerHTML="";
  var keys = Object.keys(arr);
  
  if (keys.length > 0) {

    var total_cost = 0;
    var ids = keys[0];
    
    for(var i=1; i<keys.length; i++){

      ids+= "," + keys[i];
    }
  
    xmlhttp=new XMLHttpRequest();
    xmlhttp.onreadystatechange=function() {
        
      if (this.readyState==4 && this.status==200) {
          
        var json = JSON.parse(this.responseText);

        json.products.forEach(
          function(product) {

            cookie.innerHTML+= "<div class=\"basket_item\"><a href='product.php?id=" + product.product_id + "'><img src=\"images/" + product.picture_name +"\"/></a><div class=\"livesearch_title\">" + 
            "<a href='product.php?id=" + product.product_id + "'>"+product.name +"</a><div class=\"price\"><span class=\"quantity\">"+arr[product.product_id]+ " x </span>" + parseFloat(parseFloat(product.end_price).toFixed(2)).toString()+" €</div><button class=\"remove\" onclick=\"delete_item("+product.product_id+","+arr[product.product_id]+")\"></button></div></div><br/><br/><br/><br/>";
            
            //cookie.innerHTML+= "<div class=\"basket_item\"><img src=\"images/" + product.picture_name +"\"/><div class=\"livesearch_title\">" + 
            //product.name +"<div class=\"price\"><span class=\"quantity\">"+arr[product.product_id]+ " x </span>" + product.end_price+" €</div><button class=\"remove\" onclick=\"delete_item("+product.product_id+","+arr[product.product_id]+")\"></button></div></div>";
            
			
			total_cost+= arr[product.product_id] * product.end_price;
          });

          cookie.innerHTML+="<br/><br/><div class=\"buy\"><button class=\"btn\">Πληρωμή</button><div class=\"total_cost\">Σύνολο: <b>" + total_cost +" €</b></div></div>";
        }
      
   }

   xmlhttp.open("GET","fetch_products.php?ids="+ids,true);
   xmlhttp.send();
   
  }
  else {

   cookie.innerHTML= "<p>Το καλάθι αγορών είναι άδειο.</p>";
  }



}

function delete_item(id,times) {
    
  xmlhttp=new XMLHttpRequest();
  
  xmlhttp.onreadystatechange=function() {
    if (this.readyState==4 && this.status==200) {
      
      var num = document.getElementById("counter").innerHTML;
      document.getElementById("counter").innerHTML = parseInt(num,10) - times;
      refresh_basket();
    }
   
      
     
    }
  
  xmlhttp.open("GET","remove_from_basket.php?id="+id,true);
  xmlhttp.send();
  
}


function add_to_basket(id) {
    
  xmlhttp=new XMLHttpRequest();
  
  xmlhttp.onreadystatechange=function() {
    if (this.readyState==4 && this.status==200) {
      
      var num = document.getElementById("counter").innerHTML;
      document.getElementById("counter").innerHTML = parseInt(num,10) + 1;
    }
   
      
     
    }
  
  xmlhttp.open("GET","add_to_basket.php?id="+id,true);
  xmlhttp.send();
  
}



// Get the modal
var modal = document.getElementById('basket_list');

// Get the button that opens the modal
var btn = document.getElementById("basket");

// Get the <span> element that closes the modal
var span = document.getElementsByClassName("close")[0];


var cookie = document.getElementById('cookie');
// When the user clicks on the button, open the modal
btn.onclick = function() {
 
  refresh_basket();
  modal.style.display = "block";
  
}

// When the user clicks on <span> (x), close the modal
span.onclick = function() {
  modal.style.display = "none";
}

// When the user clicks anywhere outside of the modal, close it
window.onclick = function(event) {
  if (event.target == modal) {
    modal.style.display = "none";
  }
} 
