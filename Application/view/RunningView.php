<?php

namespace Application\View;

include_once('ViewContract.php');

class RunningView implements ViewContract
{
  private static $distance = __CLASS__ . '::Distance';
  private static $time = __CLASS__ . '::Time';
  private static $date = __CLASS__ . '::Date';
  private static $submitRun = __CLASS__ . '::SubmitRun';

  private static $editRun;

  private static $msg = '';
  private static $errorMessage = '';

  private $session;

  public function __construct(\Application\Model\SessionStore $sessionStore)
  {
    $this->session = $sessionStore;
  }

  public function response()
  {
    $response = $this->appHeader();
    $response .= $this->renderLink();
    $response .= $this->renderMessage();

    if ($this->userWantsToCreateRun()) {
      if ($this->userWantsToSubmitRun() && strlen(self::$errorMessage) > 0) {
        $response .= $this->generateRunningForm();
        return $response;
      } else if (!$this->userWantsToSubmitRun()) {
        $response .= $this->generateRunningForm();
        return $response;
      }
    }

    if (strlen(self::$errorMessage) > 0) {
      $response .= $this->generateRunningForm();
      return $response;
    }

    if ($this->userWantsToEditRun()) {
      $response .= $this->generateRunningForm();
    }

    return $response;
  }

  private function appHeader(): string
  {
    return '
    <h2 class="runHeader">Run Tracker</h2>
    ';
  }

  private function renderLink(): string
  {
    if ($this->userWantsToCreateRun()) {
      return '<a class="button" href=?>Cancel new run</a>';
    }

    return '<a class="button" href=?create>Create new run</a>';
  }

  private function renderMessage(): string
  {
    return '
    <div class="message">
      <p>' . self::$msg . '</p>
    </div>
    ';
  }

  private function generateRunningForm(): string
  {
    return '
    <form action="" method="post" enctype="multipart/form-data">
      <fieldset>
        <legend>' . $this->setFieldsetTitle() . '</legend>
        <p>' . self::$errorMessage . '</p>
          <label for="' . self::$distance . '" >Distance (km) :</label>
          <input type="text" name="' . self::$distance . '" id="' . self::$distance . '" value="' . $this->setDistanceValue() . '" />
        
          <label for="' . self::$time . '" >Time format(hh:mm:ss)  :</label>
          <input type="text" size="10" name="' . self::$time . '" id="' . self::$time . '" value="' . $this->setTimeValue() . '" />
      
          <label for="' . self::$date . '" >Date  :</label>
          <input type="date" size="20" name="' . self::$date . '" id="' . self::$date . '" value="' . $this->setdateValue() . '" />
          <br/>
          <br/>
          <input id="submit" type="submit" name="' . self::$submitRun . '"  value="' . $this->setButtonValue() . '" />
          <br/>
      </fieldset>
      </form>
    ';
  }

  private function setFieldsetTitle(): string
  {
    return $this->userWantsToEditRun() || !$this->userWantsToCreateRun()
      ? 'Edit the current Run'
      : 'Keep track of your runs - Enter a completed run';
  }

  private function setButtonValue(): string
  {
    if ($this->session->hasStoredRun() && !$this->userWantsToCreateRun()) {
      return 'Update Run';
    } else {
      return 'Add Run';
    }
  }

  private function setTimeValue(): string
  {
    if ($this->session->hasStoredRun() && !$this->userWantsToCreateRun()) {
      return $this->session->getTime();
    }

    if ($this->userWantsToSubmitRun()) {
      return strip_tags($_POST[self::$time]);
    } else {
      return '00:00:00';
    }
  }

  private function setdateValue(): string
  {
    if ($this->session->hasStoredRun() && !$this->userWantsToCreateRun()) {
      return $this->session->getdate();
    }

    if ($this->userWantsToSubmitRun()) {
      return strip_tags($_POST[self::$date]);
    } else {
      return '';
    }
  }

  private function setDistanceValue(): string
  {
    if ($this->session->hasStoredRun() && !$this->userWantsToCreateRun()) {
      return $this->session->getDistance();
    }

    if ($this->userWantsToSubmitRun()) {
      return strip_tags($_POST[self::$distance]);
    } else {
      return '';
    }
  }

  public function getNewRun(string $username): \Application\Model\Run
  {
    if ($this->userWantsToSubmitRun()) {
      $distance = $_POST[self::$distance];
      $time = $_POST[self::$time];
      $date = $_POST[self::$date];
      if ($this->session->hasStoredRun()) {
        $id = $this->session->getID();
        return new \Application\Model\Run($username, $distance, $time, $date, $id);
      }
      return new \Application\Model\Run($username, $distance, $time, $date);
    }
  }

  public function setEdit(string $edit): void
  {
    self::$editRun = $edit;
  }

  public function setMessage(string $message): void
  {
    self::$msg = $message;
  }

  public function errorMessage(string $errorMessage): void
  {
    self::$errorMessage = $errorMessage;
  }

  public function userWantsToCreateRun(): bool
  {
    return isset($_GET['create']);
  }

  public function userWantsToSubmitRun(): bool
  {
    return isset($_POST[self::$submitRun]);
  }

  public function userWantsToEditRun(): bool
  {
    return isset($_POST[self::$editRun]);
  }
}
