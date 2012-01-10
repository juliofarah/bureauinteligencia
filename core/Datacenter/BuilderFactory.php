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
            case 'spreadsheet': return new TableExcelBuilder(new MapToExcel(), rand(0,150000)); break;
            case 'table': return new TableJsonBuilder(); break;
            case 'chart': return new ChartBuilder(new XmlMultiSeriesCombinationColumnLine()); break;
            default: throw new WrongTypeException(); break;
        }
    }
}

?>
