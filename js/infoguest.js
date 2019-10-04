
function agree() {
    
    xmlhttp=new XMLHttpRequest();
    
    xmlhttp.onreadystatechange=function() {
      if (this.readyState==4 && this.status==200) {
        
        document.getElementById("infoguest").style.display = "none";
       
      }
     
      }
    
    xmlhttp.open("GET","guest_agree.php",true);
    xmlhttp.send();
    
  }