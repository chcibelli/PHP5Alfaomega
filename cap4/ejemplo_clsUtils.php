<?php
require("clsUtils.php");

$utils = new Utils();

if($utils->esCrawler($_SERVER['HTTP_USER_AGENT'])) {
	echo "es un crawler";
} else {
	echo "no es un crawler";
}

?>