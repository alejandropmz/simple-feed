<?php

class Connection
{
  private $SERVER = "localhost";
  private $USER = "root";
  private $PASSWORD = "ale123456";
  private $CONNECTION;

  public function __construct()
  {
    try
    {
      $this->CONNECTION = new PDO("mysql:host=$this->SERVER; dbname=social-network", $this->USER, $this->PASSWORD);
      $this->CONNECTION->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }
    catch(PDOException $e)
    {
      echo "Error in connection " . $e;
    }
  }

  public function executeSQL($sql)
  {
    $this->CONNECTION->exec($sql);
    return $this->CONNECTION->lastInsertId();
  }

  public function querySQL($sql)
  {
    $query = $this->CONNECTION->prepare($sql);
    $query->execute();
    return $query->fetchAll();
  }
}
