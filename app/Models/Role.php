<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Observers\UserObserver;
use Auth;

class Role extends Model
{
     /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
	protected $fillable = ['name'];
	
	/**
     * The role that belong to the emp.
     */
    public function employess()
    {
        return $this->belongsToMany('App\Models\Employee', 'emp_roles', 'role_id', 'emp_id')->withPivot('created_by');
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
