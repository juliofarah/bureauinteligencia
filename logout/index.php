<?  session_start()?>
<?php
error_reporting(E_ALL);
ini_set('display_errors', '1');

require_once('../Config.class.php');
require_once "../core/Link/LinkController.php";
require_once "../core/Exceptions/LoginException.php";
require_once "../util/Session.php";
require_once '../util/Services_JSON.php';
require_once '../util/StringManager.php';
require_once "../core/User/User.php";
require_once '../core/GenericHandler.php';

?>

<?php           
    setcookie('Bureau_PosicaoApps', '', time()-3600);    
    setcookie('Bureau_PosicaoApps', Config::get('posicao_padrao_apps'), time() + 3600);    
    setcookie('Bureau_AppsMinimizados', "0", Config::get('tempo_vida_cookie'));
    setcookie('logged', '0', time() + 10);    

    Session::logout();    
    header("Location: ".LinkController::getBaseURL()."/?restaurar");
?>