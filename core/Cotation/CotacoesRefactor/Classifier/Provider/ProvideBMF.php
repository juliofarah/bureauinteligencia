<?php
/**
 * Description of ProvideBMF
 *
 * @author ramon
 */
class ProvideBMF extends Provider {

    public function provideObject(DateMap $map) {
        return new BMF($map);
    }
}
?>
