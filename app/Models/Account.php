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
        'company_name',
        'phone',
        'tax_no',
        'address',
        'department_id', 
        'area_id', 
        'staff_code', 
        'email', 
        'password', 
        'role', 
        'type',
        'status', 
        'last_login',
        'remember_token'
    ];
}