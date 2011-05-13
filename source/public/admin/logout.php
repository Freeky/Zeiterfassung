<?php
session_start(); 
session_destroy();
		echo "<font color=\"green\" face=\"Helvetica, Arial, sans-serif\"><h2>Logout successful. You will be redirected to the LogIn-Screen in <span id=\"counter\" class=\"dd\">1</span> seconds.</h2></font><br><meta http-equiv=\"refresh\" content=\"5; url=index.php\">";
		echo "<script type=\"text/javascript\">";
		echo "countDown(true);";
		echo "function countDown(init)";
		echo "{";
		echo "if (init || --document.getElementById( \"counter\" ).firstChild.nodeValue >0 )";
		echo "window.setTimeout(\"countDown()\",1000);";
		echo "};";
		echo "</script>";
?>