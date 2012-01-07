<?php
require_once '../../core/Datacenter/BuilderFactory.php';
require_once '../../core/Exceptions/WrongTypeException.php';
/**
 * Description of DatacenterBuilderFactoryTest
 *
 * @author Ramon
 */
class DatacenterBuilderFactoryTest extends PHPUnit_Framework_TestCase{
   
    /**
     * @test
     */
    public function getRightObjectAccordingToParam(){
        $factory = new BuilderFactory();
        $this->assertTrue($factory->getBuilder("table") instanceof TableJsonBuilder);
        $this->assertTrue($factory->getBuilder("chart") instanceof ChartBuilder);
    }    
        
    /**
     * @test
     */
    public function exceptionBuilder(){
        $this->setExpectedException('WrongTypeException');
        $factory = new BuilderFactory();
        $factory->getBuilder("xxx");
        $this->fail("Should have been thrown an 'WrongTypeException' cause this type does not exists");
    }
}

?>
