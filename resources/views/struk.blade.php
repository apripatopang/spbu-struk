<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Struk SPBU Pertamina</title>
  <style>
    * { box-sizing: border-box; }
    body {
      font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif;
      max-width: 520px;
      margin: 0 auto;
      padding: 12px;
      background-color: #f3f4f6;
      color: #1f2937;
    }

    /* Container Form Input untuk Layar HP & PC */
    .form-card {
      background: #ffffff;
      padding: 16px;
      border-radius: 12px;
      box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
      margin-bottom: 20px;
    }
    .form-title {
      font-weight: 700;
      font-size: 16px;
      margin-bottom: 12px;
      color: #111827;
    }

    .grid {
      display: grid;
      grid-template-columns: 1fr 1fr;
      gap: 10px;
    }
    @media (max-width: 480px) {
      .grid { grid-template-columns: 1fr; }
    }

    label {
      font-size: 12px;
      font-weight: 600;
      color: #374151;
      display: flex;
      flex-direction: column;
      gap: 4px;
    }

    input, select, textarea {
      font-family: inherit;
      font-size: 14px;
      padding: 8px 10px;
      border: 1px solid #d1d5db;
      border-radius: 6px;
      width: 100%;
      background-color: #fff;
    }
    input:focus, select:focus, textarea:focus {
      outline: none;
      border-color: #2563eb;
      box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.15);
    }
    input[readonly] {
      background-color: #f3f4f6;
      color: #6b7280;
    }

    .btn-group {
      margin-top: 14px;
      display: flex;
      gap: 8px;
    }
    .btn {
      flex: 1;
      padding: 10px;
      font-size: 13px;
      font-weight: 600;
      border: none;
      border-radius: 6px;
      cursor: pointer;
      text-align: center;
    }
    .btn-primary { background-color: #2563eb; color: #fff; }
    .btn-primary:hover { background-color: #1d4ed8; }
    .btn-success { background-color: #059669; color: #fff; }
    .btn-success:hover { background-color: #047857; }
    .btn-small { padding: 4px 8px; font-size: 11px; background: #e5e7eb; color: #374151; border-radius: 4px; border: 1px solid #d1d5db; cursor: pointer; }

    /* Area Preview Struk 58mm */
    .struk-preview-card {
      background: #fff;
      padding: 12px 0;
      border-radius: 8px;
      box-shadow: 0 2px 8px rgba(0, 0, 0, 0.06);
    }
    .struk-paper {
      font-family: monospace;
      width: 58mm;
      margin: 0 auto;
      font-size: 12px;
      line-height: 1.2;
      color: #000;
      background: #fff;
      padding: 4px;
    }

    .center { text-align: center; }
    .logo { display: block; margin: 0 auto 4px; width: 45px; height: auto; }
    .line { border-top: 1px dotted #000; margin: 6px 0; }
    .row { display: flex; justify-content: space-between; }
    .col2 { display: flex; justify-content: space-between; gap: 14px; }
    .label { min-width: 15ch; }
    .val { text-align: right; }

    /* Pengaturan Cetak Printer Thermal */
    @media print {
      body { background: #fff; padding: 0; margin: 0; }
      .no-print { display: none !important; }
      .struk-preview-card { box-shadow: none; padding: 0; }
      .struk-paper { margin: 0 auto !important; width: 58mm !important; }
      .logo { width: 140px !important; margin-bottom: 0px !important; }
    }
  </style>
</head>
<body>

  {{-- -------- FORM UBAH DATA (tidak tercetak) -------- --}}
  <div class="no-print form-card">
    <div class="form-title">⚡ INPUT STRUK SPBU</div>
    <form id="f" method="GET" action="/">
      <div class="grid">
        <label>Nama SPBU<textarea name="spbu_nama" rows="1">{{ $spbu_nama }}</textarea></label>
        <label>Kode SPBU<input name="spbu_kode" value="{{ $spbu_kode }}"></label>

        <label>Alamat SPBU<textarea name="spbu_alamat" rows="2">{{ $spbu_alamat }}</textarea></label>
        <label>No. Trans<input name="no_trans" value="{{ $no_trans }}"></label>

        <label>Waktu Transaksi (Pilih Tanggal & Jam)
          <div style="display:flex; flex-direction:column; gap:4px;">
            <div style="display:flex; gap:4px;">
              <input type="datetime-local" step="1" id="picker_waktu" style="flex:1;" title="Pilih Tanggal & Jam melalui Kalender">
              <button type="button" onclick="setWaktuSekarang()" class="btn-small" title="Set ke jam sekarang">⏰ Sekarang</button>
            </div>
            <input name="waktu" id="input_waktu" value="{{ $waktu }}" placeholder="dd/mm/YYYY HH:ii:ss" title="Format teks hasil akhir">
          </div>
        </label>

        <label>Shift<input name="shift" value="{{ $shift }}"></label>
        <label>Pulau<input name="pulau" value="{{ $pulau }}"></label>
        <label>No. Pompa (opsional)<input name="pompa" value="{{ $pompa }}"></label>

        <label>Operator<input name="operator" value="{{ $operator }}"></label>
        <label>Jenis BBM
          <input name="jenis" id="input_jenis" list="jenis_options" value="{{ $jenis }}" placeholder="Pilih / ketik jenis BBM">
          <datalist id="jenis_options">
            <option value="PERTALITE">Pertalite (Subsidi): Rp 10.000 per liter</option>
            <option value="BIOSOLAR">Biosolar (Subsidi): Rp 6.800 per liter</option>
            <option value="PERTAMAX (RON 92)">Pertamax (RON 92): Rp 16.650 per liter</option>
            <option value="PERTAMAX TURBO (RON 98)">Pertamax Turbo (RON 98): Rp 19.100 per liter</option>
            <option value="DEXLITE (CN 51)">Dexlite (CN 51): Rp 20.550 per liter</option>
            <option value="PERTAMINA DEX (CN 53)">Pertamina Dex (CN 53): Rp 22.100 per liter</option>
          </datalist>
        </label>

        <label>Volume (Liter)<input type="number" step="0.01" name="liter" id="input_liter" value="{{ number_format($liter,2,'.','') }}"></label>
        <label>Harga Non Subsidi /L (Rp)<input type="number" name="harga_non" id="input_harga_non" value="{{ $harga_non }}"></label>

        <label>Subsidi Pemerintah /L (Rp)<input type="number" name="subs_liter" id="input_subs_liter" value="{{ $subs_liter }}"></label>
        <label>Harga Jual /L (Rp) <small>(auto = non-subsidi - subsidi)</small>
          <input type="number" name="harga_jual" id="input_harga_jual" value="{{ $harga_jual }}" readonly>
        </label>

        <label>Total Dibayar Konsumen (Rp) <small>(auto hitung / ubah liter)</small>
          <input type="number" name="total_bayar" id="input_total_bayar" value="{{ $total_bayar }}">
        </label>
        <label>Cash (Rp)<input type="number" name="cash" id="input_cash" value="{{ $cash }}"></label>
        <label>No. Plat<input name="plat" value="{{ $plat }}"></label>
      </div>

      <input type="hidden" name="print" id="printFlag" value="0">
      <div class="btn-group">
        <button type="submit" class="btn btn-primary">Update Struk</button>
        <button type="button" onclick="printAfterSubmit()" class="btn btn-success">Update & Print 🖨️</button>
      </div>
    </form>
  </div>

  {{-- -------- STRUK CETAK -------- --}}
  <div class="struk-preview-card">
    <div class="struk-paper">
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
    </div>
  </div>

  <script>
    function printAfterSubmit() {
      document.getElementById('printFlag').value = '1';
      document.getElementById('f').submit();
    }
    @if ($shouldPrint)
      window.onload = () => window.print();
    @endif

    // Manajamen Picker Waktu Kalender & Jam
    const pickerWaktu = document.getElementById('picker_waktu');
    const inputWaktu = document.getElementById('input_waktu');

    function syncPickerFromInput() {
      if (!inputWaktu || !pickerWaktu) return;
      const str = inputWaktu.value.trim();
      const parts = str.split(' ');
      if (parts.length === 2) {
        const dParts = parts[0].split('/');
        const tParts = parts[1];
        if (dParts.length === 3) {
          const isoStr = `${dParts[2]}-${dParts[1].padStart(2,'0')}-${dParts[0].padStart(2,'0')}T${tParts}`;
          pickerWaktu.value = isoStr;
        }
      }
    }

    function syncInputFromPicker() {
      if (!pickerWaktu || !pickerWaktu.value) return;
      const val = pickerWaktu.value;
      const [datePart, timePart] = val.split('T');
      if (!datePart || !timePart) return;
      const [yyyy, mm, dd] = datePart.split('-');
      const tParts = timePart.split(':');
      const hh = tParts[0];
      const min = tParts[1];
      const ss = tParts[2] ? tParts[2] : '00';
      inputWaktu.value = `${dd}/${mm}/${yyyy} ${hh}:${min}:${ss}`;
    }

    function setWaktuSekarang() {
      const now = new Date();
      const pad = (n) => String(n).padStart(2, '0');
      const dd = pad(now.getDate());
      const mm = pad(now.getMonth() + 1);
      const yyyy = now.getFullYear();
      const hh = pad(now.getHours());
      const min = pad(now.getMinutes());
      const ss = pad(now.getSeconds());

      const formatted = `${dd}/${mm}/${yyyy} ${hh}:${min}:${ss}`;
      const isoStr = `${yyyy}-${mm}-${dd}T${hh}:${min}:${ss}`;

      if (inputWaktu) inputWaktu.value = formatted;
      if (pickerWaktu) pickerWaktu.value = isoStr;
    }

    if (pickerWaktu) {
      pickerWaktu.addEventListener('change', syncInputFromPicker);
      pickerWaktu.addEventListener('input', syncInputFromPicker);
    }
    if (inputWaktu) {
      inputWaktu.addEventListener('input', syncPickerFromInput);
      syncPickerFromInput();
    }

    // Auto calculate antara Liter dan Total Uang
    const inputJenis = document.getElementById('input_jenis');
    const inputLiter = document.getElementById('input_liter');
    const inputHargaNon = document.getElementById('input_harga_non');
    const inputSubsLiter = document.getElementById('input_subs_liter');
    const inputHargaJual = document.getElementById('input_harga_jual');
    const inputTotalBayar = document.getElementById('input_total_bayar');
    const inputCash = document.getElementById('input_cash');

    function checkJenisPreset() {
      if (!inputJenis) return;
      const val = inputJenis.value.trim().toUpperCase();
      if (val.includes('PERTALITE')) {
        inputHargaNon.value = 13500;
        inputSubsLiter.value = 3500;
      } else if (val.includes('SOLAR')) {
        inputHargaNon.value = 11800;
        inputSubsLiter.value = 5000;
      } else if (val.includes('TURBO')) {
        inputHargaNon.value = 19100;
        inputSubsLiter.value = 0;
      } else if (val.includes('PERTAMAX')) {
        inputHargaNon.value = 16650;
        inputSubsLiter.value = 0;
      } else if (val.includes('DEXLITE')) {
        inputHargaNon.value = 20550;
        inputSubsLiter.value = 0;
      } else if (val.includes('DEX')) {
        inputHargaNon.value = 22100;
        inputSubsLiter.value = 0;
      }

      // Jika nominal dibayar/cash sudah terisi, hitung ulang liter. Jika belum, hitung dari liter
      const totalVal = parseFloat(inputTotalBayar.value) || 0;
      if (totalVal > 0) {
        calcFromTotal();
      } else {
        calcFromLiter();
      }
    }

    function updateHargaJual() {
      const hNon = parseFloat(inputHargaNon.value) || 0;
      const subs = parseFloat(inputSubsLiter.value) || 0;
      const hJual = Math.max(0, hNon - subs);
      inputHargaJual.value = hJual;
      return hJual;
    }

    function calcFromLiter() {
      const hJual = updateHargaJual();
      const liter = parseFloat(inputLiter.value) || 0;
      const total = Math.round(liter * hJual);
      inputTotalBayar.value = total;
      inputCash.value = total;
    }

    function calcFromTotal() {
      const hJual = updateHargaJual();
      const total = parseFloat(inputTotalBayar.value) || 0;
      if (hJual > 0) {
        inputLiter.value = (total / hJual).toFixed(2);
      }
      inputCash.value = total;
    }

    function calcFromCash() {
      const hJual = updateHargaJual();
      const cashVal = parseFloat(inputCash.value) || 0;
      inputTotalBayar.value = cashVal;
      if (hJual > 0) {
        inputLiter.value = (cashVal / hJual).toFixed(2);
      }
    }

    if (inputJenis) {
      inputJenis.addEventListener('change', checkJenisPreset);
      inputJenis.addEventListener('input', checkJenisPreset);
    }
    inputLiter.addEventListener('input', calcFromLiter);
    inputHargaNon.addEventListener('input', calcFromLiter);
    inputSubsLiter.addEventListener('input', calcFromLiter);
    inputTotalBayar.addEventListener('input', calcFromTotal);
    inputCash.addEventListener('input', calcFromCash);
  </script>
</body>
</html>
