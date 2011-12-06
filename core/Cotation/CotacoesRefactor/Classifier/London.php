<?php
/**
 * Description of London
 *
 * @author ramon
 */
class London extends Cotation {

    public function London(DateMap $map){
        parent::Cotation($map);
        $this->name = "Londres";
        $this->type = "London";
    }

    public function getMonth() {
        return $this->dateMap->getMonth(substr($this->jsonInfo->codigo, 2, 1)).
            "/".substr($this->jsonInfo->codigo, 3);
    }
}
?>
