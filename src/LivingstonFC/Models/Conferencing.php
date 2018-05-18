<?php

namespace LivingstonFC\Models;

class Conferencing extends \Illuminate\Database\Eloquent\Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
     protected $table = 'Conferencing';

     public function output() {
       $output = [];

       $output['id'] = $this->id;
       $output['suiteName'] = $this->suiteName;
       $output['halfPrice'] = $this->halfPrice;
       $output['fullPrice'] = $this->fullPrice;

       return $output;
     }

} ?>
