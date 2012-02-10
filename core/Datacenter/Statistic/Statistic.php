<?php
/**
 * This class calculates average, variance and standard deviation. All you must to do 
 * to get the results is pass an ArrayIterator to the method you want.
 *
 * @author Ramon
 */
class Statistic {
   
    public function Statistic(){        
    }
    
    public function getMedian($arrayValues) {
        if($arrayValues instanceof ArrayIterator)
            $arrayValues = $arrayValues->getArrayCopy();
        $totalNumbers = sizeof($arrayValues);
        sort($arrayValues);
        if($this->isEven($totalNumbers)){
            $medianUpperPosition = $totalNumbers/2;
            $medianLowerPosition = $medianUpperPosition - 1;
            $firstNumber = $arrayValues[$medianLowerPosition];
            $secondNumber = $arrayValues[$medianUpperPosition];
            return round(($firstNumber + $secondNumber)/2,2);
        }elseif($this->isOdd($totalNumbers)){
            $medianPosition = (($totalNumbers+1)/2)-1;
            return round($arrayValues[$medianPosition],2);
        }
    }
    
    private function isEven($numberOfItems){
        return $numberOfItems % 2 == 0;
    }
    
    private function isOdd($numberOfItems){
        return $numberOfItems % 2 == 1;
    }
    
    public function average(ArrayIterator $values){
        $sum = 0;
        while($values->valid()){
            $sum += $values->current();
            $values->next();
        }
        $values->rewind();
        return round($sum/$values->count(),2);
    }
    
    public function populationStandardDeviation(ArrayIterator $values){
        return round(sqrt($this->populationVariance($values)),2);
    }
    
    public function sampleStandardDeviation(ArrayIterator $values){        
        return round(sqrt($this->sampleVariance($values)),3);
    }
    
    public function populationVariance(ArrayIterator $values){
        $sumVariance = $this->variance($values); 
        return round($sumVariance/$values->count(), 2);
    }
    
    private function variance(ArrayIterator $values){
        $average = $this->average($values);
        $sumVariance = 0;
        while($values->valid()){          
            $sumVariance += pow(($values->current() - $average), 2);
            $values->next();
        }
        return $sumVariance;
    }
    
    public function sampleVariance(ArrayIterator $values){
        $sumVariance = $this->variance($values);
        return round($sumVariance/($values->count()-1),2);
    }
}
?>
