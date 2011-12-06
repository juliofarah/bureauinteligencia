<?php
/**
 * Description of ProvideArabica
 *
 * @author ramon
 */
class ProvideArabica extends Provider {

    public function provideObject(DateMap $map) {
        return new Arabica($map);
    }
}
?>
