<?php
/**
 * Description of RSSReader
 *
 * @author RAMONox
 */
class RSSReader {

    /**
     *
     * @var SimpleXMLElement
     */
    private $rss;

    /**     
     * @var ArrayIterator
     */
    private $items;

    public function RSSReader(SimpleXMLElement $rss){
        $this->rss = $rss;        
    }

    /*public function getRss(){
        print_r($this->rss);
    }*/

    private function rssItemsToMap(){
        if($this->map->isEmpty())
            $i = 0;
        else
            $i = $this->map->size()+1;

        foreach($this->rss->channel->item as $item){
            $itemMap = new HashMap();
            $itemMap->put("title", $item->title);
            $itemMap->put("link", $item->link);
            $itemMap->put("pubDate", $item->pubDate);
            $itemMap->put("description", $item->description);
            $this->map->put($i++, $itemMap);
        }
    }

    private function setItems(){
        $this->items = new ArrayIterator();
        foreach($this->rss->channel->item as $onlyItem){
            $item = new RssItem($onlyItem->title, $onlyItem->link, $onlyItem->pubDate, $onlyItem->description);
            $this->items->append($item);
        }
    }

    public function rssFont(){                
        return $this->rss->channel->title;
    }
    
    public function rssfontDescription(){
        return $this->rss->channel->description;
    }
    /**
     * @return ArrayIterator
     */
    public function getRss(){
        $this->setItems();
        return $this->items;
    }

    /**
     * @return RssItem
     */
    public function getRssWeahter(){
        $item = $this->rss->channel->item;
        $rssItem = new RssItem($item->title, $item->link, $item->pubDate, $item->description);
        return $rssItem;
    }
}
?>
