<html> 
<head> 
<title>Поиск авиабилетов</title> 
</head> 
<body> 
<?php

 $XML=file_get_contents(dirname(__FILE__).'/xml/searchFlights.xml');
 $response=xml_to_array($XML);
   
 //  echo '<pre>';
  //print_r($response);
   //echo '</pre>';
   
    function xml_to_array($XML)
{
$XML = trim($XML);
$returnVal = $XML;

// Expand empty tags
$emptyTag = '<(.*)/>';
$fullTag = '<\\1></\\1>';
$XML = preg_replace ("|$emptyTag|", $fullTag, $XML);

$matches = [];
if (preg_match_all('|<(.*)>(.*)</\\1>|Ums', trim($XML), $matches))
{
    // Если есть элементы, тогда вернуть массив, иначе текст
    if (count($matches[1]) > 0) $returnVal = [];
    foreach ($matches[1] as $index => $outerXML)
    {
        $attribute = $outerXML;
        $value = xml_to_array($matches[2][$index]);
        if (! isset($returnVal[$attribute])) $returnVal[$attribute] = [];
            $returnVal[$attribute][] = $value;
    }
}
// Bring un-indexed singular arrays to a non-array value.
if (is_array($returnVal)) foreach ($returnVal as $key => $value)
{
    if (is_array($value) && count($value) == 1 && key($value) === 0)
    {
        $returnVal[$key] = $returnVal[$key][0];
    }
}
return $returnVal;
}
?> 
    <form action="ticket.php" method="GET">
        Введите класс обслуживания: <input type="text" name="serviceClass" value="ECONOM" /><br />
        Введите город вылета: <input type="text" name="beginLocation"  value="LED"/><br />
        Введите город прилета: <input type="text" name="endLocation" value="MOW" /><br />
     <input type="submit" value="GO" />
    </form>
   <?php 
    $serviceClass = $_POST['serviceClass'];
    $beginLocation = $_POST['beginLocation'];
    $endLocation = $_POST['endLocation'];
    
    $array = array("S:Body"=> array("settings"=>array("serviceClass" => $serviceClass)));
    $array2 = array("S:Body"=> array("settings"=>array("route" => array("beginLocation" => $beginLocation))));
    $array3 = array("S:Body"=> array("settings"=>array("route" => array("endLocation" => $endLocation))));               
    
  $basket = array_replace_recursive($response, $array, $array2, $array3);
 //echo '<pre>';
  //print_r($basket);
   //echo '</pre>';
  
  //Преобразую полученный массив в xlm
   include_once 'class.array2xml2array.php';
   $array2XML = new CArray2xml2array();
	
	
	// one root
	$array2XML->setArray($basket);
        
	if($array2XML->saveArray("config.xml")){
		echo "config array save<br>";
        }
        //Пытаюсь обратиться к нужному тегу, чтобы добавить узел
       $dom_xml= new DomDocument(); 
       $dom_xml->loadXML($array2XML); 
       $root = $dom_xml->documentElement();
?>
</body> 
</html> 
