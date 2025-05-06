<!DOCTYPE html>
<html>

<head>
    <title>Cetak Hasil Diagnosa</title>
    <link rel="stylesheet" href="{{ asset('assets/css/print.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/homeadmin.css') }}">
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 30px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th,
        td {
            padding: 10px;
            border: 1px solid #000;
            text-align: left;
            vertical-align: top;
        }

        h2 {
            text-align: center;
            margin-bottom: 30px;
        }

        .text-center {
            text-align: center;
        }

        @media print {
            .no-print {
                display: none;
            }
        }
    </style>
</head>

<body>

    <h2>Hasil Diagnosa Penyakit Bawang Merah</h2>

    @php
    $nilai_angka = isset($riwayat->nilai) ? preg_replace('/[^0-9.]/', '', $riwayat->nilai) : null;
    @endphp

    <table>
        <tbody>
            <tr>
                <th>Nama Petani</th>
                <td>{{ $riwayat->user->username ?? '-' }}</td>
            </tr>
            <tr>
                <th>Umur</th>
                <td>{{ $riwayat->user->umur ?? '-' }}</td>
            </tr>
            <tr>
                <th>Telp</th>
                <td>{{ $riwayat->user->telp ?? '-' }}</td>
            </tr>
            <tr>
                <th>Alamat</th>
                <td>{{ $riwayat->user->alamat ?? '-' }}</td>
            </tr>
            <tr>
                <th>Nama Penyakit</th>
                <td>{{ $riwayat->penyakit->nama_penyakit ?? '-' }}</td>
            </tr>
            <tr>
                <th>Deskripsi</th>
                <td>{{ $riwayat->penyakit->deskripsi ?? '-' }}</td>
            </tr>
            <tr>
                <th>Gambar Penyakit</th>
                <td><img src="{{ asset('assets/images/' . $riwayat->penyakit->gambar) }}" alt="Gambar Penyakit" style="width: 200px; height: auto;"></td>
            </tr>
            <tr>
                <th>Persentase</th>
                <td>{{ $nilai_angka !== null ? $nilai_angka . '%' : '-' }}</td>
            </tr>
            <tr>
                <th>Penanganan</th>
                <td>{{ $riwayat->penyakit->penanganan ?? '-' }}</td>
            </tr>
        </tbody>
    </table>

    <div class="text-center mt-4 no-print">
        @if ($role === 'admin')
        <a href="{{ route('admin.dashboard') }}" class="btn btn-secondary">Kembali ke Dashboard</a>
        @else
        <a href="{{ route('history') }}" class="btn btn-secondary">Kembali ke Riwayat</a>
        @endif
        <button onclick="window.print()" class="btn btn-primary">Cetak</button>
    </div>

    <script>
        window.onload = function() {
            window.print();
        };
    </script>

</body>

</html>