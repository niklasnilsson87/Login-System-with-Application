<?php

namespace Application\View;

class RunningView
{

  private static $message =  __CLASS__ . '::Message';
  private static $distance = __CLASS__ . '::Distance';
  private static $time = __CLASS__ . '::Time';
  private static $pace = __CLASS__ . '::Pace';
  private static $description = __CLASS__ . '::Description';
  private static $submitRun = __CLASS__ . '::SubmitRun';
  private static $msg = '';

  private $runs = array();

  public function response()
  {
    $response = $this->appHeader();
    $response .= $this->generateRunningForm();
    $response .= $this->generateTableHeader();
    $response .= $this->printRuns();
    return $response;
  }

  public function appHeader()
  {
    return '<h2>My Running App!</h2>';
  }

  public function generateRunningForm()
  {
    return '
    <form action="" method="post" enctype="multipart/form-data">
      <fieldset>
        <legend>Keep track of your runs - Enter a compleated run</legend>
          <p id="' . self::$message . '">' . self::$msg . '</p>
          <label for="' . self::$distance . '" >Distance :</label>
          <input type="text" size="20" name="' . self::$distance . '" id="' . self::$distance . '" value="" />
        
          <label for="' . self::$time . '" >Time  :</label>
          <input type="number" size="20" name="' . self::$time . '" id="' . self::$time . '" value="" />
      
          <label for="' . self::$pace . '" >Pace  :</label>
          <input type="text" size="20" name="' . self::$pace . '" id="' . self::$pace . '" value="" />
      
          <label for="' . self::$description . '" >Description  :</label>
          <input type="text" size="20" name="' . self::$description . '" id="' . self::$description . '" value="" />
          <br/>
          <br/>
          <input id="submit" type="submit" name="' . self::$submitRun . '"  value="Submit Run" />
          <br/>
      </fieldset>
      </form>
    ';
  }

  public function userWantsToSubmitRun()
  {
    return isset($_POST[self::$submitRun]);
  }

  public function getNewRun()
  {
    if ($this->userWantsToSubmitRun()) {
      $distance = $_POST[self::$distance];
      $time = $_POST[self::$time];
      $pace = $_POST[self::$pace];
      $description = $_POST[self::$description];
      return new \Application\Model\Run($distance, $time, $pace, $description);
    }
  }

  public function setRun(\Application\Model\Run $run)
  {

    $this->runs[] = $run;
  }

  public function printRuns()
  {
    $output = "";

    if (!empty($this->runs)) {
      foreach ($this->runs as $run) {
        $output .= "<td> " . $run->getDistance() . "</td>";
        $output .= "<td> " . $run->getTime() . "</td>";
        $output .= "<td> " . $run->getPace() . "</td>";
        $output .= "<td> " . $run->getDescription() . "</td>";
      }
    } else {
      return $output .= '</table> <p> No runs so far.. </p>';
    }

    return "<tr>" . $output . "</tr>" . "</table>";
  }

  public function generateTableHeader()
  {
    return '
  <br>
  <table>
    <tr>
      <th>Distance</th>
      <th>Time</th>
      <th>Pace</th>
      <th>Description</th>
    </tr>
  ';
  }
}
