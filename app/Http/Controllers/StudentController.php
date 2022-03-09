<?php

namespace App\Http\Controllers;

use App\Models\Country;
use App\Models\State;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
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
        
        try {
            $error = $this->studentValidation($request, 0);
        
            if (!empty($error['statusCode']) == 400) return response()->json($error, 400);
            $response = $request->all();

            $arrayMap = [];
            $index = 0;
            foreach ($response['name'] as $key => $value) {
                $collection = collect($response);
                $array = $collection->map(function ($value) use ($key) {
                    return $value[$key];
                });
                $arrayMap[$index] = $array->toArray();
                $index++;
            }

            foreach ($arrayMap as $data) {

                $result = Student::create([
                    'name' => $data['name'],
                    'countryId' => $data['countryId'],
                    'stateId' => $data['stateId'],
                    'image' => $this->upload($data['image'])
                ]);
            }

            return redirect('/list');

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
                'name' => 'required|array',
                'countryId' => 'required|array',
                'stateId' => 'required|array',
                'image' => 'required|array',
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
            $response = Student::with(['country', 'state'])->orderBy('id', 'desc')->get();
            // dd($response->toArray());
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
    public function upload($request)
    {
        $file = $request;
        $fileName = $file->getClientOriginalName();
        $folder = Str::random(10);
        $data = $file->storeAs("files/{$folder}", $fileName, "fileUploadToPublic");
        return $data;
    }
}
