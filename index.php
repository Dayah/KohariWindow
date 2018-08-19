<? require("words_array.php");
if (array_key_exists("type", $_GET))
	$type == $_GET["type"];
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN">
<html>
 <head>
  <title>Interactive Kohari Window - Mapping Personality Visibility</title>
  <style type="text/css">
H1	{ color: #EFD1D1; font-family: sans-serif; text-align: center; }
BODY	{ color: #402B2B; background-color: #805555; }
P	{ background-color: #AF9999; width: 30em; margin: 0 auto; padding: 1em; border: thick solid #9F7878; text-align: justify; }
TABLE	{ border-spacing: 2px; margin: 0 auto; }
TD	{ width: 6.5em; height: 2em; text-align: center; border: thin solid #AF9999; background-color: #9F7878; color: white; cursor: pointer; }
TD:hover	{ opacity: 0.8; }
INPUT	{ background-color: #EFD1D1; }
  </style>
  <script language="javascript">
var words = new Array();

function validate() {
	var items = document.getElementById("words");
	if (words.length < 3) { alert("Please select at least three words."); return false; }
	if (words.length > 10) { alert("Please select no more than ten words.\n(You can click words to deselect them.)"); return false; }
	if (document.getElementById("name").value == "") {
		alert("Please enter your name.");
		return false;
	}
	items.value = words.toString();
	return true;
}

function select(event) {
	if (find(event.innerHTML)) {
		event.style.backgroundColor = "#9F7878";
		remove(event.innerHTML);
	} else {
		event.style.backgroundColor = "#AF9999";
		words.push(event.innerHTML);
	}
}

function remove(element) {
	for (var x = 0; x < words.length; x++)
		if (words[x] == element)
			words.splice(x, 1);
}

function find(element) {
	for (var x = 0; x < words.length; x++)
		if (words[x] == element)
			return true;
	return false;
}

  </script>
 </head>
 <body>
  <h1>Parody of Kevan's Johari Window</h1>

<form action="./" method="post" onSubmit="return validate();">

<p style="border-bottom: none;">Sure, it feels good to see who thinks you're idealistic and ingenious, but what good does that do? Do you have the guts to paste something in your blog that may actually build character and lead to self-improvement rather than electronically fish for compliments? Let's find out.</p>

<table>
 <tr>
<? foreach($word_bank as $number=>$word) {
	if (!($number % 5) && ($number != 0)) echo "</tr><tr>\n"; ?>
<td onClick="select(this)"><?= $word ?></td>
<? } ?>
 </tr>
</table>

<p style="border-top: none;">
 Enter a unique name:
 <input type="text" name="name" id="name" maxlength=16>
 <input type="hidden" name="type" value="<?= $_GET["type"] ?>">
 <input type="hidden" name="words" id="words">
 <input type="submit" value="Save">
</p>

</form>
 </body>
</html>
<?
if (array_key_exists("name", $_POST) && array_key_exists("words", $_POST)) {
	$connection = mysql_connect("localhost", "negative", "johari");
	mysql_select_db("negative", $connection);

	$name = $_POST["name"];
	$words = explode(",", $_POST["words"]);
	sort($words);

	$data = serialize($words);
	$statement = mysql_query("INSERT INTO negative
	VALUES ('$name', " . (($_GET['type'] == 'new') ? 1 : 0) . ", " . ip2long($_SERVER['REMOTE_ADDR']) . ", '$data')", $connection);
}
?>
