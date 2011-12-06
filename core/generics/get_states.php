<?php
    require_once 'Controller.php';
    require_once 'GenericDao.php';
    require_once 'State.php';

    $controller = new Controller(new GenericDao(Connection::connect()));
    header('Content-type: application/json');
    print_r($controller->states());
?>
