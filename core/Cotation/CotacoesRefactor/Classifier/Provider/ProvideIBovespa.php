<?php
/**
 * Description of ProvideIBovespa
 *
 * @author ramon
 */
class ProvideIBovespa extends Provider {

    public function provideObject(DateMap $map) {
        return new IBovespa($map);
    }
}
?>
