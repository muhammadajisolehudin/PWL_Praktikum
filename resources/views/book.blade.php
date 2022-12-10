@extends('adminlte::page')
@section('title', 'Home Page')
@section('content_header')
    <h1>Data Buku</h1>
@stop

@section('content')
<div class="container-fluid">
    <div class="card card-default">
        <div class="card card-header">{{ _('pengelolaan Buku') }}</div>
        <div class="card-body">
            <button class="btn btn-primary" data-toggle="modal" data-target="#tambahBukuModal"><i class="fa fa-plus"></i>Tambah Data</button>
            <hr/>
            <table id="table-data" class="table table-border">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>JUDUL</th>
                        <th>PENULIS</th>
                        <th>TAHUN</th>
                        <th>PENERBIT</th>
                        <th>COVER</th>
                        <th>AKSI</th>
                    </tr>
                </thead>
                <tbody>
                    @php $no=1; @endphp
                    @foreach ($books as $book)
                        <tr>
                            <td>{{ $no++ }}</td>
                            <td>{{ $book->judul }}</td>
                            <td>{{ $book->penulis }}</td>
                            <td>{{ $book->tahun }}</td>
                            <td>{{ $book->penerbit }}</td>
                            <td>
                                @if ($book->cover !== null)
                                <img src="{{ asset('storage/cover_buku/'.$book->cover) }}" width="100px"/>
                                @else
                                    [Gambar tidak tersedia]

                                @endif
                            </td>
                            <td></td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

</div>


<!-- Modal -->
<div class="modal fade" id="tambahBukuModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Tambah Data Buku</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">

        <form method="post" action="{{ route('admin.book.submit') }}" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label for="judul">Judul Buku</label>
                <input type="text" class="form-control" name="judul" id="judul" required/>
            </div>
            <div class="form-group">
                <label for="penulis">Penulis</label>
                <input type="text" class="form-control" name="penulis" id="penulis" required/>
            </div>
            <div class="form-group">
                <label for="tahun">Tahun</label>
                <input type="year" class="form-control" name="tahun" id="tahun" required/>
            </div>
            <div class="form-group">
                <label for="penerbit">Penerbit</label>
                <input type="text" class="form-control" name="penerbit" id="penerbit" required/>
            </div>
            <div class="form-group">
                <label for="cover">Cover</label>
                <input type="file" class="form-control" name="cover" id="cover" required/>
            </div>
    </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                <button type="button" class="btn btn-primary">Kirim</button>
        </form>
        </div>
    </div>
  </div>
</div>
@stop
@endsection

