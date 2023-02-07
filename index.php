<?php

$themeSetting = 0;
$theme = array('#323232', '#696969', '#D0D2D3', '#52D1FF', '#83FFFC', '#49A7FC', '#00D1CB', '#00FF88', '#BABA00', '#A66100', '#E88080', '#CC7700', '#FF8048', '#D49CFF', '#F27BFF', '#FF7878', '#FF4040', '#FF8048', '#F9B939');

if (isset($_GET['t'])) {
	
	$theme = $_GET['t'];
	
	if ($theme == 'default') {
	
		$themeSetting = 1;
		$theme = array('#FFF', '#999', '#000', '#009', '#00F', '#06F', '#099', '#060', '#990', '#520', '#900', '#A50', '#C70', '#909', '#F0F', '#C00', '#F03', '#FF6208', '#F90');
	}
	
}
	
$errors = array();

// Colors.xml upload
if (isset($_POST['submit'])) {
	
	// no errors
	if (!$_FILES['colors']['error']) {
		
		if ($_FILES['colors']['size'] == 0) {
			
			$errors[] = "No file uploaded";
		}
		else if ($_FILES['colors']['size'] < 100000 && $_FILES['colors']['size'] > 1000) { // files smaller than 100K, larger than 1K
			
			if ($_FILES['colors']['name'] != 'Colors.xml') {
				
				$errors[] = "You must upload the 'Colors.xml' file from your Dreamweaver configuration folder";
			}
			else {
				if ($_FILES['colors']['type'] == "text/xml") {
						
						$themeSetting = 3;
						
						// parse file
						$colorsToEdit = simplexml_load_file($_FILES['colors']['tmp_name']);
						$syntaxColors0 = $colorsToEdit->colorGroup[0]->syntaxColor;
						
						// assign theme colors
						$theme = array();
						
						foreach ($syntaxColors0 as $syntaxColor) {
						
							switch((string) $syntaxColor['id']) { 
								
								case 'CodeColor_TemplateText' :
									$theme[1] = $syntaxColor['text'];
									break;
								case 'CodeColor_CFCommentText' :
									$theme[2] = $syntaxColor['text'];
									break;
								case 'CodeColor_JavascriptBracket' :
									$theme[3] = $syntaxColor['text'];
									break;
								case 'CodeColor_PHPScriptFunctionsKeywords' :
									$theme[4] = $syntaxColor['text'];
									break;
								case 'CodeColor_PHPScriptBuiltinVariables' :
									$theme[5] = $syntaxColor['text'];
									break;
								case 'CodeColor_JavascriptNative' :
									$theme[6] = $syntaxColor['text'];
									break;
								case 'CodeColor_TemplateCommentText' :
									$theme[7] = $syntaxColor['text'];
									break;
								case 'CodeColor_JavaImplicit' :
									$theme[8] = $syntaxColor['text'];
									break;
								case 'CodeColor_PHPScriptConstant' :
									$theme[9] = $syntaxColor['text'];
									break;
								case 'CodeColor_SVGTag' :
									$theme[12] = $syntaxColor['text'];
									break;
								case 'CodeColor_JavascriptClient' :
									$theme[13] = $syntaxColor['text'];
									break;
								case 'CodeColor_TemplateText' :
									$theme[14] = $syntaxColor['text'];
									break;
								case 'CodeColor_PHPScriptString' :
									$theme[15] = $syntaxColor['text'];
									break;
								case 'CodeColor_PHPScriptBlock' :
									$theme[16] = $syntaxColor['text'];
									break;
								case 'CodeColor_JavascriptNumber' :
									$theme[17] = $syntaxColor['text'];
									break;
								case 'CodeColor_PHPScriptComment' :
									$theme[18] = $syntaxColor['text'];
									break;
								default:
									break;
							}
						}
						
						$tagColors = $colorsToEdit->colorGroup[0]->tagColor;
						
						foreach ($tagColors as $tagColor) {
						
							switch((string) $tagColor['id']) { 
								
								case 'CodeColor_HTMLObject' :
									$theme[10] = $tagColor['text'];
									break;
								case 'CodeColor_SVGTagGroup' :
									$theme[11] = $tagColor['text'];
									break;
								default:
									break;
							
							}
						}
						
						$syntaxColors1 = $colorsToEdit->colorGroup[1]->syntaxColor;
						
						foreach ($syntaxColors1 as $syntaxColor) {
						
							switch((string) $syntaxColor['id']) { 
								
								case 'CodeColor_CSSSelector' :
									$theme[14] = $syntaxColor['text'];
									break;
								default: 
									break;
							
							}
						}
						
						$theme[0] = $_POST['uploadbkgd'];
						
						
				} else {
					
					$errors[] = "Bad file type";
				}
			}
		} else {
			
			$errors[] = "File size too large or too small";
		}
		
	// errors
	} else {
		
		if ($_FILES['colors']['error'] == 4) {
			
			$errorType = "No file uploaded";
			
		} else {
			if ($_FILES['colors']['error'] == 1) {
				$errorType = "File size too large";
			}
			else if ($_FILES['colors']['error'] == 2) {
				$errorType = "File size too large";
			}
			else if ($_FILES['colors']['error'] == 3) {
				$errorType = "File was not fully uploaded";
			}
			else if ($_FILES['colors']['error'] == 6) {
				$errorType = "No temporary folder";
			}
			else if ($_FILES['colors']['error'] == 7) {
				$errorType = "Failed to save file";
			}
			else if ($_FILES['colors']['error'] == 8) {
				$errorType = "A php extension stopped the upload";
			} else {
				$errorType = "Unknown";
			}
			$errors[] = "image error: ".$errorType;
		}
	}
}


