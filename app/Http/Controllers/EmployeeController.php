<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\department;
use App\Models\Employee;
use App\Models\phonenumberEmployee;
use App\Models\AddressEmployee;
use Illuminate\Support\Facades\Validator;
class EmployeeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $empList = Employee::where('status', '=', 1)->with('Department','Address','phone')->orderBy('ID', 'DESC')->get()->toArray();
        if (!empty($empList)) {
            $response = APIResponse('200', 'Success', $empList);
        } else {
            $response = APIResponse('201', 'No Employee found.');
        }          
        return $response;
    }

 

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
      
        if (!empty($request)) {
            $validateData = Validator::make($request->all(),[
                'first_name' => 'required',
                'last_name' => 'required',
                'dept_id' => 'required',
            ]);

            if ($validateData->fails()) {
                $messages = $validateData->errors()->all();
                return APIResponse('201', 'Validation errors.', $messages);
            }

            $empContent = new Employee();
           
            $empContent->first_name = $request->get('first_name');
            $empContent->last_name = $request->get('last_name');
            $empContent->dept_id = $request->get('dept_id');
            $empContent->status = 1;
            $empContent->save();
            $emp_id = $empContent->id;
            if(!empty($emp_id)){
                foreach($request->get('address') as $val){
                    $empaddress= new AddressEmployee();
                    $empaddress->employee_id = $emp_id;
                    $empaddress->address = $val;
                    $empaddress->save();

                }
                foreach($request->get('phonenumber') as $val){
                    $empphone= new phonenumberEmployee();
                    $empphone->employee_id = $emp_id;
                    $empphone->phonenumber = $val;
                    $empphone->save();

                }
            }
            
            if ($empContent) {
                $response = APIResponse('200', 'Data has been added successfully.');
            } else {
               $response = APIResponse('201', 'Something went wrong, please try again.'); 
            }
                    
        } else {
            $response = APIResponse('201', 'Something went wrong, please try again.');
        }
        return $response;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $empList = Employee::where('id', '=', $id)->with('Department','Address','phone')->orderBy('ID', 'DESC')->get()->toArray();

        if (!empty($empList)) {
            $response = APIResponse('200', 'Success', $empList);
        } else {
            $response = APIResponse('201', 'No employee found.');
        }          
        return $response;
    }



    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $employee = Employee::where('id', '=' ,(int) $id)->first();

        if (!$employee) {
            return APIResponse('201', 'No Employee found.');
        }

        $validateData = Validator::make($request->all(),[
            'first_name' => 'required',
            'last_name' => 'required',
            'dept_id' => 'required',
        ]);

        if ($validateData->fails()) {
            $messages = $validateData->errors()->all();
            return APIResponse('201', 'Validation errors.', $messages);
        }


        $updated = Employee::where('id', '=' ,(int) $id)->update(
            ['first_name' => $request->get('first_name')],
            ['last_name' => $request->get('last_name')],   
            ['dept_id' => $request->get('dept_id')],
            ['status' => $request->get('status')]);
           
            if(!empty($id)){
                AddressEmployee::where("employee_id",$id)->delete();
                phonenumberEmployee::where("employee_id",$id)->delete();
                foreach($request->get('address') as $val){
                    $empaddress= new AddressEmployee();
                    $empaddress->employee_id = $id;
                    $empaddress->address = $val;
                    $empaddress->save();
                }
                foreach($request->get('phonenumber') as $val){
                    $empphone= new phonenumberEmployee();
                    $empphone->employee_id = $id;
                    $empphone->phonenumber = $val;
                    $empphone->save();
                }
            }

        if ($updated) {
            $response = APIResponse('200', 'Employee has been updated successfully.');
        }
        else {
            $response = APIResponse('201', 'Something went wrong, please try again.');
        }

        return $response;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $udpated= Employee::where('ID',(int) $id)->delete();
        AddressEmployee::where("employee_id",$id)->delete();
        phonenumberEmployee::where("employee_id",$id)->delete();
        if ($udpated) {
            $response = APIResponse('200', 'Employee has been deleted successfully.');
        } else {
            $response = APIResponse('201', 'Something went wrong, please try again.');
        }

        return $response;
    }

    public function searchByTitle($title) 
    {
        $data = Employee::where('first_name','LIKE','%'.$title.'%')->where('status', '=', 1)->orderBy('ID', 'DESC')->paginate(10);

        if (!empty($data)) {
            $response = APIResponse('200', 'Success', $data);
        } else {
            $response = APIResponse('201', 'No data found.');
        }          
        return $response;
    }

}
