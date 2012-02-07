<?php
/**
 * Description of XMLMultiSeries
 *
 * @author ramon
 */
abstract class XmlMultiSeries extends XmlChart {

    /**
     * @var SimpleXMLElement 
     */
    protected $categories;  

    public function XmlMultiSeries(){
        parent::XmlChart();
        $this->configChartParams();
    }

    private function configChartParams(){
        $this->root->addAttribute("bgColor", "FFFFFF");
    }

    public function addCategories(ArrayObject $categoriesName){
        $itCategoriesName = $categoriesName->getIterator();
        while($itCategoriesName->valid()){
            $this->addCategory($itCategoriesName->current());
            $itCategoriesName->next();
        }
    }

    public function addCategoriesAttribute($name, $value){
        $this->categories()->addAttribute($name, $value);
    }
    
    public function addCategory($cattegoryName){
        $categories = $this->categories();
        $categories->addChild("category")->addAttribute("label", $cattegoryName);
    }
    
    public function addCategoryAttribute($label, $attribute, $attributeValue){
        $categories = $this->categories();
        $allCategory = $categories->children()->category;
        
        foreach($allCategory as $category){
            if($category['label'] == $label){
                $category->addAttribute($attribute, $attributeValue);
            }
        }
    }
    
    /**
     * @return SimpleXMLElement
     */
    private function categories(){
        if ($this->categories == null){
            $this->categories = $this->root->addChild("categories");
        }
        return $this->categories;
    }

    public function setValues(ArrayObject $values, $toDataset){
        $itValues = $values->getIterator();        
        while($itValues->valid()){            
            $this->setValue($itValues->current(), $toDataset);
            $itValues->next();
        }
    }

    public function setValue($value, $toDataset){
        if($this->verifyIfDatasetExistsAndReturnIt($toDataset) == null){
            $this->newDataset($toDataset);
        }        
        $dataset = $this->getDataset($toDataset);        
        $dataset->addChild("set")->addAttribute("value", $value);
    }

    public function setColorToDataset($seriesName, $color){
        $dataset = $this->getDataset($seriesName);        
        if($dataset != null){
            $dataset->addAttribute("color", $color);
        }
    }
    
    public function renderDatasetAsLine($seriesName){
        $dataset = $this->getDataset($seriesName);
        if($dataset != null){
            if(!$this->attributeExists($dataset->attributes(), "renderAs"))
                $dataset->addAttribute("renderAs", "Line");
        }
    }
    /**
     * @return SimpleXMLElement
     */
    protected function getDataset($seriesName){
        return $this->verifyIfDatasetExistsAndReturnIt($seriesName);
    }
    
    /**     
     * @param <type> $datasetName
     * @return SimpleXMLElement
     */
    protected function verifyIfDatasetExistsAndReturnIt($seriesName){
        $children = $this->root->children();
        $datasets = $children->dataset;
        $datasetSearched = null;
        
        foreach($datasets as $dataset){
            if($dataset['seriesName'] == $seriesName)
                $datasetSearched = $dataset;
        }
        return $datasetSearched;        
    }
    
    public function newDataset($seriesName){
        $dataset = $this->verifyIfDatasetExistsAndReturnIt($seriesName);
        if($dataset == null){
            $this->root->addChild("dataset")->addAttribute("seriesName", $seriesName);
        }        
    }
    
    protected function attributeExists($attributes, $att){
        foreach($attributes as $attName => $attValue){            
            if($attName == $att)
                return true;
        }
        return false;
    }
    
}
?>
