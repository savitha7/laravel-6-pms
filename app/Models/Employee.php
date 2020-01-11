<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Observers\UserObserver;
use Auth;

class Employee extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
	protected $fillable = ['name', 'email', 'role_id', 'address', 'photo', 'doj'];
	
	
	/**
	* Relationship Table - The roles that belong to the emp.
	*/
    public function roles()
    {
        return $this->belongsToMany('App\Models\Role', 'emp_roles', 'emp_id', 'role_id')->withPivot('created_by')->withTimestamps();
    }

	/**
     * Get the salaries of the employee
     */
    public function salaries()
    {
        return $this->hasMany('App\Models\Salary','employee_id');
    }	
	
	protected static function boot() {	   
		parent::boot();
		
		if(Auth::check())
		{			
			$class = get_called_class();
			$class::observe(new UserObserver());		
		}
    }

}
