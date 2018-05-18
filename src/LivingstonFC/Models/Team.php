<?php

namespace LivingstonFC\Models;

class Team extends \Illuminate\Database\Eloquent\Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
     protected $table = 'Team';

     public function output() {
       $output = [];

       $output['name'] = $this->name;
       $output['badge'] = $this->badge;
      
       return $output;
     }
} ?>
