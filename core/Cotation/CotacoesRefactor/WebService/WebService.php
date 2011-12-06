<?php
/**
 * Description of WebService
 *
 * @author RAMONox
 */
class WebService {

    private $json;

    public function WebService(){        
    }

    public function setJson($json){
        $this->json = $json;
    }


    public function editArqJson(){
        $fp = fopen("../cotacoes.json", "w");
        fwrite($fp, $this->json);
        fclose($fp);
    }
}

?>
