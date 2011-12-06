<?php
/**
 * Description of File
 *
 * @author ramon
 */
class File {

    private $file;

    private $name;

    public function File($file = null, $name = null){
        $this->file = $file;
        $this->name = $name;
    }

    public function getName(){
        return $this->name;
    }
    
    public function getType(){
        return $this->file['type'];
    }

    public function name(){        
        return $this->formatName($this->file['name']);
    }

    public function save($dir){
        $destinity = $dir.$this->name();
        if(file_exists($dir)){
            if(file_exists($destinity)){
               $this->file['name'] = rand(0, 100000)."_".$this->file['name'];
               $destinity = $dir.$this->name();
            }
            if(move_uploaded_file($this->file['tmp_name'], $destinity))
                return true;
            return false;
        }
        throw new Exception("Diretório não existente!");
    }

    private function formatName($name) {
        return StringManager::removeSpecialChars($name);
    }

    public function toArray(){
        return array("simplename" => $this->name);
    }

    public function toJson(){
        return json_encode($this->toArray());
    }
}
?>
