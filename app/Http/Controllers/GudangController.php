<?php

namespace App\Http\Controllers;

use App\Models\Gudang;
use Illuminate\Http\Request;

class GudangController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
        $gudang = Gudang::create([
            'kodegudang' =>$request->kodegudang,
            'nama' =>$request->nama,
            'alamat' =>$request->alamat,
            'kota' =>$request->kota,
            'provinsi' =>$request->provinsi,
            'namakontak' =>$request->namakontak,
            'telp' =>$request->telp,
          
        ]);

        return response()->json([
            'data'=>$gudang
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Gudang  $gudang
     * @return \Illuminate\Http\Response
     */
    public function show(Gudang $gudang)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Gudang  $gudang
     * @return \Illuminate\Http\Response
     */
    public function edit(Gudang $gudang)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Gudang  $gudang
     * @return \Illuminate\Http\Response
     */
    public function update($id=null,Request $request)
    {
        $gudang = Gudang::find($id);
        $gudang->kodegudang = $request->kodegudang;
        $gudang->nama = $request->nama;
        // $product->jumlah = $request->jumlah;
        $gudang->alamat = $request->alamat;
        $gudang->kota = $request->kota;
        $gudang->provinsi = $request->provinsi;
        $gudang->namakontak = $request->namakontak;
        $gudang->telp = $request->telp;
     
        $gudang->save();

        return response()->json([
            'data' => $gudang
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Gudang  $gudang
     * @return \Illuminate\Http\Response
     */
    public function destroy(Gudang $gudang)
    {
        //
    }
}
