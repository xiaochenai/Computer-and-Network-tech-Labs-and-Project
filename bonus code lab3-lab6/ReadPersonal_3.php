<?php
$q=$_GET["q"];

$xmlDoc = new DOMDocument();
$xmlDoc->load("PersonalInfo.xml");
$exist = 0;
$x=$xmlDoc->getElementsByTagName('Name');
//create new elements

$z=$xmlDoc->getElementsByTagName('person');
$t = $xmlDoc->getElementsByTagName("search_times");
//judge if the element has exist, if not we create the element search_times in the end of all Element person
if($t->length == 0)
{
	for($i=0;$i<=$z->length-1;$i++)
	{	$times = $xmlDoc->createElement("search_times");
		$z->item($i)->appendChild($times);
	}
}
//count search time
$people=$xmlDoc->getElementsByTagName('person');
	foreach($people as $person){
		@$p_times = $person->getElementsByTagName( "search_times" );
		@$p_times->item(0)->nodeValue=$p_times->item(0)->nodeValue+1;
		$xmlDoc->save('PersonalInfo.xml');
		}
for ($i=0; $i<=$x->length-1; $i++)
{
//Process only element nodes
if ($x->item($i)->nodeType==1)
  {
  if ($x->item($i)->childNodes->item(0)->nodeValue == $q)
    { 
    $y=($x->item($i)->parentNode);
	$exist = 1;
    }
  }
}

$person=(@$y->childNodes);

for (@$i=0;@$i<@$person->length;@$i++)
{ 
//Process only element nodes
if ($person->item($i)->nodeType==1)
  { 
  echo($person->item($i)->nodeName);
  echo(": ");
  echo(@$person->item($i)->childNodes->item(0)->nodeValue);
  echo("<br />");
  } 

}
if($exist == 0)
{
	echo ("<h1>No such person exist</h1>");	
}
?>