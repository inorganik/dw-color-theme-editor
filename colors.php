<?php 


libxml_use_internal_errors(true);
$colorsXML = simplexml_load_file('ColorsCheck.xml');
//print_r($colorsXML);

if (!$colorsXML) {
	echo "ERROR<br>";
	foreach(libxml_get_errors() as $error) {
		echo "\t", $error->message;
	}
}

$syntaxColors = $colorsXML->colorGroup->syntaxColor;

$colors = array();
foreach ($syntaxColors as $color) {
	
	$type = strval($color['id']);
	$text = strval($color['text']);
	
	//echo $type."\n<br>";
	
	if (isset($text)) {
		$colors[$type] = $text;
		//echo $text."\n<br><br>";
	}
	//echo "<br>";
	
}

asort($colors);

?>


<!DOCTYPE HTML>
<html>
<head>
<meta charset="UTF-8">
<title>Dreamweaver Color Scheme Editor</title>

<style type="text/css">
body {
	margin:0;
	padding:40px;
	font-family:Helvetica, Arial, sans-serif;
	font-weight:300;
}
h1, h2, h3 {
	margin-top:0;
	font-weight:300;
}
ul {
	margin-bottom:40px;
}
li {	
	margin-bottom:5px;
}
ul li { 
	list-style-type:none;
}
input {
	margin-right:5px;
	border:0;
	padding:2px;
}
pre {
	display:inline;
	font-size:1.1em;
}
#inorganik {
	font-family:Georgia, "Times New Roman", Times, serif;
	text-align:right;
	position:fixed;
	bottom:10px;
	right:20px;
	width:85px;
	height:30px;
}
#inorganik a {	
	color:#ff7519;
	font-size:.75em;
	font-weight:bold;
}
</style>

<script type="text/javascript" src="jscolor/jscolor.js"></script>


</head>

<body>
<h1>Colors</h1>
<form method="post" action="download-xml.php">
    <ul>
    	<li><input class="color" onchange="document.getElementsByTagName('BODY')[0].style.backgroundColor = '#'+this.color">Background color</li>
        <li><input class="color" onchange="document.getElementsByTagName('BODY')[0].style.color = '#'+this.color" value="#000">Text color (names)</li>
        <li><hr></li>
		<?php 
        $lastVal = '';
		echo "<li>Starting count: ".count($colors)."</li>";
		$newCount = array();
        foreach ($colors as $key => $val) {
            
			if ($lastVal != $val) {
            	echo "<li><input class=\"color {hash:true}\" name=\"$key\" value=\"$val\">$key</li>\n";
				$newCount[] = 1;
				$lastVal = $val;
			}				
            
        }
		echo "<li>Ending count count: ".count($newCount)."</li>";
        
        ?>
    </ul>
    <ol>
        <li>Backup your old colors: <pre>User/Library/Application Support/Adobe/Dreamweaver XX/en-US/Configuration/CodeColoring/Colors.xml</pre></li>
        <li>Replace the old file with this one: <input type="submit" name="submit" value="Download this scheme"></li>
        <li>Set background color in Prefs > Code Coloring > Default background</li>
        <li>Restart Dreamweaver</li>
    </ol>
</form>
<p>This projects uses <a href="http://jscolor.com/">JSColor</a> by Jan Odv&aacute;rko</p>
<div id="inorganik"><a href="http://inorganik.net">[inorganik]</a></div>
</body>
</html>