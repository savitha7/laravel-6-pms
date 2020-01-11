<?php

namespace App\Services;

use Illuminate\Http\Request;
use App\Models\Salary;
use App\Models\Employee;
use Illuminate\Http\Response;
use Illuminate\Validation\Rule;
use DB;

class SalaryService
{

    protected $commonService;
    protected const ENCRYPT_PREFIX = 'salary:';

    public function __construct(CommonService $commonService)
    {
        $this->commonService = $commonService;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @param Request $request
     * @return Response
     */
    public function create(Request $request)
    {
        $data['employees'] = Employee::all();
        $data['emp_id'] = $this->commonService->decrypt($request->emp_id);
		return $data;
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return Response
     */
    public function store(Request $request)
    {
        $getEmployee = Employee::findOrFail($request->employee_id);

		$request['salary_month'] = date('Y-m-d', strtotime($request->salary_month.'-25'));
		$validatedData = $request->validate([
            'employee_id' => 'required|exists:employees,id',
			'salary_month' => ['required', 'date',Rule::unique('salaries')->where(function ($query) use ($request) {
                            $query->where('employee_id', $request->employee_id);
                        }),'after_or_equal:' . $getEmployee->doj],
            'working_days' => 'required|max:2',
            'basic_pay' => 'required|max:11',
            'hra' => 'required|max:11',
            'medical_allowance' => 'required|max:11',
            'special_allowance' => 'required|max:11',
            'transport' => 'required|max:11',
            'lta' => 'required|max:11',
            'provident_fund' => 'required|max:11',
            'professional_tax' => 'required|max:11'
        ],['salary_month.after_or_equal'=>'The salary month must be greater than DOJ.']);

        return Salary::create($validatedData);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id)
    {
        $salaryID = $this->commonService->decrypt($id,self::ENCRYPT_PREFIX);
        $getSalary = Salary::select(DB::raw('salaries.*,(basic_pay + hra + medical_allowance + special_allowance + transport + lta + incentive ) as total_pay, (provident_fund + professional_tax)  as total_deduction'))->findOrFail($salaryID);
		$data['salary'] = $getSalary;
		$data['employee'] = $getSalary->employee;

        return $data;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($id)
    {
        $salaryID = $this->commonService->decrypt($id,self::ENCRYPT_PREFIX);
        $data['salary'] = Salary::findOrFail($salaryID);
		$data['employees'] = Employee::all();
        $data['salary_uid'] = $id;
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
        $getEmployee = Employee::findOrFail($request->employee_id);
        $salaryID = $this->commonService->decrypt($id,self::ENCRYPT_PREFIX);
		$request['salary_month'] = date('Y-m-d', strtotime($request->salary_month.'-25'));
		$validatedData = $request->validate([
            'employee_id' => 'required|exists:employees,id',
			'salary_month' => ['required','date',Rule::unique('salaries')->where(function ($query) use ($request) {
                            $query->where('employee_id', $request->employee_id);
                        })->ignore($salaryID),'after_or_equal:' . $getEmployee->doj],
            'working_days' => 'required|max:2',
            'basic_pay' => 'required|max:11',
            'hra' => 'required|max:11',
            'medical_allowance' => 'required|max:11',
            'special_allowance' => 'required|max:11',
            'transport' => 'required|max:11',
            'lta' => 'required|max:11',
            'provident_fund' => 'required|max:11',
            'professional_tax' => 'required|max:11'
        ],['salary_month.after_or_equal'=>'The salary month must be greater than DOJ.']);

		return Salary::whereId($salaryID)->update($validatedData);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id)
    {
        $salaryID = $this->commonService->decrypt($id,self::ENCRYPT_PREFIX);
        $salary = Salary::findOrFail($salaryID);

        return $salary->delete();
    }

	public function getSalaries(Request $request){
        $data = array();
        $count_total = $count_filter = false;
            $data = array();
            $search_for = false;
            if ($request->filled('search.value')) {
                $search_for = $request->input('search.value');
            }

            $buildQuery = Salary::select(DB::raw('salaries.*,(basic_pay + hra + medical_allowance + special_allowance + transport + lta + incentive ) as total_pay, (provident_fund + professional_tax)  as total_deduction'))->with(['employee'])->orderBy('salaries.id', 'desc');

			if ($request->filled('emp_id')) {
                $employeeID = $this->commonService->decrypt($request->emp_id);
                $buildQuery->where('salaries.employee_id',$employeeID);
            }

            if ($search_for) {
                $buildQuery->where(function ($query) use ($search_for) {
                    $query->where('salaries.salary_month', 'LIKE', '%' . $search_for . '%');
                    $query->orWhere('total_pay', 'LIKE', '%' . $search_for . '%');
                    $query->orWhere('total_deduction', 'LIKE', '%' . $search_for . '%');
                    $query->orWhere(DB::raw("DATE_FORMAT(salaries.created_at, '%b %d, %Y')"), 'LIKE', '%' . $search_for . '%');
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
            $salaries = $query;

            if ($salaries->count() > 0) {

                foreach ($salaries as $key => $salary) {
                    $action = '';
					$salaryMonth = date('M, Y', strtotime($salary->salary_month));
                    $salaryID = $this->commonService->encrypt($salary->id,self::ENCRYPT_PREFIX);

					$action .= '<a href="' . route('salary.edit', ['salary' => $salaryID]) . '" type="button" class="btn btn-primary btn-sm" title="Edit"><i class="fa fa-edit"></i></a>';

					$action .= ' <button type="button" class="btn btn-danger btn-sm" title="Delete" data-toggle="modal" data-target="#delete_modal" data-action="' . route('salary.destroy', ['salary' => $salaryID]) . '" data-msg="Are you sure you want to delete the employee <strong>' .$salary->employee->name.' : '. $salaryMonth. '</strong> salary data?" title="Delete"><i class="fa fa-trash"></i></i></button>';

					$action .= ' <a href="' . route('salary.show', ['salary' => $salaryID]) . '" type="button" class="btn btn-secondary btn-sm" title="View"><i class="fa fa-eye"></i></a>';

                    $data[$key][0] = $key + 1;
                    $data[$key][1] = $salary->employee->name;
                    $data[$key][2] = $salary->employee->email;
                    $data[$key][3] = $salaryMonth;
                    $data[$key][4] = $salary->total_pay;
                    $data[$key][5] = $salary->total_deduction;
                    if($action != '') {
                        $data[$key][6] = $action;
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
