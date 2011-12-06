<?php

/**
 * Description of MultiSeriesColumnConfig
 *
 * @author ramon
 */
class MultiSeriesColumnConfig extends MultiSeriesConfig {

    public function MultiSeriesColumnConfig(){
        parent::MultiSeriesConfig(new XmlMultiSerieColumn());
    }
}
?>
