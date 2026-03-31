<?php

namespace App\Http\Controllers\Unit;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\Profile;
use App\Models\KegiatanKerjasama;
use App\Models\Evaluasi;
use App\Models\JenisKerjasama;

class UnitPageController extends Controller
{
    /**
     * Resolve the unit_kerja_id for the currently logged-in user.
     */
    private function resolveUnitId()
    {
        $user = Auth::user();
        $profile = Profile::where('user_id', $user->id)->first();

        if (!$profile || !$profile->unit_kerja_id) {
            abort(403, 'Profil unit kerja tidak ditemukan.');
        }

        return $profile->unit_kerja_id;
    }

    /**
     * Helper: scope query to kegiatan belonging to this unit.
     */
    private function scopeUnit($query, $unitId)
    {
        return $query->whereHas('unitKerjas', fn($q) => $q->where('unit_kerjas.id', $unitId));
    }

    // ─── Data Kerjasama ──────────────────────────────────────────
    public function dkerjasama()
    {
        $unitId = $this->resolveUnitId();

        $kerjasamaUnit = $this->scopeUnit(KegiatanKerjasama::query(), $unitId)
            ->with(['jenisKerjasama', 'mitras'])
            ->orderBy('created_at', 'desc')
            ->get();

        return view('auth.unit', compact('kerjasamaUnit'));
    }

    // ─── Evaluasi Kinerja ────────────────────────────────────────
    public function evaluasi()
    {
        $unitId = $this->resolveUnitId();

        // Kegiatan yang sudah dievaluasi oleh unit ini
        $evaluasiList = $this->scopeUnit(KegiatanKerjasama::query(), $unitId)
            ->whereHas('evaluasis')
            ->with(['evaluasis', 'mitras', 'jenisKerjasama'])
            ->orderBy('updated_at', 'desc')
            ->get();

        // Kegiatan yang belum dievaluasi
        $belumEvaluasi = $this->scopeUnit(KegiatanKerjasama::query(), $unitId)
            ->whereDoesntHave('evaluasis')
            ->with(['mitras', 'jenisKerjasama'])
            ->orderBy('created_at', 'desc')
            ->get();

        return view('auth.unit', compact('evaluasiList', 'belumEvaluasi'));
    }

    // ─── Laporan Data ────────────────────────────────────────────
    public function laporan()
    {
        $unitId = $this->resolveUnitId();

        $jenisKerjasama = JenisKerjasama::orderBy('nama_kerjasama')->get();

        $kerjasamaUnit = $this->scopeUnit(KegiatanKerjasama::query(), $unitId)
            ->with(['jenisKerjasama', 'mitras'])
            ->orderBy('created_at', 'desc')
            ->get();

        return view('auth.unit', compact('jenisKerjasama', 'kerjasamaUnit'));
    }

    // ─── Statistik Data ──────────────────────────────────────────
    public function statistik()
    {
        $unitId = $this->resolveUnitId();

        $totalKerjasama = $this->scopeUnit(KegiatanKerjasama::query(), $unitId)->count();

        // Status breakdown
        $statusBreakdown = $this->scopeUnit(KegiatanKerjasama::query(), $unitId)
            ->select('status', DB::raw('count(*) as total'))
            ->groupBy('status')
            ->pluck('total', 'status');

        // Tren per tahun
        $trenPerTahun = $this->scopeUnit(KegiatanKerjasama::query(), $unitId)
            ->select(DB::raw('YEAR(created_at) as tahun'), DB::raw('count(*) as total'))
            ->groupBy('tahun')
            ->orderBy('tahun')
            ->get();

        // Sebaran jenis kerjasama
        $sebaranJenis = DB::table('kegiatan_jenis_kerjasamas')
            ->join('jenis_kerjasamas', 'kegiatan_jenis_kerjasamas.id_jenis', '=', 'jenis_kerjasamas.id')
            ->join('kegiatan_units', 'kegiatan_jenis_kerjasamas.id_kegiatan', '=', 'kegiatan_units.id_kegiatan')
            ->where('kegiatan_units.id_unit', $unitId)
            ->select('jenis_kerjasamas.nama_kerjasama', DB::raw('count(*) as total'))
            ->groupBy('jenis_kerjasamas.nama_kerjasama')
            ->get();

        // Rata-rata evaluasi
        $avgEvaluasi = Evaluasi::whereHas('kegiatanKerjasama', function ($q) use ($unitId) {
            $q->whereHas('unitKerjas', fn($qu) => $qu->where('unit_kerjas.id', $unitId));
        })
            ->select(
                DB::raw('ROUND(AVG(kualitas),1)     as avg_kualitas'),
                DB::raw('ROUND(AVG(keterlibatan),1)  as avg_keterlibatan'),
                DB::raw('ROUND(AVG(efisiensi),1)     as avg_efisiensi'),
                DB::raw('ROUND(AVG(kepuasan),1)      as avg_kepuasan')
            )
            ->first();

        return view('auth.unit', compact(
            'totalKerjasama',
            'statusBreakdown',
            'trenPerTahun',
            'sebaranJenis',
            'avgEvaluasi'
        ));
    }
}
