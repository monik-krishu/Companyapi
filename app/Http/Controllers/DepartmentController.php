<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\department;
use Illuminate\Support\Facades\Validator;
class DepartmentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $deptList = department::where('status', '=', 1)->orderBy('ID', 'DESC')->paginate(10);

        if (!empty($deptList)) {
            $response = APIResponse('200', 'Success', $deptList);
        } else {
            $response = APIResponse('201', 'No department found.');
        }          
        return $response;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
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
                'name' => 'required',
            ]);

            if ($validateData->fails()) {
                $messages = $validateData->errors()->all();
                return APIResponse('201', 'Validation errors.', $messages);
            }

            $deptContent = new department();
           
            $deptContent->name = $request->get('name');
            
            $deptContent->status = 1;
            
            $deptContent->save();

            if ($deptContent) {
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
        $deptList = department::where('id', '=', $id)->orderBy('ID', 'DESC')->get()->toArray();

        if (!empty($deptList)) {
            $response = APIResponse('200', 'Success', $deptList);
        } else {
            $response = APIResponse('201', 'No department found.');
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
        $department = department::where('id', '=' ,(int) $id)->first();

        if (!$department) {
            return APIResponse('201', 'No department found.');
        }

        $validateData = Validator::make($request->all(),[
            'name' => 'required',
        ]);

        if ($validateData->fails()) {
            $messages = $validateData->errors()->all();
            return APIResponse('201', 'Validation errors.', $messages);
        }


        $updated = department::where('id', '=' ,(int) $id)->update(
            ['name' => $request->get('name')],
            ['status' => $request->get('status')]);

        if ($updated) {
            $response = APIResponse('200', 'department has been updated successfully.');
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
        $udpated= department::where('ID',(int) $id)->delete();

        if ($udpated) {
            $response = APIResponse('200', 'Department has been deleted successfully.');
        } else {
            $response = APIResponse('201', 'Something went wrong, please try again.');
        }

        return $response;
    }
}
