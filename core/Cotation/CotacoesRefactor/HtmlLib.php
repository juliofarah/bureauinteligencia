<?php
/**
 * Description of HtmlLib
 *
 * @author ramon
 */
require_once 'Cotacao.php';
require_once 'Bolsa.php';
require_once 'BolsaDao.php';
require_once 'JSONBolsaDao.php';
require_once 'BolsaController.php';
require_once 'Classifier/Classifier.php';
require_once 'Classifier/DateMap.php';

class HtmlLib {

    /**
     * @var BolsaController
     */
    private static $controller = null;
    
    private static function init(){
        if(self::$controller == null)
            self::$controller = new BolsaController(new Bolsa(), new JSONBolsaDao(new CodeMap(), new DateMap()));
    }

    /**
     *
     * @return HashMap
     */
    public static function cotacoes(){
        self::init();        
        return self::$controller->getBolsa()->getCotacoes();
    }

    public static function buildLinesHtml(ArrayIterator $cot, $anotherType = null){
        $html = "";
        while($cot->valid()){
            $html .="<tr id='".$cot->current()->getCode()."' class='cotation-values'>";
            if($anotherType == null)
                $html .= self::buildLineWithCurrent($cot->current());
            else
                $html .= self::buildLineWithCurrentFisicaOrIndicador($cot->current(), $anotherType);
            $html .= "</tr>";
            $cot->next();
        }        
        return $html;
    }

    public static function buildLineWithCurrent(Cotation $cot){
        $html = "";
        $tdImg = self::buildImgTag($cot->getImage())."<a class='open-chart-window'>".$cot->getMonth()."</a>";
        $html .= self::buildTD($tdImg);
        $html .= self::buildTD($cot->getLast());

        $class = $cot->getDiff() >= 0 ? "positive" : "negative";

        $html .=self::buildTD($cot->getDiff(), $class);
        
        $html .= self::buildTD($cot->openContracts());


        return $html;
    }

    public static function buildLineWithCurrentFisicaOrIndicador(Cotation $cot, $bool){
        $html = "";
        $tdImg = self::buildImgTag($cot->getImage())."<a class='open-chart-window'>".$cot->getName()."</a>";

        if($bool)
            $html .= self::buildTD($tdImg, "first-arabica");
        else
            $html .= self::buildTD($tdImg, "first-indicador");
        
        $html .= self::buildTD($cot->getLast());

        $class = $cot->getDiff() >= 0 ? "positive" : "negative";

        $html .= self::buildTD($cot->getDiff(), $class);
        
        $html .= self::buildTD($cot->getClose());

        return $html;
    }

    public static function buildTD($content, $class = null){
        $td = "<td";
        if($class != null)
            $td .= " class = '$class'";
        $td .= ">";
        $td.= $content;
        $td .= "</td>";
        return $td;
    }

    private static function buildImgTag($img){
        $image = "<img src='".LinkController::getBaseURL()."/images/".$img."' alt=''/> ";
        return $image;
    }
    
}
?>
