<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Jurusan;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\DB;

class JurusanController extends Controller
{
 
    public function jurusan(Request $request)
    {
        $data = Jurusan::query();
            
            
        
        if($request->ajax()){
            

            return DataTables::of($data)
            
            ->addColumn('no', function($data){
                return $data->DT_RowIndex;
            })
            ->addColumn('name', function($data){
                return $data->name;
            })
            ->addColumn('action', function($data){
                return 'action';
            })
            ->make(true);
        }

        

        return view('admin.jurusan');
    }

    public function storeJurusan(Request $request)
    {
        // Mulai transaksi
        DB::beginTransaction();
    
        try {
            // Validasi data
            $request->validate([
                'name' => 'required|string|max:255',
            ]);
    
            Jurusan::create([
                'name' => $request->name,
            ]);
    
    
            DB::commit();
    
            return redirect()->route('jurusan')->with('success', 'Jurusan added successfully');
        } catch (\Exception $e) {
            DB::rollBack();
    
            return redirect()->back()->withErrors(['error' => 'Terjadi kesalahan saat menambahkan Jurusan.'])->withInput();
        }
    }




    

    // Metode untuk mendapatkan list jurusan
    public function list()
    {
        $jurusans = Jurusan::all();
        return response()->json($jurusans);
    }

    public function editJurusan($id)
{
    $jurusan = Jurusan::findOrFail($id);
    return response()->json($jurusan);
}

public function updateJurusan(Request $request, $id)
{
    $request->validate([
        'name' => 'required|string|max:255',
    ]);

    $jurusan = Jurusan::findOrFail($id);
    $jurusan->update([
        'name' => $request->name,
    ]);

    return redirect()->route('jurusan')->with('success', 'Jurusan updated successfully');
}

public function deleteJurusan($id)
{
    $jurusan = Jurusan::findOrFail($id);
    $jurusan->delete();

    return redirect()->route('jurusan')->with('success', 'Jurusan deleted successfully');
}

}
