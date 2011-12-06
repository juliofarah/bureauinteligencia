<?php

/**
 * Description of ProvideDolarCom
 *
 * @author ramon
 */
class ProvideDolarCom extends Provider {

    public function provideObject(DateMap $map) {
        return new DolarCom($map);
    }
}
?>
