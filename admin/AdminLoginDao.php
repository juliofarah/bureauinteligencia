<?php
/**
 * Description of AdminLoginDao
 *
 * @author ramon
 */
class AdminLoginDao {

    /**
     * @var PDO
     */
    private $session;

    public function AdminLoginDao(PDO $session){
        $this->session = $session;
    }

    /**
     * @param AdminUser $admin
     * @return AdminUser
     */
    public function getToLogin(AdminUser $admin){
        $statement = "SELECT id, name, username FROM user
            WHERE username = :username AND password = :password LIMIT 1";
        $query = $this->session->prepare($statement);
        $query->bindParam(':username', $admin->username());
        $query->bindParam(':password', $admin->password());
        $query->execute();

        if($query->rowCount() > 0){
            $response = $query->fetch(PDO::FETCH_ASSOC);
            return new AdminUser($response['username'], $response['name'], null, $response['id']);
        }
        return null;
    }
}
?>
