<?php


/**
 * Description of MultiSeriesCandleConfig
 *
 * @author ramon
 */
class MultiSeriesCandleConfig extends MultiSeriesConfig{

    public function MultiSeriesCandleConfig(){
        parent::MultiSeriesConfig(new XMLMultiSeriesCandle());
    }
    
    public function config(ArrayIterator $cotations){
        $i = 1;
        $date = $cotations->offsetGet(0)->getDate();
        $dateInParts = explode('-', $date);        
        $month = $dateInParts[1];
        while($cotations->valid()){            
            $cot = $this->returnCotation($cotations->current());            
            $currentMonth = $this->getCurrentMonth($cot->getDate());
            if($this->monthIsDiferent($currentMonth, $month)){
                $month = $currentMonth;
                $this->multiSeries->addCategory($this->translateMonth($month));
                $this->multiSeries->addCategoryAttribute($this->translateMonth($month), "x", $i);
            }
            $this->multiSeries->setValue(
                    "all_values", 
                    $cot->getOpen(), 
                    $cot->getMax(), 
                    $cot->getMin(),
                    $cot->getClose(),
                    $i);
            $this->addTextToTooltipInASet('all_values', $i, $cot);
            $i++;
            $cotations->next();
        }
    }
    
    private function addTextToTooltipInASet($seriesname, $index, Cotation $cotation){
        $text = "Abertura: ".$cotation->getOpen();
        $text .= "\nFechamento: ".$cotation->getClose();
        $text .= "\nMaximo: ".$cotation->getMax();
        $text .= "\nMinimo: ".$cotation->getMin();
        $text .= "\nData: ".$cotation->getDate();
        $this->multiSeries->addAttributeToASet("tooltext", $text, $index, $seriesname);
    }
    
    private function translateMonth($index){
        $months = array(
            "01" => "Janeiro",
            "02" => "Fevereiro",
            "03" => "Março", 
            "04" => "Abril",
            "05" => "Maio",
            "06" => "Junho",
            "07" => "Julho",
            "08" => "Agosto",
            "09" => "Setembro",
            "10" => "Outuburo",
            "11" => "Novembro",
            "12" => "Dezembro"
        );
        
        return $months[$index];
    }
    
    private function getCurrentMonth($currentDate){
        $date = explode("-", $currentDate);
        $currentMonth = $date[1];        
        return $currentMonth;
    }
    
    private function monthIsDiferent($currentMonth, $fixedMonth){
        return ($currentMonth != $fixedMonth);
    }
}

?>
