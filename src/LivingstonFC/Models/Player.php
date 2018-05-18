<?php

namespace LivingstonFC\Models;

class Player extends \Illuminate\Database\Eloquent\Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
     protected $table = 'Player';

     public function output() {
       $output = [];

       $output['id'] = $this->id;
       $output['squadNo'] = $this->squadNo;
       $output['team'] = $this->team;
       $output['firstName'] = $this->firstName;
       $output['lastName'] = $this->lastName;
       $output['position'] = $this->position;
       $output['dateOfBirth'] = $this->dateOfBirth;
       $output['height'] = $this->height;
       $output['nationality'] = $this->nationality;
       $output['imageIcon'] = $this->imageIcon;
       $output['backgroundImg'] = $this->backgroundImg;
       $output['signed'] = $this->signed;
       $output['matches'] = $this->matches;
       $output['goals'] = $this->goals;
       $output['assists'] = $this->assists;
       $output['redCards'] = $this->redCards;
       $output['yellowCards'] = $this->yellowCards;
       $output['playerUri'] = 'player/' . $player->id;

       return $output;
     }
} ?>
