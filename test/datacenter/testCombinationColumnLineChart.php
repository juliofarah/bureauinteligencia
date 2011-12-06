<?php
    require_once '../asserts/Asserts.php';
    require_once '../../core/Charts/XmlCharts/XmlChart.php';
    require_once '../../core/Charts/XmlCharts/MultiSerie/XmlMultiSeries.php';
    require_once '../../core/Charts/XmlCharts/MultiSerie/XmlMultiSeriesCombinationColumnLine.php';
    
    $xmlExpected = xml();
        
    $xmlTest = "test";
    $xml = new XmlMultiSeriesCombinationColumnLine();
    $xml->addChartAttribute("caption", "Product Sales and Downloads");
    $xml->addChartAttribute("showValues", "0");
    $xml->setPYAxisName("Sales");
    $xml->setSYAxisName("Total Downloads");
    $xml->addCategory("Jan");
    $xml->addCategory("Fev");
    $xml->addCategory("Mar");
    $xml->addCategory("Abr");
    $xml->newDataset("2006");
    $xml->setValues(new ArrayObject(array("27400","29800","25800","20580")), "2006");
    
    $xml->setValues(new ArrayObject(array("10000","11500","12500","13000")), "2005");
    $xml->setValues(new ArrayObject(array("12000","13000","11000","9500")), "2004");
    
    $xml->setLineToAnAxis("2005", "S");
    $xml->setLineToAnAxis("2004", "S");
    
    $xmlFile = "text.xml";
    assertEquals(formatGreaterAndSmallerSymbols($xml->buildXml($xmlFile)), $xmlExpected);
?>

<?
    function xml(){
        return formatGreaterAndSmallerSymbols(chart());   
    }
    
    function chart(){
        $xml = "<?xml version=\"1.0\"?>";
        $xml .= " <chart bgColor=\"FFFFFF\" caption='Product Sales and Downloads' showValues='0' PYAxisName='Sales' SYAxisName='Total Downloads'>";
        $xml .=     "<categories>";
        $xml .=         "<category label='Jan'/>";
        $xml .=         "<category label='Fev'/>";
        $xml .=         "<category label='Mar'/>";
        $xml .=     "</categories>";
        $xml .=     "<dataset seriesName='2006'>";
        $xml .=         "<set value='27400'/>";
        $xml .=         "<set value='29800'/>";
        $xml .=         "<set value='25800'/>";
        $xml .=     "</dataset>";
        $xml .=     "<dataset seriesName='2005' parentYAxis='S'>";
        $xml .=         "<set value='10000'/>";
        $xml .=         "<set value='11500'/>";
        $xml .=         "<set value='12500'/>";
        $xml .=     "</dataset>";
        $xml .= "</chart>";
        
        $xml = str_replace("'", "\"", $xml);
        return $xml;
    }
    
    function formatGreaterAndSmallerSymbols($tag){
        return str_replace(array("<", ">"), array("&lt;", "&gt;"), $tag);
    }
?>
