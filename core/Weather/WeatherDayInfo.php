<?php
/**
 * Description of WeatherDayInfo
 *
 * @author RAMONox
 */
class WeatherDayInfo {

    private $day;

    private $min;

    private $max;

    private $prec;

    private $situation;


    public function WeatherDayInfo($day, $min, $max, $prec, $situation){
        $this->day = $day;
        $this->min = $min;
        $this->max = $max;
        $this->prec = $prec;
        $this->situation = $situation;
    }

    public function day(){
        return $this->day;
    }

    public function min(){
        return $this->min;
    }

    public function max(){
        return $this->max;
    }

    public function precptation(){
        return $this->prec;
    }

    public function situation(){
        return $this->situation;
    }

    public function imageSituation(){
        $img = "";        
        switch (trim($this->situation)){
            case "Céu Claro"          : $img = "<img src='imgs/cli_ceuclaro.gif' class='margem' align='left'>"; break;
            case "Chuvas"             : $img =  "<img src='imgs/cli_chuvas.gif' class='margem' align='left'>"; break;
            case "Encoberto"          : $img =  "<img src='imgs/cli_encoberto.gif' class='margem' align='left'>"; break;
            case "Nublado"            : $img =  "<img src='imgs/cli_nublado.gif' class='margem' align='left'>"; break;
            case "Nublado com Chuvas" : $img =  "<img src='imgs/cli_pancadas.gif' class='margem' align='left'>"; break;
            case "Pancadas"           : $img =  "<img src='imgs/cli_pancadas.gif' class='margem' align='left'>"; break;
            case "Pancadas Isoladas"  : $img =  "<img src='imgs/cli_pancadasisoladas.gif' class='margem' align='left'>"; break;
            case "Poucas Nuvens" : $img =  "<img src='imgs/cli_poucasnuvens.gif' class='margem' align='left'>"; break;
        }
        return str_replace(">", " title='".$this->situation."' >", $img);
    }
}
?>
