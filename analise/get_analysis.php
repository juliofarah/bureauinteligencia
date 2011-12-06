<?php
    require_once '../core/DataBase/Connection.php';
    require_once '../core/User/User.php';
    require_once '../util/Session.php';
    require_once '../util/StringManager.php';
    require_once '../util/Maps/HashMap.php';
    require_once '../core/Link/LinkController.php';

    require_once '../core/Publication/CommentDao.php';
    require_once '../core/Publication/Comment.php';
    require_once '../core/Publication/PublicationHandler.php';
    
    PublicationHandler::connect();    
?>
