<?php
session_start();
if(isset($_SERVER['HTTP_REFERER'])) {
    $previous = $_SERVER['HTTP_REFERER'];
    header("Location: $previous");
}



require_once 'DataBase_Connection/PDO_DB_Connect.php';
require_once 'Class/Identical.php';
require_once 'Class/Exist.php';
require_once 'Class/Toss.php';
require_once 'Class/NoEmpty.php';

////////////////////////////
////////addCommand/////////
///////////////////////////
if(isset($_POST['team'])){
$team = $_POST['team'];
$table = $_SESSION['table_name'];

$stmt = $pdo->query("SELECT `team` FROM `$table`");
$teams = $stmt->fetchAll(PDO::FETCH_COLUMN, 0);

if(!in_array($team, $teams)){
  $sql = $pdo->prepare("INSERT INTO `$table` (team) VALUES ('$team')");
  $sql->execute();
}
}
////////////////////////////
////////addCommand/////////
///////////////////////////



//////////////////////////////////
//////////////// del group ///////
////////////////////////////////
  if(isset($_POST['group_id'])){


      $del = $_POST['name_group'];
      $del_group = $del;

      $exist = new Exist($pdo, $del);
      if($exist->tableExists()){
        $sql = "DROP TABLE $del";
        $stmt = $pdo->prepare($sql);
        $stmt->execute();

        $counters = $del . '_count';
        if (isset($_SESSION["$counters"])){
          unset($_SESSION["$counters"]);
        }
      }

      $sql = "DELETE FROM alpha WHERE name = '$del' ";
      $stmt = $pdo->prepare($sql);
      $stmt->execute();
      //////////////////////////////////
      //////////////// del group group///////
      ////////////////////////////////
      $del_grouptable = $del . $del;
      $exist = new Exist($pdo, $del_grouptable);
      if($exist->tableExists()){
        $sql = "DROP TABLE $del_grouptable";
        $stmt = $pdo->prepare($sql);
        $stmt->execute();
      }

      }
      //////////////////////////////////
      //////////////// del group group///////
      ////////////////////////////////

//////////////////////////////////
//////////////// del group///////
////////////////////////////////



/////////////////////////////////
//////////////// del command from AA///////
////////////////////////////////
  if(isset($_POST['id_addCommand'])){
    $name = $_POST['team'];
    $table = $_SESSION['table_name'];
    $generate = $table . $table;

    $exist = new Exist($pdo, $generate);
      if($exist->tableExists()) {

      $poisk = new NoEmpty($pdo, $generate, $name);
      if($poisk->in_DB()){

      $sql = "DELETE FROM $generate WHERE home =:home OR away=:away";
      $stmt = $pdo->prepare($sql);
      $stmt->bindParam(':home', $name);
      $stmt->bindParam(':away', $name);
      $stmt->execute();

      $sql = "DELETE FROM $table WHERE team=:team";
      $stmt = $pdo->prepare($sql);
      $stmt->bindParam(':team', $name);
      $stmt->execute();
    }
    ///////not table "AA", but can delete value from table "A"
    }else {
    $sql = "DELETE FROM $table WHERE team=:team";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':team', $name);
    $stmt->execute();
  }
      }
      //////////////////////////////////
      //////////////// del command from AA///////
      ////////////////////////////////



//////////////////////////////////
//////////////// add group///////
////////////////////////////////
if(isset($_POST['add_group'])){
  $table = 'alpha';
  $exist =new Exist($pdo, $table);
  if(!$exist->tableExists()){
  $sql = "CREATE TABLE `$db`.`$table` (
     `id` INT(11) NOT NULL AUTO_INCREMENT ,
     `name` VARCHAR(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL ,
     PRIMARY KEY  (`id`)) ENGINE = MyISAM CHARSET=utf8 COLLATE utf8_general_ci";
     $stmt = $pdo->prepare($sql);
     $stmt->execute();
  }
    $alphabet = range('A','Z');
     $stmt = $pdo->query("SELECT `name` FROM `$table`");
     $group = $stmt->fetchAll(PDO::FETCH_COLUMN, 0);

    $identical = new Identical($alphabet, $group);
    if(!$identical->identical_values()){

    $arr3 = array_diff($alphabet, $group);
    $key = current($arr3);

    if(in_array($key, $alphabet)){
      $sql = $pdo->prepare("INSERT INTO `$table` (name) VALUES ('$key')");
      $sql->execute();
    }
    $create_key = new Exist($pdo, $key);
    if(!$create_key->tableExists()){
    $sql = "CREATE TABLE  `$db`.`$key` (
      `id` INT(11) NOT NULL AUTO_INCREMENT ,
      `team` VARCHAR(100) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL ,
      PRIMARY KEY (`id`))ENGINE=MyIsam";
    $stmt = $pdo->prepare($sql);
    $stmt->execute();
    }
  }
}
//////////////////////////////////
//////////////// add group///////
////////////////////////////////





