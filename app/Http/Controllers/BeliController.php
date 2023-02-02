<?php

namespace App\Http\Controllers;

use App\Models\Beli;
use Illuminate\Http\Request;

class BeliController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // $belis = Beli::paginate(10)->map(function ($belis){
        //     return[
        //         'notrans' =>($belis->notrans),
        //         'tanggal' =>($belis->tanggal),
        //         'supplier' =>($belis->supplier),
        //         'itembeli' =>json_decode($belis->itembeli),
        //     ];

        // });
        // return response()->json([
        //     'data' => $belis
        // ]);
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
     
            // $beli = Beli::create([
            //     'notrans'          => $request->notrans,
            //     'tanggal'          => $request->tanggal,
            //     'supplier'          => $request->supplier,
            //     'itembeli'          => json_encode($request->itembeli),
            //    //jsoncode untuuk panggil data array
            // //    $beli->save();
                
            // ]);
            $beli = new Beli;
            $beli->notrans = $request->notrans;
            $beli->tanggal = $request->tanggal;
            $beli->supplier = $request->supplier;
            $beli->itembeli =json_encode($request->itembeli);
           
            // foreach ($request->itembeli as $itembeli) {
            //     $beli->itembeli = $itembeli;
            // }
            $beli->save();
    
            return response()->json([
                'data'=> $tanggal
            ]);
        
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Beli  $beli
     * @return \Illuminate\Http\Response
     */
    public function show(Beli $beli)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Beli  $beli
     * @return \Illuminate\Http\Response
     */
    public function edit(Beli $beli)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Beli  $beli
     * @return \Illuminate\Http\Response
     */
    public function update($id=null,Request $request)
    {
       
        $beli = Beli::find($id);
        $beli = Beli::where('id',$id)->first();
        $beli->notrans = $request->notrans;
        $beli->tanggal = $request->tanggal;
        $beli->supplier = $request->supplier;
        $beli->itembeli =json_encode($request->itembeli);
        $beli->save();
        
        return response()->json([
            'data'=> $beli
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Beli  $beli
     * @return \Illuminate\Http\Response
     */
    public function destroy(Beli $beli)
    {
        //
    }
}
