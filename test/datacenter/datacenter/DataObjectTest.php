<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of DataObjectTest
 *
 * @author Ramon
 */
class DataObjectTest extends PHPUnit_Framework_TestCase{
    
    /**
     * @test
     */
    public function turnDataToJson(){
        $subgroup = new Subgroup("subgrupo");
        $font = new Font("fonte");
        $type = new CoffeType("type");
        $variety = new Variety("variety",1);
        $origin = new Country("origin");
        $destiny = new Country("destiny");
        
        $data = new Data(1990, $subgroup, $font, $type, $variety, $origin, $destiny);
        
        $this->assertEquals($this->jsonExpected(), $data->toJson());
    }
    
    private function jsonExpected(){
        $json = '{';
        $json .= '"year":1990,';
        $json .= '"subgroup":{"name":"subgrupo"},';
        $json .= '"font":{"name":"fonte"},';
        $json .= '"type":{"name":"type"},';
        $json .= '"variety":{"id":1,"name":"variety"},';
        $json .= '"origin":{"name":"origin"},';
        $json .= '"destiny":{"name":"destiny"}';
        $json .= '}';
        
        return $json;
    }
}

?>
