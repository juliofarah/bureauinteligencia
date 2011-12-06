<?php
/**
 * Description of ProvideLondon
 *
 * @author ramon
 */
class ProvideLondon extends Provider {

    public function provideObject(DateMap $map) {
        return new London($map);
    }
}
?>
