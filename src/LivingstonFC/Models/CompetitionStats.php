<?php

namespace LivingstonFC\Models;

class CompetitionStats extends \Illuminate\Database\Eloquent\Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
     protected $table = 'CompetitionStats';

     public function output() {
       $output = [];

       $output['id'] = $this->id;
       $output['competition'] = $this->competition;
       $output['competitionYearStarted'] = $this->competitionYearStarted;
       $output['teamName'] = $this->teamName;
       $output['position'] = $this->position;
       $output['played'] = $this->played;
       $output['won'] = $this->won;
       $output['drawn'] = $this->drawn;
       $output['lost'] = $this->lost;
       $output['for'] = $this->for;
       $output['against'] = $this->against;
       $output['points'] = $this->points;

       return $output;
     }
} ?>
