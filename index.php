<?php
//output header to an internal buffer instead of sending to client
ob_start();
//writes 'header.html' to the buffer
include 'header.html';
//grab contents of buffer in a variable
$buffer = ob_get_contents();
//clear the buffer
ob_end_clean();

//get the 'p' query. i.e. https://example.com/?p=about
$page = $_GET['p'];

//if our page wasn't found in the 'pages' directory, go to the home page
if (!(file_exists("pages/$page.html"))) {
	$page = "home";
}

//if we had a file called 'privacy_policy' it will be 'privacy policy'
$pageTitle = str_replace("_", " ", $page);
//'privacy policy' becomes 'Privacy Policy'
$pageTitle = ucwords($pageTitle);

//make title for tab
$title = "$pageTitle | Code@IU";
//we search for the title tag and replace it with the title up there ^
//The first parameter is regex. the parentheses make a group, so '$1' refers to '<title>' and '$3' is </title>
//the dot (.) in php is string concatenation
$buffer = preg_replace('/(<title>)(.*?)(<\/title>)/i', '$1' . $title . '$3', $buffer);

//output our buffer (the modified header.html), our page content, and our footer.html
echo $buffer;
include "pages/$page.html";
include 'footer.html';
?>