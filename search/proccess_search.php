<?php
error_reporting(E_ALL);
ini_set('display_errors', '1');

    require_once '../core/generics/State.php';
    $toSearch = $_REQUEST['toSearch'];

    require_once "../core/SearchEngine/SearchEngine.php";
    $paramsSetted = $_GET['paramsSetted'];
    $paramsValue = $_GET['paramsValues'];

    $i = 0;

    $arrayParams = new ArrayObject();
    
    foreach($paramsSetted as $param){
        $arrayParams->offsetSet($param, $paramsValue[$i++]);
    }

    $search = new SearchEngine(Connection::connect());    
    $resultSearch = ($search->search($toSearch, $arrayParams->getIterator()));    
    if($resultSearch->count()){        
        header('Content-type: application/json');
        $proccessSearch = null;
        if($toSearch == "video"){
            requireVideo();
            $proccessSearch = new ProccessVideoSearch($resultSearch);
        }elseif($toSearch == "paper"){
            requirePaper();
            $proccessSearch = new ProccessPublicationSearch($resultSearch);
        }elseif($toSearch == 'analysis'){
            requireAnalysis();            
            $proccessSearch = new ProccessAnalysisSearch($resultSearch);
        }      
        $json = new JsonResponse();
        $json->response(true, $proccessSearch->getResultsFound(), TRUE);
        $json->addValue("searchType", $toSearch);
        print_r($json->serialize());
    }else{
        $json = new JsonResponse();
        print_r($json->response(false, "Nenhum registro encontrado")->addValue("searchType", $toSearch)->serialize());
    }
?>
<?
function requirePublications(){
    require_once '../core/Publication/Publication.php';
    require_once '../core/generics/SubArea.php';
    require_once '../core/SearchEngine/ProccessPublicationSearch.php';
}

function requireVideo(){
    require_once '../core/Video/Video.php';
    require_once '../core/Video/SubArea.php';
    require_once '../core/SearchEngine/ProccessVideoSearch.php';
}

function requireAnalysis(){
    requirePublications();
    require_once '../core/SearchEngine/ProccessAnalysisSearch.php';
    require_once '../core/Publication/Analyse.php';
}

function requirePaper(){
    requirePublications();
    require_once '../core/Publication/File.php';
    require_once '../core/Publication/Paper.php';
}
?>