<?php
/**
 * Description of ProvideNewYork
 *
 * @author ramon
 */
class ProvideNewYork extends Provider {

    public function provideObject(DateMap $map) {
        return new NewYork($map);
    }
}
?>
