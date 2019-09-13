<?php

class Database {
    private $connection;

    // Connect to database with secure config data.
  public function connect() {
    $url = getenv('JAWSDB_URL');
    $dbparts = parse_url($url);

    $servername = $dbparts['host'];
    $dbName = $dbparts['user'];
    $dbPassword = $dbparts['pass'];
    $database = ltrim($dbparts['path'],'/');
    
    // Create connection
    $conn = new mysqli($hostname, $username, $password, $database);

    // Check connection
    if ($conn->connect_error) {
      die("Connection failed: " . $conn->connect_error);
    }
      echo "Connection was successfully established!";
  }

    // Check if user exists in database
    public function getUser() {
        $query_user = "SELECT * FROM users";
        $result = $this->connect()->query($query_user);
        $numRows = $result->num_rows;

        if ($numRows > 0) {
            while($row = $result->fetch_assoc()) {
                $data[] = $row;
            }
            return $data;
        }
    }
}