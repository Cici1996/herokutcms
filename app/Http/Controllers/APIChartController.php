<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use JWTFactory;
use JWTAuth;
use Validator;
use Illuminate\Support\Facades\DB;

use App\Models\MemberModel;
use App\Models\LpModel;

class APIChartController extends Controller
{
    public function ChartKelamin(Request $request){

        $q = MemberModel::groupBy('Member_Kelamin')
                ->select('Member_Kelamin AS Id', 
                        DB::raw('CASE
                            WHEN Member_Kelamin = 1 THEN "Laki-laki"
                            WHEN Member_Kelamin = 2 THEN "Perempuan"
                            ELSE "Tidak diketahui" 
                        END AS Nama'),
                        DB::raw('count(Member_Kelamin) as Jumlah'))
                ->get();
        
        return response()->json($q);  
    }

    public function LpById(Request $request,$id){


        $q = LpModel::where('LP_Id', '=', $id)
                ->select(
                    'LP_Id',
                    'LP_Model',
                    'LP_Desk',
                    DB::raw('UPPER(LP_Nomor) AS LP_Nomor'),
                    DB::raw('LOWER(LP_Pola_Modus) AS LP_Pola_Modus'),
                    DB::raw('LOWER(LP_Pola_Motif) AS LP_Pola_Motif'),
                    DB::raw('LOWER(LP_Pola_Sasaran) AS LP_Pola_Sasaran'),
                    DB::raw('DATE_FORMAT(LP_Tanggal, "%d %M %Y") AS LP_Tanggal'))
                ->get();
        
        return response()->json($q);

    }
}
