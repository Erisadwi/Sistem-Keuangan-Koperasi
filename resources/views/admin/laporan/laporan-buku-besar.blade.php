@extends('layouts.laporan-admin2')

@push('styles')
 @vite('resources/css/style-laporanBukuBesar.css')
@endpush

@section('title', 'Laporan Buku Besar')  
@section('title-1', 'Buku Besar')  
@section('title-content', 'Laporan Buku Besar')  
@section('period', 'Periode Oktober 2025')  
@section('sub-title', 'Laporan Buku Besar')  

@section('content')

<x-menu.month-filter/>
<x-menu.unduh/>

<div class="laporan-buku-besar-wrap">
  <div class="table-scroll-wrapper">
    
    {{-- 1. Kas Besar --}}
    <h4 class="judul-section">1. Kas Besar</h4>
    @include('partials.buku-besar-table', ['data' => $kasBesar ?? null, 'label' => 'kas besar'])

    {{-- 2. Bank Mandiri --}}
    <h4 class="judul-section">2. Bank Mandiri</h4>
    @include('partials.buku-besar-table', ['data' => $bankMandiri ?? null, 'label' => 'bank mandiri'])

    {{-- 3. Kas Kecil --}}
    <h4 class="judul-section">3. Kas Kecil</h4>
    @include('partials.buku-besar-table', ['data' => $kasKecil ?? null, 'label' => 'kas kecil'])

    {{-- 4. Kas Niaga --}}
    <h4 class="judul-section">4. Kas Niaga</h4>
    @include('partials.buku-besar-table', ['data' => $kasNiaga ?? null, 'label' => 'kas niaga'])

    {{-- 5. Bank BNI --}}
    <h4 class="judul-section">10. Bank BNI</h4>
    @include('partials.buku-besar-table', ['data' => $bankBni ?? null, 'label' => 'bank bni'])

    {{-- 6. Barang Dalam Perjalanan --}}
    <h4 class="judul-section">10. Barang Dalam Perjalanan</h4>
    @include('partials.buku-besar-table', ['data' => $barangDalamPerjalanan ?? null, 'label' => 'barang dalam perjalanan'])

    {{-- 7. Pinjaman Perusahaan --}}
    <h4 class="judul-section">171. Pinjaman Perusahaan</h4>
    @include('partials.buku-besar-table', ['data' => $pinjamanPerusahaan ?? null, 'label' => 'pinjaman perusahaan'])

    {{-- 8. Persediaan Barang --}}
    <h4 class="judul-section">5. Persediaan Barang</h4>
    @include('partials.buku-besar-table', ['data' => $persediaanBarang ?? null, 'label' => 'persediaan barang'])

    {{-- 9. Pinjaman Karyawan --}}
    <h4 class="judul-section">6. Pinjaman Karyawan</h4>
    @include('partials.buku-besar-table', ['data' => $pinjamanKaryawan ?? null, 'label' => 'pinjaman karyawan'])

    {{-- 10. Pinjaman --}}
    <h4 class="judul-section">7. Pinjaman</h4>
    @include('partials.buku-besar-table', ['data' => $pinjaman ?? null, 'label' => 'pinjaman'])

    {{-- 11. Darmawisata --}}
    <h4 class="judul-section">8. Darmawisata</h4>
    @include('partials.buku-besar-table', ['data' => $darmawisata ?? null, 'label' => 'darmawisata'])

    {{-- 12. Logam Mulia --}}
    <h4 class="judul-section">111. Logam Mulia</h4>
    @include('partials.buku-besar-table', ['data' => $logamMulia ?? null, 'label' => 'logam mulia'])

    {{-- 13. Piutang Usaha Niaga --}}
    <h4 class="judul-section">118. Piutang Usaha Niaga</h4>
    @include('partials.buku-besar-table', ['data' => $piutangUsahaNiaga ?? null, 'label' => 'piutang usaha niaga'])

    {{-- 14. Piutang Usaha Kredit Barang --}}
    <h4 class="judul-section"> 119. Piutang Usaha Kredit Barang</h4>
    @include('partials.buku-besar-table', ['data' => $piutangUsahaKreditBarang ?? null, 'label' => ' piutang usaha kredit barang'])

    {{-- 15. Piutang Usaha Simpan Pinjam --}}
    <h4 class="judul-section"> 120. Piutang Usaha Simpan Pinjam</h4>
    @include('partials.buku-besar-table', ['data' => $piutangUsahaSimpanPinjam ?? null, 'label' => ' piutang usaha simpan pinjam'])

    {{-- 16. Piutang Usaha Pembiayaan --}}
    <h4 class="judul-section"> 121. Piutang Usaha Pembiayaan</h4>
    @include('partials.buku-besar-table', ['data' => $piutangUsahaPembiayaan ?? null, 'label' => ' piutang usaha pembiayaan'])

    {{-- 17. Piutang Usaha Pengurusan Surat --}}
    <h4 class="judul-section"> 122. Piutang Usaha Pengurusan Surat</h4>
    @include('partials.buku-besar-table', ['data' => $piutangUsahaPengurusanSurat ?? null, 'label' => ' piutang usaha pengurusan surat'])

    {{-- 18. Persediaan Alat Tulis Kantor --}}
    <h4 class="judul-section"> 123. Persediaan Alat Tulis Kantor</h4>
    @include('partials.buku-besar-table', ['data' => $persediaanAlatTulisKantor ?? null, 'label' => ' persediaan alat tulis kantor'])

    {{-- 19. Persediaan Minuman --}}
    <h4 class="judul-section"> 124. Persediaan Minuman</h4>
    @include('partials.buku-besar-table', ['data' => $persedianminuman ?? null, 'label' => 'persediaan minuman'])

    {{-- 20. Persediaan Makanan--}}
    <h4 class="judul-section">125. Persediaan Makanan</h4>
    @include('partials.buku-besar-table', ['data' => $persediaanmakanan ?? null, 'label' => ' persediaan makanan'])

    {{-- 21. Persediaan Rokok--}}
    <h4 class="judul-section">116. Persediaan Rokok</h4>
    @include('partials.buku-besar-table', ['data' => $persediaanRokok ?? null, 'label' => ' persediaan makanan'])

    {{-- 22. Persediaan Konsinyasi / Barang titipan--}}
    <h4 class="judul-section">113. Persediaan Konsinyasi / Barang titipan</h4>
    @include('partials.buku-besar-table', ['data' => $persediaanKonsinyasi?? null, 'label' => 'persediaan konsinyasi / barang titipan'])

    {{-- 23. Persediaan Alat Olah Raga--}}
    <h4 class="judul-section">114. Persediaan Alat Olah Raga</h4>
    @include('partials.buku-besar-table', ['data' => $persediaanAlatOlahRaga ?? null, 'label' => ' persediaan alat olah raga'])

    {{-- 24. Persediaan Keb. Rumah Tangga--}}
    <h4 class="judul-section">117. Persediaan Keb. Rumah Tangga</h4>
    @include('partials.buku-besar-table', ['data' => $persediaanRumahTangga ?? null, 'label' => ' persediaan keb. rumah tangga'])

    {{-- 25. Persediaan Pulsa--}}
    <h4 class="judul-section">115. Persediaan Pulsa</h4>
    @include('partials.buku-besar-table', ['data' => $persediaanPulsa ?? null, 'label' => ' persediaan pulsa'])

    {{-- 26. BIAYA DIBAYAR DIMUKA--}}
    <h4 class="judul-section">126. BIAYA DIBAYAR DIMUKA</h4>
    @include('partials.buku-besar-table', ['data' => $biayaDiMuka ?? null, 'label' => 'biaya dibayar dimuka'])

    {{-- 27. BIAYA DIBAYAR DIMUKA TIKET & VOUCHER DARMAWISATA--}}
    <h4 class="judul-section">127. BIAYA DIBAYAR DIMUKA TIKET & VOUCHER DARMAWISATA</h4>
    @include('partials.buku-besar-table', ['data' => $biayaDiMukaTiketDarmawisata ?? null, 'label' => ' biaya dibayar dimuka tiket & voucher darmawisata'])

    {{-- 28. BIAYA DIBAYAR DIMUKA TIKET & VOUCHER--}}
    <h4 class="judul-section">128. BIAYA DIBAYAR DIMUKA TIKET & VOUCHER</h4>
    @include('partials.buku-besar-table', ['data' => $biayaDiMukaTiket ?? null, 'label' => ' biaya dibayar dimuka tiket & voucher' ])

    {{-- 29. Uang Muka Pajak PPh 21--}}
    <h4 class="judul-section">129. Uang Muka Pajak PPh 21</h4>
    @include('partials.buku-besar-table', ['data' => $uangMukaPajakSatu ?? null, 'label' => ' uang muka pajak PPh 21'])

    {{-- 30. Uang Muka Pajak PPh 25--}}
    <h4 class="judul-section">130. Uang Muka Pajak PPh 25</h4>
    @include('partials.buku-besar-table', ['data' => $uangMukaPajakLima ?? null, 'label' => ' uang muka pajak PPh 25 '])

    {{-- 31. Uang Muka Pajak PPn Masukan--}}
    <h4 class="judul-section">131. Uang Muka Pajak PPn Masukan</h4>
    @include('partials.buku-besar-table', ['data' => $uangMukaPajakMasukan ?? null, 'label' => ' uang muka pajak PPh masukan'])

    {{-- 32. Investasi jangka panjang--}}
    <h4 class="judul-section">182. Investasi Jangka Panjang</h4>
    @include('partials.buku-besar-table', ['data' => $investasiJangkaPanjang ?? null, 'label' => ' investasi jangka panjang '])

    {{-- 33. Aktiva Tetap Berwujud--}}
    <h4 class="judul-section">17. Aktiva Tetap Berwujud</h4>
    @include('partials.buku-besar-table', ['data' => $aktivTetapBerwujud ?? null, 'label' => ' aktiva tetap berwujud '])

    {{-- 34. Nilai Perolehan Aktiva Tetap (Kendaraan)--}}
    <h4 class="judul-section">20. Nilai Perolehan Aktiva Tetap (Kendaraan)</h4>
    @include('partials.buku-besar-table', ['data' => $nilaiPerolehanKendaraan ?? null, 'label' => ' Nilai Perolehan Aktiva Tetap (Kendaraan) '])

    {{-- 35. Nilai Perolehan Aktiva Tetap (Inventaris)--}}
    <h4 class="judul-section">132. Nilai Perolehan Aktiva Tetap (Inventaris)</h4>
    @include('partials.buku-besar-table', ['data' => $nilaiPerolehanInventaris  ?? null, 'label' => ' Nilai Perolehan Aktiva Tetap (Inventaris) '])

    {{-- 36. Nilai Perolehan Aktiva Tetap (Elektronik)--}}
    <h4 class="judul-section">133. Nilai Perolehan Aktiva Tetap (Elektronik)</h4>
    @include('partials.buku-besar-table', ['data' => $nilaiPerolehanElektronik  ?? null, 'label' => ' Nilai Perolehan Aktiva Tetap (Elektronik) '])

    {{-- 37. Akumulasi Penyusutan Aktiva Tetap (Kendaraan)--}}
    <h4 class="judul-section">134. Akumulasi Penyusutan Aktiva Tetap (Kendaraan)</h4>
    @include('partials.buku-besar-table', ['data' => $akumulasiPenyusutanKendaraan  ?? null, 'label' => ' Akumulasi Penyusutan Aktiva Tetap (Kendaraan) '])

    {{-- 38. Akumulasi Penyusutan Aktiva Tetap (Inventaris)--}}
    <h4 class="judul-section">135. Akumulasi Penyusutan Aktiva Tetap (Inventaris)</h4>
    @include('partials.buku-besar-table', ['data' => $akumulasiPenyusutanInventaris  ?? null, 'label' => ' Akumulasi Penyusutan Aktiva Tetap (Inventaris) '])

    {{-- 39. Akumulasi Penyusutan Aktiva Tetap (Elektronik)--}}
    <h4 class="judul-section">136. Akumulasi Penyusutan Aktiva Tetap (Elektronik)</h4>
    @include('partials.buku-besar-table', ['data' => $akumulasiPenyusutanElektronik  ?? null, 'label' => ' Akumulasi Penyusutan Aktiva Tetap (Elektronik) '])

    {{-- 40. 139. Nilai Perolehan Aktiva Tetap Tak Berwujud Software--}}
    <h4 class="judul-section">139. Nilai Perolehan Aktiva Tetap Tak Berwujud Software</h4>
    @include('partials.buku-besar-table', ['data' => $nilaiPerolehanTakBerwujudSoftware ?? null, 'label' => ' Nilai Perolehan Aktiva Tetap Tak Berwujud Software '])

    {{-- 41. Amortisasi Aktiva Tetap Tak Berwujud Amor Software--}}
    <h4 class="judul-section">140. Amortisasi Aktiva Tetap Tak Berwujud Amor Software</h4>
    @include('partials.buku-besar-table', ['data' => $amortisasiTakBerwujudAmorSoftware  ?? null, 'label' => ' Amortisasi Aktiva Tetap Tak Berwujud Amor Software '])

    {{-- 42. Hutang Usaha ATK--}}
    <h4 class="judul-section">141. Hutang Usaha ATK </h4>
    @include('partials.buku-besar-table', ['data' => $hutangUsahaAtk?? null, 'label' => ' hutang usaha ATK'])

    {{-- 43. Hutang Usaha Minuman--}}
    <h4 class="judul-section">142. Hutang Usaha Minuman </h4>
    @include('partials.buku-besar-table', ['data' => $hutangUsahaMinuman ?? null, 'label' => 'hutang usaha minuman'])

    {{-- 44. Hutang Usaha makanan--}}
    <h4 class="judul-section">143. Hutang Usaha makanan </h4>
    @include('partials.buku-besar-table', ['data' => $hutangUsahaMakanan ?? null, 'label' => ' hutang usaha makanan'])

    {{-- 45. Hutang Usaha Rokok--}}
    <h4 class="judul-section">144. Hutang Usaha Rokok </h4>
    @include('partials.buku-besar-table', ['data' => $hutangUsahaRokok ?? null, 'label' => 'hutang usaha rokok'])

    {{-- 46. Hutang Usaha Konsinyasi--}}
    <h4 class="judul-section">145. Hutang Usaha Konsinyasi </h4>
    @include('partials.buku-besar-table', ['data' => $hutangUsahaKonsinyasi ?? null, 'label' => ' hutang usaha konsinyasi'])

    {{-- 47. Hutang Usaha Keb. Rumah Tangga --}}
    <h4 class="judul-section">146. Hutang Usaha Keb. Rumah Tangga </h4>
    @include('partials.buku-besar-table', ['data' => $hutangUsahaRumahTangga ?? null, 'label' => ' hutang usaha keb. rumah tangga'])

    {{-- 48. Hutang Usaha Pulsa--}}
    <h4 class="judul-section">147. Hutang Usaha Pulsa </h4>
    @include('partials.buku-besar-table', ['data' => $hutangUsahaPulsa ?? null, 'label' => ' hutang usaha pulsa'])

    {{-- 49. Hutang Usaha Iklan--}}
    <h4 class="judul-section">149. Hutang Usaha Iklan </h4>
    @include('partials.buku-besar-table', ['data' => $hutangUsahaIklan ?? null, 'label' => 'hutang usaha iklan'])

    {{-- 50. Hutang Usaha Good Receive Not Invoice--}}
    <h4 class="judul-section">28. Utang </h4>
    @include('partials.buku-besar-table', ['data' => $hutangUsahaGoodReceive ?? null, 'label' => ' hutang usaha good receive ot invoice'])

    {{-- 51. Hutang Usaha Kredit Barang--}}
    <h4 class="judul-section">150. Hutang Usaha Kredit Barang </h4>
    @include('partials.buku-besar-table', ['data' => $hutangUsahaKreditBarang?? null, 'label' => ' hutang usaha kredit barang'])

    {{-- 52. Hutang Usaha Pengurusan Surat--}}
    <h4 class="judul-section">28. Utang </h4>
    @include('partials.buku-besar-table', ['data' => $hutangUsahaPengurusanSurat ?? null, 'label' => ' hutang usaha pengurusan surat'])

    {{-- 53. Hutang Usaha Pembiayaan--}}
    <h4 class="judul-section">152. Hutang Usaha Pembiayaan </h4>
    @include('partials.buku-besar-table', ['data' => $hutangUsahaPembiayaan?? null, 'label' => ' hutang usaha pembiayaan'])

    {{-- 54. Hutang Refund Tiket & Voucher--}}
    <h4 class="judul-section">167. Hutang Refund Tiket & Voucher</h4>
    @include('partials.buku-besar-table', ['data' => $hutangRefundTiket ?? null, 'label' => ' hutang refund tiket & voucher'])

    {{-- 55. Non Usaha Hutang Rekening Titipan--}}
    <h4 class="judul-section">137. Non Usaha Hutang Rekening Titipan </h4>
    @include('partials.buku-besar-table', ['data' => $nonUsahaHutangRekeningTitipan ?? null, 'label' => ' non usah hutang rekening titipan'])

    {{-- 56. Hutang Pajak Penghasilan PPh Final--}}
    <h4 class="judul-section">154. Hutang Pajak Penghasilan PPh Final </h4>
    @include('partials.buku-besar-table', ['data' => $hutangPajakPenghasilanFinal ?? null, 'label' => 'hutang pajak penghasilan pph final'])

    {{-- 57. Utang Usaha--}}
    <h4 class="judul-section">29. Utang Usaha </h4>
    @include('partials.buku-besar-table', ['data' => $utangUsaha ?? null, 'label' => ' utang usaha'])

    {{-- 58. Simpanan Sukarela--}}
    <h4 class="judul-section">32. Simpanan Sukarela* </h4>
    @include('partials.buku-besar-table', ['data' => $simpananSukarela ?? null, 'label' => ' simpanan sukarela'])

    {{-- 59. Utang Jangka Panjang--}}
    <h4 class="judul-section">36. Utang Jangka Panjang </h4>
    @include('partials.buku-besar-table', ['data' => $utangJangkaPanjang ?? null, 'label' => ' utang jangka panjang'])

    {{-- 60. Utang Bank--}}
    <h4 class="judul-section">37. Utang Bank</h4>
    @include('partials.buku-besar-table', ['data' => $utangBank ?? null, 'label' => ' utang bank'])

    {{-- 61. Hutang Modal Pinjaman--}}
    <h4 class="judul-section">174. Hutang Modal Pinjaman </h4>
    @include('partials.buku-besar-table', ['data' => $hutangModalPinjaman?? null, 'label' => ' hutang modal pinjaman'])

    {{-- 62. Modal--}}
    <h4 class="judul-section">39. Modal </h4>
    @include('partials.buku-besar-table', ['data' => $modal ?? null, 'label' => ' modal'])

    {{-- 63. Laba/Rugi Periode Berjalan--}}
    <h4 class="judul-section">157. Laba/Rugi Periode Berjalan </h4>
    @include('partials.buku-besar-table', ['data' => $labaRugiPeriodeBerjalan ?? null, 'label' => 'laba/rugi periode berjalan'])

    {{-- 64. Laba Ditahan (Defisit)--}}
    <h4 class="judul-section">158. Laba Ditahan (Defisit) </h4>
    @include('partials.buku-besar-table', ['data' => $labaDitahanDefisit ?? null, 'label' => 'laba ditahan (defisit)'])

    {{-- 65. Simpanan Pokok*--}}
    <h4 class="judul-section">40. Simpanan Pokok* </h4>
    @include('partials.buku-besar-table', ['data' => $simpananPokok ?? null, 'label' => ' simpanan pokok'])

    {{-- 66. Simpanan Wajib*--}}
    <h4 class="judul-section">41. Simpanan Wajib*</h4>
    @include('partials.buku-besar-table', ['data' => $simpananWajib ?? null, 'label' => ' simpanan wajib'])

    {{-- 67. Modal Awal--}}
    <h4 class="judul-section">42. Modal Awal </h4>
    @include('partials.buku-besar-table', ['data' => $modalAwal ?? null, 'label' => 'modal awal'])

    {{-- 68. Pendapatan*--}}
    <h4 class="judul-section">47. Pendapatan* </h4>
    @include('partials.buku-besar-table', ['data' => $pendapatan ?? null, 'label' => ' pendapatan'])

    {{-- 69. Pendapatan Usaha Niaga--}}
    <h4 class="judul-section">159. Pendapatan Usaha Niaga</h4>
    @include('partials.buku-besar-table', ['data' => $pendapatanUsahaNiaga ?? null, 'label' => 'pendapatan usaha niaga'])

    {{-- 70. Pendapatan Usaha Kredit Barang--}}
    <h4 class="judul-section">160. Pendapatan Usaha Kredit Barang </h4>
    @include('partials.buku-besar-table', ['data' => $pendapatanUsahaKreditBarang ?? null, 'label' => 'pendapatan usaha kredit barang'])

    {{-- 71. Pendapatan Usaha Iklan --}}
    <h4 class="judul-section">161. Pendapatan Usaha Iklan </h4>
    @include('partials.buku-besar-table', ['data' => $pendapatanUsahaIklan ?? null, 'label' => ' pendapatan usaha iklan'])

    {{-- 72. Pendapatan Usaha Foto Copy--}}
    <h4 class="judul-section">162. Pendapatan Usaha Foto Copy </h4>
    @include('partials.buku-besar-table', ['data' => $PendapatanUsahaFotoCopy ?? null, 'label' => ' pendapatan usaha foto copy'])

    {{-- 73. Pendapatan Usaha Tiket & Voucher --}}
    <h4 class="judul-section">163. Pendapatan Usaha Tiket & Voucher</h4>
    @include('partials.buku-besar-table', ['data' => $pendapatanUsahaTiketVoucher ?? null, 'label' => ' pendapatan usaha tiket & voucher'])

    {{-- 74. Pendapatan Usaha Pengurusan Surat--}}
    <h4 class="judul-section">164. Pendapatan Usaha Pengurusan Surat </h4>
    @include('partials.buku-besar-table', ['data' => $pendapatanUsahaPengurusanSurat ?? null, 'label' => 'pendapatan usaha pengurusan surat'])

    {{-- 75. Pendapatan Usaha Pembiayaan--}}
    <h4 class="judul-section">165. Pendapatan Usaha Pembiayaan</h4>
    @include('partials.buku-besar-table', ['data' => $pendapatanUsahaPembiayaan ?? null, 'label' => 'pendapatan usaha pembiayaan'])

    {{-- 76. Pendapatan Lain - Lain--}}
    <h4 class="judul-section">168. Pendapatan Lain - Lain</h4>
    @include('partials.buku-besar-table', ['data' => $pendapatanLain ?? null, 'label' => ' pendapatan lain - lain'])

    {{-- 78. PENDAPATAN JASA GIRO--}}
    <h4 class="judul-section">169. PENDAPATAN JASA GIRO</h4>
    @include('partials.buku-besar-table', ['data' => $pendapatanJasaGiro ?? null, 'label' => ' pendapatan jasa giro'])

    {{-- 79. Pendapatan sewa lahan koperasi--}}
    <h4 class="judul-section">184. Pendapatan sewa lahan koperasi</h4>
    @include('partials.buku-besar-table', ['data' => $pendapatanSewaLahanKoperasi ?? null, 'label' => ' pendapatan sewa lahan koperasi'])

    {{-- 80. Pendapatan dari Pinjaman*--}}
    <h4 class="judul-section">48. Pendapatan dari Pinjaman*</h4>
    @include('partials.buku-besar-table', ['data' => $pendapatandariPinjaman ?? null, 'label' => ' pendapatan dari pinjaman'])

    {{-- 81. Pendapatan Lainnya--}}
    <h4 class="judul-section">49. Pendapatan Lainnya</h4>
    @include('partials.buku-besar-table', ['data' => $pendapatanLainnya ?? null, 'label' => ' pendapatan lainnya'])

    {{-- 82.Beban--}}
    <h4 class="judul-section">50. Beban</h4>
    @include('partials.buku-besar-table', ['data' => $beban ?? null, 'label' => ' beban'])

    {{-- 83. Gaji Pegawai Tetap--}}
    <h4 class="judul-section">138. Gaji Pegawai Tetap</h4>
    @include('partials.buku-besar-table', ['data' => $gajiPegawaiTetap ?? null, 'label' => ' gaji pegawai tetap'])

    {{-- 84. Tunjangan Karyawan--}}
    <h4 class="judul-section">173. Tunjangan Karyawan</h4>
    @include('partials.buku-besar-table', ['data' => $tunjanganKaryawan ?? null, 'label' => ' tunjangan karyawan'])

    {{-- 85. Biaya Lainnya--}}
    <h4 class="judul-section">60. Biaya Lainnya</h4>
    @include('partials.buku-besar-table', ['data' => $biayaLainnya ?? null, 'label' => ' biaya lainnya'])

    {{-- 86. Biaya Penyusutan Aktiva Tetap (Inventaris)--}}
    <h4 class="judul-section">176. Biaya Penyusutan Aktiva Tetap (Inventaris)</h4>
    @include('partials.buku-besar-table', ['data' => $biayaPenyusutanInventaris ?? null, 'label' => ' biaya penyusutan aktiva tetap (inventaris)'])

    {{-- 87.Biaya Penyusutan Aktiva Tetap (Kendaraan) --}}
    <h4 class="judul-section">177. Biaya Penyusutan Aktiva Tetap (Kendaraan)</h4>
    @include('partials.buku-besar-table', ['data' => $biayaPenyusutanKendaraan ?? null, 'label' => ' biaya penyusutan aktiva tetap (kendaraan)'])

    {{-- 88. Biaya Penyusutan Aktiva Tetap (ELektronik) --}}
    <h4 class="judul-section">178. Biaya Penyusutan Aktiva Tetap (ELektronik)</h4>
    @include('partials.buku-besar-table', ['data' => $biayaPenyusutanElektronik ?? null, 'label' => ' biaya penyusutan aktiva tetap (elektronik)'])

    {{-- 89. HPP Usaha Niaga--}}
    <h4 class="judul-section">179. HPP Usaha Niaga</h4>
    @include('partials.buku-besar-table', ['data' => $hppUsahaNiaga ?? null, 'label' => ' hpp usaha niaga'])

    {{-- 90. PPH 29/Badan--}}
    <h4 class="judul-section">180. PPH 29/Badan</h4>
    @include('partials.buku-besar-table', ['data' => $pphBadan ?? null, 'label' => ' pph 29 / badan'])

    {{-- 91. HPP Usaha Tiket dan voucher--}}
    <h4 class="judul-section">181. HPP Usaha Tiket dan voucher</h4>
    @include('partials.buku-besar-table', ['data' => $hppUsahaTiketVvoucher ?? null, 'label' => ' hpp usaha tiket dan voucher'])

    {{-- 92. Biaya BPJS--}}
    <h4 class="judul-section">183. Biaya BPJS</h4>
    @include('partials.buku-besar-table', ['data' => $biayaBpjs ?? null, 'label' => ' biaya BPJS'])

    {{-- 93. Beban Telfon--}}
    <h4 class="judul-section">52. Beban Telfon</h4>
    @include('partials.buku-besar-table', ['data' => $bebanTelfon ?? null, 'label' => 'beban telfon'])

    {{-- 94. Biaya Listrik dan Air--}}
    <h4 class="judul-section">53. Biaya Listrik dan Air</h4>
    @include('partials.buku-besar-table', ['data' => $biayaListrikAir ?? null, 'label' => ' biaya listrik dan air'])

    {{-- 95. Biaya Transportasi--}}
    <h4 class="judul-section">54. Biaya Transportasi</h4>
    @include('partials.buku-besar-table', ['data' => $biayaTransportasi ?? null, 'label' => 'biaya transportasi'])

    {{-- 96. Pengeluaran Lainnya--}}
    <h4 class="judul-section">31. Pengeluaran Lainnya</h4>
    @include('partials.buku-besar-table', ['data' => $pengeluaranLainnya ?? null, 'label' => ' pengeluaran lainnya'])

    {{-- 97. BIAYA ADMINISTRASI BANK LAINNYA--}}
    <h4 class="judul-section">170. BIAYA ADMINISTRASI BANK LAINNYA</h4>
    @include('partials.buku-besar-table', ['data' => $biayaAdministrasiBank ?? null, 'label' => ' biaya administrasi bank lainnya'])

    {{-- 98. Pemeliharaan Bangunan--}}
    <h4 class="judul-section">172. Pemeliharaan Bangunan</h4>
    @include('partials.buku-besar-table', ['data' => $pemeliharaanBangunan ?? null, 'label' => ' pemeliharaan bangunan'])

    {{-- 99. Beban Persewaan Bangunan--}}
    <h4 class="judul-section">175. Beban Persewaan Bangunan</h4>
    @include('partials.buku-besar-table', ['data' => $bebanPersewaanBangunan ?? null, 'label' => 'beban persewaan bangunan'])

    {{-- 100. Transfer Antar Kas--}}
    <h4 class="judul-section">110. Transfer Antar Kas</h4>
    @include('partials.buku-besar-table', ['data' => $transferAntarKas ?? null, 'label' => ' transfer antar kas'])


  </div>
</div>

@endsection