?>

<!DOCTYPE HTML>
<html>
<head>
<meta charset="UTF-8">

<!-- CREATED: July, 2013 -->
<!-- UPDATE: Apr 14, 2014 - added # to colors in xml file -->
<!-- UPDATE: Apr 3, 2014 - style improvements, colored syntax names -->

<title>Dreamweaver Color Theme Editor</title>

<link rel="shortcut icon" href="favicon.png" type="image/png">

<style type="text/css">
body {
	margin:0;
	padding:40px;
	font-family:Helvetica, Arial, sans-serif;
	font-weight:300;
	background-color:<?php echo $theme[0];?>;
	color:<?php echo $theme[2];?>;
}
.bkgdColor {
	border:1px <?php echo $theme[2];?> solid !important;
}
h1 {
	color:#9eb83d;
}
h2 {
	border-bottom-style:solid;
	border-bottom-width:1px;
}
hr {
	border:0;
	border-style:solid;
	border-bottom-width:1px;
	margin:15px 0;
}
h1, h2, h3 {
	margin-top:0;
	font-weight:300;
}
p {
	line-height: 1.4em;
}
a {
	color:#9eb83d;
	text-decoration:none;
}
a:hover {
	text-decoration:underline;
}
a.active {
	font-weight:bold;
	text-decoration:underline;
}
ul {
	margin-bottom:40px;
}
li {	
	margin-bottom:5px;
}
ul.colors li { 
	list-style-type:none;
}
input {
	font-family:Helvetica, Arial, sans-serif;
	margin-right:5px;
	border:0;
	padding:4px;
}
.color {
	margin-right:15px;
}
input[type=submit] {
	padding:10px 15px;
	cursor:pointer;
	background-color:#9eb83d;
}
input[type=submit]:hover {
	background-color:#7b9322;
}
.download {
	font-size:1.1em;
	padding: 10px 20px !important;
	margin: 10px 0 !important;
	border-bottom:4px #7b9322 solid;
}
.download:hover {
	border-bottom:4px #647916 solid;
}
code {
	font-family:'Monaco', monospace;
	font-size:.95em;
}
.highlight {
	background:rgba(255,240,0,.2);
}
.upload {
	padding:5px;
	border:1px <?php echo $theme[2]; ?> solid;
	margin-bottom:40px;
	display:inline-block;
}
.red {
	color:red;
}
</style>

<script type="text/javascript" src="jscolor/jscolor.js"></script>
<script type="text/javascript">

	window.onload = function() {
		var colors = document.querySelectorAll('.codeColor');
		for (var i = 0; i < colors.length; i++) {
			colors[i].parentNode.style.color = '#'+colors[i].value;
			colors[i].onchange = function() {
				this.parentNode.style.color = '#'+this.value;
			}
		}
    }

</script>

</head>

<body>
<h1 style="display:inline-block;">Dreamweaver Color Theme Editor&nbsp;</h1><span>by <a style="color:#4d63bc;" href="https://twitter.com/inorganik" target="_blank">@inorganik</a></span>
<p>Edit your Dreamweaver code colors. Click a color to change it, or type in a hex value. <a href="#instructions">Installation instructions</a>, how to <a href="#restore">restore default colors</a> and <a href="#about">about</a> are at the bottom.</p>
<p>Start with: <a <?php if ($themeSetting == 0) echo "class=\"active\" "; ?>href="?">Easy-transition-to-dark theme</a> &nbsp;|&nbsp; <a <?php if ($themeSetting == 1) echo "class=\"active\" "; ?>href="?t=default">Default theme</a> &nbsp;|&nbsp; <a <?php if ($themeSetting == 3) echo "class=\"active\" "; ?>href="#yourTheme">Upload and edit your own theme</a></p>

