<?php
/**
 * Check if a table exists in the current database.
 *
 * @ param PDO $pdo PDO instance connected to a database.
 * @ param string $table Table to search for.
 * @ return bool TRUE if table exists, FALSE if no table found.
 */
class Exist
{
  private $pdo, $table;

  public function __construct($pdo, $table){
    $this->pdo = $pdo;
    $this->table = $table;
  }

  public function tableExists() {

      // Try a select statement against the table
      // Run it in try/catch in case PDO is in ERRMODE_EXCEPTION.
      try {
          $result = $this->pdo->query("SELECT 1 FROM $this->table LIMIT 1");
      } catch (Exception $e) {
          // We got an exception == table not found
          return FALSE;
      }

      // Result is either boolean FALSE (no table found) or PDOStatement Object (table found)
      return $result !== FALSE;
  }
//* Check if a table exists in the current database.
}
?>
