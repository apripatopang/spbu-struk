<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/', function (Request $r) {
    // DEFAULT biar kalau kosong tetap tampil
    $spbu_kode   = $r->input('spbu_kode', '132B2606');
    $spbu_nama   = $r->input('spbu_nama', 'SPBU RAWAMANGUN No.66');
    $spbu_alamat = $r->input('spbu_alamat', 'JL. RAWAMANGUN NO.66 PEKANBARU');

    $shift       = $r->input('shift', '2');
    $no_trans    = $r->input('no_trans', '417687');
    $waktu       = $r->input('waktu', now()->format('d/m/Y H:i:s'));

    $pulau       = $r->input('pulau', '4');      // Island
    $pompa       = $r->input('pompa', null);     // kalau mau pisah pulau/pompa, isi sendiri
    $operator    = $r->input('operator', 'OPERATOR');

    $jenis       = strtoupper(trim($r->input('jenis', 'PERTALITE')));

    // Preset resmi sesuai daftar screenshot pengguna (Wilayah Riau):
    if (str_contains($jenis, 'PERTALITE')) {
        $harga_non  = 13500;
        $subs_liter = 3500;
    } elseif (str_contains($jenis, 'SOLAR')) {
        $harga_non  = 11800;
        $subs_liter = 5000;
    } elseif (str_contains($jenis, 'TURBO')) {
        $harga_non  = 19100;
        $subs_liter = 0;
    } elseif (str_contains($jenis, 'PERTAMAX')) {
        $harga_non  = 16650;
        $subs_liter = 0;
    } elseif (str_contains($jenis, 'DEXLITE')) {
        $harga_non  = 20550;
        $subs_liter = 0;
    } elseif (str_contains($jenis, 'DEX')) {
        $harga_non  = 22100;
        $subs_liter = 0;
    } else {
        $harga_non  = (int) $r->input('harga_non', 10000);
        $subs_liter = (int) $r->input('subs_liter', 0);
    }

    $harga_jual  = (int) ($harga_non - $subs_liter);      // hasil akhir per liter

    // Jika total_bayar diinputkan dari form, hitung liter dari total_bayar (atau sebaliknya)
    if ($r->has('total_bayar') && (int)$r->input('total_bayar') > 0) {
        $total_bayar = (int) $r->input('total_bayar');
        if ($harga_jual > 0) {
            $liter = round($total_bayar / $harga_jual, 2);
        } else {
            $liter = (float) $r->input('liter', 10.00);
        }
    } elseif ($r->has('cash') && (int)$r->input('cash') > 0 && !$r->has('liter')) {
        $total_bayar = (int) $r->input('cash');
        if ($harga_jual > 0) {
            $liter = round($total_bayar / $harga_jual, 2);
        } else {
            $liter = (float) $r->input('liter', 10.00);
        }
    } else {
        $liter       = (float) $r->input('liter', 10.00);
        $total_bayar = (int) round($liter * $harga_jual);
    }

    // TOTAL (otomatis dari liter x harga)
    $total_tanpa = (int) round($liter * $harga_non);
    $total_subs  = (int) round($liter * $subs_liter);

    $cash        = (int) $r->input('cash', $total_bayar);

    $plat        = strtoupper($r->input('plat', 'BM1448QX'));

    return view('struk', compact(
        'spbu_kode','spbu_nama','spbu_alamat',
        'shift','no_trans','waktu','pulau','pompa','operator',
        'jenis','liter','harga_non','subs_liter','harga_jual',
        'total_tanpa','total_subs','total_bayar','cash','plat'
    ) + ['shouldPrint' => $r->boolean('print', false)]);
});
