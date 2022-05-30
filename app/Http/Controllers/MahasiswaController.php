<?php

namespace App\Http\Controllers;

use App\Models\Mahasiswa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Kelas;

class MahasiswaController extends Controller
{
    /**
    * Display a listing of the resource.
    *
    *@return \Illuminate\Http\Response
    */
    public function index()
    {
        //fungsi eloquent menampilkan data menggunakan pagination
        // $mahasiswa = $mahasiswa = DB::table('mahasiswa')->paginate(3); // Mengambil semua isi tabel
        // $posts = Mahasiswa::orderBy('Nim', 'desc')->paginate(3);
        // return view('mahasiswa.index', compact('mahasiswa'));
        // with('i', (request()->input('page', 1) - 1) * 5);

        //yang semula Mahasiswa::all diubah menjadi with() yang menyatakan relasi
        $mahasiswa = Mahasiswa::with('kelas')->get();
        $paginate = Mahasiswa::orderBy('id_mahasiswa', 'asc')->paginate(3);
        return view('mahasiswa.index', ['mahasiswa' => $mahasiswa, 'paginate'=>$paginate]);
    }
    public function create()
    {
        $kelas = Kelas::all(); //mendapatkan data dari tabel kelas
        return view('mahasiswa.create', ['Kelas' => $kelas]);
    }
    public function store(Request $request)
    { 
        //melakukan validasi data
        $request->validate([
            'Nim' => 'required',
            'Nama' => 'required',
            'Kelas' => 'required',
            'Jurusan' => 'required',
            'Email' => 'required',
            'Alamat' => 'required',
            'Tanggal_Lahir' => 'required',
        ]);

        $mahasiswa = new Mahasiswa;
        $mahasiswa->nim = $request->get('Nim');
        $mahasiswa->nama = $request->get('Nama');
        $mahasiswa->jurusan = $request->get('Jurusan');
        $mahasiswa->email = $request->get('Email');
        $mahasiswa->alamat = $request->get('Alamat');
        $mahasiswa->tanggal_lahir = $request->get('Tanggal_Lahir');
        $mahasiswa->save();

        $kelas = new Kelas;
        $kelas->id = $request->get('Kelas');

        //fungsi eloquent untuk menambahkan data dengan relasi belongsTo
        $mahasiswa->kelas()->associate($kelas);
        $mahasiswa->save();

        //jika data berhasil ditambahkan, akan kembali ke halaman utama
        return redirect()->route('mahasiswa.index')
            ->with('success', 'Mahasiswa Berhasil Ditambahkan');

    }
    public function show($Nim)
    {
        //menampilkan detail data berdasarkan Nim Mahasiswa
        //code sebelum dibuat relasi --> $mahasiswa = Mahasiswa::find($Nim);
        $mahasiswa = Mahasiswa::with('kelas')->where('nim', $Nim)->first();
        
        return view('mahasiswa.detail', ['Mahasiswa' => $mahasiswa]);
    }
    public function edit($Nim)
    {
        //menampilkan detail data dengan menemukan berdasarkan Nim Mahasiswa untuk diedit
        $mahasiswa = Mahasiswa::with('kelas')->where('nim', $Nim)->first();;
        $kelas = Kelas::all(); //mendapatkan data dari tabel kelas
        return view('mahasiswa.edit', compact('mahasiswa', 'kelas'));
    }
    public function update(Request $request, $Nim)
    {
        //melakukan validasi data
        $request->validate([
            'Nim' => 'required',
            'Nama' => 'required',
            'Kelas' => 'required',
            'Jurusan' => 'required',
            'Email' => 'required',
            'Alamat' => 'required',
            'Tanggal_Lahir' => 'required',
        ]);

        $mahasiswa = Mahasiswa::with('kelas')->where('nim', $Nim)->first();
        $mahasiswa->nim = $request->get('Nim');
        $mahasiswa->nama = $request->get('Nama');
        $mahasiswa->jurusan = $request->get('Jurusan');
        $mahasiswa->email = $request->get('Email');
        $mahasiswa->alamat = $request->get('Alamat');
        $mahasiswa->tanggal_lahir = $request->get('Tanggal_Lahir');
        $mahasiswa->save();

        $kelas = new Kelas;
        $kelas->id = $request->get('Kelas');

        //fungsi eloquent untuk menambahkan data dengan relasi belongsTo
        $mahasiswa->kelas()->associate($kelas);
        $mahasiswa->save();

        //jika data berhasil diupdate, akan kembali ke halaman utama
        return redirect()->route('mahasiswa.index')
            ->with('success', 'Mahasiswa Berhasil Diupdate');
    }
    public function destroy( $Nim)
    {
        //fungsi eloquent untuk menghapus data
        Mahasiswa::where('nim', $Nim)->first()->delete();
        return redirect()->route('mahasiswa.index')
        -> with('success', 'Mahasiswa Berhasil Dihapus');
    }
    public function search(Request $request)
    {
        $keyword = $request->search;
        $mahasiswa = Mahasiswa::where('nim', 'LIKE', "%" . $keyword . "%")
            ->orWhere("nama", "LIKE", "%$keyword%")
            ->orWhere("kelas", "LIKE", "%$keyword%")
            ->orWhere("jurusan", "LIKE", "%$keyword%")
            ->orWhere("email", "LIKE", "%$keyword%")
            ->orWhere("alamat", "LIKE", "%$$keyword%")
            ->orWhere("tanggal_lahir", "LIKE", "%$$keyword%")
            ->paginate(3);
            return view('mahasiswa.index', compact('mahasiswa'));
            with('i', (request()->input('page', 1) - 1) * 5);
    }
    public function khs($Nim)
    {
        $data = Mahasiswa::where('nim', $Nim)->with(['kelas', 'khs.mataKuliah'])->first();
        return view('mahasiswa.khs', compact('data'));
    }
};
