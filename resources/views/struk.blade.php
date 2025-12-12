<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <title>Struk SPBU Pertamina</title>
  <style>
    /* ukuran kertas 58mm, font nota */
    body { font-family: monospace; width: 58mm; margin: 8px auto; font-size: 12px; }
    .center { text-align: center; }
    .no-print { margin-bottom: 8px; }
    .logo {
  display: block;
  margin: 10px auto 20px;
  width: 120px;    /* kalau mau lebih besar ubah ke 50px */
  height: auto;
}

    .logo { display:block; margin: 0 auto 4px; width: 30px; height: auto; }
    .line { border-top: 1px dotted #000; margin: 6px 0; }

    .row { display: flex; justify-content: space-between; }
    .col2 { display:flex; justify-content: space-between; gap: 14px; }
    .label { min-width: 16ch; }     /* label rata titik dua */
    .val   { text-align: right; }

    /* Saat print, sembunyikan form dan atur tampilan */
@media print {
  .no-print { display: none !important; }
  body { margin: 0 auto !important; }

  /* BESARKAN logo dan beri jarak */
  .logo {
    display: block !important;
    width: 180px !important;
    height: auto !important;
    margin-top: 0px !important;     /* jarak dari atas */
    margin-bottom: 0px !important;  /* jarak ke teks di bawah */
  }
}




    /* tombol sederhana */
    button { font-family: monospace; }
    input, select, textarea { font-family: monospace; width: 100%; box-sizing: border-box; }
    .grid { display:grid; grid-template-columns: 1fr 1fr; gap:6px 8px; }
  </style>
</head>
<body>

  {{-- -------- FORM UBAH DATA (tidak tercetak) -------- --}}
  <div class="no-print">
    <div style="font-weight:bold; margin-bottom:4px;">INPUT STRUK</div>
    <form id="f" method="GET" action="/">
      <div class="grid">
        <label>Nama SPBU<textarea name="spbu_nama" rows="1">{{ $spbu_nama }}</textarea></label>
        <label>Kode SPBU<input name="spbu_kode" value="{{ $spbu_kode }}"></label>

        <label>Alamat SPBU<textarea name="spbu_alamat" rows="2">{{ $spbu_alamat }}</textarea></label>
        <label>No. Trans<input name="no_trans" value="{{ $no_trans }}"></label>

        <label>Shift<input name="shift" value="{{ $shift }}"></label>
        <label>Waktu (dd/mm/YYYY HH:ii:ss)<input name="waktu" value="{{ $waktu }}"></label>

        <label>Pulau<input name="pulau" value="{{ $pulau }}"></label>
        <label>No. Pompa (opsional)<input name="pompa" value="{{ $pompa }}"></label>

        <label>Operator<input name="operator" value="{{ $operator }}"></label>
        <label>Jenis BBM<input name="jenis" value="{{ $jenis }}"></label>

        <label>Volume (Liter)<input type="number" step="0.01" name="liter" value="{{ number_format($liter,2,'.','') }}"></label>
        <label>Harga Non Subsidi /L (Rp)<input type="number" name="harga_non" value="{{ $harga_non }}"></label>

        <label>Subsidi Pemerintah /L (Rp)<input type="number" name="subs_liter" value="{{ $subs_liter }}"></label>
        <label>Harga Jual /L (Rp) <small>(auto = non-subsidi - subsidi)</small>
          <input type="number" name="harga_jual" value="{{ $harga_jual }}" readonly>
        </label>

        <label>No. Plat<input name="plat" value="{{ $plat }}"></label>
        <label>Cash (Rp)<input type="number" name="cash" value="{{ $cash }}"></label>
      </div>

      <input type="hidden" name="print" id="printFlag" value="0">
      <div style="margin-top:6px; display:flex; gap:6px;">
        <button type="submit">Update Struk</button>
        <button type="button" onclick="printAfterSubmit()">Update & Print</button>
      </div>
    </form>
    <div class="line"></div>
  </div>

  {{-- -------- STRUK CETAK -------- --}}
  <div class="center">
    <img src="{{ asset('images/pertamina.png') }}" class="logo" alt="Pertamina">
    <div style="font-weight:bold;">{{ $spbu_kode }}</div>
    <div style="font-weight:bold;">{{ strtoupper($spbu_nama) }}</div>
    <div>{{ strtoupper($spbu_alamat) }}</div>
  </div>

  <div class="row" style="margin-top:4px;">
    <div>Shift:{{ $shift }}</div>
    <div>No.Trans: {{ $no_trans }}</div>
  </div>
  <div>Waktu: {{ $waktu }}</div>

  <div class="line"></div>

  <div class="col2">
    <div>Pulau/pompa  :  {{ $pulau }}</div>
    <div></div>
  </div>
  <div class="row"><div class="label">Operator</div><div class="val">:  {{ strtoupper($operator) }}</div></div>
  <div class="row"><div class="label">Jenis BBM</div><div class="val">:  {{ strtoupper($jenis) }}</div></div>
  <div class="row"><div class="label">Volume</div><div class="val">:  {{ number_format($liter,2) }} Liter</div></div>

  <div class="line"></div>

  <div style="font-weight:bold;">Informasi Harga BBM (Rp/Liter)</div>
  <div class="row"><div class="label">Harga Non Subsidi</div><div class="val">:  {{ number_format($harga_non,0,',','.') }}</div></div>
  <div class="row"><div class="label">Subsidi Pemerintah</div><div class="val">:  {{ number_format($subs_liter,0,',','.') }}</div></div>
  <div class="row"><div class="label">Harga Jual</div><div class="val">:  {{ number_format($harga_jual,0,',','.') }}</div></div>

  <div class="line"></div>

  <div style="font-weight:bold;">Total Penjualan (Rp)</div>
  <div class="row"><div class="label">Tanpa Subsidi</div><div class="val">:  {{ number_format($total_tanpa,0,',','.') }}</div></div>
  <div class="row"><div class="label">Subsidi Pemerintah</div><div class="val">:  {{ number_format($total_subs,0,',','.') }}</div></div>
  <div class="row"><div class="label">Dibayar Konsumen</div><div class="val">:  {{ number_format($total_bayar,0,',','.') }}</div></div>

  <div class="line"></div>

  <div style="font-weight:bold;">CASH</div>
  <div style="text-align:right; font-weight:bold;">{{ number_format($cash,0,',','.') }}</div>

  <div class="line"></div>

  <div>No. Plat : {{ $plat }}</div>

  <div class="line"></div>

  <div style="text-align:center;">
    Anda Mendapatkan Subsidi Dari<br>
    Pemerintah Sebesar Rp {{ number_format($total_subs,0,',','.') }}<br>
    (Perhitungan Subsidi Unaudited<br>
    atau Estimasi). Gunakan BBM<br>
    Subsidi Secara Bijak.
  </div>

  <script>
    function printAfterSubmit() {
      document.getElementById('printFlag').value = '1';
      document.getElementById('f').submit();
    }
    @if ($shouldPrint)
      window.onload = () => window.print();
    @endif
  </script>
</body>
</html>
