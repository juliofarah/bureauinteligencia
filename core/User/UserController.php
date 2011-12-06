<?php
/**
 * Description of UserController
 *
 * @author ramon
 */
class UserController {

    /**     
     * @var UserDao 
     */
    private $dao;
    
    public function UserController(UserDao $dao){
        $this->dao = $dao;
    }
    
    public function subscribe(User $user, $confirm_pass){
        if($user->password() == $confirm_pass){
            return $this->dao->save($user);
        }else{
            throw new Exception('Senhas informadas não conferem');
        }
    }
    
    public function newPassword(User $user){                             
        $newPassword = $this->generateNewPassword();
        $newUser = $this->dao->updatePassword($user, $newPassword);
        if($newUser != null){
            $emailController = new EmailController();
            if(!$emailController->sendNewPasswordEmail($newUser, $newPassword)){
                throw new Exception("Falha ao enviar email com a nova senha!");
            }
            return true;
        }
        throw new Exception("Os dados informados não existem no sistema");
    }
    
    private function generateNewPassword(){
        $newPass = rand(0, 10000);        
        return $newPass;
    }
}

?>
