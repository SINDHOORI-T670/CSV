<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\csvdata;
use File;
use DB;
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
        if(!empty($insert)){
            DB::table('csvdatas')->insert($insert);
        }
        
        return redirect()->route('csvs');
    }
}
