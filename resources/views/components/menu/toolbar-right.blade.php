<div class="toolbar">
  <div class="date-filter">
    <button id="tanggalButton" class="filter-button">
        <span class="df-ic" aria-hidden="true">
        <svg width="16" height="16" viewBox="0 0 24 24" fill="none">
          <rect x="3" y="4" width="18" height="17" rx="3" stroke="#0ea5e9" stroke-width="2"/>
          <path d="M8 2v4M16 2v4M3 10h18" stroke="#0ea5e9" stroke-width="2" stroke-linecap="round"/>
        </svg>
        </span>
        Tanggal
    </button>
    <div id="tanggalDropdown" class="dropdown-content">
      <div class="range">
        <label for="startDate">Tanggal Mulai:</label>
        <input type="date" id="startDate" name="startDate" class="input-date">
      </div>
      <div class="range">
        <label for="endDate">Tanggal Akhir:</label>
        <input type="date" id="endDate" name="endDate" class="input-date">
      </div>
      <div class="dropdown-buttons">
        <button class="btn save" onclick="saveDateRange()">Simpan</button>
        <button class="btn cancel" onclick="cancelDateRange()">Batal</button>
      </div>
    </div>
  </div>

  <div class="search-filter">
    Cari :
    <input type="text" id="transactionId" placeholder="Kode Transaksi" class="search-input">
    <button class="filter-button" onclick="searchTransaction()">
    <span class="df-ic" aria-hidden="true">
      <svg width="14" height="14" viewBox="0 0 24 24" fill="none">
      <path d="M21 21l-6-6m2.5-4.5A7.5 7.5 0 1 1 12 4.5a7.5 7.5 0 0 1 7.5 7.5z" stroke="#2563eb" stroke-width="2" stroke-linecap="round"/>
      </svg>
    </span>
    </button>
  </div>

    <button class="filter-button" onclick="clearFilter()">
        <span class="df-ic" aria-hidden="true">
        {{-- X (SVG) --}}
        <svg width="14" height="14" viewBox="0 0 24 24" fill="none">
          <path d="M6 6l12 12M18 6L6 18" stroke="#2563eb" stroke-width="2" stroke-linecap="round"/>
        </svg>
        </span>
        Hapus filter
    </button>

    <div class="download-wrap">
      <a href="# {{-- {{ $filePath }} --}}" download class="df-btn df-download">
      <span class="df-ic" aria-hidden="true">
      <svg width="14" height="14" viewBox="0 0 24 24" fill="none">
        <path d="M12 16v-4m0 0l-4 4m4-4l4 4" stroke="#0ea5e9" stroke-width="2" stroke-linecap="round"/>
        <path d="M4 4h16v12H4V4z" stroke="##0ea5e9" stroke-width="2" stroke-linecap="round"/>
      </svg>
      </span>
      Unduh{{-- {{ $buttonText }}- --}}
      </a>
    </div>

</div>

<style>
.toolbar {
  display: flex;
  justify-content: flex-end;
  align-items: center;
  gap: 4px;
  background-color: transparent;
  padding: 8px;
  border-radius: 5px;
  margin-top: -35px;
  margin-right: 55px;
}

.filter-button {
  appearance: none;
  border: 1px solid #d1d5db;        
  background: #ffffff;              
  color: #111827;                    
  padding: 4px 8px;                  
  border-radius: 8px;                
  cursor: pointer;                 
  font-size: 12px;                   
  display: inline-flex;              
  align-items: center;               
  gap: 6px;                         
  box-shadow: 0 2px 4px rgba(107, 105, 105, 0.647); 
  line-height: 1;    
  margin-left: 3px;   
  transition: background-color 0.3s, border-color 0.3s;
}

.filter-button:hover {
  background-color: #f8fafc;              
  border-color: #cbd5e1;                  
}

.filter-button i {
  font-size: 12px;
}

.date-filter {
  position: relative;
}

#tanggalDropdown {
  display: none;
  position: absolute;
  top: 35px;
  background-color: white;
  border: 1px solid #d1d5db;
  padding: 15px;
  box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
  border-radius: 8px;
  z-index: 100;
  width: 200px;
}

.range {
  margin-bottom: 10px;
}

.range label {
  font-size: 12px;
  color: #333;
}

.input-date {
  width: 100%;
  padding: 6px;
  font-size: 12px;
  border-radius: 8px;
  border: 1px solid #d1d5db;
}

.dropdown-buttons {
  display: flex;
  justify-content: space-between;
}

.btn {
  padding: 5px 10px;
  background-color: #28a745;
  color: white;
  border: none;
  border-radius: 8px;
  cursor: pointer;
}

.btn.save {
  appearance:none;border:1px solid #25E11B;background:#25E11B;color:#fff;
    padding:8px 12px;border-radius:8px;cursor:pointer;font-size:12px; box-shadow:0 2px 4px rgba(107, 105, 105, 0.647); min-width: 70px; max-height:28px;margin-top:10px
}
.btn.cancel {
  appearance:none;border:1px solid #EA2828;background:#EA2828;color:#fff;
    padding:6px 10px;border-radius:8px;cursor:pointer;font-size:12px;box-shadow:0 2px 4px rgba(107, 105, 105, 0.647); min-width: 70px; max-height:28px;margin-top:10px
}

.dropdown-buttons .btn:hover {
  background-color: #218838;
}

.dropdown-buttons .btn.cancel:hover {
  background-color: #c82333;
}

.search-filter input {
  padding: 5px 10px;
  font-size: 12px;
  border-radius: 8px;
  border: 1px solid #d1d5db;
  box-shadow: 0 2px 4px rgba(107, 105, 105, 0.647);
  width: 200px;
}

.search-filter button {
  padding: 5px 10px;
  background-color: #fff;
  border: none;
  border-radius: 8px;
  cursor: pointer;
}

.search-filter button:hover {
  background-color: #e7e7e7;
}

.filter-button, .search-filter button {
  font-size: 12px;
}

.search-filter {
  margin-left:5px;
  font-size:13px;
  font-weight:500;
  display: flex;
  align-items: center;
  gap: 10px;
}

.search-filter input {
  width: 110px;
  margin-right:-5px;
}

</style>


<script>
  document.getElementById('tanggalButton').addEventListener('click', function() {
    const dropdown = document.getElementById('tanggalDropdown');
    dropdown.style.display = (dropdown.style.display === 'block') ? 'none' : 'block';
  });

  function saveDateRange() {
    const startDate = document.getElementById('startDate').value;
    const endDate = document.getElementById('endDate').value;
    if (startDate && endDate) {
      alert('Tanggal dari ' + startDate + ' hingga ' + endDate + ' telah disimpan.');
      // Anda bisa menambahkan kode untuk mengirimkan rentang tanggal ke backend
    } else {
      alert('Silakan pilih tanggal yang valid.');
    }
    document.getElementById('tanggalDropdown').style.display = 'none';
  }

  function cancelDateRange() {
    document.getElementById('tanggalDropdown').style.display = 'none';
  }

  function searchTransaction() {
    const transactionId = document.getElementById('transactionId').value;
    if (transactionId) {
      alert('Mencari ID Transaksi: ' + transactionId);

    } else {
      alert('Silakan masukkan ID Transaksi.');
    }
  }


  function clearFilter() {
    document.getElementById('transactionId').value = '';
    alert('Filter dihapus.');
  }
</script>