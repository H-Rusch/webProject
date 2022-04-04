<?php

/**
 * Username has to be a string of 3 to 16 letters and numbers
 * @param $username string to be tested
 * @return bool information whether it is a valid username
 */
function validateUsername(string $username): bool {
    if (isset($username) and is_string($username) and preg_match('/^[a-zA-Z0-9]{3,16}$/', $username)) {
        return true;
    }
    return false;
}

/**
 * Password has to be a string
 * @param $password string to be tested
 * @return bool information whether it is a valid password
 */
function validatePassword(string $password): bool {
    if (isset($password) and is_string($password)) {
        return true;
    }
    return false;
}

/**
 * Check given email address
 * @param $email string to be tested
 * @return bool information whether it is a valid email
 */
function validateEMail(string $email): bool {
    if (isset($email) and is_string($email) and filter_var($email, FILTER_VALIDATE_EMAIL)) {
        return true;
    }
    return false;
}

