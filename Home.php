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
  <div class="center-auto">
<form action="redirect.php" method="POST">
<input class="sub" type="submit" name="add_group" value="Add group"/>
</form>
</div>

<?php

require_once 'DataBase_Connection/PDO_DB_Connect.php';
require_once 'Class/Exist.php';

$exist = new Exist($pdo, $table_alpha);
if($exist->tableExists()){
///////////////////////////////////////
//////////////vuvod table/////////////
/////////////////////////////////////


    $stmt = $pdo->query("SELECT * FROM `$table_alpha`");
   $groupbase = $stmt->fetchAll();
   array_multisort($groupbase, SORT_DESC);
   $res = '<div class="center-auto"><table>';
   foreach ($groupbase as $val) {
     $res .= '<tr>';
     $res .= '<td>';
     $res .= '<form action="redirect.php" method="POST"><input hidden="hidden" type="text" name="name_group" value="'. $val['name'] .'"/></td><td><a href="addCommand.php?name='. $val['name'] .'">'.$val['name'].'</a><input class="sendsubmit" type="submit" name="group_id"/></form>';
     $res .= '</td>';
     $res .= '</tr>';
   }

   echo $res .= '</table></div>';
///////////////////////////////////////
//////////////vuvod table/////////////
/////////////////////////////////////
}
?>
</body>
</html>
