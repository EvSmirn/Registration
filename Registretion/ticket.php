<html> 
<head> 
<title>Поиск авиабилетов</title> 
</head> 
<body> 
<?php
   error_reporting( E_ERROR );
   include 'searchFlights.php';
   $s_serviceClass=$_POST['serviceClass'];
   $s_beginLocation=$_POST['beginLocation'];
   $s_endLocation=$_POST['endLocation'];
   
   //deleteXmlNamespace($xmlstr);
   $xml = new SimpleXMLElement($xmlstr);
   $ns = $xml->getNamespaces(true);
    
   $serviceClass = $xml->children($ns['S'])->Body->children($ns['ns2'])->searchFlights->children($ns[''])->settings->serviceClass = $s_serviceClass;
   $beginLocation = $xml->children($ns['S'])->Body->children($ns['ns2'])->searchFlights->children($ns[''])->settings->route->beginLocation=$s_beginLocation;
   $endLocation = $xml->children($ns['S'])->Body->children($ns['ns2'])->searchFlights->children($ns[''])->settings->route->endLocation=$s_endLocation;
   
   /*function deleteXmlNamespace(&$xml){ 
        $pattern = "|(<[/]*)[a-z][^:\s>]*:([^:\s>])[\s]*|sui"; 
        $replacement="\\1\\2"; 
        $xml = preg_replace($pattern, $replacement, $xml); 
        $pattern = "|(<[/]*[^\s>]+)[-]|sui"; 
        $replacement="\\1_"; 
        $xml = preg_replace($pattern, $replacement, $xml); 
        $pattern = "|xmlns[:a-z]*=\"[^\"]*\"|isu"; 
        $replacement=""; 
        $xml = preg_replace($pattern, $replacement, $xml); 
    } */
   $xml->saveXML("Ticket.xml");
?> 
    <form action="ticket.php" method="post">
        Введите класс обслуживания: <input type="text" name="serviceClass" value="ECONOM" /><br />
        Введите город вылета: <input type="text" name="beginLocation"  value="LED"/><br />
        Введите город прилета: <input type="text" name="endLocation" value="MOW" /><br />
      <input type="submit" value="Записать" name="submit">
    </form>
  
</body> 
</html> 
