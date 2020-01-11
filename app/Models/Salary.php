<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Observers\UserObserver;
use Auth;

class Salary extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
	protected $fillable = ['employee_id', 'salary_month', 'working_days', 'basic_pay', 'hra', 'medical_allowance', 'special_allowance', 'transport', 'lta', 'incentive', 'provident_fund','professional_tax'];
	
	/**
     * Get the employee that owns the salary.
     */
    public function employee()
    {
        return $this->belongsTo('App\Models\Employee','employee_id');
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
