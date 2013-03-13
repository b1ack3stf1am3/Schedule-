<?php
if(isset($_SESSION['message'])) {

	echo "<div class = \"alert alert-{$_SESSION['message']['type']}\">{$_SESSION['message']['text']}</div>";

	unset($_SESSION['message']);
}


if(isset($_GET['p'])) {
	$p = $_GET['p'];
} else {
	$p = DEFAULT_PAGE;
}

include("pages/$p.php");

