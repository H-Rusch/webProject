<?php

class classUser {
    private $userID = null;
    private $username = null;
    private $email = null;
    private $encodedPassword = null;

    public function __construct($userID, $username, $encodedPassword, $email) {
        $this->userID = $userID;
        $this->username = $username;
        $this->email = $email;
        $this->encodedPassword = $encodedPassword;
    }

    public function setPasswordWithoutValidation($newPassword) {
        $this->encodedPassword = $newPassword;
    }

    public function getID() {
        return $this->userID;
    }

    public function getName() {
        return $this->username;
    }

    public function getEmail() {
        return $this->email;
    }

    public function getPassword() {
        return $this->encodedPassword;
    }
}
?>
