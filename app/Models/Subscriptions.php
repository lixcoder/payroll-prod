<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Subscriptions extends Model
{
    
    public $table = 'subscriptions';

    public static function checkSubscription($id){
        $currentSub = Sbscription::where('business_id', $id)->get();

        if(count($currentSub)>=1){
           return json_decode($currentSub); 
        }
        else{
            return "No Subscription for Current user!!!";
        }
        
    }
}
