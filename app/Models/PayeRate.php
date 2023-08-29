<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class PayeRate extends Model
{
     
	public $table = "paye";

    public static $rules = [
            'income_from' => 'required',
            'income_to' => 'required',
            'percentage' => 'required',
        ];
    /*
        public static function getRateFromAmount($amount) {
            $em= Doctrine_Manager::getInstance()->getCurrentConnection();
            
            $sql="SELECT amount from paye where income_from <=$amount AND income_to >=$amount ";
            $stmnt=$em->execute($sql);
            $result=$stmnt->fetch();
            //echo $amount." paye=>".$result["amount"].'<br>';
            return $result["amount"];
        }
        */
    
    public static $messages = array(
            'i_from.required'=>'Please insert income from amount!',
    //        'i_from.regex'=>'Please insert a valid income from amount!',
            'i_to.required'=>'Please insert income to amount!',
    //        'i_to.regex'=>'Please insert a valid income to amount!',
            
            'p.required'=>'Please insert percentage!',
    //        'amount.regex'=>'Please insert a valid amount!',
        );
    
        // Don't forget to fill this array
        protected $fillable = [];
}