/////////////////////////////////////////////////
////////Create TABLE  Generate group/////////
/////////////////////////////////////////////
if(isset($_POST['generate'])){
  // $_SESSION["count_"]++;
  $tableName = $_SESSION['table_name'];
  $generate = $tableName . $tableName;
  $counters = $tableName . '_count';
  $_SESSION["$counters"]++;
  ///////////////////////////
  $exist = new Exist($pdo, $generate);
  if(!$exist->tableExists()){
  $sql = "CREATE TABLE `$db`.`$generate` ( `id_rez` INT(11) NOT NULL AUTO_INCREMENT ,
    `home` VARCHAR(255) NOT NULL ,
    `home_rez` VARCHAR(255) NOT NULL ,
    `away` VARCHAR(255) NOT NULL ,
    `away_rez` VARCHAR(255) NOT NULL ,
    PRIMARY KEY  (`id_rez`))
    ENGINE = MyISAM CHARSET=utf8 COLLATE utf8_general_ci";
    $stmt = $pdo->prepare($sql);
    $stmt->execute();
}
////////////////////////////
////////Create TABLE/////////
///////////////////////////

////////////////////////////
////////Generate group/////////
///////////////////////////

$stmt = $pdo->query("SELECT `team` FROM `$tableName`");
$members = $stmt->fetchAll(PDO::FETCH_COLUMN, 0);
/* Начало транзакции, отключение автоматической фиксации */
$pdo->beginTransaction();

/* Вставка множества записей по принципу "все или ничего" */

    $sql = "INSERT INTO $generate
        (home, home_rez,  away, away_rez)
        VALUES (?, ?, ?, ?)";

$sth = $pdo->prepare($sql);

$schedule = new Toss($members);
$aa = $schedule->tossTeam();
$count = (count($members)%2) ? 0 : 1;

for($i = 0; count($aa) > $i; $i ++){
  if(count($members)-$count>$i){
  foreach ($aa[$i] as $key) {
    $sth->execute([
        $key['home'],
        $key['home_rez'],
        $key['away'],
        $key['away_rez'],
    ]);
  }
  }
}
/* Фиксация изменений */
$pdo->commit();

/* Соединение с базой данных снова в режиме автоматической фиксации */

}
////////////////////////////
////////Generate group/////////
///////////////////////////

/////////////////////////////////////////////////
////////Create TABLE  Generate group/////////
/////////////////////////////////////////////


///////////////////////////////////////////////////////
///////////////////////////////////////
//////////////UPdate table/////////////
/////////////////////////////////////
if(isset($_POST['update_rez'])){
if ((in_array($_POST['home_rez'], range(1,9999)) || $_POST['home_rez'] == '0') && (in_array($_POST['away_rez'], range(1,9999)) || $_POST['away_rez'] == '0')) {
$id_rez = $_POST['id_rez'];
$home_rez = $_POST['home_rez'];
$away_rez =  $_POST['away_rez'];

$tableName = $_SESSION['table_name'];
$generate = $tableName . $tableName;

$data = [
  'id_rez' => $id_rez,
    'home_rez' => $home_rez,
    'away_rez' => $away_rez,
];
$sql = "UPDATE `$generate` SET home_rez=:home_rez, away_rez=:away_rez WHERE id_rez=:id_rez";
$stmt= $pdo->prepare($sql);
$stmt->execute($data);
}
}
///////////////////////////////////////////////////////
///////////////////////////////////////
//////////////UPdate table/////////////
/////////////////////////////////////
