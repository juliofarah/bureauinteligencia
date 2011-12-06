<?php
/**
 * Description of ProvideEuroCom
 *
 * @author ramon
 */
class ProvideEuroCom extends Provider {

    public function provideObject(DateMap $map) {
        return new EuroCom($map);
    }
}
?>
