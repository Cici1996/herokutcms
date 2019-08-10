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
                            WHEN "Member_Kelamin" = \'1\' THEN \'Laki-laki\'
                            WHEN "Member_Kelamin" = \'2\' THEN \'Perempuan\'
                            ELSE \'Tidak diketahui\' 
                        END AS Nama'),
                        DB::raw('count("Member_Kelamin") as Jumlah'))
                ->get();
        
        return response()->json($q);  
    }

    public function LpById(Request $request,$id){


        $q = LpModel::where('lp_id', '=', $id)
                ->select(
                    'lp_id',
                    'lp_model',
                    'lp_desk',
                    DB::raw('UPPER("lp_nomor") AS lp_Nomor'),
                    DB::raw('LOWER("lp_pola_modus") AS lp_Pola_Modus'),
                    DB::raw('LOWER("lp_pola_motif") AS lp_Pola_Motif'),
                    DB::raw('LOWER("lp_pola_sasaran") AS lp_Pola_Sasaran'),
                    DB::raw('TO_CHAR("lp_tanggal" :: DATE, \'Mon dd, yyyy\') AS lp_Tanggal'))
                ->get();
        
        return response()->json($q);

    }
}
