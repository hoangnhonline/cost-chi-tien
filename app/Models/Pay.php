<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class Pay extends Model  {

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'pay';

	 /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = true;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'customer_id', 
        'pay_date', 
        'bill_id', 
        'bank_id', 
        'total_amount'        
    ];
}