<?php
/*
Plugin Name: now_on_sell
Plugin URI: 
Description: 【The function to cooperate E-commerce site】<br />If there is any stoks,it appear a button to link E-commerce site.<br />If there is no stock,it display "We have Already finished to sell reserve ticket".
Version: 1.0
Author: rainy4649
Author URI: 
*/

function now_on_sell($pre_id) {
	//　ID of item
	$id = $pre_id[id];

	require 'config.php';
	$conn = mysql_connect($db, $user, $pw) or die(mysql_error());

	// connect to MySQL, select database
	mysql_query('SET NAMES utf8', $conn);
	// set character code of query
	mysql_select_db($db_name) or die(mysql_error());

	// get stock by key as item number
	$SQL="
	select dtb_products_class.stock, dtb_products.status
	 from dtb_products_class, dtb_products
	 where dtb_products_class.product_id=".$id."
	 and dtb_products.product_id=".$id.";
	";

	// excute SQL
	$res = mysql_query($SQL) or die(mysql_error());
	$row = mysql_fetch_array($res, MYSQL_NUM);
	$stock = $row[0];
	$show= $row[1];

	// free the result, close the connect
	mysql_free_result($res);
	mysql_close($conn);

	if($show==1) {
		if ($stock > 0) {
			$answer = "<a href='".$url."/products/detail.php?product_id=".$id."' class='online'>". $button ."</a>";
		}else{
			$answer = "<span style='color: red;'>". $finish ."</span>";
		}
	}else{
		$answer="";
	}
	return $answer;
}

add_shortcode('now_on_sell', 'now_on_sell');

?>
