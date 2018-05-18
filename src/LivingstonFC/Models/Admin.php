<?php

namespace LivingstonFC\Models;

class Admin extends \Illuminate\Database\Eloquent\Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
     protected $table = 'Admin';

     public function authenticate($apiKey)
     {
         $admin = Admin::where('adminApiKey', '=', $apiKey)->take(1)->get();

         $this->details = $admin[0];
         return ($admin[0]->exists) ? true : false;
     }
} ?>
