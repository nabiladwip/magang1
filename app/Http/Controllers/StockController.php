<?php

namespace App\Http\Controllers;
use DB;
use App\Models\Stock;
use App\Models\Product;
use App\Models\Pembelian;
use App\Models\Jual;
use App\Models\Itembeli;
use App\Models\Itemjual;
use App\Models\Gudang;


use Illuminate\Http\Request;

class StockController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    
        // $dbstock =Product::select('pembelians.tanggal ', 'detailpembelian.kode', 'detailpembelian.jumlah as jumlahbeli','juals.tanggal', 'detailpenjualan.kode', 'detailpenjualan.jumlah as jumlahjual',Itembeli::raw("if(detailpembelian.jumlah>0,'beli',null) as status" ))
        // $dbstock =Product::select('pembelians.tanggal', 'detailpembelian.kode', 'detailpembelian.jumlah as jumlahbeli',
        // 'juals.tanggal', 'detailpenjualan.kode', 'detailpenjualan.jumlah as jumlahjual',
        // Itembeli::raw("if(detailpembelian.jumlah>0,'beli',null) as status" ),
        // Itemjual::raw("if(detailpenjualan.jumlah>0,'jual',null) as status2" ))

    //     DB::query()
    // ->fromSub(
    //     DB::table('send_to_employees')
    //         ->select([
    //             'caseid',
    //             'docs',
    //             'helper',
    //             'employee_id'
    //         ])
    //         ->union(
    //             DB::table('onprocess')
    //                 ->select([
    //                     'caseid',
    //                     'docs',
    //                     'helper',
    //                     'employee_id'
    //                 ])
    //         ),
    //     'inner'
    // )

   
        // $dbstock =Product::select('pembelians.tanggal', 'detailpembelian.kode', 'detailpembelian.jumlah as jumlahbeli',
        // 'juals.tanggal', 'detailpenjualan.kode', 'detailpenjualan.jumlah as jumlahjual',
        // Itembeli::raw("if(detailpembelian.jumlah>0,'beli',null) as status" ))

        // ->select('juals.tanggal', 'detailpenjualan.kode', 'detailpenjualan.jumlah', Itemjual::raw("if(detailpenjualan.jumlah>0,'jual',null) as status" ))
        // $dbstock = Product::select('detailpembelian.jumlah as beli','detailpenjualan.jumlah as jual', DB::raw('(CASE WHEN detailpenjualan.jumlah>0 THEN "jual" WHEN detailpembelian.jumlah>0 THEN "beli" END) as status '))
        // $dbstock =Product::select('juals.tanggal', 'detailpenjualan.kode', 'detailpenjualan.jumlah as jumlahjual','detailpembelian.jumlah as jumlahbeli', DB::raw("if(juals.notrans LIKE 'TRXB%','jual','beli') as status" ))
      
        //  ->select('juals.tanggal', 'detailpenjualan.kode', 'detailpenjualan.jumlah',)
        //  Itemjual::raw("if(detailpenjualan.jumlah>0,'jual',null) as status")


    // $dbstock = DB::table('products')
    // ->select(DB::raw(
    //     DB::table('detailpembelian')
    //     ->select([
    //         'kode',
    //         'jumlah'
    //     ])
    //     ->union(
    //         DB::table('pembelians')
    //         ->select([
    //             'tanggal'
    //         ])
    //         ),
        
    //     'inner'ZZ

    // ))
        
    public function index($kode=null, $kodegudang=null){
        
        $dbbeli = Itembeli::select(DB::raw('pembelians.tanggal as tanggal, detailpembelian.kode,pembelians.kodegudang, detailpembelian.jumlah,  "beli" as status'))
                    ->join('pembelians','pembelians.notrans','=','detailpembelian.notrans')
                    ->join('gudangs','gudangs.kodegudang','=','pembelians.kodegudang')
                    ->where('detailpembelian.kode',$kode);
                    
                    
                    // ->where('pemebelians.kodegudang', $kodegudang);
        
        $dbjual = Itemjual::select(DB::raw('juals.tanggal as tanggal, detailpenjualan.kode, juals.kodegudang, detailpenjualan.jumlah, "jual" as status'))
                    ->join('juals','juals.notrans','=','detailpenjualan.notrans')
                     ->join('gudangs','gudangs.kodegudang','=','juals.kodegudang')
                    ->where('detailpenjualan.kode',$kode);

        if($kodegudang){
            $dbjual->where('juals.kodegudang',$kodegudang);
            $dbbeli->where('pembelians.kodegudang',$kodegudang);       
            //or where        
         }
                    
        $dbstock = $dbbeli->union($dbjual)->orderby('tanggal')->get();

       
        // $dbstock->get();
 
       
         if($dbstock){
                        $stock =0;
                        $data_stock=[];
                        foreach($dbstock as $d_stock){
                            if($d_stock->status==='beli'){
                                $d_stock['kodegudang'] =$d_stock['kodegudang'];
                                $d_stock['tanggal'] =$d_stock['tanggal'];
                                $d_stock['keterangan'] ="Pembelian" .$d_stock['nama'] .' ' .$d_stock['notrans'];
                                $d_stock['masuk'] =$d_stock['jumlah'];
                                $d_stock['keluar'] =0;
                                $stock += $d_stock['masuk'];
                                $d_stock['stock']=$stock;
                            }else{
                                $d_stock['tanggal'] =$d_stock['tanggal'];
                                $d_stock['keterangan'] ="Penjualan" .$d_stock['nama'] .' ' .$d_stock['notrans'];
                                $d_stock['keluar'] =$d_stock['jumlah'];
                                $d_stock['masuk'] =0;
                                $stock -=  $d_stock['keluar'];
                                $d_stock['stock']=$stock;
                            }
                            array_push($data_stock, $d_stock );
                        }
                    }
                    // }else if($dbgudang){
                    //     $stock =0;
                    //     $data_stock=[];
                    //     foreach($dbgudang as $d_stock){
                    //         if($d_stock->status==='beli'){
                    //             $d_stock['kodegudang'] =$d_stock['kodegudang'];
                    //             $d_stock['tanggal'] =$d_stock['tanggal'];
                    //             $d_stock['keterangan'] ="Pembelian" .$d_stock['nama'] .' ' .$d_stock['notrans'];
                    //             $d_stock['masuk'] =$d_stock['jumlah'];
                    //             $d_stock['keluar'] =0;
                    //             $stock += $d_stock['masuk'];
                    //             $d_stock['stock']=$stock;
                    //         }else{
                    //             $d_stock['tanggal'] =$d_stock['tanggal'];
                    //             $d_stock['keterangan'] ="Penjualan" .$d_stock['nama'] .' ' .$d_stock['notrans'];
                    //             $d_stock['keluar'] =$d_stock['jumlah'];
                    //             $d_stock['masuk'] =0;
                    //             $stock -=  $d_stock['keluar'];
                    //             $d_stock['stock']=$stock;
                    //         }
                    //         array_push($data_stock, $d_stock );
                    //     }
                    // }
                    // } else{
                    //     return response()->json([
                    //         'data' => $dbpembelian
                    //     ]);   
                    // }  
                    
            
        return response()->json([
            'data' => $data_stock
        ]);   
    }

    // $dbstock=DB::select(DB::raw("
    // ->select('products.kode', 'products.nama', 'stock.tanggal', 'stock.jumlah', 'stock.status') from
    // (
    // ->select('pembelians.tanggal', 'detailpembelian.kode', 'detailpembelian.jumlah', 'beli' as status) from detailpembelian 
    // ->leftJoin('pembelians' on 'pembelians.notrans' '=''detailpembelian.notrans')
    // where('detailpembelian.kode' ,$kode)
    // 'union all'               
    // ->select('juals.tanggal', 'detailpenjualan.kode', 'detailpenjualan.jumlah', 'jual' as status) from detailpenjualan 
    // ->leftJoin ('juals' on 'juals.notrans' '=' 'detailpenjualan.notrans')
    // where('detailpenjualan.kode' ,$kode))
    // )
    //  stock, products
    // ->where('products.kode',$kode))
    // ->orderby('stock.tanggal','asc')
    // "));
    // dd($kode);

    // $dbstock=DB::select(DB::raw("select('kode') from products
    // "));
    
	// 		 
    
        //    ->get();


        // ->where('products.kode', $kode)
        //      ->join('detailpembelian', 'detailpembelian.kode', '=', 'products.kode')
        //      ->join('pembelians', 'pembelians.notrans', '=', 'detailpembelian.notrans')
        //     ->join('detailpenjualan', 'detailpenjualan.kode', '=', 'products.kode')
        //     ->join('juals', 'juals.notrans', '=', 'detailpenjualan.notrans')
        //     ->orderby('pembelians.tanggal','asc')
        //     ->orderby('juals.tanggal','asc')
        //     ->select(['pembelians.*', 'detailpembelian.*'])
        //     ->get();

        // ->select('pembelians.* as statusbeli')
        // ->get();

        // ->get(['pembelians.tanggal', 'detailpembelian.kode', 'detailpembelian.jumlah', 'juals.tanggal', 'detailpenjualan.kode', 'detailpenjualan.jumlah']);
        // dd($dbstock);

            // if($dbstock){
            //             $stock =0;
            //             $data_stock=[];
            //             foreach($dbstock as $d_stock){
            //                 if($d_stock['jumlahbeli']){
            //                     $stock['tanggal'] =$d_stock['tanggal'];
            //                     $stock['keterangan'] ="penjualan" .$d_stock['nama'] .' ' .$d_stock['notrans'];
            //                     $d_stock['masuk'] =$d_stock['jumlah'];
            //                     $d_stock['masuk'] =0;
            //                     $stock += $data['masuk'];
            //                     $d_stock['stock']=$stock;
            //                 }else{
            //                     $stock['tanggal'] =$d_stock['tanggal'];
            //                     $stock['keterangan'] ="penjualan" .$d_stock['nama'] .' ' .$d_stock['notrans'];
            //                     $d_stock['masuk'] =0;
            //                     $d_stock['masuk'] =$d_stock['jumlah'];
            //                     $stock -= $data['masuk'];
            //                     $d_stock['stock']=$stock;
            //                 }
            //                 array_push($data_stock, $data);
            //             }
            //         }
    
      

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
       
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
//         $datastock = "SELECT products.kode, juals.kode, pembelians.kode
// FROM ((products
// INNER JOIN juals ON products.kode = juals.kode)
// INNER JOIN pembelians ON products.kode = pembelians.kode)"; 

//     // $nama= "SELECT products.nama,"

//         // $datastock = DB::table('products')->join('juals', 'juals.kode', '=','products.kode')
//         // ->join('belis', 'belis.kode','=','products.kode')
//         // ->select('juals.kode', 'juals.jumlah','belis.kode', 'belis.jumlah')
//         // ->get();
//         $stock = Stock::create([
//             'kode' =>$request->kode,
//             'nama' =>,
//             'stock' =>
            

//         ]);

//         return response()->json([
//             'data'=>$datastock
//         ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Stock  $stock
     * @return \Illuminate\Http\Response
     */
    public function show(Stock $stock)
    {
        return response()->json([
            'data'=>$datastock
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Stock  $stock
     * @return \Illuminate\Http\Response
     */
    public function edit(Stock $stock)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Stock  $stock
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Stock $stock)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Stock  $stock
     * @return \Illuminate\Http\Response
     */
    public function destroy(Stock $stock)
    {
        //
    }
}
