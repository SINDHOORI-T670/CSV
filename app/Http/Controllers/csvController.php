<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\csvdata;
use File;
use DB;
use Mail;
class csvController extends Controller
{
    public function index(){
        $datas = csvdata::all();
        return view('index',compact('datas'));
    }
    public function addcsv(){
        return view('addcsvpage');
    }
    public function uploadcsvdata(Request $request){
        $request->validate([
            'file' => 'required|mimes:csv,txt'
        ],[
            'file.required'=>'Please uplaod file',
            'file.mimes'=>'Invalid CSV: File must have .csv extension.'
        ]);
        
        $file = $request->file('file');

        $csvData = file_get_contents($file);

        $rows = array_map("str_getcsv", explode("\n", $csvData));

        $header = array_shift($rows);
        $titles = csvdata::pluck('modulecode','modulename','moduleterm')->toArray();
        foreach ($rows as $key => $value) {
            if ($value[0] == "") {
                continue;
            }
            $value = array_combine($header, $value);
            if (in_array($value['module_code'], $titles))
                continue;
            if (in_array($value['module_name'], $titles))
                continue;
            if (in_array($value['module_term'], $titles))
                continue;
                
            $insert[] = ['modulecode' => $value['module_code'], 'modulename' => $value['module_name'],'moduleterm' => $value['module_term']];
            $titles[] = [$value['module_code'],$value['module_name'],$value['module_term']];
        }
        $rules=[
            '*.modulecode' => [
                'required'
            ],
            '*.modulename' => [
                'required'
            ],
            '*.moduleterm' => [
                'required'
            ]
        ];
        $messages = [];
        foreach($insert as $rowNum => $row)
        {
            foreach($row as $field => $value) {
                $messages["{$rowNum}."."$field".'.required'] = "{$field} is missing at row 1";
                // $messages["{$rowNum}."."$field".'.regex'] = "The {$field} contains symbols at row {$rowNum}";
            }
        }
        $validator = Validator::make($insert,$rules,$messages);
            if($validator->fails()){
                $errors=$validator->errors();
                Mail::send('emails.validationmail', ['errors' => $errors], function ($m) use ($errors) {
                    $m->from('sindhooritavm@gmail.com', 'Validation Mail');
        
                    $m->to('charush@accubits.com', 'Charush')->subject('Listing of validation erros for CSV import');
                });
                return redirect()->back()->with('error','Something went wrong,please check the mail');
            }else{
               if(!empty($insert)){
                    DB::table('csvdatas')->insert($insert);
                }
                return redirect()->route('csvs');
            }    
        }
}
