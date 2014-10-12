<?php

echo "<html><head><title>Data in Books.xml</title></head><body>";

// We have to select the desired file to parse.
// In this case, we've saved it as Books.xml.
$file = "Books2.xml";


// The xml_parser_create() function will make an object that allows 
// us to move through an xml document, extracting the relevant data.
$xml_parser = xml_parser_create();


// The parser needs to know what to do when it encounters the various
// elements of the XML document.  This function gets passed the xml
// parser object we created above, followed by the names of the 
// functions that will be called when the parser encounters a tag
// opening and closing an element.
xml_set_element_handler($xml_parser, "elementStart", "elementEnd");

// Now, we need to tell the parser what function to call when it
// encounters data inside a set of tags.
xml_set_character_data_handler($xml_parser, "data_handler");

// Normal file handling: the desired file must be opened for reading
// before it can be read by the parser.  
$fp = fopen($file, "r");

// This will extract up to 1000 bytes of data from the file Books.xml
// which is more than enough to get through our entire document.
$data = fread($fp, 1000);

// Here we actually parse the the data we took from Books.xml,
// calling the handler functions as many times as necessary.
// If the XML document is faulty, it will report an error message
// with the line number.
if(!(xml_parse($xml_parser, $data, feof($fp)))){
    die("Error on line " . xml_get_current_line_number($xml_parser));
}

// We must free up the XML parser when we are finished.
xml_parser_free($xml_parser);


// We must close the file to prevent erratic behavior.
fclose($fp);

echo "</body></html>";

// When the parser encounters a tag opening, it calls this function.
// Ex:  <tag>Meow</tag>   "TAG" is the passed data.
function elementStart($parser, $data)
{	//echo"3";
	global $booknumber;
	if($data == "BOOK")
	{
		$booknumber = $booknumber+1;
		echo "Book #$booknumber:<br>";
	}
	elseif($data == "TITLE")
		echo "<i>";
	//echo"4";
}

// When the parser encounters data, it calls this function.
// Ex:  <tag>Meow</tag>   "Meow" is the passed data.
function data_handler($parser, $data)
{	
	//echo "1";
    echo " $data ";
}

// When the parser encounters a tag closing, it calls this function.
// Ex:  <tag>Meow</tag>   "TAG" is the passed data.
function elementEnd($parser, $data)
{	//echo"2";
	if($data == "BOOK")
		echo "<br><br>";
	elseif($data == "TITLE")
		echo "</i> by ";
}
?>