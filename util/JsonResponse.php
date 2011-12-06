<?php
/**
 * Description of JsonResponse
 *
 * @author RAMONox
 */
class JsonResponse {

    private $response = array("status" => null, "message" => null);

    private $withoutHeader = false;
    
    public function JsonResponse(){}
    /**
     * @param <type> $status
     * @param <type> $message
     * @return JsonResponse
     */
    public function response($status, $message, $list = false){
        $this->response["status"] = $status;
        $this->response["message"] = $message;
        if($list){
            $this->response['message'] = json_decode($this->response['message']);            
        }
        return $this;
    }

    /**
     * @return JsonResponse
     */
    public function withoutHeader(){
        $this->withoutHeader = true;
        return $this;
    }

    /**
     *
     * @param <type> $param
     * @param <type> $value
     * @return JsonResponse
     */
    public function addValue($param, $value){
        $this->response[$param] = $value;
        return $this;
    }

    public function serialize(){
        if(!$this->withoutHeader)
            header('Content-type: application/json');
        return json_encode($this->response);        
    }

}
?>
