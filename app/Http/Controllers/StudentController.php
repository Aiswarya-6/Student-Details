<?php

namespace App\Http\Controllers;

use App\Models\Country;
use App\Models\State;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class StudentController extends Controller
{
    public function index()
    {
        $country = Country::all('id', 'countryName');

        return view("welcome")->with('country', $country);
    }
    public function store(Request $request)
    {
        // dd($request->toArray());
        try {
            $error = $this->studentValidation($request, 0);
            if (!empty($error['statusCode']) == 400) return response()->json($error, 400);

            $response = Student::create([
                'name' => $request->name,
                'countryId' => $request->countryId,
                'stateId' => $request->stateId,
                'image' => $request->image
            ]);
            dd($response->toArray());
            return view('welcome');
            throw new \Exception('student creation failed.');
        } catch (\Exception $e) {
            $error = [];
            $error['errorMessage'] = $e->getMessage();
            $error['filePath'] = $e->getFile();
            $error['lineNumber'] = $e->getLine();

            return response()->json([
                'message' => 'No result found.',
                'error' => $error,
                'statusCode' => 400,
                'status' => 'failed',
                'errorMessages' =>  ['No result found.']
            ], 400);
        }
    }
    public function studentValidation(Request $request, $id)
    {
        $data = $request->all();


        $validator = Validator::make(
            $data,
            [
                'name' => 'required|string',
                'countryId' => 'required|integer',
                'stateId' => 'required|integer',
                'image' => 'required|string',
            ]
        );
        if ($validator->fails()) {
            $error = [
                'message' => 'Validation failed.',
                'error' => $validator->errors(),
                'statusCode' => 400,
                'status' => 'failed',
                'errorMessages' =>  $validator->errors()->all()
            ];
            return $error;
        }
    }

    public function place($id)
    {
        try {

            $country = Country::with('state')->where('id', $id)->first();

            if (empty($country)) {
                throw new \Exception("No results found.");
            }

            return $country;
        } catch (\Exception $e) {
            $error = [];
            $error['errorMessage'] = $e->getMessage();
            $error['filePath'] = $e->getFile();
            $error['lineNumber'] = $e->getLine();

            return response()->json([
                'message' => 'No results found.',
                'error' => $error,
                'statusCode' => 400,
                'status' => 'failed',
                'errorMessages' =>  ['No results found.']
            ], 400);
        }
    }

    public function list()
    {
        try {
            $response = Country::with('state')->orderBy('id', 'desc')->get();

            if (empty($response->toArray())) {
                throw new \Exception('No results found.');
            }
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Something went wrong.',
                'error' => $e->getMessage(),
                'statusCode' => 400,
                'status' => 'failed',
                'errorMessages' =>  ['Something went wrong.']
            ], 400);
        }

        return view('list')->with(array('response' => $response));
    }
}
