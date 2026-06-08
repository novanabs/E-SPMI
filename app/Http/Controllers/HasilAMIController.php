<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Audit;
use App\Models\AuditKriteria;
use App\Models\AuditorJurusan;
use App\Models\Kriteria;
use App\Models\User;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

class HasilAMIController extends Controller
{
    // Submit / finalisasi penilaian AMI
    public function submit(Request $request)
    {
        $request->validate([
            'program_studi' => 'required|string',
            'role'          => 'required|in:admin_jurusan,admin_FKIP,auditor',
        ]);

        $audit = Audit::updateOrCreate(
            ['program_studi' => $request->program_studi],
            ['fakultas'     => 'Keguruan dan Ilmu Pendidikan']
        );

        $role = $request->role;

        if ($role === 'auditor') {
            $audit->update([
                'auditor_submitted_at' => now(),
                'auditor_submitted_by' => auth()->id(),
            ]);
        } else {
            $audit->update([
                'jurusan_submitted_at' => now(),
                'jurusan_submitted_by' => auth()->id(),
            ]);
        }

        return response()->json([
            'success' => true,
            'message' => 'Penilaian AMI berhasil disubmit. Data tidak dapat diubah lagi.',
        ]);
    }

    // Simpan header audit
    public function saveHeader(Request $request)
    {

        try {
            $request->validate([
                'tanggal_audit' => 'required|date',
                'catatan_umum'  => 'nullable|string|max:200',
                'auditor_1_id'  => 'nullable|exists:users,id',
                'auditor_2_id'  => 'nullable|exists:users,id',
                'program_studi' => 'required|string',
            ]);

            $audit = Audit::updateOrCreate(
                [
                    'program_studi' => $request->program_studi,
                ],
                [
                    'fakultas'      => 'Keguruan dan Ilmu Pendidikan',
                    'tanggal_audit' => $request->tanggal_audit,
                    'catatan_umum'  => $request->catatan_umum,
                    'auditor_1_id'  => $request->auditor_1_id ?: null,
                    'auditor_2_id'  => $request->auditor_2_id ?: null,
                ]
            );

            return response()->json(['audit_id' => $audit->id]);

        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }


    // Simpan per kriteria (dipanggil tiap tombol Simpan di tiap card)
    public function saveKriteria(Request $request)
    {
        try {

            $data = AuditKriteria::updateOrCreate(
                [
                    'jurusan_id'  => $request->jurusan_id,
                    'kriteria_id' => $request->kriteria_id,
                ],
                [
                    'temuan'      => $request->temuan,
                    'rekomendasi' => $request->rekomendasi,
                ]
            );

            return response()->json($data);

        } catch (\Throwable $e) {

            return response()->json([
                'message' => $e->getMessage(),
                'line'    => $e->getLine(),
                'file'    => $e->getFile(),
            ], 500);

        }
    }

    // Export ke Excel
    public function exportPdf($jurusanId)
    {
        $jurusan = User::findOrFail($jurusanId);


        $auditHeader = Audit::where(
            'program_studi',
            $jurusanId
        )->latest()->first();

        // Ambil semua kriteria, tapi muat auditKriterias yang filternya sesuai jurusan_id
        $auditKriterias = Kriteria::with([
            'auditKriterias' => function ($query) use ($jurusanId) {
                $query->where('jurusan_id', $jurusanId);
            }
        ])->get();


        $auditor = AuditorJurusan::where('jurusan', $jurusan->homebase)
            ->get();


        $pdf = Pdf::loadView(
            'exports.audit-pdf',
            compact(
                'jurusan',
                'auditHeader',
                'auditKriterias',
                'auditor'
            )
        )->setPaper('a4', 'portrait');

        return $pdf->stream(
            'AMI_' .
            str_replace(' ', '_', $jurusan->homebase) .
            '.pdf'
        );
    }
}
