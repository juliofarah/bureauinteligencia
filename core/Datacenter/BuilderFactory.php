<?php
/**
 * Description of BuilderFactory
 *
 * @author Ramon
 */
class BuilderFactory {

    /**     
     * @param string $type
     * @return Builder 
     */
    public function getBuilder($type){
        switch($type){
            case 'table': return new TableBuilder(); break;
            case 'chart': return new ChartBuilder(new XmlMultiSeriesCombinationColumnLine()); break;
            default: throw new WrongTypeException(); break;
        }
    }
}

?>
