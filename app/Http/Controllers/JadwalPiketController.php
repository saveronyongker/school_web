<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\JadwalPiket;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Barryvdh\DomPDF\Facade\Pdf;


class JadwalPiketController extends Controller
{
    public function create()
    {
        // Minggu ini
        $startCurrent = now()->startOfWeek();
        $endCurrent = $startCurrent->copy()->endOfWeek();

        // Minggu depan
        $startNext = now()->addWeek()->startOfWeek();
        $endNext = $startNext->copy()->endOfWeek();

        $tanggalMingguIni = [];
        for ($date = $startCurrent; $date->lte($endCurrent); $date->addDay()) {
            $tanggalMingguIni[] = $date->format('Y-m-d');
        }

        $tanggalMingguDepan = [];
        for ($date = $startNext; $date->lte($endNext); $date->addDay()) {
            $tanggalMingguDepan[] = $date->format('Y-m-d');
        }

        $guruMapel = User::where('role', 'guru_mapel')->get();

        // Cek apakah sudah ada jadwal
        $jadwalIniAda = JadwalPiket::whereBetween('tanggal', [$startCurrent, $endCurrent])->exists();
        $jadwalDepanAda = JadwalPiket::whereBetween('tanggal', [$startNext, $endNext])->exists();

        return view('admin.page.jadwal_piket.create', compact(
            'tanggalMingguIni',
            'tanggalMingguDepan', 
            'guruMapel', 
            'jadwalIniAda',
            'jadwalDepanAda',
            'startCurrent',
            'endCurrent',
            'startNext',
            'endNext'
        ));
    }

    // ✅ Method baru untuk store jadwal minggu ini
    public function storeMingguIni(Request $request)
    {
        $request->validate([
            'jadwal_ini' => 'required|array',
            'jadwal_ini.*' => 'required|array|size:3', // 3 guru per hari
            'jadwal_ini.*.*' => 'required|exists:users,id', // user_id valid
        ]);

        // Hapus jadwal lama minggu ini
        $start = now()->startOfWeek();
        $end = $start->copy()->endOfWeek();
        JadwalPiket::whereBetween('tanggal', [$start, $end])->delete();

        // Simpan jadwal baru minggu ini
        foreach ($request->jadwal_ini as $tanggal => $guruIds) {
            foreach ($guruIds as $index => $userId) {
                JadwalPiket::create([
                    'tanggal' => $tanggal,
                    'user_id' => $userId,
                    'shift' => $index + 1,
                ]);
            }
        }

        return redirect()->route('jadwal.piket.create')->with('success', 'Jadwal piket minggu ini berhasil disimpan!');
    }

    public function store(Request $request)
    {
        $request->validate([
            'jadwal_depan' => 'required|array',
            'jadwal_depan.*' => 'required|array|size:3', // 3 guru per hari
            'jadwal_depan.*.*' => 'required|exists:users,id', // user_id valid
        ]);

        // Hapus jadwal lama minggu depan
        $start = now()->addWeek()->startOfWeek();
        $end = $start->copy()->endOfWeek();
        JadwalPiket::whereBetween('tanggal', [$start, $end])->delete();

        // Simpan jadwal baru minggu depan
        foreach ($request->jadwal_depan as $tanggal => $guruIds) {
            foreach ($guruIds as $index => $userId) {
                JadwalPiket::create([
                    'tanggal' => $tanggal,
                    'user_id' => $userId,
                    'shift' => $index + 1,
                ]);
            }
        }

        return redirect()->route('jadwal.piket.create')->with('success', 'Jadwal piket minggu depan berhasil disimpan!');
    }

    public function show(Request $request)
    {
        $minggu = $request->get('minggu', 'depan'); // default: depan

        if ($minggu === 'ini') {
            $start = now()->startOfWeek();
            $end = $start->copy()->endOfWeek();
        } else {
            $start = now()->addWeek()->startOfWeek();
            $end = $start->copy()->endOfWeek();
        }

        $jadwal = JadwalPiket::mingguIni($start, $end)->get()->groupBy('tanggal');

        return view('admin.page.jadwal_piket.show', compact('jadwal', 'start', 'end', 'minggu'));
    }

    public function editHarian($tanggal)
    {
        $tanggal = Carbon::parse($tanggal);
        $jadwalHarian = JadwalPiket::where('tanggal', $tanggal->format('Y-m-d'))
            ->with('guru')
            ->orderBy('shift')
            ->get();

        $guruMapel = User::where('role', 'guru_mapel')->get();

        return view('admin.page.jadwal_piket.edit_harian', compact('jadwalHarian', 'tanggal', 'guruMapel'));
    }

    public function updateHarian(Request $request, $tanggal)
    {
        $tanggal = Carbon::parse($tanggal);
        
        $request->validate([
            'guru_piket' => 'required|array|size:3',
            'guru_piket.*' => 'required|exists:users,id',
        ]);

        // Hapus jadwal lama hari ini
        JadwalPiket::where('tanggal', $tanggal->format('Y-m-d'))->delete();

        // Simpan jadwal baru
        foreach ($request->guru_piket as $index => $userId) {
            JadwalPiket::create([
                'tanggal' => $tanggal->format('Y-m-d'),
                'user_id' => $userId,
                'shift' => $index + 1,
            ]);
        }

        return redirect()->route('jadwal.piket.show', ['minggu' => 'depan'])
            ->with('success', 'Jadwal piket untuk ' . $tanggal->format('d M Y') . ' berhasil diperbarui.');
    }

    public function exportPdf(Request $request)
    {
        $minggu = $request->get('minggu', 'depan');

        if ($minggu === 'ini') {
            $start = now()->startOfWeek();
            $end = $start->copy()->endOfWeek();
        } else {
            $start = now()->addWeek()->startOfWeek();
            $end = $start->copy()->endOfWeek();
        }

        $jadwal = JadwalPiket::mingguIni($start, $end)->get()->groupBy('tanggal');

        // Generate PDF
        $pdf = \PDF::loadView('admin.page.jadwal_piket.pdf', compact('jadwal', 'start', 'end', 'minggu'));
        $pdf->setPaper('A4', 'portrait');

        return $pdf->download('jadwal_piket_' . $minggu . '_' . now()->format('Y-m-d') . '.pdf');
    }
}