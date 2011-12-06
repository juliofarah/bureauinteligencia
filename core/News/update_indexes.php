<?php
    
    $indexes = $_POST['indexes'];
    $ids = $_POST['ids'];
    
    require_once 'NewsController.php';
    require_once 'NewsDao.php';
    require_once 'NewRSS.php';
    
    $controller = new NewsController(new NewsDao(Connection::connect()));
    $listNews = new ArrayObject();
    
    foreach($ids as $i => $id){
        $news = new NewRSS(null, null, $indexes[$i]);
        $news->setId($id);
        $listNews->append($news);
    }
    
    $controller->updatePositions($listNews);
    
?>


