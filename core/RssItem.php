<?php

/**
 * Description of RssItem
 *
 * @author RAMONox
 */
class RssItem {

    private $title;
    private $link;
    private $publicationDate;
    private $description;
    
    public function RssItem($title, $link, $publicationDate, $description){
        $this->title = $title;
        $this->link = $link;
        $this->publicationDate = $publicationDate;
        $this->description = $description;
    }

    public function title(){
        return $this->title;
    }

    public function link(){
        return $this->link;
    }

    public function pubDate(){                
        if($this->publicationDate != "")
            //return date('d/m/Y : H:i:s', strtotime(substr(trim($this->publicationDate), 0, -5)));
            return date('d/m/Y : H:i:s', strtotime(trim($this->publicationDate)));
        return " - ";
    }

    public function description(){
        return $this->description;
    }
}
?>
