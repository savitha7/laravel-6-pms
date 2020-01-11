<?php
namespace App\Services;

use Illuminate\Http\Request;
use App\Models\Role;
use App\Models\Employee;
use Illuminate\Http\Response;
use Illuminate\Validation\Rule;
use DB;

class EmployeeService
{

    protected $commonService;

	public function __construct(CommonService $commonService)
	{
		$this->commonService = $commonService;
	}

	/**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return Response
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:employees',
            'roles' => 'required|array|min:1',
            'address' => 'max:255',
			'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:1048',
            'doj' => 'required|date|date_format:Y-m-d',
        ]);

		$is_created = Employee::create($validatedData);
		if ($is_created) {
			if ($request->filled('roles')) {
				$is_created->roles()->attach($request->roles);
			}

			if (request()->photo) {
				$imageName = time() . '.' . request()->photo->getClientOriginalExtension();

				$isMoved = request()->photo->move(public_path('assets/images/employee'), $imageName);
				if ($isMoved) {
					$is_created->photo = $imageName;
					$is_created->save();
				}
			}
		}

        return $is_created;
    }

    /**
     * get employee data
     *
     * @param  int  $id
     * @return array
     */
    public function show($id)
    {
        $employeeID = $this->commonService->decrypt($id);
        $data['employee'] = Employee::findOrFail($employeeID);
        $data['employee_uid'] = $id;
        return $data;
    }

