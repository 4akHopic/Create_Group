<?php session_start();

require_once 'DataBase_Connection/PDO_DB_Connect.php';
require_once 'Class/Exist.php';


$table = $_GET['name'];
$_SESSION['table_name'] = $_GET['name'];


$exist = new Exist($pdo, $table);
if($exist->tableExists()) {
  ?>
  <form action="redirect.php" method="post">
    <input type='text' required name="team">
    <input type="submit" name="Add" value="Add">
  </form>

  <?php
///////////////////////////////////////
//////////////vuvod table/////////////
/////////////////////////////////////
$stmt = $pdo->query("SELECT * FROM $table");
$teams = $stmt->fetchAll();

$res = '<table>';
foreach ($teams as $val) {
  $res .='<tr>';
  $res .= '<td><form action="redirect.php" method="POST"><input type="hidden" name="team" value="'. $val['team'] .'"/><input type="submit" name="id_addCommand" value="x"/>';
  $res .= $val['team'] .'</form> <td>';
  $res .='</tr>';
}
echo $res . '</table>';
///////////////////////////////////////
//////////////vuvod table/////////////
////////////////////////////////////
$counters = $table . '_count';
$members=$pdo->query("SELECT COUNT(*) as count FROM $table")->fetchColumn();

if (!isset($_SESSION["$counters"])){
$_SESSION["$counters"]=0;
}

if ($_SESSION["$counters"] < 1 && $members > 1){
?>
   <form action="redirect.php" method="post">
     <input type="hidden" name="gen" value="<?=$table?>">
     <input  type="submit" name="generate" value="Generate">
   </form>

 <?php
}else { ?>
   <form action="" method="post">
     <input type="hidden" name="gen" value="<?=$table?>">
     <input disabled type="submit" name="generate" value="Generate">
   </form>

<?php }

//<-------------------------------------------------------------------------------------------------------------------------------//
  $table = $_GET['name'];
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
     $res .= '<td> <form action="redirect.php" method="POST">' . $val['home'] . '<input type="text" required name="home_rez" value="'.$val['home_rez'].'">' . $val['away'] .'<input type="text" required name="away_rez" value="'.$val['away_rez'].'"><input type="hidden" name="id_rez" value="'. $val['id_rez'] .'"/><input type="submit" name="update_rez" value="UPdate"></form></td>';
     $res .= '</tr>';
   }
   echo $res .= '</table>';

}
   ///////////////////////////////////////
   //////////////vuvod table/////////////
   /////////////////////////////////////
   /////////////////////////////////////////////////
 }else {
   echo 'Page not found  <a href="Home.php">Home</a>';
 }
?>
