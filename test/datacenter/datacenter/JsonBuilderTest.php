<?php
require_once '../../core/Datacenter/JsonBuilder.php';

/**
 * Description of JsonBuilderTest
 *
 * @author Ramon
 */
class JsonBuilderTest extends PHPUnit_Framework_TestCase{
    
    /**     
     * @var JsonBuilder 
     */
    private $jsonBuilder;
    
    public function setUp(){
       $this->jsonBuilder = new JsonBuilder(); 
    }
    
    /**
     * @test
     */
    public function addParam(){
        $attributeName = "test";
        $attributeContent = "testContent";
        $this->jsonBuilder->add($attributeName, $attributeContent);
        $this->assertEquals($this->simpleJson(),$this->jsonBuilder->render());
    }
    
    /**
     * @test
     */
    public function addDoubleParamWithSameName(){
        $attributeName = "test";
        $attributeContent = "testContent";
        $attributeContent2 = "testContent2";
        $this->jsonBuilder->add($attributeName, $attributeContent);
        $this->jsonBuilder->add($attributeName, $attributeContent2);
        $this->assertEquals(str_replace("Content\"","Content2\"",$this->simpleJson()),
                $this->jsonBuilder->render());
    }
    
    /**
     * @test
     */
    public function addListOfParams(){
        $attributeName = "params";
        $attributeContent = array("content1","content2","content3");
        $attributeChildrenName = "th";
        $this->jsonBuilder->addMultipleValues($attributeName, $attributeChildrenName, $attributeContent);
        $this->assertEquals($this->multJson(),$this->jsonBuilder->render());        
    }
    
    /**
     * @test
     */
    public function addDifferentParams(){
        $this->jsonBuilder->add("variety", "v1");
        $this->jsonBuilder->add("type", "t1");
        $this->jsonBuilder->add("origin", "o1");
        $this->jsonBuilder->add("destiny", "d1");
        $json = '{"variety":"v1","type":"t1","origin":"o1","destiny":"d1"}';
        $this->assertEquals($json,
                $this->jsonBuilder->render());
        $this->jsonBuilder->addMultipleValues("values","value",array(1,2,3));
        $json = str_replace('}', ',"values":[{"value":1},{"value":2},{"value":3}]}', $json);
        $this->assertEquals($json,$this->jsonBuilder->render());
    }
    
    /**
     * @test
     */
    public function addValuesAtRuntime(){
        $this->jsonBuilder->addAttrtibute("test");
        $this->jsonBuilder->addValueToAtt("test","testContent");
        $this->assertEquals($this->simpleJson(),$this->jsonBuilder->render());
    }
    
    private function simpleJson(){
        return '{"test":"testContent"}';
    }
    
    private function multJson(){
        return '{"params":[{"th":"content1"},{"th":"content2"},{"th":"content3"}]}';
    }
}

?>
