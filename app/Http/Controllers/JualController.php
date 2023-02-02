<?php

namespace App\Http\Controllers;

use App\Models\Jual;
use DB;
use App\Helpers\Helper;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Stock; 
use App\Models\Itemjual;


class JualController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    { 
        // Jual::max('notrans');
        $juals = Jual::paginate(10)->map(function ($juals){
            return[
                'notrans' =>($juals->notrans),
                'tanggal' =>($juals->tanggal),
                'customer' =>($juals->customer),
                'itemjual' =>Itemjual::where('notrans',$juals->notrans)->get(),
            ];

        });
        return response()->json([
            'data' => $juals
        ]);
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
    
    // public static function NotransGenerator($model, $trow, $length=4, $prefix)
    // {
        
    // }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $nomor =Jual::max('notrans');
        $urutan =substr($nomor,3); //substr merubah string menjadi integer karena menggambil data dari dtaabase berupa satring
           //angka 3 itu dari depan kan TRX maka yg 00000 selanjutnya akan masuk urutan dan di +1 
        $newnomor = $urutan+1;
        $str = str_pad('0', 4, "0", STR_PAD_LEFT);
        $lastnomor ='TRX' .$str .$newnomor;

        $jual = new Jual();
    
       $jual->notrans = $lastnomor;
        $jual->tanggal =$request->tanggal;
        $jual->customer =$request->customer;
         $jual->kodegudang =$request->kodegudang;
        
        $gudang=DB::table('gudangs')->where('kodegudang', $request->kodegudang)->first();
         if($gudang){
            foreach ($request->itemjual as $val) { //ngecek kode
            
                $product = DB::table('products')->where('kode', $val['kode'])->first(); //valkode itu item beli kode karena dipecah
                if($product){ //jika product ada maka jadilah membuat stock baru
                    $itemjual = new Itemjual;
                    $itemjual->notrans = $lastnomor;
                    $itemjual->kode = $val['kode'];
                    $itemjual->jumlah = $val['jumlah'];

                    $stock=DB::table('datastocks')->where('kode',$val['kode'])->first();
                    if(!empty($stock) && $stock->minimum  < $request->kode){
                        return 'error stock tidak cukup';
                    }else {
                        $itemjual->save();
                    }
                 }
            }
                $stock = DB::table('datastocks')->where('kode',$val['kode'])->first();
    
                if(!empty($stock) && $stock->minimum  < $request->kode){
                    return 'error stock tidak cukup' ;
                }else {
                    $jual->save();
                }
                   
            }
                return response()->json([
                    'data'=> $jual
                ]);
            }
         

        
           
           
            // $val2 =intval($val['jumlah']); //keluarnya
            // $val1 =intval($product->jumlah);
            // $jumlah =$val1-$val2;

            // $stock = new Stock;
            // $stock->kode =$val['kode']; //apa yang mau ditampilin di stock
            // $stock->nama="Penjualan " .$product->nama .' ' .$lastnomor;
            // $stock->keluar=intval($val['jumlah']);
            // $stock->masuk=0;
            // $stock->stock= $jumlah;
            

            //karena string maka di intval dulu jadi int
          
            // $val1=0;
            // $val2=0;
         
            
            //  DB::table('products')
            //      ->where('id',$product->id)
            //      ->update(['jumlah'=> $jumlah]); //stock akhir
            
      
            
    
        // $id = Jual::getId();
        // foreach ($id as $value);
        // $notranslama =$value['id'];
        // $notransbaru =$notranslama +1;
        
//  $jual = Jual::orderBy('notrans', 'DESC')->get();

// DB::table('juals')->orderBy('id', 'desc')->first();

// Jual::max('notrans');

// $query = ("SELECT max(notrans) as noTerakhir FROM juals");
// $notrans =$query['noTerakhir'];


// // $no = "TRX0000";
// $urutan =(int)substr($no,3,3);
// $urutan++;

// $huruf= "TRX";
// $transaksi =$huruf . sprintf("%05s", $urutan);
// echo $transaksi;
// $transaksi =sprintf("%05s", $urutan);

// $lastRow = Jual::latest()->first();
// $lastRowId = $lastRow->notrans;

// $newRowId = preg_replace('/TRX/', '', $lastRowId);
// $newRowId = (int) $newRowId+1;
// $newRowId = 'TRX0000' . $newRowId;

// SELECT MAX(id) FROM juals;

       

    //     $id= $jual->id;

    //    $jual = Jual::find($id);
    //    DB::table('juals')
    //         ->where('id',$id)
    //         ->update(['notrans' => "TRX0000" .$id]);
    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Jual  $jual
     * @return \Illuminate\Http\Response
     */

    
       
        
    public function show(Jual $jual)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Jual  $jual
     * @return \Illuminate\Http\Response
     */


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Jual  $jual
     * @return \Illuminate\Http\Response
     */
    public function update($id=null ,Request $request)
    {
        $jual = Jual::find($id);
       
        $jual->tanggal = $request->tanggal;
        $jual->customer = $request->customer;
        $jual->save();
        // $jual->itembeli =json_encode($request->itembeli);
        $itemjual = Itemjual::where('notrans',$jual->notrans)->get();
        if($itemjual){
            Itemjual::where('notrans',$jual->notrans)->delete();
        }
        foreach ($request->itemjual as $val){
            // $itembeli = Itembeli::where('notrans',$notrans)->first();
          
                // $itemjual = Itemjual::find($id);
                $itemjual = new Itemjual;
                $itemjual->notrans = $jual->notrans;
                $itemjual->kode = $val['kode'];
                $itemjual->jumlah = $val['jumlah'];

                $itemjual->save();
        }

       
        
        return response()->json([
            'data'=> $jual
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Jual  $jual
     * @return \Illuminate\Http\Response
     */
    public function destroy($id=null)
    {
        // Itemjual::where('notrans',$jual->notrans)->delete();
        // $jual->delete();
        // // $itembeli->delete();
        // return response()->json([
        //     'message' => 'message '
        // ], 200);
        $jual = Jual::find($id);
        if($jual){
            Itemjual::where('notrans',$jual->notrans)->delete();
            $jual->delete();
        }
         return response()->json([
            'message' => 'penjualan berhasil dihapusss'
        ], 200);
    }
}

