<?php

namespace LivingstonFC\Models;

class SeasonTickets extends \Illuminate\Database\Eloquent\Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
     protected $table = 'SeasonTickets';

     public function output() {
       $output = [];

       $output['validInYearStart'] = $this->validInYearStart;
       $output['adultSeasonPrice'] = $this->adultSeasonPrice;
       $output['adultWalkUpPrice'] = $this->adultWalkUpPrice;
       $output['concessionSeasonPrice'] = $this->concessionSeasonPrice;
       $output['concessionWalkUpPrice'] = $this->concessionSeasonPrice;
       $output['under16SeasonPrice'] = $this->under16SeasonPrice;
       $output['under16WalkUpPrice'] = $this->under16WalkUpPrice;
       $output['familySeasonPrice'] = $this->familySeasonPrice;
       $output['familyWalkUpPrice'] = $this->familyWalkUpPrice;
       $output['purchaseFromDate'] = $this->purchaseFromDate;
       $output['descriptionPTop'] = $this->descriptionPTop;
       $output['descriptionPBottom'] = $this->descriptionPBottom;


       return $output;
     }

} ?>
