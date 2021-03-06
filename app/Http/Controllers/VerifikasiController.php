<?php

namespace App\Http\Controllers;
use App\Models\Pesanan;
use DB;
use Illuminate\Http\Request;

class VerifikasiController extends Controller
{
    public function __construct()
    {
       $this->middleware('auth:admin');
    }

    public function index()
    {   
        $i=0;
        $x=0;
        $pesananVerif = Pesanan::where('status', '1')->get(); 
        $pesananNonVerif = Pesanan::where('status', '0')->get(); 

        return view('admin.verifikasi', ['pesananNonVerif' => $pesananNonVerif , 'pesananVerif' => $pesananVerif , 'i' => $i , 'x' => $x]); 
    }
    public function view($id)
    {
        $i=0;
        $pesananVerif = DB::table('pesanans')
            ->join('pembayarans', 'pesanans.id', '=', 'pembayarans.pesanan_id')
            ->where('pesanans.id', '=', $id)
            ->get();
        return view('admin.verifikasi_view', ['pesananVerif' => $pesananVerif  , 'i' => $i]);
    }
    public function update($id)
{
    $pesananNonVerif = Pesanan::find($id);
    $pesananNonVerif->status = 1;
    $pesananNonVerif->update();
    return redirect()->route('admin.verifikasi')
                        ->with('success','Berhasil Verifikasi!');
}
}
