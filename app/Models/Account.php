<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class Account extends Model  {

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'users';

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
        'name', 
        'department_id', 
        'area_id', 
        'staff_code', 
        'email', 
        'password', 
        'role', 
        'status', 
        'last_login'
    ];
}