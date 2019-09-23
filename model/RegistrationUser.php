<?php

namespace Login\Model;

include_once('Exceptions.php');

class RegistrationUser
{
  private $username;
  private $password;
  private $passwordCheck;

  public function __construct($username, $password, $passwordCheck)
  {
    if (empty($username) && empty($password)) {
      throw new \UsernameAndPasswordEmpty;
    }

    if ($password != $passwordCheck) {
      throw new \PasswordDoesNotMatch;
    }

    $this->username = new \Login\Model\FilterUsername($username);
    $this->password = new \Login\Model\FilterPassword($password);
  }

  public function getUser()
  {
    return $this->username;
  }

  public function getUserPassword()
  {
    return $this->password;
  }
}
