<?php
class NoEmpty{
  private $table;
  private $team;
  private $pdo;

  public function __construct($pdo, $table, $team)
  {
    $this->pdo = $pdo;
    $this->table = $table;
    $this->team = $team;
  }

public function in_DB(){
  $stmt = $this->pdo->prepare("SELECT home_rez, away_rez  FROM $this->table WHERE home=:home OR away=:away");
  $stmt->execute(['home' => $this->team, 'away' => $this->team]);
  $data = $stmt->fetchAll();
var_dump($data);

foreach ($data as $val) {
  foreach ($val as $key) {
if(strlen($key)>0){
  return FALSE;
}else{
  $result = TRUE;
      }
    }
  }
  return $result !== FALSE;
}

}
?>
