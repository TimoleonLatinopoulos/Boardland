<?php
 
$json = json_encode("ok", true);
setcookie("guest_agree", $json, time() + (86400 * 30), '/'); // 86400 = 1 day
$_COOKIE['guest_agree']=$json;

?>