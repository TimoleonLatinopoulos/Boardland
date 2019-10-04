<?php

function convert_rating_to_image_name($rating){
	
	// round to nearest half (e.g. 1.26 -> 1.5, 3.6 -> 3.5, 4.8 -> 5)
	$stars = round($rating * 2) / 2;
	
	if ($stars == floor($stars)){ // no half stars
		return "star_rating_".$stars;
	} else {
		// if stars = 3.5, then the image name is star_rating_half_4
		return "star_rating_half_".ceil($stars);
	}
	
}

?>