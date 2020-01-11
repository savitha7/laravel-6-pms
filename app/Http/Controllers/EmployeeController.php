<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Role;
use App\Services\EmployeeService;
use Illuminate\Http\Response;

class EmployeeController extends EMPController
{

	protected $employeeService;

	public function __construct(EmployeeService $employeeService)
	{
		$this->employeeService = $employeeService;
	}

	/**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $data['page_set'] = 'list_emp';
        return view('employee.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
		$data['roles'] = Role::all();
		return view('employee.create',$data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return Response
     */
    public function store(Request $request)
    {
		$this->employeeService->store($request);
        return redirect('/employees')->with('success', 'Employee data is successfully saved');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id)
    {
        $data = $this->employeeService->show($id);
		return view('employee.show',$data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($id)
    {
		$data = $this->employeeService->edit($id);
		return view('employee.edit', $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param  int  $id
     * @return Response
     */
    public function update(Request $request, $id)
    {
        $this->employeeService->update($request, $id);
		return redirect('/employees')->with('success', 'Employee data is successfully updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id)
    {
		$this->employeeService->destroy($id);
		return redirect('/employees')->with('success', 'Employee data is successfully deleted');
    }

	public function getEmployees(Request $request){
		$json_data = $this->employeeService->getEmployees($request);

        if ($request->ajax()) {
            echo json_encode($json_data);
        } else {
            return redirect()->back();
        }
	}
}
