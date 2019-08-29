<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProvinsiController extends Controller
{
    
    public function paginate(){

        $provinsi = DB::table('provinces')
                    ->paginate(request('limit',20));

        if(request()->all()){
            $provinsi->appends(request()->all());
        }

        return response()->json($provinsi);

    }

    public function view(){
        return view('provinsi.index');
    }

    public function store(Request $request){
        $this->validate($request,[
            'name' => 'required'
        ]);

        $provinces = DB::table('provinces')->insert([
                'name' => $request->name
            ]);

        return response()->json($provinces);
    }

    public function show($id){
        $provinces = DB::table('provinces')->where('id','=',$id)->first();

        if(empty($provinces)){
            return response()->json(['message' => 'data not found'], 404);
        }

        return response()->json($provinces);
    }
}
