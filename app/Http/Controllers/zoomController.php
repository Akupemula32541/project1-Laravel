<?php

namespace App\Http\Controllers;

use App\Models\zoom;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Symfony\Contracts\Service\Attribute\Required;

class zoomController extends Controller
{
    /**
     * Display a listing of the resource.
     */
   public function index(Request $request)
    {
        $katakunci = $request->katakunci;
        $jumlahbaris = 4;
        if(strlen($katakunci)) {
            $data = zoom::where('nim', 'like', "%{$katakunci}%")
                    ->orWhere('nama', 'like', "%{$katakunci}%")
                    ->orWhere('jurusan', 'like', "%{$katakunci}%")
                    ->paginate($jumlahbaris);
                    
        } else {
            $data = zoom::orderBy('nim','desc')->paginate($jumlahbaris);
        }
        
        return view('zoom.index')->with('data',$data);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view ('zoom.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        Session::flash('nim', $request->nim);
        Session::flash('nama', $request->nama);
        Session::flash('jurusan', $request->jurusan);

        $request->validate([
            'nim' => 'required|numeric|unique:zoom,nim',
            'nama' => 'required',
            'jurusan' => 'required',
        ], [
            'nim.required' => 'NIM wajib diisi',
            'nim.numeric' => 'NIM wajib dalam angka',
            'nim.unique' => 'NIM yang diisi sudah ada dalam database',
            'nama.required' => 'nama wajib diisi',
            'jurusan.required' => 'jurusan wajib diisi',
        ]);
        $data = [
            'nim' => $request->nim,
            'nama' => $request->nama,
            'jurusan' => $request->jurusan,
        ];
        zoom::create($data);
        return redirect()->to('zoom')->with('sukses', 'berhasil menambahkan data');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $data = zoom::where('nim',$id)->first();
        return view('zoom.edit')->with('data', $data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'nama' => 'required',
            'jurusan' => 'required',
        ], [
            'nama.required' => 'nama wajib diisi',
            'jurusan.required' => 'jurusan wajib diisi',
        ]);
        $data = [
            'nama' => $request->nama,
            'jurusan' => $request->jurusan,
        ];
        zoom::where('nim',$id)->update($data);
        return redirect()->to('zoom')->with('sukses', 'berhasil melakukan update data');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        zoom::where('nim',$id)->delete();
        return redirect()->to('zoom')->with('sukses','berhasil melakukan delete data');
    }
}