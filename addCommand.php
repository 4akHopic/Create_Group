<?php session_start(); ?>
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
<?php

require_once 'DataBase_Connection/PDO_DB_Connect.php';
require_once 'Class/Exist.php';


$table = $_GET['name'];
$_SESSION['table_name'] = $_GET['name'];
session_write_close();
$generate = $table . $table;

$exist = new Exist($pdo, $table);
if($exist->tableExists()) {

  ?>

  <div class="center">
    <td><a href="Home.php"><img src="img/home.png" alt="Home"></a></td>
    <div class="center-auto">
<p>Group: <?php echo $table; ?></p>
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
//////////////show table/////////////
/////////////////////////////////////
$stmt = $pdo->query("SELECT * FROM $table");
$teams = $stmt->fetchAll();

$res = '<table width=100>';
foreach ($teams as $val) {
  $res .='<tr>';
  $res .= '<form action="redirect.php" method="POST"><input type="hidden" name="team" value="'. $val['team'] .'"/><td><input class="sendsubmit-visible" type="submit" name="del_team"/></td><td>'. $val['team'] .'</td></form>';
  $res .='</tr>';
}
echo $res . '</table>';

///////////////////////////////////////
//////////////show table/////////////
////////////////////////////////////

$members = $pdo->query("SELECT COUNT(*) as count FROM $table")->fetchColumn();
$groupbase = [];

$exist = new Exist($pdo, $generate);
if ($exist->tableExists()) {
  $stmt = $pdo->query("SELECT * FROM `$generate`");
  $groupbase = $stmt->fetchAll();
}


if ($members > 1 && !$groupbase) {
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
///////////////////////////////////////
//////////////show table/////////////
/////////////////////////////////////
/////////////////////////////////////////////////

  $addGenerate = new Exist($pdo, $generate);
  if($addGenerate->tableExists()){


    $stmt = $pdo->query("SELECT * FROM `$generate`");
   $groupbase = $stmt->fetchAll();

   if ($groupbase) {

  echo '<button class="button-right" type="submit" name="update_rez" form="example" formaction="redirect.php" formmethod="POST">Update rezult</button>';
   $res = '<form id="example">';
   $res .= '<div class="generate-teams">';
   $res .= '<table> ';
   foreach ($groupbase as $val) {
     $res .= '<tr>';
     $res .= '<td>' . $val['home'] . '</td>';
     $res .= '<td><input class="item" type="text"  name="update['.$val['id_rez'].'][home_rez]" value="'.$val['home_rez'] .'"></td>';
     $res .= '<td>'." : ".'</td>';
     $res .= '<td><input class="item" type="text"  name="update['.$val['id_rez'].'][away_rez]" value="'.$val['away_rez'].'"></td>';
     $res .= '<td>' . $val['away'] .'</td>';
     $res .= '<td><input type="hidden" name="update['.$val['id_rez'].'][id_rez]" value="'. $val['id_rez'] .'"/></td>';
     $res .= '</tr>';
   }
   $res .= '</table>';
   $res .= '</div>';
   echo $res .='</form>';

}

}
   ///////////////////////////////////////
   //////////////show table/////////////
   /////////////////////////////////////
   /////////////////////////////////////////////////

echo '</div>';
echo '</div>';
 }else {
   echo 'Page not found  <a href="Home.php">Home</a>';
 }
?>

</body>
</html>
