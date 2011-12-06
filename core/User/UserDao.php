<?php
class UserDao {
    /**
     * @var PDO
     */
    private $session;

    public function UserDao(PDO $session){
        $this->session = $session;
    }

    /**
     * @param User $user
     * @return User 
     */
    public function get(User $user){
        $statement = "SELECT name, username, positions, email FROM users WHERE username = :username AND password = :password LIMIT 1";
        $query = $this->session->prepare($statement);
        $query->bindParam(":username", $user->username());
        $query->bindParam(":password", $user->password());

        try{
            $query->execute();
            if($query->rowCount() > 0){
                $result = $query->fetch(PDO::FETCH_ASSOC);
                $user = new User($result['name'], $result['username']);
                $user->setPositions($result['positions']);
                $user->setEmail($result['email']);
                return $user;
            }else{
                return null;
            }
        }catch(PDOException $err){
            throw new PDOException($err->getMessage());
        }        
    }

    public function saveConfig(User $user){
        $statement = "UPDATE users SET positions = :pos WHERE username = :username LIMIT 1";
        $query = $this->session->prepare($statement);
        $query->bindParam(":pos", $user->getPositions());
        $query->bindParam(":username", $user->username());
        $query->execute();
        return $query->rowCount() > 0;
    }
    
    public function save(User $user){
        if(!$this->existsUser($user)){
            $sql = "INSERT INTO users (name, username, email, password, positions, city, activity) VALUES 
                (:name, :username, :email, :password, :positions, :city, :activity)";
            $query = $this->session->prepare($sql);
            $query->bindParam(':name', $user->name());
            $query->bindParam(':username', $user->username());
            $query->bindParam(':email', $user->email());
            $query->bindParam(':password', $user->password());
            $query->bindParam(':positions', $user->getPositions());
            $query->bindParam(":city", $user->getCityId());
            $query->bindParam(":activity", $user->getMyActivityId());
            $query->execute();
            return $query->rowCount() == 1;            
        }else{
            throw new Exception("Nome de usuário já foi utilizado");
        }
    }
    
    public function updatePassword(User $user, $newPassword = null){
        $sql = "UPDATE users SET password = :pass WHERE username = :username AND email = :email LIMIT 1";
        $query = $this->session->prepare($sql);
        if($newPassword == null)
            $query->bindParam(":pass", $user->password());
        else
            $query->bindParam (":pass", $newPassword);
        $query->bindParam(":username", $user->username());
        $query->bindParam(":email", $user->email());        
        
        $query->execute();
        if($query->rowCount() > 0){
            $newuser = new User(null, $user->username(), $newPassword);
            return $this->get($newuser);
        }
        return null;
    }
    
    private function existsUser(User $user){
        $sql = "SELECT username FROM users WHERE username = :username";
        $query = $this->session->prepare($sql);
        $query->bindParam(':username', $user->username());
        
        $query->execute();
        
        return $query->rowCount() > 0;
    }
}
?>
