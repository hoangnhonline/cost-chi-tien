<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class Bank extends Model  {

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'area';

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
        'bank_name', 
        'acount_name',
        'acount_no',        
        'branch'
    ];
}