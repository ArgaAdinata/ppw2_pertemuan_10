<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Buku</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap5.min.css" rel="stylesheet">
</head>
<body>
    @include('auth.layouts')
    <div class="container mt-4">
        @if (Session::has('pesan'))
            <div class="alert alert-success">
                {{ session::get('pesan') }}
            </div>
        @endif

        <div class="d-flex justify-content-between mb-3">
            <h1>Daftar Buku</h1>
            @auth
            <a href="{{ route('buku.create')}}" class="btn btn-primary">Tambah Buku</a>
        @endauth
        </div>

        <table id="bukuTable" class="table table-striped table-bordered">
            <thead class="table-dark">
                <tr>
                    <th>Id</th>
                    <th>Judul Buku</th>
                    <th>Penulis</th>
                    <th>Harga</th>
                    <th>Tanggal Terbit</th>
                    @auth
                        <th>Aksi</th>
                    @endauth
                </tr>
            </thead>
            <tbody>
                @php $i = 1; @endphp
                @foreach ($data_buku as $buku)
                    <tr>
                        <td>{{ $i }}</td>
                        <td>{{ $buku->judul }}</td>
                        <td>{{ $buku->penulis }}</td>
                        <td>{{ "Rp. ".number_format($buku->harga, 2, ',', '.') }}</td>
                        <td>{{ \Carbon\Carbon::parse($buku->tgl_terbit)->format('d-m-Y') }}</td>
                        @auth
                            <td>
                                <form action="{{route('buku.destroy', $buku->id)}}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button onclick="return confirm('Yakin mau di hapus?')" type="submit" class="btn btn-danger btn-sm">Hapus</button>
                                </form>
                                <a href="{{route('buku.edit', $buku->id)}}" class="btn btn-primary btn-sm">Update</a>
                            </td>
                        @endauth
                    </tr>
                    @php $i++; @endphp
                @endforeach
            </tbody>
        </table>
    </div>


    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap5.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#bukuTable').DataTable({
                "language": {
                    "url": "//cdn.datatables.net/plug-ins/1.11.5/i18n/id.json"
                },
                "pageLength": 10,
                "lengthMenu": [[10, 25, 50, 100, -1], [10, 25, 50, 100, "Semua"]],
                "columnDefs": [
                    @auth
                        { "orderable": false, "targets": 5 }
                    @endauth
                ]
            });
        });
    </script>
</body>
</html>
