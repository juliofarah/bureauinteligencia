<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ServiceTest
 *
 * @author Ramon
 */
class ServiceTest extends PHPUnit_Framework_TestCase{
    //put your code here
    
    /**
     * @test
     */
    public function service(){
        $stack = array();
        $this->assertEquals(0, count($stack));
    }
}

?>
