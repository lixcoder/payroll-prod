<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class License extends Model
{
    //
    protected $table = 'subscriptions';

    public static function checkSubscription($id){
        $currentSub = License::where('business_id', $id)->get();

        if(count($currentSub)>=1){
           $currentSub = json_decode($currentSub, true); 
            return $currentSub[0]['trial_end_date'];
        }
        else{
            return 0;
        }
    }
}
