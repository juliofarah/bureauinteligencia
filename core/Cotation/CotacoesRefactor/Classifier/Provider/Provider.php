<?php
/**
 * Description of Provider
 *
 * @author ramon
 */
abstract class Provider {

    public function Provider(){

    }

    /**
     * @param DateMap $map
     * @return Cotation
     */
    public abstract function provideObject(DateMap $map);
}
?>
