<?php

namespace App\Http\Controllers;
use App\Models\Pembelian;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Stock;
use App\Models\Itembeli;
use App\Models\Gudang;
use Illuminate\Support\Facades\DB;

class PembelianController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $pembelians = Pembelian::paginate(10)->map(function ($pembelians){
            return[
                'notrans' =>($pembelians->notrans),
                'tanggal' =>($pembelians->tanggal),
                'supplier' =>($pembelians->supplier),
                'itembeli' => Itembeli::where('notrans',$pembelians->notrans)->get()
            ];

        });
        return response()->json([
            'data' => $pembelians
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
   

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //  $pembelian = Pembelian::create([
        //         'notrans'          => $request->notrans,
        //         'tanggal'          => $request->tanggal,
        //         'supplier'          => $request->supplier,
        //         'itembeli'          => json_encode($request->itembeli),
        //        //jsoncode untuuk panggil data array
        //  ]);
         $pembelian = new Pembelian;
         $pembelian->notrans = $request->notrans;
         $pembelian->tanggal = $request->tanggal;
         $pembelian->supplier = $request->supplier;
         $pembelian->kodegudang =$request->kodegudang;
         $gudang=DB::table('gudangs')->where('kodegudang', $request->kodegudang)->first();
         if($gudang){
            foreach ($request->itembeli as $val) {
                $product = DB::table('products')->where('kode', $val['kode'])->first();
                $stock=0;
          if($product){
            $itembeli = new Itembeli;
            $itembeli->notrans = $request->notrans;
            $itembeli->kode = $val['kode'];
            $itembeli->jumlah = $val['jumlah'];

            $stock=DB::table('datastocks')->where('maksimal', $val['jumlah'])->where('kode',$val['kode'])->get();
    
            if(count($stock) > $request->kode){
                return 'error melebihi stock'.' '.$val['kode'];
               }else {
                $itembeli->save();
               }
            
         }  
        }
        $stock=DB::table('datastocks')->where('maksimal', $val['jumlah'])->where('kode',$val['kode'])->get();
    
        if(count($stock) > $request->kode){
            return 'error melebihi stock pada kode barang' .' '.$val['kode'];
           }else {
            $pembelian->save();
           }
      
    }
    return response()->json([
        'data'=> $pembelian
    ]);

}
//  $dbbeli = Itembeli::select(DB::raw('pembelians.tanggal as tanggal, detailpembelian.kode,pembelians.kodegudang, detailpembelian.jumlah,  "beli" as status'))
        //             ->join('pembelians','pembelians.notrans','=','detailpembelian.notrans')
        //             ->join('gudangs','gudangs.kodegudang','=','pembelians.kodegudang')
        //             ->where('detailpembelian.kode',$kode)->sum('jumlah')->groupBy('kode')->get();
                    
        //             // ->where('pemebelians.kodegudang', $kodegudang);
        
        // $dbjual = Itemjual::select(DB::raw('juals.tanggal as tanggal, detailpenjualan.kode, juals.kodegudang, detailpenjualan.jumlah, "jual" as status'))
        //             ->join('juals','juals.notrans','=','detailpenjualan.notrans')
        //              ->join('gudangs','gudangs.kodegudang','=','juals.kodegudang')
        //             ->where('detailpenjualan.kode',$kode);
        
        //  $pembelian->itembeli =json_encode($request->itembeli);
        // foreach($itembeli as $dbbeli){
        //     $dbbeli['masuk'] = $dbbeli['jumlah'];
        //     $dbbeli['keluar'] = 0;
        //     $stock+=$dbbeli['masuk'];
        //     $dbbeli['stock']=$stock;

        //  }
            // print_r($val) ;
        //   $product= Product::where('kode'= )
          

            // $val2 =intval($val['jumlah']);
            // $val1 =intval($product->jumlah);
            // $jumlah =$val1+$val2;

            // $stock = new Stock;
            // $stock->kode =$val['kode'];
            // $stock->nama="Pembelian" .$product->nama .' ' .$request->notrans;
            // $stock->stock= $val['jumlah'];
            // $stock->masuk= intval($val['jumlah']);
            // $stock->keluar=0;
            // $stock->stock= $jumlah;
            
          
            // $val1=0;
            // $val2=0;
         
            

            //  DB::table('products')
            //      ->where('id',$product->id)
            //      ->update(['jumlah'=> $jumlah]);
            
            // $stock->jumlah=;
         
        
        

        

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update($id=null ,Request $request)
    {

        // $pembelian =DB::table('itembeli')->where('notrans', $notrans)->get();
        $pembelian = Pembelian::find($id);
        // $pembelian = Pembelian::where('id',$id)->first();
        $pembelian->notrans = $request->notrans;
        $pembelian->tanggal = $request->tanggal;
        $pembelian->supplier = $request->supplier;

        $pembelian->save();

        $itembeli = Itembeli::where('notrans',$request->notrans)->get(); //ngunci dr pembelian kalo tidak bisa dirubah pake $pembelian
        if($itembeli){
            Itembeli::where('notrans',$request->notrans)->delete();
        }

            foreach ($request->itembeli as $val){
                    $itembeli = new Itembeli;
                    $itembeli->notrans = $request->notrans;
                    $itembeli->kode = $val['kode'];
                    $itembeli->jumlah = $val['jumlah'];

                    $stock=DB::table('datastocks')->where('maksimal', $val['jumlah'])->where('kode',$val['kode'])->get();
    
                    if(count($stock) > $request->kode){
                        return 'error melebihi stock';
                       }else {
                        $itembeli->save();
                       }
                  
            }
            return response()->json([
                'data'=> $pembelian
            ]);
        }

        // foreach ($request->itembeli as $val){
        //     // $itembeli =DB::table('detailpembelian')->where('notrans', $notrans)->get();
        //     $itembeli = Itembeli::where('notrans',$notrans)->first();
        //     $itembeli = Itembeli::find($id);
            
        //     $itembeli->kode = $val['kode'];
        //     $itembeli->jumlah = $val['jumlah'];

        // }
        // $pembelian->itembeli =json_encode($request->itembeli);
       
        
      

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy( $id=null)
    {
       
        $pembelian = Pembelian::find($id);
        if($pembelian){
            Itembeli::where('notrans',$pembelian->notrans)->delete();
            $pembelian->delete();
        }
         return response()->json([
            'message' => 'pembelian berhasil dihapusss'
        ], 200);

    }
}
