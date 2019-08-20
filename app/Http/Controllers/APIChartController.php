<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use JWTFactory;
use JWTAuth;
use Validator;
use Illuminate\Support\Facades\DB;

use App\Models\MemberModel;
use App\Models\LpModel;
use App\Models\VJenisUsiaModel;

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

    public function Lp(Request $request){


        $q = LpModel::select(
                    'lp_id AS id',
                    'lp_model AS model',
                    'lp_desk AS desk',
                    DB::raw('UPPER("lp_nomor") AS nomor'),
                    DB::raw('TO_CHAR("lp_tanggal" :: DATE, \'Mon dd, yyyy\') AS tanggal'))
                ->get();
        
        return response()->json($q);

    }

    public function ChartUsia(Request $request){

        $q = VJenisUsiaModel::get();
        return response()->json($q);

    }

    public function DetailUserData(Request $request,$id){

        $q = DB::table('users AS a')
                ->select(
                    'id',
                    'member_id',
                    'Member_NRP AS member_nrp',
                    'Member_Nama AS member_nama',
                    DB::raw('TO_CHAR("Member_Tgl_Lahir" :: DATE, \'Mon dd, yyyy\') AS tanggal_lahir'),
                    DB::raw('CASE 
                                WHEN "Member_Kelamin" = \'1\' THEN \'Laki-laki\'
                                WHEN "Member_Kelamin" = \'2\' THEN \'Perempuan\'
                            ELSE \'Tidak diketahui\' END AS kelamin')
                    )
                ->join('t_member AS b','b.Member_ID','=','a.member_id')
                ->where('b.Member_ID','=','671')
                ->get();
        return response()->json($q);

    }
}
