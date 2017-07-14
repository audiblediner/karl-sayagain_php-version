<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Recipes</title>
<meta name="keywords" content="recipes, Carl Sagan, apple pie, universe">
<style type="text/css">

html, body {
	width:300px;
	height:100px;
	position:absolute;
	left:50%;
	top:40%;
	margin:-100px 0 0 -150px;
	font-family:Garamond;font-size:11px;}

#quote {
	text-align: center; font-size: 36px;}
div b {
	color: #FF0000;}
#credit {
	text-align: right;font-size: 20px;}

#link {
	text-align: left;font-size: 18px;}

</style>
</head>

<body>   

	<?php
	
	//suppress error related to empty value until issue is better understood	
	error_reporting(0);	

	//Create variables telling the PHP class how to parse the XML file and tell it where the XML file is
    	$xml_file = "recipes.xml";
   	$xml_name_key = "*RECIPES*FEATURED*NAME";
   	$xml_link_key = "*RECIPES*FEATURED*LINK";
 	$featured_array = array();
    	$counter = 0;

    
	function startTag($parser, $data){
		global $current_tag;
		$current_tag .= "*$data";
	}

	function endTag($parser, $data){
		global $current_tag;
		$tag_key = strrpos($current_tag, '*');
		$current_tag = substr($current_tag, 0, $tag_key);
	}

	function contents($parser, $data){
		global $current_tag, $xml_name_key, $xml_link_key, $counter, $featured_array;
		switch($current_tag){
			case $xml_name_key:
			 	$featured_array[$counter]->name = $data;
				break;
			case $xml_link_key:
				$featured_array[$counter]->link = $data;
				$counter++;
				break;
		}
	}


	$xml_parser = xml_parser_create();
	xml_set_element_handler($xml_parser, "startTag", "endTag");
	xml_set_character_data_handler($xml_parser, "contents");
	
	$fp = fopen($xml_file, "r") or die("Ugh... what goes here again?");
	$data = fread($fp, filesize($xml_file)) or die("Could not read file");

		if(!(xml_parse($xml_parser, $data, feof($fp)))){
	        ini_set('display_errors','on');

	}

    	xml_parser_free($xml_parser);
    	fclose($fp);


	for($y=0;$y<=0;$y++){
		$featured_array = array_values($featured_array);
		$arrayamt = (count($featured_array)-1);
		$x = rand(0,$arrayamt);

		echo '<div id="quote">';
		echo "If you wish to make ";
 		echo "<b>" . $featured_array[$x]->name . "</b> from scratch, you must first invent the universe.";
 		echo "</div>";
 		echo '<br>';
 		echo '<div id="credit">';
 		echo "- Karl ";
		echo "<a href=\"http://www.kellycolht.com/recipes/\">Sayagain</a>";  
		echo "<br>";
 		echo "</div>";	
		echo "<br>";
		echo "<br>";
		echo "<br>";
		echo "<br>";
		echo "<div link>";		
		echo "For a lesser challenge, you could start from here: ";		
		echo "<a href=\""  . $featured_array[$x]->link . "\">" . $featured_array[$x]->link . "</a>";
		echo "</div>";		
		unset($featured_array[$x]);
	}

    	?> 

</body>
</html>