    /**
     * get the data for edit form
     *
     * @param  int  $id
     * @return array
     */
    public function edit($id)
    {
		$employeeID = $this->commonService->decrypt($id);
		$getEmployee = Employee::findOrFail($employeeID);
		$data['employee']  = $getEmployee;

		//get role
		foreach ($getEmployee->roles as $role) {
			$emp_roles[] = $role->id;
		}
		$roles = Role::all();
		if (isset($emp_roles)) {
			foreach ($roles as $key => $role) {
				$get_roles[$key]['id'] = $role->id;
				$get_roles[$key]['name'] = $role->name;
				$get_roles[$key]['status'] = false;
				if (in_array($role->id, $emp_roles)) {
					$get_roles[$key]['status'] = true;
				}
			}
		} else {
			foreach ($roles as $key => $role) {
				$get_roles[$key]['id'] = $role->id;
				$get_roles[$key]['name'] = $role->name;
				$get_roles[$key]['status'] = false;
			}
		}
		$data['roles'] = $get_roles;
		$data['employee_uid'] = $id;

        return $data;
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
        $employeeID = $this->commonService->decrypt($id);
		$validatedData = $request->validate([
            'name' => 'required|string|max:255',
			'email' => ['required', 'string', 'email', 'max:255', Rule::unique('employees')->ignore($employeeID),],
            'roles' => 'required|array|min:1',
            'address' => 'max:255',
			'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:1048',
            'doj' => 'required|date|date_format:Y-m-d',
        ]);

        $employee = Employee::find($employeeID);
        if ($employee) {
			$employee->name = $request->name;
			$employee->email = $request->email;
			$employee->address = $request->address;
			$employee->doj = $request->doj;

		if ($employee->save()) {
			if ($request->filled('roles')) {
				$employee->roles()->sync($request->roles);
			}
			if (request()->photo) {
				$imageName = time() . '.' . request()->photo->getClientOriginalExtension();

				$isMoved = request()->photo->move(public_path('assets/images/employee'), $imageName);
				if ($isMoved) {
					$employee->photo = $imageName;
					$employee->save();
				}
			}
		}
			return $employee;
		} else {
			return abort(404);
		}
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return array
     */
    public function destroy($id)
    {
		$employeeID = $this->commonService->decrypt($id);
		$show = Employee::findOrFail($employeeID);

		return $show->delete();
    }

	public function getEmployees(Request $request){
        $data = array();
        $count_total = $count_filter = false;
            $data = array();
            $search_for = false;
            if ($request->filled('search.value')) {
                $search_for = $request->input('search.value');
            }

            $buildQuery = DB::table('employees')
                ->join('emp_roles', 'employees.id', '=', 'emp_roles.emp_id')
                ->join('roles', 'emp_roles.role_id', '=', 'roles.id')
                ->leftJoin('salaries', 'employees.id', '=', 'salaries.employee_id')
                ->select(DB::raw('employees.name,employees.email,employees.photo,employees.doj,employees.id ,GROUP_CONCAT(roles.name)as roles,GROUP_CONCAT(salaries.basic_pay + salaries.hra + salaries.medical_allowance + salaries.special_allowance + salaries.transport + salaries.lta + salaries.incentive ) as total_pay, GROUP_CONCAT(salaries.provident_fund + salaries.professional_tax)  as total_deduction, CONCAT(SUM(salaries.basic_pay + salaries.hra + salaries.medical_allowance + salaries.special_allowance + salaries.transport + salaries.lta + salaries.incentive)) as pay, CONCAT(SUM(salaries.provident_fund + salaries.professional_tax)) as dedu,  CONCAT(SUM(salaries.basic_pay + salaries.hra + salaries.medical_allowance + salaries.special_allowance + salaries.transport + salaries.lta + salaries.incentive - salaries.provident_fund - salaries.professional_tax)) as salary'))
                ->groupBy('employees.id');

            if ($search_for) {
                $buildQuery->where(function ($query) use ($search_for) {
                    $query->where('employees.name', 'LIKE', '%' . $search_for . '%');
                    $query->orWhere('employees.email', 'LIKE', '%' . $search_for . '%');
                    $query->orWhere('employees.address', 'LIKE', '%' . $search_for . '%');
                    $query->orWhere(DB::raw("DATE_FORMAT(employees.created_at, '%b %d, %Y')"), 'LIKE', '%' . $search_for . '%');
                });
            }

            $start = 0;
            $length = 10;
            if ($request->filled('start')) {
                $start = $request->start;
            }
            if ($request->filled('length')) {
                $length = $request->length;
            }

            $query_total = $query = $buildQuery->get();
            if ($request->length != -1) {
                $query = $buildQuery->limit($length)->offset($start)->get();
            }
            $employees = $query;

            if ($employees->count() > 0) {

                foreach ($employees as $key => $employee) {
                    $getRoles = [];
                    $action = '';
					$employeeID = $this->commonService->encrypt($employee->id);
					$photo = 'assets/images/dummy.png';
					if ($employee->photo != '' && file_exists( public_path('/assets/images/employee/'.$employee->photo))) {
						$photo = 'assets/images/employee/'.$employee->photo;
					}

					$action .= '<a href="' . route('employees.edit', ['employee' => $employeeID]) . '" type="button" class="btn btn-primary btn-sm" title="Edit"><i class="fa fa-edit"></i></a>';

					$action .= ' <button type="button" class="btn btn-danger btn-sm" title="Delete" data-toggle="modal" data-target="#delete_modal" data-action="' . route('employees.destroy', ['employee' => $employeeID]) . '" data-msg="Are you sure you want to delete the employee <strong>' . $employee->name . '</strong> data?" title="Delete"><i class="fa fa-trash"></i></i></button>';

					$action .= ' <a href="' . route('employees.show', ['employee' => $employeeID]) . '" type="button" class="btn btn-secondary btn-sm" title="View"><i class="fa fa-eye"></i></a>';

                    $salary = ' <a href="' . route('salary.elist', ['emp_id' => $employeeID]) . '" type="button" class="btn btn-secondary btn-sm" title="Salary details"><i class="fa fa-money"></i> '.$employee->salary.'</a>';

					$data[$key][0] = $key + 1;
                    $data[$key][1] = '<img src="' . ASSET_URL . $photo . '" width="50" class="thumbnail">';
                    $data[$key][2] = $employee->name;
                    $data[$key][3] = $employee->email;
                    $data[$key][4] = $employee->roles;
                    $data[$key][5] = date('M d, Y', strtotime($employee->doj));
                    $data[$key][6] = $salary;
                    if($action != '') {
                        $data[$key][7] = $action;
                    }
                }
            }

            $count_total = $query_total->count();
            $count_filter = $query->count();

        $dt_data = array(
            "draw" => intval($request->input('draw')),
            "recordsTotal" => intval($count_total),
            "recordsFiltered" => intval($count_filter),
            "data" => $data,
        );

        return $dt_data;
	}
}
