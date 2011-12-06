<?php
/**
 * Description of LoginController
 *
 * @author RAMONox
 */
class LoginController {

    /**     
     * @var UserDao 
     */
    private $userDao;

    public function LoginController(UserDao $dao){
        $this->userDao = $dao;
    }

    /**     
     * @param <type> $username
     * @param <type> $password
     * @return boolean
     */
    public function login($username, $password){
        $user = new User(null, $username, $password);        
        $user = $this->userDao->get($user);                        
        if($user != null){
            Session::login($user);
            setcookie('Bureau_PosicaoApps', '', time()-3600);
            //setcookie('Bureau_PosicaoApps', "publicacoes|noticias|videoteca", time() + 3600);
            setcookie('Bureau_PosicaoApps', $user->getPositions(), time() + 3600);
            setcookie('Bureau_AppsMinimizados', "0", Config::get('tempo_vida_cookie'));
            setcookie('logged', '1', time() + 10);
            return true;
        }
        return false;
    }  

    public function logout(){
        //session_destroy();
        //session_write_close();
        Session::logout();
    }
}
?>
