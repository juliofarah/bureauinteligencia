<div>
    Aguarde...
</div>
<?    
    require_once 'core/Login/LoginController.php';
    require_once 'core/User/UserDao.php';
    //require_once 'core/User/User.php';    


    $loginController = new LoginController(new UserDao(Connection::connect()));
    try{
        if($loginController->login($_POST['username'], $_POST['password'])){            
            header("Location: ".Config::get('baseurl'));
        }else{
            header("Location: ".Config::get('baseurl').'index?login-fail=true');
        }
    }catch(PDOException $err){
        die($err->getMessage());
    }
?>