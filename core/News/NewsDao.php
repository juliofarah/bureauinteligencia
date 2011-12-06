<?php
class NewsDao {
    /**
     * @var PDO
     */
    private $session;


    public function NewsDao(PDO $session){
        $this->session = $session;
    }

    public function delete($id){
        $statement = "DELETE FROM news_rss WHERE id = :id LIMIT 1";
        $query = $this->session->prepare($statement);
        $query->bindParam(":id", $id);
        $query->execute();
        return $query->rowCount() > 0;
    }

    public function save(NewRSS $news){
        $statement = "INSERT INTO news_rss (title, link, position) VALUES (:title, :link, :position)";
        try{
            $position = $this->total()+1;
            $query = $this->session->prepare($statement);
            $query->bindParam(":title", $news->title());
            $query->bindParam(":link", $news->link());
            $query->bindParam(":position", $position);
            $query->execute();
        }catch(PDOException $err){
            throw new PDOException($err->getMessage());
        }
    }
    
    public function updatePositions(ArrayObject $listNewsRss){
        foreach($listNewsRss as $news){
            $this->updateNewsRssPositions($news);
        }
    }
    
    public function updateNewsRssPositions(NewRSS $rss){
        $sql = "UPDATE news_rss SET position = :position WHERE Id = :id";
        $query = $this->session->prepare($sql);
        $query->bindParam(":position", $rss->position());
        $query->bindParam(":id", $rss->id());
        $query->execute();        
    }

    /**
     * @return ArrayObject
     */
    public function listAll(){
        $statement = "SELECT id, title, link FROM news_rss ORDER BY position ASC";
        $query = $this->session->prepare($statement);
        try{
            $query->execute();
            if($query->rowCount() > 0){
                return $this->buildArrayNews($query->fetchAll(PDO::FETCH_ASSOC));
            }
            return new ArrayObject();
        }catch(PDOException $err){
            throw new PDOException($err->getMessage());
        }
    }
    
    
    /**
     * @param <type> $underLimit
     * @param <type> $maxValues
     * @return ArrayObject
     */
    public function getAll($underLimit, $maxValues){
        $limit = $underLimit.",". $maxValues;
        $statement = "SELECT id, title, link, position FROM news_rss ORDER BY position ASC";// LIMIT ".$limit;
        $query = $this->session->prepare($statement);

        try{
            $query->execute();
            $results = $query->fetchAll(PDO::FETCH_ASSOC);
            if($query->rowCount() > 0){
                return $this->buildArrayNews($results);
            }
            return new ArrayObject();
        }catch(PDOException $err){
            throw new PDOException($err->getMessage());
        }
    }

    /**
     * @param array $result
     * @return ArrayObject
     */
    private function buildArrayNews($result){
        $arrayNews = new ArrayObject();
        foreach($result as $row){           
            $arrayNews->append($this->buildNew($row));
        }
        return $arrayNews;
    }

    private function buildNew($new){
        if(isset ($new['position']))
            $newsRSS = new NewRSS($new['title'], $new['link'], $new['position']);
        else
            $newsRSS = new NewRSS($new['title'], $new['link']);
        $newsRSS->setId($new['id']);
        return $newsRSS;
    }
    
    public function total(){
        $statement = "SELECT COUNT(*) AS total FROM news_rss";
        $query = $this->session->prepare($statement);
        try{
            $query->execute();
            $result = $query->fetch(PDO::FETCH_ASSOC);
            return $result['total'];
        }catch(PDOException $err){
            throw new PDOException($err->getMessage());
        }
    }

    /**
     *
     * @param <type> $id
     * @return NewRSS
     */
    public function get($id){
        $statement = "SELECT id, title, link FROM news_rss WHERE id = :id LIMIT 1";
        $query = $this->session->prepare($statement);
        $query->bindParam(":id", $id);
        try{
            $query->execute();
            if($query->rowCount() > 0){
                return $this->buildNew($query->fetch(PDO::FETCH_ASSOC));
            }
            return null;
        }catch(PDOException $err){
            throw new PDOException($err->getMessage());
        }
    }
}
?>
