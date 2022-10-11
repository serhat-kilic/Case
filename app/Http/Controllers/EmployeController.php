<?php

namespace App\Http\Controllers;

use App\Models\Car;
use App\Models\Employee;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class EmployeController extends BaseController
{
    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function create(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|max:255',
            'surname' => 'required|max:255',
            'email' => 'required|email|unique:employees',
            'sex' => 'in:male,female',
            'age' => 'numeric'
        ]);

        $employee = Employee::create($validatedData);
        return $this->responseMessage('success','Employee created successfully',$employee);
    }

    public function edit(Request $request, $id)
    {
        $validatedData = $request->validate([
            'name' => 'required|max:255',
            'surname' => 'required|max:255',
            'email' => 'required|email|unique:employees,email,' . $id,
            'sex' => 'in:male,female',
            'age' => 'numeric'
        ]);
        $employee = Employee::find($request->id);
        if ($employee) {
            $employee->update($validatedData);
            return $this->responseMessage('success','Employee updated succesfully',$employee);
        } else {
            return $this->responseMessage('error','No such employee was found.',422);
        }

    }

    public function index()
    {
        if (!Cache::has('employees')) {
            $employees = Cache::rememberForever('employees', function () {
                return Employee::all();
            });
        } else {
            $employees = Cache::get('employees');
        }
        return $this->responseMessage('success', '', $employees);


    }

    public function delete($id)
    {
        $employee = Employee::find($id);
        if ($employee) {
            $employee->delete();
            return $this->responseMessage('success', 'Employee was deleted');
        } else {
            return $this->responseMessage('error', 'No such employee was found.', '', 422);
        }
    }

    public function giveCar(Request $request){
        $validatedData = $request->validate([
            'employee_id' => 'required|numeric|unique:cars,employee_id',
            'car_id' => 'required|numeric',
        ]);
        $employee=Employee::find($request->employee_id);
        $car=Car::find($request->car_id);

        if(!$employee || !$car){
            return $this->responseMessage('error','Entered values are incorrect','',422);
        }
        $car->update(['employee_id'=>$employee->id]);
        return $this->responseMessage('success','Vehicle assigned to employee',Employee::where('id',$request->employee_id)->with('car')->get());
    }

    public function employee($id){
        $employee=Employee::find($id);
        if($employee){
            return $this->responseMessage('success','',$employee);
        }else{
            return $this->responseMessage('error','No such employee was found.','',422);
        }
    }

    public function search(Request $request){
        $employees=Employee::where('name','like','%'.$request->q.'%')->orWhere('surname','like','%'.$request->q.'%')->orWhere('email','like','%'.$request->q.'%')->get();
        return $this->responseMessage('success','',$employees);
    }


    public function employeesCars(){
        $cars=Car::with('employee')->where('employee_id','!=',null)->get();
        return $this->responseMessage('success','',$cars);

    }
}
