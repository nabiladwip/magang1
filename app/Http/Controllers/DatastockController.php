<?php

namespace App\Http\Controllers;

use App\Models\Datastock;
use App\Models\Product;
use Illuminate\Http\Request;

class DatastockController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($kode=null, $kodegudang=null)
    {
        $dbbarangjual = Product::select(DB::raw('products.kode', 'products.nama'))
                ->join('datastocks','datastocks.kode','=','producst.kode')
                ->join('juals','juals.notrans','=','detailpenjualan.notrans')
                ->join('gudangs','gudangs.kodegudang','=','juals.kodegudang')
                ->where('detailpembelian.kode',$kode);
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
        $datastock = Datastock::create([
            'kode' =>$request->kode,
            'minimum' =>$request->minimum,
            'maksimal' =>$request->maksimal,
        ]);

        return response()->json([
            'data'=>$datastock
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Datastock  $datastock
     * @return \Illuminate\Http\Response
     */
    public function show(Datastock $datastock)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Datastock  $datastock
     * @return \Illuminate\Http\Response
     */
    public function edit(Datastock $datastock)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Datastock  $datastock
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Datastock $datastock)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Datastock  $datastock
     * @return \Illuminate\Http\Response
     */
    public function destroy(Datastock $datastock)
    {
        //
    }
}
