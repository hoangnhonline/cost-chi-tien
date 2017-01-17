<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class BillDetail extends Model  {

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'bill_detail';

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
        'bill_id', 
        'product_name', 
        'unit', 
        'amount', 
        'price', 
        'total_price'
    ];
}