<!DOCTYPE html>
<html>
<head>
    <title>Kartu Hasil Studi Mahasiswa Jurusan Teknologi Informasi</title>
</head>
<body>
    <center>
        <h3>KARTU HASIL STUDI</h3>
    </center>
    <br><br>
<div>
    <b>Nama : </b> {{$data->nama}} <br>
    <b>NIM : </b>  {{$data->nim}} <br>
    <b>Kelas : </b>{{$data->kelas->nama_kelas}} <br>
</div>

<br>
<table class="table table-bordered">
    <thead>
        <tr>
            <th width="350px">Mata Kuliah</th>
            <th width="100px">SKS</th>
            <th width="100px">Semester</th>
            <th width="100px">Nilai</th>
            </tr>
    </thead>
    <tbody>
        @foreach ($data->khs as $khs)
            <tr>
                <td width="350px">{{ $khs->mataKuliah->nama_matkul }}</td>
                <td class=align-item-center width="100px">{{ $khs->mataKuliah->sks }}</td>
                <td class=text-center width="100px">{{ $khs->mataKuliah->semester }}</td>
                <td class=text-center width="100px">{{ $khs->nilai }}</td>
            </tr>
        @endforeach
    </tbody>
</table>
</body>
</html>