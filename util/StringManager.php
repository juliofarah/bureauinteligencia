<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of StringManager
 *
 * @author RAMONox
 */
class StringManager {

    private static $SPECIAL = array("á","à","ã","â","ä","é","è","ê","ë","í","ì","î","ï","ó","ò","õ","ô","ö","ú","ù","û","ü","ç");
    private static $NORMAL =  array("a","a","a","a","a","e","e","e","e","i","i","i","i","o","o","o","o","o","u","u","u","u","c");
    private static $FORBIDDEN = array("ª","º","°","[","]","{","}","/","?",";",":",".",",","<",">","~","^","`","´","=","-","_","+",
        "§","(",")","*","&","¨","%","$","#","@","!","£","¢","¬","\"","'","\\","|", "'", "€");

    private static $FORBIDDEN2 = array("ª","º","°","[","]","{","}","/","?",";",":",",","<",">","~","^","`","´","=","-","_","+",
        "§","(",")","*","&","¨","%","$","#","@","!","£","¢","¬","\"","'","\\","|", "'", "€");


    private static $SEPECIAL_LINK = array("%C3%A1", "%C3%A0", "%C3%A3", "%C3%A2", "%C3%A4 ");
    
    public function removeSpecialsCharsFrom($string){
        $string = str_replace(self::$SPECIAL, self::$NORMAL, str_replace(self::$FORBIDDEN, "", $string));
        return $string;
    }

    public static function removeSpecialChars($string){
        
        $string = str_replace(self::$SPECIAL, self::$NORMAL, str_replace(self::$FORBIDDEN2, "", $string));
        return $string;
    }

    public function removeCodesOfGetRequests($string){
        
    }
}
?>
