<?php

namespace LivingstonFC\Models;

class CoachingStaff extends \Illuminate\Database\Eloquent\Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
     protected $table = 'CoachingStaff';


     public function output() {
       $output = [];

       $output['id'] = $this->id;
       $output['firstName'] = $this->firstName;
       $output['lastName'] = $this->lastName;
       $output['position'] = $this->position;
       $output['imageIconUrl'] = $this->imageIcon;
       $output['team'] = $this->team;
       $output['coachingStaffURI'] = '/coachingstaff/' . $this->id;

       return $output;
     }
} ?>
