<?php

namespace LivingstonFC\Models;

class LivingstonGame extends \Illuminate\Database\Eloquent\Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
     protected $table = 'LivingstonGame';


     public function output() {
       $output = [];

       $output['id'] = $this->id;
       $output['opponent'] = $this->opponent;
       $output['competition'] = $this->competition;
       $output['competitionYearStarted'] = $this->competitionYearStarted;
       $output['date'] = $this->date;
       $output['time'] = $this->time;
       $output['scoreLivingston'] = $this->scoreLivingston;
       $output['scoreOpponent'] = $this->scoreOpponent;
       $output['venue'] = $this->venue;
       $output['referee'] = $this->referee;
       $output['commentary'] = $this->commentary;
       $output['travelLink'] = $this->travelLink;
       $output['livingstonGameUri'] = 'livingstongame/' . $this->id;

       return $output;
     }
} ?>
