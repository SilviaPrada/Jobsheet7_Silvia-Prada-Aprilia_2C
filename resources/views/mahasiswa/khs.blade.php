@extends('mahasiswa.layout')

@section('content')
<div class="row">
    <div class="col-lg-12 margin-tb">
        <div class="pull-left mt-2">
            <h2>JURUSAN TEKNOLOGI INFORMASI-POLITEKNIK NEGERI MALANG</h2>
            <br>
            <h1 class="text-center">KARTU HASIL STUDI (KHS)</h1>
        </div>
    </div>
</div>

<br><br>

<div class="row" style="margin:0px 0px 0px 10px">
    <div>
        <b>Nama : </b> {{$data->nama}} <br>
        <b>NIM : </b>  {{$data->nim}} <br>
        <b>Kelas : </b>{{$data->kelas->nama_kelas}} <br>
    </div>
    <div style="margin:0px 0px 0px 800px;">
        <a class="btn btn-success" href="{{ route('mahasiswa.cetak_khs', $data->nim) }}"> Cetak KHS</a>
    </div>
</div>
    
<br>
<table class="table table-bordered">
    <thead>
        <tr>
            <th>Mata Kuliah</th>
            <th>SKS</th>
            <th>Semester</th>
            <th>Nilai</th>
            </tr>
    </thead>
    <tbody>
        @foreach ($data->khs as $khs)
            <tr>
                <td>{{ $khs->mataKuliah->nama_matkul }}</td>
                <td>{{ $khs->mataKuliah->sks }}</td>
                <td>{{ $khs->mataKuliah->semester }}</td>
                <td>{{ $khs->nilai }}</td>
            </tr>
        @endforeach
    </tbody>
</table>
@endsection