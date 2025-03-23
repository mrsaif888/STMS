<?php
class User {
    public $username;
    public $password;
    public $role;

    public function __construct($username, $password, $role) {
        $this->username = $username;
        $this->password = $password;
        $this->role = $role;
    }
}

class UserFactory {
    public static function createUser($username, $password, $role) {
        // You can customize behavior based on role here
        return new User($username, $password, $role);
    }
}
?>
