<?php

namespace LivingstonFC\Models;

class CommunityEvent extends \Illuminate\Database\Eloquent\Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
     protected $table = 'CommunityEvent';

     public function output() {
       $output = [];

       $output['id'] = $this->id;
       $output['name'] = $this->name;
       $output['image'] = $this->image;
       $output['description'] = $this->description;
       $output['eventUrl'] = $this->link;
       $output['eventUri'] = '/comminutyevent/' . $this->id;

       return $output;
     }
} ?>
