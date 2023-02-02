<?php

namespace App\Http\Controllers;
use DB;
use App\Models\Product;
use App\Models\Pembelian;
use App\Models\Jual;
use App\Models\Itembeli;
use App\Models\Itemjual;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // $products = Product::paginate(10);
        // return response()->json([
        //     'data' => $products
        // ]);
        
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

        // $status =false;
        // $message= '';

        // $validator= Validator::make($request->all(),[
        //     'kode'=> 'required|max:255|unique:products',
        //     'nama'=> 'required|max:255',
        //     'satuan_besar'=> 'required|max:255',
        //     'satuan_kecil'=> 'required|max:255',
        //     'pembagi_satuan'=> 'required|max:255',
        //     'harga_satuan_besar'=> 'required|max:255',
        //     'ppn'=> 'required|max:255',
        //     'status'=> 'required|max:255',

        // ]);

        // if($validator->fails()){
        //     $status =false;
        //     $message= $validator->errors();
        // }else{
        //     $status =true;
        // }

        // return response()->json([
        //     'status' => $status,
        //     'message' => $message
        // ], 201);
        $product = Product::create([
            'kode' =>$request->kode,
            'nama' =>$request->nama,
            // 'jumlah' =>$request->jumlah,
            'satuan_besar' =>$request->satuan_besar,
            'satuan_kecil' =>$request->satuan_kecil,
            'pembagi_satuan' =>$request->pembagi_satuan,
            'harga_satuan_besar' =>$request->harga_satuan_besar,
            'ppn' =>$request->ppn,
            'status' =>$request->status,
        ]);

        return response()->json([
            'data'=>$product
        ]);
    }

    //     $penjualan = DB::table('products')
    //     ->join('detailpenjualan', 'detailpenjualan.kode', '=', 'products.kode')
    //     ->join('juals', 'juals.notrans', '=', 'detailpenjualan.notrans')

    //     ->get();

    //     $pembelian = DB::table('products')
    //     ->join('detailpembelian', 'detailpembelian.kode', '=', 'products.kode')
    //     ->join('pembelians', 'pembelians.notrans', '=', 'detailpembelian.notrans')
    //     ->get();

    //     // ->select('products.nama', 'products.kode')
    //     // ->get();
    //     $data_pembelian=[];
    //     if($pembelian){
    //         $stock =0;
    //         foreach($pembelian as $d_pembelian){
    //                 $data_pembelian[]=array(
    //                     'kode' =>$d_pembelian->kode,
    //                     'notrans'=>$d_pembelian->notrans,
    //                     'tanggal'=>$d_pembelian->tanggal,
    //                     'nama' =>"pembelian" .$d_pembelian->nama .' ' .$d_pembelian->notrans,
    //                     'jumlah' =>$d_pembelian->jumlah,  
    //                     'jenis' => '1',
    //                 );
           
    //         }   
    //     }
    //     if($penjualan){
    //         $stock =0;
    //         foreach($penjualan as $d_penjualan){
    //     array_push( $data_pembelian, array(
    //         'kode' =>$d_penjualan->kode,
    //         'notrans'=>$d_penjualan->notrans,
    //         'tanggal'=>$d_penjualan->tanggal,
    //         'nama' =>"penjualan" .$d_penjualan->nama .' ' .$d_penjualan->notrans,
    //         'jumlah' =>$d_penjualan->jumlah,  
    //         'jenis' => '2',
    //     ));
    //     // $data_penjualan[]=array(
    //     //                 'kode' =>$d_penjualan->kode,
    //     //                 'nama' =>"penjualan" .$d_penjualan->nama .' ' .$d_penjualan->notrans,
    //     //                 'keluar' =>$d_penjualan->jumlah,  
    //     //                 'jenis' => '2',
    //     //             );
           
    //         }   
    //     }

    //     // array_push( $data_pembelian, $data_penjualan);
    //   $final=[];
    //     if($data_pembelian){
    //         $stock =0;
    //         foreach($data_pembelian as $dt_pembelian){
    //             // $final[]= array(
    //             //     'nama'=> "penjualan" .$dt_pembelian->nama .' ' .$dt_pembelian->notrans,
    //             //     'masuk'=>$dt_pembelian->jumlah,
    //             // );
    //             if($dt_pembelian['jenis'] === '1'){
    //                 // $final[]= array(
    //                 //     $'nama'=> "penjualan" .$dt_pembelian->nama .' ' .$dt_pembelian->notrans,
    //                 //     'masuk'=>$dt_pembelian->jumlah,
    //                 // );
    //                 $data['nama'] = $dt_pembelian['nama'] ;
    //                 $data['tanggal']= $dt_pembelian['tanggal'];
    //                 $data['masuk']= $dt_pembelian['jumlah'];
    //                 $stock += $data['masuk'];
                  
    //             }else{
                   
    //                 $data['nama'] =$dt_pembelian['nama'] ;
    //                 $data['tanggal']= $dt_pembelian['tanggal'];
    //                 $data['masuk']= 0;
    //                 $data['keluar'] =$dt_pembelian['jumlah'];
    //                 $stock -= $data['keluar'];
                   
    //             }
    //             $data['stock'] =$stock;
    //               array_push($final, $data);
    //         }
    //     }

      

       
        // $dbstock =  DB::table('products')
        //      ->join('detailpembelian', 'detailpembelian.kode', '=', 'products.kode')
        //      ->join('pembelians', 'pembelians.notrans', '=', 'detailpembelian.notrans')
        //     ->join('detailpenjualan', 'detailpenjualan.kode', '=', 'products.kode')
        //     ->join('juals', 'juals.notrans', '=', 'detailpenjualan.notrans')
        //     ->orderby('pembelians.tanggal','asc')
        //     ->orderby('juals.tanggal','asc')
        //     // ->select('pembelians.id as id beli', 'juals.id as idjual', 'juals.tanggal', 'juals.notrans',
        //     // 'detailpenjualan.kode', 'detailpenjualan.jumlah as jumlahjual', 'detailpembelian.jumlah as jumlahbeli')
        //     ->get();

    //     if($dbstock){
    //         $stock =0;
    //         $data_stock=[];
    //         foreach($dbstock as $d_stock){
    //             if($d_stock['jumlahbeli']){
    //                 $stock['tanggal'] =$d_stock['tanggal'];
    //                 $stock['keterangan'] ="penjualan" .$d_stock['nama'] .' ' .$d_stock['notrans'];
    //                 $d_stock['masuk'] =$d_stock['jumlah'];
    //                 $d_stock['masuk'] =0;
    //                 $stock += $data['masuk'];
    //                 $d_stock['stock']=$stock;
    //             }else{
    //                 $stock['tanggal'] =$d_stock['tanggal'];
    //                 $stock['keterangan'] ="penjualan" .$d_stock['nama'] .' ' .$d_stock['notrans'];
    //                 $d_stock['masuk'] =0;
    //                 $d_stock['masuk'] =$d_stock['jumlah'];
    //                 $stock -= $data['masuk'];
    //                 $d_stock['stock']=$stock;
    //             }
    //             array_push($data_stock, $data);
    //         }
    //     }
    //     return response()->json([
    //         'data'=>$data
    //     ]);

       
    // }
    //      //     $data_penjualan['kode']=$d_penjualan->kode;
    //             //     $data_penjualan['nama'] = 
    //             //     $data_penjualan['keluar'] = $d_penjualan->jumlah;
    //             //     $stock -= $data_penjualan['keluar'];
                
    //             //  $data['stock']=$stock;
    //             // array_push($data_stock, $data);

    // /**
    //  * Display the specified resource.
    //  *
    //  * @param  \App\Models\Product  $product
    //  * @return \Illuminate\Http\Response
    //  */
    // public function show(Product $product)
    // {
    //     return response()->json([
    //         'data'=>$product
    //     ]);
    // }

    // /**
    //  * Show the form for editing the specified resource.
    //  *
    //  * @param  \App\Models\Product  $product
    //  * @return \Illuminate\Http\Response
    //  */
    
    // /**
    //  * Update the specified resource in storage.
    //  *
    //  * @param  \Illuminate\Http\Request  $request
    //  * @param  \App\Models\Product  $product
    //  * @return \Illuminate\Http\Response
    //  */
    public function update($id=null, Request $request,)
    {

        $product = Product::find($id);
        $product->kode = $request->kode;
        $product->nama = $request->nama;
        // $product->jumlah = $request->jumlah;
        $product->satuan_besar = $request->satuan_besar;
        $product->satuan_kecil = $request->satuan_kecil;
        $product->pembagi_satuan = $request->pembagi_satuan;
        $product->harga_satuan_besar = $request->harga_satuan_besar;
        $product->ppn = $request->ppn;
        $product->status = $request->status;
        $product->save();

        return response()->json([
            'data' => $product
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product)
    {
        $product->delete();
        return response()->json([
            'message' => 'product dihapus'
        ], 204);
    }
}
