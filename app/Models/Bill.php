<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class Bill extends Model  {

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'bill';

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
        'bill_no', 
        'date_export', 
        'product_cost', 
        'tax', 
        'total_cost', 
        'pay', 
        'owed'        
    ];
}