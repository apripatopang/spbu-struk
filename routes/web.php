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

    $jenis       = $r->input('jenis', 'PERTALITE');
    $liter       = (float) $r->input('liter', 10.00);

    // Harga per liter
    $harga_non   = (int) $r->input('harga_non', 10000);   // non-subsidi
    $subs_liter  = (int) $r->input('subs_liter', 0);      // subsidi per liter
    $harga_jual  = (int) ($harga_non - $subs_liter);      // hasil akhir di struk

    // TOTAL (otomatis dari liter x harga)
    $total_tanpa = (int) round($liter * $harga_non);
    $total_subs  = (int) round($liter * $subs_liter);
    $total_bayar = (int) round($liter * $harga_jual);

    $cash        = (int) $r->input('cash', $total_bayar);

    $plat        = strtoupper($r->input('plat', 'BM1448QX'));

    return view('struk', compact(
        'spbu_kode','spbu_nama','spbu_alamat',
        'shift','no_trans','waktu','pulau','pompa','operator',
        'jenis','liter','harga_non','subs_liter','harga_jual',
        'total_tanpa','total_subs','total_bayar','cash','plat'
    ) + ['shouldPrint' => $r->boolean('print', false)]);
});
