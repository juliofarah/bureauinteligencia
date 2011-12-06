<?php
error_reporting(E_ALL);
ini_set('display_errors', '1');
    /*require_once 'Cotacao.php';
    require_once 'Bolsa.php';    
    require_once 'BolsaDao.php';
    require_once 'JSONBolsaDao.php';
    require_once 'BolsaController.php';

    $bolsa = new Bolsa;
    $bolsaDao = new JSONBolsaDao();

    $codeMap = new CodeMap();
    $dateMap = new DateMap();
    
    $bolsaController = new BolsaController($bolsa, $bolsaDao);
    $iterator = $bolsaController->getBolsa()->getCotacoes();


    print_r($dateMap->getMap());
    echo "<br />".$dateMap->getMap()->count()."<br />";
    foreach($dateMap->getMap() as $date){
        echo "date = $date<br /><br />";
    }
    
    while($iterator->valid()){
        echo "Codigo: ".$iterator->current()->getCodigo();
        echo "<br />Produto: ".$iterator->current()->getName($codeMap);
        echo "<br />Mês: ".$iterator->current()->getMounth($dateMap);
        echo "<br />Valor: ".$iterator->current()->getValor();
        echo "<br />Diferencial: ".$iterator->current()->getDiferencial();
        echo "<br />---------------<br />";
        $iterator->next();
    }*/
    require_once 'Maps/HashMap.php';
    require_once("HtmlLib.php");
    require_once 'Classifier/Classifier.php';

    $cotacoes = HtmlLib::cotacoes();

    foreach($cotacoes->get("BMF") as $cotacao){
        echo "Nome: ".$cotacao->getName(). " - ".$cotacao->getLast()."<br />";        
        //echo "Codigo : ".$cotacao->getCodigo()." - ". $cotacao->getImage();"<br />";
        //echo "<br />";
    }
?>
