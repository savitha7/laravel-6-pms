<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\SalaryService;
use Illuminate\Http\Response;

class SalaryController extends Controller
{

	protected $salaryService;

	public function __construct(SalaryService $salaryService)
	{
		$this->salaryService = $salaryService;
	}

    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $data['page_set'] = 'list_salary';
		$data['emp_id'] = $request->emp_id;

        return view('salary.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @param Request $request
     * @return Response
     */
    public function create(Request $request)
    {
        $data = $this->salaryService->create($request);
		return view('salary.create',$data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return Response
     */
    public function store(Request $request)
    {
        $this->salaryService->store($request);

        return redirect('/salary')->with('success', 'Salary data is successfully saved');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id)
    {
		$data = $this->salaryService->show($id);

        return view('salary.show', $data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($id)
    {
        $data = $this->salaryService->edit($id);

        return view('salary.edit', $data);
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
        $this->salaryService->update($request,$id);

		return redirect('/salary')->with('success', 'Salary data is successfully updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id)
    {
        $this->salaryService->destroy($id);

        return redirect('/salary')->with('success', 'Salary data is successfully deleted');
    }

	public function getSalaries(Request $request){
        $data = $this->salaryService->getSalaries($request);

        if ($request->ajax()) {
            echo json_encode($data);
        } else {
            return redirect()->back();
        }
	}

}
