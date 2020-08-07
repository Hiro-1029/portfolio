<?php

class Database {
  private $servername = "localhost";
  private $username = "root";
  private $password = "root";
  private $database = "coffee_order";
  public $conn;

  public function __construct() {
    $this->conn = new mysqli($this->servername, $this->username, $this->password, $this->database);

    if ($this->conn->connect_error) {
      die("Connection error: " . $this->conn->connect_error);
    }
    return $this->conn;
  }

}