<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Item;
use Exception;
use Illuminate\Http\Request;

class ItemController extends Controller
{
    public function index(){
        $item = Item::all('nama','price','deskripsi');

        return response()->json($item);
    }

    public function store(Request $request){
        $request->validate([
            'nama' => 'required',
            'price' => 'required'
        ]);

        try {
            Item::create([
                'nama' => $request->nama,
                'price' => $request->price,
                'deskripsi' => $request->deskripsi
            ]);
        } catch(Exception $e){
            return response()->json([
                'status' => 'failed',
                'errors' => ['message' => 'Server error']
            ], 500);
        }

        return response()->json([
            'status' => 'success',
            'message' => 'Data berhasil ditambahkan'
        ]);
    }

    public function update($id, Request $request){
        $request->validate([
            'nama' => 'required',
            'price' => 'required'
        ]);

        $item = Item::find($id);

        if ($item == null){
            return response()->json([
                'status' => 'failed',
                'errors' => ['message' => 'Data tidak ditemukan']
            ], 404);
        }

        try {
            $item->nama = $request->nama;
            $item->price = $request->price;
            $item->deskripsi = $request->deskripsi;

            $item->save();
        } catch(Exception $e){
            return response()->json([
                'status' => 'failed',
                'errors' => ['message' => 'Server error']
            ], 500);
        }

        return response()->json([
            'status' => 'success',
            'message' => 'Data berhasil ditambahkan'
        ]);
    }

    public function destroy($id){
        $item = Item::find($id);

        if ($item == null){
            return response()->json([
                'status' => 'failed',
                'errors' => ['message' => 'Data tidak ditemukan']
            ], 404);
        }

        try {
            $item->delete();
        } catch(Exception $e){
            return response()->json([
                'status' => 'failed',
                'errors' => ['message' => 'Server error']
            ], 500);
        }

        return response()->json([
            'status' => 'success',
            'message' => 'Data berhasil ditambahkan'
        ]);
    }
}
