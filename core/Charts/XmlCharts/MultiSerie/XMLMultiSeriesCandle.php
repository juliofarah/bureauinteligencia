<?php
/**
 * Description of XMLMultiSeriesCandle
 *
 * @author ramon
 */
class XMLMultiSeriesCandle extends XmlMultiSeries{
    
    public function setValues(ArrayObject $values, $toDataset){
        $iterator = $values->getIterator();
        while($iterator->valid()){
            $current = $iterator->current();
            if(!isset ($current['volume']))
                $this->setValue($toDataset, $current['open'], $current['hight'], $current['low'], $current['close'], $current['x']);
            else
                $this->setValue($toDataset, $current['open'], $current['hight'], $current['low'], $current['close'], $current['x'], $current['volume']);
            $iterator->next();
        }
    }
    
    public function setValue($toDataset, $open, $high, $low, $close, $x, $volume = null){
        if($this->verifyIfDatasetExistsAndReturnIt($toDataset) == null){
            $this->newDataset($toDataset);
        }
        $dataset = $this->getDataset($toDataset);
        $set = $dataset->addChild("set");
        $set->addAttribute("open", $open);
        $set->addAttribute("high", $high);
        $set->addAttribute("low", $low);
        $set->addAttribute("close", $close);
        $set->addAttribute("x", $x);
        if($volume != null)
            $set->addAttribute ("volume", $volume);
    }
    
    /**
     *
     * @param type $index
     * @param type $seriesname
     * @return SimpleXMLElement 
     */
    public function getSettag($index, $seriesname){
        $dataset = $this->getDataset($seriesname);
        $children = $dataset->children()->set;
        foreach($children as $set){
            if($set['x'] == $index){
                return $set;
            }
        }
        return null;
    }
    
   public function addAttributeToASet($attribute, $value, $index, $seriesname){
       $set = $this->getSettag($index, $seriesname);
       if($set != null){
           $set->addAttribute($attribute, $value);
       }
   }
}

?>