<form method="post" action="download-xml.php">

    <ul class="colors" style="padding-left:0;">
    	<li><input class="color bkgdColor {hash:true}" name="bkgd" onchange="document.getElementsByTagName('BODY')[0].style.backgroundColor = '#'+this.color" value="<?php echo $theme[0]; ?>">Background color</li>
        <li><hr></li>

        <li><input class="color codeColor {hash:true}" name="999" value="<?php echo $theme[1]; ?>"><code>Comments</code></li>
		<li><input class="color codeColor {hash:true}" name="000" value="<?php echo $theme[2]; ?>"><code>Text, JavaScript functions and variables</code></li>
        <li><input class="color codeColor {hash:true}" name="009" value="<?php echo $theme[3]; ?>"><code>HTML &lt;tag&gt;, CSS property, JavaScript bracket, keywords, PHP superglobals.</code></li>
        <li><input class="color codeColor {hash:true}" name="00F" value="<?php echo $theme[4]; ?>"><code>HTML attribute values, JavaScript string, operators, SVG number</code></li>
        <li><input class="color codeColor {hash:true}" name="06F" value="<?php echo $theme[5]; ?>"><code>PHP variables</code></li>
        <li><input class="color codeColor {hash:true}" name="099" value="<?php echo $theme[6]; ?>"><code>CSS import, HTML &lt;table&gt;, JavaScript native function</code></li>
        <li><input class="color codeColor {hash:true}" name="060" value="<?php echo $theme[7]; ?>"><code>HTML anchor, CSS string, PHP keywords, XML string</code></li>
        <li><input class="color codeColor {hash:true}" name="990" value="<?php echo $theme[8]; ?>"><code>Java Implicit</code></li>
        <li><input class="color codeColor {hash:true}" name="520" value="<?php echo $theme[9]; ?>"><code>PHP constant</code></li>
        <li><input class="color codeColor {hash:true}" name="900" value="<?php echo $theme[10]; ?>"><code>HTML script, CSS Media query</code></li>
        <li><input class="color codeColor {hash:true}" name="A50" value="<?php echo $theme[11]; ?>"><code>SVG tag group</code></li>
        <li><input class="color codeColor {hash:true}" name="C70" value="<?php echo $theme[12]; ?>"><code>SVG Tag</code></li>
        <li><input class="color codeColor {hash:true}" name="909" value="<?php echo $theme[13]; ?>"><code>HTML &lt;img&gt;, style</code></li>
        <li><input class="color codeColor {hash:true}" name="F0F" value="<?php echo $theme[14]; ?>"><code>CSS selector</code></li>
        <li><input class="color codeColor {hash:true}" name="C00" value="<?php echo $theme[15]; ?>"><code>PHP string</code></li>
        <li><input class="color codeColor {hash:true}" name="F03" value="<?php echo $theme[16]; ?>"><code>PHP script block</code></li>
        <li><input class="color codeColor {hash:true}" name="FF6208" value="<?php echo $theme[17]; ?>"><code>PHP numbers, JavaScript numbers &amp; Spry classes</code></li>
        <li><input class="color codeColor {hash:true}" name="F90" value="<?php echo $theme[18]; ?>"><code>HTML form, PHP comment, SVG attribute</code></li>
    </ul>
    
    <h2 id="instructions">Installation</h2>
    <ol>
        <li>Backup your old colors:<br>
        <strong>Mac:</strong> <code>USERNAME/Library/Application Support/Adobe/Dreamweaver CSX/en-US/Configuration/CodeColoring/Colors.xml</code><br>
        <strong>Win:</strong> <code>C:\Users\USERNAME\AppData\Roaming\Adobe\Dreamweaver CSX\en_US\Configuration\CodeColoring</code></li>
        <li>Replace the old file with this one: <br>
        	<input type="submit" name="submit" class="download" value="Download this theme"></li>
        <li>Set background color to something different in Prefs > Code Coloring > Default background<br>
        <strong>OR</strong>, restart Dreamweaver.</li>
    </ol>
</form>
<h2 id="yourTheme">Upload and edit your theme</h2>
<p>If you&rsquo;d like to edit a theme you created, upload your <code>Colors.xml</code> file below.</p>
<?php if ($errors) {
		
	echo "<h3 class=\"red\">Error uploading file:</h3>\n";
	echo "<ul class=\"red\">\n";
	foreach ($errors as $error) {
		echo "<li>$error</li>\n";
	}
	echo "</ul>\n";
} ?>
<form class="upload" method="post" action="" enctype="multipart/form-data">
	<input type="hidden" name="MAX_FILE_SIZE" value="100000" />
	<input type="file" name="colors">
    <label>Background:</label><input class="color bkgdColor {hash:true}" name="uploadbkgd" value="<?php echo $theme[0]; ?>">
    <input type="submit" name="submit" value="Upload &amp; Edit">
</form>
<h2 id="about">About</h2>
<p>Dreamweaver stores 212 color values, and 99% of them are repeats of eachother. This is because Dreamweaver assumes that for every different language of code you are editing, you will want a different code coloring scheme. This makes changing code colors incredibly tedious. This editor combines all the repeats into the 18 unique colors for you to edit. Then you can download an XML file that you just need to drop in place.</p>
<p>Unfortunately, Dreamweaver gets its <span class="highlight">cursor highlight color</span> from system preferences, so you will need to change that there if you want to. (On Mac: Preferences > General > Highlight color). I find a yellow or green color works very well on both dark and light themes.</p>
<p>For the color pickers, this project uses <a href="http://jscolor.com/" target="_blank">JSColor</a> by Jan Odv&aacute;rko.</p>
<h2 id="restore">Restore default colors</h2>
<p>If you want to restore default colors, just select the default theme, and follow the installation instructions.</p>
</body>
</html>