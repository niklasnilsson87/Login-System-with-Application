<?php

namespace Application\Model;

class SessionStore
{
  private static $SESSION_RUN = __CLASS__ . "::RUN";
  private static $SESSION_RUN_ID = __CLASS__ . "::RUN_ID";
  private static $SESSION_RUN_DISTANCE = __CLASS__ . "RUN_DISTANCE";
  private static $SESSION_RUN_TIME = __CLASS__ . "RUN_TIME";
  private static $SESSION_RUN_date = __CLASS__ . "RUN_date";
  private static $SESSION_SAVED_MESSAGE = __CLASS__ . "SAVED_MESSAGE";

  public function hasStoredRun(): bool
  {
    return isset($_SESSION[self::$SESSION_RUN]);
  }

  public function saveSessionRun(\Application\Model\Run $run)
  {
    $_SESSION[self::$SESSION_RUN_ID] = $run->getID();
    $_SESSION[self::$SESSION_RUN_DISTANCE] = $run->getDistance();
    $_SESSION[self::$SESSION_RUN_TIME] = $run->getTime();
    $_SESSION[self::$SESSION_RUN_date] = $run->getdate();
    $this->setRunState(true);
  }

  public function setRunState(bool $bool): void
  {
    $_SESSION[self::$SESSION_RUN] = $bool;
  }

  public function getID(): string
  {
    return $_SESSION[self::$SESSION_RUN_ID];
  }

  public function getDistance(): string
  {
    return $_SESSION[self::$SESSION_RUN_DISTANCE];
  }

  public function getTime(): string
  {
    return $_SESSION[self::$SESSION_RUN_TIME];
  }

  public function getdate(): string
  {
    return $_SESSION[self::$SESSION_RUN_date];
  }

  public function saveMessage(string $message): void
  {
    $_SESSION[self::$SESSION_SAVED_MESSAGE] = $message;
  }

  public function hasStoredMessage(): bool
  {
    return isset($_SESSION[self::$SESSION_SAVED_MESSAGE]);
  }

  public function getStoredMessage(): string
  {
    return $_SESSION[self::$SESSION_SAVED_MESSAGE];
  }

  public function unsetSession(): void
  {
    unset($_SESSION[self::$SESSION_RUN]);
    unset($_SESSION[self::$SESSION_RUN_ID]);
    unset($_SESSION[self::$SESSION_RUN_DISTANCE]);
    unset($_SESSION[self::$SESSION_RUN_TIME]);
    unset($_SESSION[self::$SESSION_RUN_date]);
  }

  public function unsetMessage(): void
  {
    unset($_SESSION[self::$SESSION_SAVED_MESSAGE]);
  }
}
