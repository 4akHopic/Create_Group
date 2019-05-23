<?php
class Identical
{
    private $arr1 = [];
    private $arr2 = [];

      public function __construct($arr1, $arr2)
      {
        $this->arr1 = $arr1;
        $this->arr2 =  $arr2;
      }

      public function identical_values() {

         sort( $this->arr1 );
         sort( $this->arr2 );

         return $this->arr1 == $this->arr2;
         }
}
?>
