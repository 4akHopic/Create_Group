<form action="redirect.php" method="POST">
<input type="submit" name="add_group" value="Add group"/>

</form>
<?php

require_once 'DataBase_Connection/PDO_DB_Connect.php';
require_once 'Class/Exist.php';

$table = 'alpha';
$exist = new Exist($pdo, $table);
if($exist->tableExists()){
///////////////////////////////////////
//////////////vuvod table/////////////
/////////////////////////////////////


    $stmt = $pdo->query("SELECT * FROM `$table`");
   $groupbase = $stmt->fetchAll();
   array_multisort($groupbase, SORT_DESC);
   $res = '<table>';
   foreach ($groupbase as $val) {
     $res .= '<tr>';

     $res .= '<td><form action="redirect.php" method="POST"><input hidden="hidden" type="text" name="name_group" value="'. $val['name'] .'"/><a href="addCommand.php?name='. $val['name'] .'">'.$val['name'].'</a><input type="submit" name="group_id" value="x"/></form></td>';

     $res .= '</tr>';
   }

   echo $res .= '</table>';
///////////////////////////////////////
//////////////vuvod table/////////////
/////////////////////////////////////
}
