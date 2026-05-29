<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\MatriksLED;
use App\Models\SyaratUnggul;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SyaratController extends Controller
{
    public function index()
    {
        $userId = Auth::id();

        $data = SyaratUnggul::with([
            'matriks.subItemElemen',
            'matriks.userSubItemElements' => function ($q) use ($userId) {
                $q->where('id_users', $userId);
            },
            'matriks.userMatrik'          => function ($q) use ($userId) {
                $q->where('id_users', $userId);
            }
        ])->get();

        // Compute NA, syarat3, syarat5 for status table
        $na = 0;
        $matriksAll = MatriksLED::with([
            'userMatrik' => function ($q) use ($userId) {
                $q->where('id_users', $userId);
            }
        ])->orderBy('nomor')->get();

        foreach ($matriksAll as $m) {
            $na += (float) ($m->userMatrik->nilai_total ?? 0);
        }

        // Compute syarat3/syarat5 from data collection
        $syarat3 = false;
        $syarat5 = false;
        foreach ($data as $item) {
            $m3 = $item->memenuhi_3_tahun ?? false;
            $m5 = $item->memenuhi_5_tahun ?? false;

            if ($item->nomor == 1) {
                $subItems = $item->matriks->subItemElemen ?? collect();
                $userValues = $item->matriks->userSubItemElements ?? collect();
                $nilaiMap = $userValues->pluck('nilai', 'id_sub_item_elemen');
                $NDS3 = $NDL = $NDLK = $NDGB = 0;
                foreach ($subItems as $sub) {
                    $v = $sub->variabel;
                    $n = (float) ($nilaiMap[$sub->id] ?? 0);
                                    if ($v == 'NDS3') $NDS3 = $n;
                        if ($v == 'NDL') $NDL = $n;
                        if ($v == 'NDLK') $NDLK = $n;
                        if ($v == 'NDGB') $NDGB = $n;
                }
                $totalLektor = $NDL + $NDLK + $NDGB;
                $m3 = $NDS3 >= 1 && $totalLektor >= 2;
                $m5 = $NDS3 >= 2 && $totalLektor >= 2 && $NDLK >= 1;
            } elseif (in_array($item->nomor, [2,3,4])) {
                $jawaban = (float) ($item->matriks->userMatrik->jawaban ?? 0);
                $m3 = $jawaban >= 3.0;
                $m5 = $jawaban >= 3.5;
            } elseif ($item->nomor == 5) {
                $NM = 0; $S1=$S2=$S3=$S4=$S5=$S6=0; $INT=$ISBN=$PATEN=0;
                $subItems = $item->matriks->subItemElemen ?? collect();
                $userValues = $item->matriks->userSubItemElements ?? collect();
                $nilaiMap = $userValues->pluck('nilai', 'id_sub_item_elemen');
                foreach ($subItems as $sub) {
                    $v = $sub->variabel; $n = (float)($nilaiMap[$sub->id]??0);
                    if ($v == 'NM') $NM = $n;
                    if ($v == 'SINTA1_MHS') $S1 = $n;
                    if ($v == 'SINTA2_MHS') $S2 = $n;
                    if ($v == 'SINTA3_MHS') $S3 = $n;
                    if ($v == 'SINTA4_MHS') $S4 = $n;
                    if ($v == 'SINTA5_MHS') $S5 = $n;
                    if ($v == 'SINTA6_MHS') $S6 = $n;
                    if ($v == 'INT_MHS') $INT = $n;
                    if ($v == 'ISBN_MHS') $ISBN = $n;
                    if ($v == 'PATEN_MHS') $PATEN = $n;
                }
                if ($NM > 0) {
                    $m3 = ((($S1+$S2+$S3+$S4+$S5+$INT+$ISBN+$PATEN)/$NM)*100) >= 15;
                    $m5 = ((($S1+$S2+$S3+$S4+$INT+$ISBN+$PATEN)/$NM)*100) >= 25;
                }
            } elseif ($item->nomor == 6) {
                $NDTPS = 0; $NDTPS_PUB = 0;
                $subItems = $item->matriks->subItemElemen ?? collect();
                $userValues = $item->matriks->userSubItemElements ?? collect();
                $nilaiMap = $userValues->pluck('nilai', 'id_sub_item_elemen');
                foreach ($subItems as $sub) {
                    $v = $sub->variabel; $n = (float) ($nilaiMap[$sub->id] ?? 0);
                    if ($v == 'NDTPS') $NDTPS = $n;
                    if ($v == 'NDTPS_PUB') $NDTPS_PUB = $n;
                }
                if ($NDTPS > 0) {
                    $persen3 = ($NDTPS_PUB / $NDTPS) * 100;
                    $persen5 = $persen3;
                    $m3 = $persen3 >= 20;
                    $m5 = $persen5 >= 20;
                }
            }

            if ($m3) $syarat3 = true;
            if ($m5) $syarat5 = true;
        }

        return view('SyaratUnggul.index', compact('data', 'na', 'syarat3', 'syarat5'));
    }
}
