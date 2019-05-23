<?php
class Toss
{
    private $teams;

    public function __construct($teams)
    {
      $this->teams = $teams;
    }

    function tossTeam(){

    $away = array_splice($this->teams,(count($this->teams)/2));
    $home = $this->teams;
    for ($i=0; $i < count($home)+count($away); $i++){
        for ($j=0; $j<count($home); $j++){
          if(isset($home[$j]) && isset($away[$j])){
            $round[$i][$j]["home"]=$home[$j];
            $round[$i][$j]["home_rez"]='';
            $round[$i][$j]["away"]=$away[$j];
            $round[$i][$j]["away_rez"]='';
          }
        }
        if(count($home)+count($away) > 2){
          @  array_unshift($away,array_shift(array_splice($home,1,1)));
            array_push($home,array_pop($away));
        }
    }
    return $round;
    }
}

 ?>
