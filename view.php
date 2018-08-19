<?
	$connection = mysql_connect("localhost", "negative", "johari");
	mysql_select_db("negative", $connection);

	$row = mysql_fetch_row(mysql_query("SELECT words FROM negative WHERE name='$name'"));
	$row = unserialize($row[0]);

	print_r($row);
?>
