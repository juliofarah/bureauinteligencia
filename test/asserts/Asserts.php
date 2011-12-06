<?php
    function assertEquals($value, $expected){
        if(!assertTrue($value == $expected)){
            echo " <strong>Should be</strong> [$expected]";
            echo " <strong>but found</strong> [";
            echo highlitesDifferentWords($expected, $value);
            echo "]";
        }
    }
    
    function assertTrue($value){
        if($value){
            printAssert ('green', "O teste passou!");
            return true;
        }
        printAssert ('red', "O teste n&atilde;o passou!");
        return false;
    }

    function printAssert($color, $message){
        echo "<strong style='color: $color'>$message</strong><br />";
    }
    
    function highlitesDifferentWords($expected, $value){
        $expectedLength = strlen($expected);       
        $var = array();
        for($i = 0; $i < $expectedLength; $i++){
            if(isset ($value[$i])){
                //echo "<br /><br />".$value[$i]. " - ".$expected[$i]."|| equals? = ".($value[$i] == $expected[$i])."<br />";
                if($value[$i] != $expected[$i]){
                    $letter = $value[$i];                    
                    $string = "<span style='color: red'>".$letter."</span>";                
                    array_push($var, $string);
                }else{
                    array_push($var, $value[$i]);
                }
            }            
        }
        if($i < strlen($value)){
            for($j = $i; $j < strlen($value); $j++){
                array_push($var, "<span style='color: red'>".$value[$j]."</span>");
            }
        }            
        return turnArrayToString($var);
    }
    
    function turnArrayToString(array $array){        
        $string = "";
        for($i = 0; $i < sizeof($array); $i++){
            $string .= $array[$i];
        }
        return $string;
    }

?>
