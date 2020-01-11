<?php
namespace App\Observers;
use Auth;

class UserObserver {
	
    private $userID;

    public function __construct(){
        $this->userID = Auth::id();        
    }

    public function saving($model)
    {
		if($model->exists){
            if(in_array('updated_by',$model->getFillable())){
                $model->updated_by = $this->userID;
            }
        } else {
            if(in_array('created_by',$model->getFillable())){
                $model->created_by = $this->userID;
            }
        }
    }

    public function saved($model)
    {
        if($model->exists){
            if(in_array('updated_by',$model->getFillable())){
                $model->updated_by = $this->userID;
            }
        } else {
            if(in_array('created_by',$model->getFillable())){
                $model->created_by = $this->userID;
            }
        }
    }

    public function updating($model)
    {
        if(in_array('updated_by',$model->getFillable())){
            $model->updated_by = $this->userID;
        }
    }

    public function updated($model)
    {
        if(in_array('updated_by',$model->getFillable())){
            $model->updated_by = $this->userID;
        }
    }


    public function creating($model)
    {
        if(in_array('created_by',$model->getFillable())){
            $model->created_by = $this->userID;
        }
    }

    public function created($model)
    {
        if(in_array('created_by',$model->getFillable())){
            $model->created_by = $this->userID;
        }
    }

    public function createMany($model)
    {
        if(in_array('created_by',$model->getFillable())){
            $model->created_by = $this->userID;
        }
    }
	
}