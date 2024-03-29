<?php

namespace Login\Model;

include_once('Exceptions.php');

class FilterPassword
{
  private static $MIN_LENGTH = 6;

  private $password;

  public function __construct(string $toBeFiltered)
  {
    if (empty($toBeFiltered) || strlen($toBeFiltered) < self::$MIN_LENGTH) {
      throw new \PasswordEmpty;
    } else {
      $this->password = $toBeFiltered;
    }
  }

  public function getPassword(): string
  {
    return $this->password;
  }
}
