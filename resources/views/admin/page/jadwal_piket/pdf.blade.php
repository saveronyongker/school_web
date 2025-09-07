<!DOCTYPE html>
<html>
<head>
    <title>Jadwal Guru Piket</title>
    <meta charset="utf-8">
    <style>
        body { font-family: Arial, sans-serif; font-size: 12px; }
        .header { text-align: center; margin-bottom: 20px; }
        table { width: 100%; border-collapse: collapse; margin-bottom: 20px; }
        th, td { border: 1px solid #000; padding: 8px; text-align: left; }
        th { background-color: #f2f2f2; }
        .text-center { text-align: center; }
        .text-right { text-align: right; }
    </style>
</head>
<body>
    <div class="header">
        <h2>JADWAL GURU PIKET</h2>
        <h3>
            @if ($minggu === 'ini')
                MINGGU INI
            @else
                MINGGU DEPAN
            @endif
        </h3>
        <p>{{ $start->format('d M Y') }} - {{ $end->format('d M Y') }}</p>
    </div>

    <table>
        <thead>
            <tr>
                <th width="15%">Hari</th>
                <th width="15%">Tanggal</th>
                <th width="35%">Guru Piket Shift 1</th>
                <th width="35%">Guru Piket Shift 2</th>
                <th width="35%">Guru Piket Shift 3</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($jadwal as $tanggal => $piketHarian)
                @php
                    $date = \Carbon\Carbon::parse($tanggal);
                    $hari = ['Minggu', 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'][$date->dayOfWeek];
                    $shift1 = $piketHarian->where('shift', 1)->first();
                    $shift2 = $piketHarian->where('shift', 2)->first();
                    $shift3 = $piketHarian->where('shift', 3)->first();
                @endphp
                <tr>
                    <td>{{ $hari }}</td>
                    <td>{{ $date->format('d/m/Y') }}</td>
                    <td>{{ $shift1 ? $shift1->guru->name : '-' }}</td>
                    <td>{{ $shift2 ? $shift2->guru->name : '-' }}</td>
                    <td>{{ $shift3 ? $shift3->guru->name : '-' }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div style="margin-top: 30px;">
        <p><strong>Catatan:</strong></p>
        <p>1. Jadwal ini berlaku untuk minggu {{ $minggu === 'ini' ? 'ini' : 'depan' }}</p>
        <p>2. Guru wajib hadir sesuai jadwal piket</p>
        <p>3. Jika berhalangan, wajib mengganti dengan guru lain dan memberitahu admin</p>
    </div>
</body>
</html>