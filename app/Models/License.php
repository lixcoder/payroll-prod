<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class License extends Model
{
    //
    protected $table = 'subscriptions';

    public static function checkSubscription($id){
        $currentSub = License::where('business_id', $id)->get();

        if(count($currentSub)>=1){
           $currentSub = json_decode($currentSub, true); 

            if(Carbon::now()->greaterThan(Carbon::parse($currentSub[0]['trial_end_date']))){
               return 0;
            }else{
                return 1;
            }
            
        }
        else{
            return 0;
        }
    }
}
