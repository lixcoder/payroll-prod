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

            if(Carbon::now()->greaterThan(Carbon::parse($currentSub[0]['trial_end_date']))  ){
                // && $currentSub[0]['status'] == 'approved' && $currentSub[0]['deleted_at'] == NULL
                //indicates new subscrition needed to keep using services
               return $currentSub[0]['status'] " : " $currentSub[0]['deleted_at'] ;
            }else{
                //indicates subscrition is still active
                return 1;
            }
            
        }
        else{
            //indicates new subscrition needed to keep using services
            return 0;
        }
    }
}
