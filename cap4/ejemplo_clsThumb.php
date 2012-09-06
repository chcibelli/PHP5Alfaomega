<?php
require("clsThumb.php");

$th = new Thumb();
echo $th->onlineThumb($_REQUEST['img'],$_REQUEST['w']);


echo "<pre>";
print_r($_SERVER);

?>