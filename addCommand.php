<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <link rel="stylesheet" href="/css/style.css">
  <link rel="icon" href="/img/iconff.ico">
  <title>App</title>
</head>
<body>
<?php session_start();

require_once 'DataBase_Connection/PDO_DB_Connect.php';
require_once 'Class/Exist.php';


$table = $_GET['name'];
$_SESSION['table_name'] = $_GET['name'];
$counters = $table . '_count';
if (!isset($_SESSION["$counters"])){
$_SESSION["$counters"]=0;
}
session_write_close();

$exist = new Exist($pdo, $table);
if($exist->tableExists()) {

  ?>

  <div class="center">
    <td><a href="Home.php"><img src="img/home.png" alt="Home"></a></td>
    <div class="center-auto">
  <table>
    <tr>
  <form action="redirect.php" method="post">

    <td><input class="edit" type='text' required name="team"></td>
    <td><input class="add" type="submit" name="add_team" value="Add"></td>
  </form>
</tr>
</table>
  <?php

///////////////////////////////////////
//////////////vuvod table/////////////
/////////////////////////////////////
$stmt = $pdo->query("SELECT * FROM $table");
$teams = $stmt->fetchAll();

$res = '<table width=100>';
foreach ($teams as $val) {
  $res .='<tr>';
  $res .= '<form action="redirect.php" method="POST"><input type="hidden" name="team" value="'. $val['team'] .'"/><td><input class="sendsubmit-visible" type="submit" name="id_addCommand"/></td><td>'. $val['team'] .'</td></form>';
  $res .='</tr>';
}
echo $res . '</table>';

///////////////////////////////////////
//////////////vuvod table/////////////
////////////////////////////////////

$members=$pdo->query("SELECT COUNT(*) as count FROM $table")->fetchColumn();

if ($_SESSION["$counters"] < 1 && $members > 1){
?>

   <form action="redirect.php" method="post">
     <input class="add" type="submit" name="generate" value="Generate">
   </form>

 <?php
}else { ?>

   <form action="" method="post">
     <input disabled class="add-disabled" type="submit" name="generate" value="Generate">
   </form>

<?php }
//<-------------------------------------------------------------------------------------------------------------------------------//

  $generate = $table . $table;
  $addGenerate = new Exist($pdo, $generate);
  if($addGenerate->tableExists()){

    ///////////////////////////////////////
    //////////////vuvod table/////////////
    /////////////////////////////////////
    /////////////////////////////////////////////////
    $stmt = $pdo->query("SELECT * FROM `$generate`");
   $groupbase = $stmt->fetchAll();

   $res = '<table>';
   foreach ($groupbase as $val) {
     $res .= '<tr>';
     $res .= '<form action="redirect.php" method="POST"><td>' . $val['home'] . '</td><td><input class="item" type="text" required name="home_rez" value="'.$val['home_rez'] .'"></td><td>'." : ".'</td><td><input class="item" type="text" required name="away_rez" value="'.$val['away_rez'].'"></td><td>' . $val['away'] .'</td><input type="hidden" name="id_rez" value="'. $val['id_rez'] .'"/><td><input class="add" type="submit" name="update_rez" value="UPdate"></td></form>';
     $res .= '</tr>';
   }
   echo $res .= '</table>';

}
   ///////////////////////////////////////
   //////////////vuvod table/////////////
   /////////////////////////////////////
   /////////////////////////////////////////////////

echo '</div>';
 }else {
   echo 'Page not found  <a href="Home.php">Home</a>';
 }
?>

</body>
</html>
