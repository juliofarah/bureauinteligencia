<?php
/**
 * Description of PublicationHandler
 *
 * @author ramon
 */
require_once 'PublicationController.php';
require_once 'PublicationDao.php';
require_once 'Publication.php';
require_once 'Paper.php';
require_once 'Analyse.php';
require_once 'File.php';
//require_once '../generics/SubArea.php';

class PublicationHandler {

    private static $connect;

    private static $totalPapers;   
    
    private static $totalAnalysis;
    
    /**     
     * @var PublicationController 
     */
    private static $controller;
    
    public static function connect(){
        self::$connect = Connection::connect();
        self::$controller = new PublicationController(new PublicationDao(self::$connect));        
    }

    /**
     *
     * @param <type> $page
     * @return ArrayObject
     */
    public static function getAllPapers($page){        
        try{
            self::$totalPapers = self::$controller->totalPapers();
            return self::$controller->listAllPapers($page);
        }catch(PDOException $exception){
            echo $exception->getMessage();
        }
    }

    /**     
     * @param type $link
     * @return Analyse 
     */
    public static function getAnAnalysis($link){
        return self::$controller->getAnAnalysis($link);
    }
    
    
    public static function getAllAnalysis($page){
        try{
            self::$totalAnalysis = self::$controller->totalAnalysis();
            return self::$controller->listAllAnalysis($page);
        }catch(PDOException $exception){
            echo $exception->getMessage();
        }
    }
    
    public static function totalPapers(){
        return self::$totalPapers;
    }
    
    public static function totalAnalysis(){
        return self::$totalAnalysis;
    }
    
    
    public static function printListPapers($list){
        echo "<table class='table-papers' border='0'>";        
        echo    "<tbody>";
        foreach($list as $publication){        
            self::printPapers($publication);
        }
        echo    "</tbody>";
        echo "</table>";
    }

    public static function printListAnalysis($list){
        echo "<ul>";
        $i = 0;
        foreach($list as $publication){        
            if($i++ <= 4)
                self::printAnalysis($publication);
        }
        echo "</ul>";        
    }
        
    public static function printPapers(Paper $publication){        
        $html = "<tr>";
        $html .= "<td class='name-paper'>".$publication->title()."</td>";
        $html .= "<td>";
        $html .=    "<a target='_blank' href='".LinkController::getBaseURL()."/publicacao/".$publication->getSimpleFilename()."'>";
        $html .=    "<img class='pdf' title='puclicação' alt='pdf' src='".LinkController::getBaseURL()."/images/pdf-icon.jpg'/>";       
        $html .=    "</a>";
        $html .= "</td>";
        $html .= "</tr>";
        echo $html;
    }

    public static function printAnalysis(Analyse $publication){        
        $html = "<li>";
        $html .= "<span class='date-publication'>[";
        $html .= $publication->getDateFormatted();
        $html .= "]</span>";
        $html .= "<a target='_blank' href='".LinkController::getBaseURL()."/analise/".$publication->link().".html'>";
        $html .= $publication->title();
        $html .= "</a><br />";
        $qtdComments = $publication->getComments()->count();        
        $html .= "<span class='number-comments'>";
        $html .= $qtdComments.' '.($qtdComments == 1 ? "comentário" : "comentários");
        $html .= "</span>";
        $html .= "</li>";
        echo $html;
    }
    
    public static function printComment(Comment $comment){
        $html = "";
        $html .= "<dt>";
        $html .=    "<span class='comment-author'>";
        $html .=        $comment->getWitter()->name();
        $html .=    "</span> disse:";
        $html .= "</dt>";
        
        $html .= "<dd>";
        $html .=    "<p class='text-comment'>";
        $html .=        $comment->text();
        $html .=    "</p>";
        $html .=    "<span class='time-comment'>";
        $html .=        $comment->getFormatedDatetime();
        $html .=    "</span>";
        $html .= "</dd>";
        
        echo $html;
    }
}
?>
