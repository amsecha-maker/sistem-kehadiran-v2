<!doctype html>
<html lang="id" class="h-full">
 <head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Sistem Kehadiran Siswa SD - PRO</title>
  <script src="https://cdn.tailwindcss.com/3.4.17"></script>
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
  <script src="/_sdk/element_sdk.js"></script>
  <style>
    @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700&display=swap');
    
    * {
      font-family: 'Plus Jakarta Sans', sans-serif;
    }
    
    :root {
      --primary: #4F81BD;
      --secondary: #A9D18E;
      --accent: #FFD966;
      --bg-light: #F4F6F9;
      --bg-dark: #1a1a2e;
      --card-dark: #16213e;
      --text-dark: #e4e4e7;
    }
    
    .dark {
      --bg-light: #1a1a2e;
      --card-light: #16213e;
    }
    
    body {
      background-color: var(--bg-light);
      transition: background-color 0.3s ease;
    }
    
    .dark body {
      background-color: var(--bg-dark);
    }
    
    .sidebar {
      background: linear-gradient(180deg, #4F81BD 0%, #3a6a9e 100%);
    }
    
    .dark .sidebar {
      background: linear-gradient(180deg, #16213e 0%, #1a1a2e 100%);
    }
    
    .card {
      background: white;
      border-radius: 12px;
      box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
      transition: all 0.3s ease;
    }
    
    .dark .card {
      background: #16213e;
      color: #e4e4e7;
    }
    
    .btn-primary {
      background: linear-gradient(135deg, #4F81BD 0%, #3a6a9e 100%);
      color: white;
      border-radius: 8px;
      padding: 10px 20px;
      font-weight: 600;
      transition: all 0.3s ease;
    }
    
    .btn-primary:hover {
      transform: translateY(-2px);
      box-shadow: 0 4px 12px rgba(79, 129, 189, 0.4);
    }
    
    .btn-success {
      background: linear-gradient(135deg, #A9D18E 0%, #8bc34a 100%);
      color: white;
    }
    
    .btn-warning {
      background: linear-gradient(135deg, #FFD966 0%, #ffc107 100%);
      color: #333;
    }
    
    .btn-danger {
      background: linear-gradient(135deg, #ef5350 0%, #c62828 100%);
      color: white;
    }
    
    .toast {
      position: fixed;
      bottom: 20px;
      right: 20px;
      padding: 16px 24px;
      border-radius: 12px;
      color: white;
      font-weight: 500;
      z-index: 9999;
      animation: slideIn 0.3s ease, slideOut 0.3s ease 2.7s;
      box-shadow: 0 10px 30px rgba(0,0,0,0.2);
    }
    
    .toast-success { background: linear-gradient(135deg, #A9D18E 0%, #8bc34a 100%); }
    .toast-error { background: linear-gradient(135deg, #ef5350 0%, #c62828 100%); }
    .toast-info { background: linear-gradient(135deg, #4F81BD 0%, #3a6a9e 100%); }
    
    @keyframes slideIn {
      from { transform: translateX(100%); opacity: 0; }
      to { transform: translateX(0); opacity: 1; }
    }
    
    @keyframes slideOut {
      from { transform: translateX(0); opacity: 1; }
      to { transform: translateX(100%); opacity: 0; }
    }
    
    .weekend {
      background-color: #e5e7eb !important;
    }
    
    .dark .weekend {
      background-color: #374151 !important;
    }
    
    .badge-green { background: #A9D18E; color: #1a5f1a; }
    .badge-yellow { background: #FFD966; color: #7c5c00; }
    .badge-red { background: #ef5350; color: white; }
    
    .modal-overlay {
      position: fixed;
      inset: 0;
      background: rgba(0,0,0,0.5);
      backdrop-filter: blur(4px);
      display: flex;
      align-items: center;
      justify-content: center;
      z-index: 1000;
      opacity: 0;
      visibility: hidden;
      transition: all 0.3s ease;
    }
    
    .modal-overlay.active {
      opacity: 1;
      visibility: visible;
    }
    
    .modal-content {
      background: white;
      border-radius: 16px;
      padding: 24px;
      max-width: 500px;
      width: 90%;
      transform: scale(0.9);
      transition: transform 0.3s ease;
    }
    
    .dark .modal-content {
      background: #16213e;
      color: #e4e4e7;
    }
    
    .modal-overlay.active .modal-content {
      transform: scale(1);
    }
    
    .loading {
      display: inline-block;
      width: 20px;
      height: 20px;
      border: 2px solid #f3f3f3;
      border-top: 2px solid #4F81BD;
      border-radius: 50%;
      animation: spin 1s linear infinite;
    }
    
    @keyframes spin {
      0% { transform: rotate(0deg); }
      100% { transform: rotate(360deg); }
    }
    
    .nav-item {
      padding: 12px 20px;
      border-radius: 8px;
      color: rgba(255,255,255,0.8);
      cursor: pointer;
      transition: all 0.3s ease;
      display: flex;
      align-items: center;
      gap: 12px;
    }
    
    .nav-item:hover, .nav-item.active {
      background: rgba(255,255,255,0.2);
      color: white;
    }
    
    .stat-card {
      padding: 20px;
      border-radius: 12px;
      background: linear-gradient(135deg, var(--primary) 0%, #3a6a9e 100%);
      color: white;
    }
    
    .stat-card.green { background: linear-gradient(135deg, #A9D18E 0%, #8bc34a 100%); }
    .stat-card.yellow { background: linear-gradient(135deg, #FFD966 0%, #ffc107 100%); color: #333; }
    .stat-card.red { background: linear-gradient(135deg, #ef5350 0%, #c62828 100%); }
    
    select, input {
      border: 2px solid #e5e7eb;
      border-radius: 8px;
      padding: 8px 12px;
      transition: all 0.3s ease;
    }
    
    .dark select, .dark input {
      background: #1a1a2e;
      border-color: #374151;
      color: #e4e4e7;
    }
    
    select:focus, input:focus {
      border-color: #4F81BD;
      outline: none;
      box-shadow: 0 0 0 3px rgba(79, 129, 189, 0.2);
    }
    
    table {
      width: 100%;
      border-collapse: collapse;
    }
    
    th, td {
      padding: 12px;
      text-align: left;
      border-bottom: 1px solid #e5e7eb;
    }
    
    .dark th, .dark td {
      border-color: #374151;
    }
    
    th {
      background: #f8fafc;
      font-weight: 600;
      color: #4F81BD;
    }
    
    .dark th {
      background: #1a1a2e;
      color: #A9D18E;
    }
    
    @media print {
      .sidebar, .no-print, .btn-primary, .btn-success, .btn-warning, .btn-danger {
        display: none !important;
      }
      
      .main-content {
        margin-left: 0 !important;
        padding: 0 !important;
      }
      
      .card {
        box-shadow: none !important;
        border: 1px solid #ddd !important;
      }
      
      body {
        background: white !important;
      }
      
      .print-header {
        display: block !important;
        text-align: center;
        margin-bottom: 30px;
      }
    }
    
    .print-header {
      display: none;
    }
    
    @media (max-width: 768px) {
      .sidebar {
        position: fixed;
        left: -280px;
        z-index: 100;
        height: 100%;
      }
      
      .sidebar.open {
        left: 0;
      }
      
      .main-content {
        margin-left: 0 !important;
      }
    }
  </style>
  <style>body { box-sizing: border-box; }</style>
  <script src="/_sdk/data_sdk.js" type="text/javascript"></script>
 </head>
 <body class="h-full overflow-auto">
  <div id="app" class="flex h-full"><!-- Sidebar -->
   <aside class="sidebar w-64 min-h-full p-6 flex flex-col fixed left-0 top-0 bottom-0 z-50" id="sidebar">
    <div class="mb-8">
     <h1 class="text-white text-xl font-bold" id="appTitle">Sistem Kehadiran SD</h1>
     <p class="text-white/60 text-sm" id="schoolName">PRO Edition</p>
    </div>
    <nav class="flex-1 space-y-2">
     <div class="nav-item active" data-page="dashboard" onclick="showPage('dashboard')">
      <svg class="w-5 h-5" fill="none" stroke="currentColor" viewbox="0 0 24 24">
       <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"></path>
      </svg> Dashboard
     </div>
     <div class="nav-item" data-page="siswa" onclick="showPage('siswa')">
      <svg class="w-5 h-5" fill="none" stroke="currentColor" viewbox="0 0 24 24">
       <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z"></path>
      </svg> Data Siswa
     </div>
     <div class="nav-item" data-page="absensi" onclick="showPage('absensi')">
      <svg class="w-5 h-5" fill="none" stroke="currentColor" viewbox="0 0 24 24">
       <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"></path>
      </svg> Input Absensi
     </div>
     <div class="nav-item" data-page="rekap" onclick="showPage('rekap')">
      <svg class="w-5 h-5" fill="none" stroke="currentColor" viewbox="0 0 24 24">
       <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
      </svg> Rekap Bulanan
     </div>
    </nav>
    <div class="mt-auto space-y-2"><button onclick="toggleDarkMode()" class="nav-item w-full no-print">
      <svg class="w-5 h-5" fill="none" stroke="currentColor" viewbox="0 0 24 24">
       <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z"></path>
      </svg> Mode Gelap </button>
    </div>
   </aside><!-- Mobile Menu Button --> <button onclick="toggleSidebar()" class="fixed top-4 left-4 z-50 p-2 bg-white dark:bg-gray-800 rounded-lg shadow-lg md:hidden no-print">
    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewbox="0 0 24 24">
     <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
    </svg></button> <!-- Main Content -->
   <main class="main-content flex-1 ml-64 p-6 overflow-auto"><!-- Print Header -->
    <div class="print-header">
     <h1 class="text-2xl font-bold text-gray-800">SISTEM KEHADIRAN SISWA SD</h1>
     <p class="text-lg text-gray-600" id="printSubtitle">Rekap Kehadiran</p>
     <hr class="my-4 border-2 border-gray-800">
    </div><!-- Dashboard Page -->
    <section id="page-dashboard" class="page">
     <div class="flex justify-between items-center mb-6 flex-wrap gap-4">
      <h2 class="text-2xl font-bold text-gray-800 dark:text-white">Dashboard</h2>
      <div class="flex gap-2 flex-wrap no-print"><button onclick="showImportModal()" class="btn-primary text-sm">📥 Import Data</button> <button onclick="exportBackup()" class="btn-success text-sm">📤 Export Backup</button> <button onclick="showResetModal()" class="btn-danger text-sm">🗑️ Reset Data</button>
      </div>
     </div><!-- Stats Cards -->
     <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
      <div class="stat-card">
       <p class="text-white/80 text-sm">Total Siswa</p>
       <p class="text-3xl font-bold" id="totalSiswa">0</p>
      </div>
      <div class="stat-card green">
       <p class="text-white/80 text-sm">Hadir Hari Ini</p>
       <p class="text-3xl font-bold" id="hadirHariIni">0</p>
      </div>
      <div class="stat-card yellow">
       <p class="text-sm">Rata-rata Kehadiran</p>
       <p class="text-3xl font-bold" id="rataKehadiran">0%</p>
      </div>
      <div class="stat-card red">
       <p class="text-white/80 text-sm">Alpha Bulan Ini</p>
       <p class="text-3xl font-bold" id="alphaTotal">0</p>
      </div>
     </div><!-- Chart -->
     <div class="card p-6 mb-6">
      <h3 class="text-lg font-semibold mb-4 dark:text-white">Statistik Kehadiran Bulan Ini</h3>
      <canvas id="attendanceChart" height="100"></canvas>
     </div><!-- Quick Actions -->
     <div class="card p-6">
      <h3 class="text-lg font-semibold mb-4 dark:text-white">Aksi Cepat</h3>
      <div class="grid grid-cols-2 md:grid-cols-4 gap-4"><button onclick="showPage('absensi')" class="btn-primary">📝 Input Absensi</button> <button onclick="showPage('siswa')" class="btn-success">👨‍🎓 Kelola Siswa</button> <button onclick="showPage('rekap')" class="btn-warning">📊 Lihat Rekap</button> <button onclick="exportCSV()" class="btn-primary">📄 Export CSV</button>
      </div>
     </div>
    </section><!-- Siswa Page -->
    <section id="page-siswa" class="page hidden">
     <div class="flex justify-between items-center mb-6 flex-wrap gap-4">
      <h2 class="text-2xl font-bold text-gray-800 dark:text-white">Data Siswa</h2><button onclick="showSiswaModal()" class="btn-primary no-print">+ Tambah Siswa</button>
     </div><!-- Search -->
     <div class="card p-4 mb-6 no-print"><input type="text" id="searchSiswa" placeholder="🔍 Cari nama atau NISN..." class="w-full" oninput="filterSiswa()">
     </div><!-- Siswa Table -->
     <div class="card overflow-x-auto">
      <table>
       <thead>
        <tr>
         <th>No</th>
         <th>Nama</th>
         <th>NISN</th>
         <th>Nama Ortu</th>
         <th>No WhatsApp</th>
         <th class="no-print">Aksi</th>
        </tr>
       </thead>
       <tbody id="siswaTableBody"></tbody>
      </table>
     </div>
    </section><!-- Absensi Page -->
    <section id="page-absensi" class="page hidden">
     <div class="flex justify-between items-center mb-6 flex-wrap gap-4">
      <h2 class="text-2xl font-bold text-gray-800 dark:text-white">Input Absensi</h2>
      <div class="flex gap-2 no-print"><select id="bulanSelect" onchange="updateAbsensi()" class="px-4 py-2"> <option value="0">Januari</option> <option value="1">Februari</option> <option value="2">Maret</option> <option value="3">April</option> <option value="4">Mei</option> <option value="5">Juni</option> <option value="6">Juli</option> <option value="7">Agustus</option> <option value="8">September</option> <option value="9">Oktober</option> <option value="10">November</option> <option value="11">Desember</option> </select> <select id="tahunSelect" onchange="updateAbsensi()" class="px-4 py-2"> <option value="2024">2024</option> <option value="2025">2025</option> <option value="2026">2026</option> </select>
      </div>
     </div><!-- Absensi Table -->
     <div class="card overflow-x-auto">
      <table id="absensiTable">
       <thead id="absensiTableHead"></thead>
       <tbody id="absensiTableBody"></tbody>
      </table>
     </div>
    </section><!-- Rekap Page -->
    <section id="page-rekap" class="page hidden">
     <div class="flex justify-between items-center mb-6 flex-wrap gap-4">
      <h2 class="text-2xl font-bold text-gray-800 dark:text-white">Rekap Bulanan</h2>
      <div class="flex gap-2 flex-wrap no-print"><button onclick="exportCSV()" class="btn-success">📄 Export CSV</button> <button onclick="printRekap()" class="btn-primary">🖨️ Cetak Rekap</button>
      </div>
     </div><!-- Rekap Table -->
     <div class="card overflow-x-auto" id="rekapContainer">
      <table>
       <thead>
        <tr>
         <th>No</th>
         <th>Nama</th>
         <th>NISN</th>
         <th>Hadir</th>
         <th>Sakit</th>
         <th>Izin</th>
         <th>Alpha</th>
         <th>Persentase</th>
         <th class="no-print">Aksi</th>
        </tr>
       </thead>
       <tbody id="rekapTableBody"></tbody>
      </table>
      <div class="p-4 text-sm text-gray-500 dark:text-gray-400">
       <p id="printDate"></p>
      </div>
     </div>
    </section>
   </main>
  </div><!-- Modals --> <!-- Siswa Modal -->
  <div id="siswaModal" class="modal-overlay">
   <div class="modal-content">
    <h3 class="text-xl font-bold mb-4 dark:text-white" id="siswaModalTitle">Tambah Siswa</h3>
    <form id="siswaForm" onsubmit="saveSiswa(event)"><input type="hidden" id="siswaId">
     <div class="space-y-4">
      <div><label class="block text-sm font-medium mb-1 dark:text-gray-300">Nama Lengkap</label> <input type="text" id="namaSiswa" required class="w-full" placeholder="Masukkan nama siswa">
      </div>
      <div><label class="block text-sm font-medium mb-1 dark:text-gray-300">NISN</label> <input type="text" id="nisnSiswa" required class="w-full" placeholder="Masukkan NISN">
      </div>
      <div><label class="block text-sm font-medium mb-1 dark:text-gray-300">Nama Orang Tua</label> <input type="text" id="namaOrtu" required class="w-full" placeholder="Masukkan nama orang tua">
      </div>
      <div><label class="block text-sm font-medium mb-1 dark:text-gray-300">No WhatsApp</label> <input type="text" id="noWa" required class="w-full" placeholder="08xxxxxxxxxx">
      </div>
     </div>
     <div class="flex gap-2 mt-6"><button type="submit" class="btn-primary flex-1">Simpan</button> <button type="button" onclick="closeSiswaModal()" class="btn-danger flex-1">Batal</button>
     </div>
    </form>
   </div>
  </div><!-- Reset Modal -->
  <div id="resetModal" class="modal-overlay">
   <div class="modal-content text-center">
    <div class="text-6xl mb-4">
     ⚠️
    </div>
    <h3 class="text-xl font-bold mb-2 dark:text-white">Reset Semua Data?</h3>
    <p class="text-gray-600 dark:text-gray-400 mb-6">Semua data siswa dan absensi akan dihapus permanen. Tindakan ini tidak dapat dibatalkan!</p>
    <div class="flex gap-2"><button onclick="confirmReset()" class="btn-danger flex-1">Ya, Reset</button> <button onclick="closeResetModal()" class="btn-primary flex-1">Batal</button>
    </div>
   </div>
  </div><!-- Import Modal -->
  <div id="importModal" class="modal-overlay">
   <div class="modal-content">
    <h3 class="text-xl font-bold mb-4 dark:text-white">Import Data</h3>
    <div class="border-2 border-dashed border-gray-300 dark:border-gray-600 rounded-lg p-8 text-center"><input type="file" id="importFile" accept=".json" class="hidden" onchange="handleImport(event)">
     <div class="text-4xl mb-2">
      📁
     </div>
     <p class="text-gray-600 dark:text-gray-400 mb-4">Pilih file backup (.json)</p><button onclick="document.getElementById('importFile').click()" class="btn-primary">Pilih File</button>
    </div><button onclick="closeImportModal()" class="btn-danger w-full mt-4">Batal</button>
   </div>
  </div><!-- Delete Confirm Modal -->
  <div id="deleteModal" class="modal-overlay">
   <div class="modal-content text-center">
    <div class="text-6xl mb-4">
     🗑️
    </div>
    <h3 class="text-xl font-bold mb-2 dark:text-white">Hapus Siswa?</h3>
    <p class="text-gray-600 dark:text-gray-400 mb-6" id="deleteMessage">Data siswa akan dihapus permanen.</p>
    <div class="flex gap-2"><button onclick="confirmDelete()" class="btn-danger flex-1">Ya, Hapus</button> <button onclick="closeDeleteModal()" class="btn-primary flex-1">Batal</button>
    </div>
   </div>
  </div>
  <script>
    // ==================== STORAGE MODULE ====================
    const StorageKeys = {
      SISWA: 'siswaData',
      ABSENSI: 'absensiData',
      SETTINGS: 'settingsBulanTahun'
    };
    
    function initStorage() {
      if (!getFromStorage(StorageKeys.SISWA)) {
        saveToStorage(StorageKeys.SISWA, []);
      }
      if (!getFromStorage(StorageKeys.ABSENSI)) {
        saveToStorage(StorageKeys.ABSENSI, {});
      }
      if (!getFromStorage(StorageKeys.SETTINGS)) {
        const now = new Date();
        saveToStorage(StorageKeys.SETTINGS, {
          bulan: now.getMonth(),
          tahun: now.getFullYear()
        });
      }
    }
    
    function saveToStorage(key, data) {
      try {
        localStorage.setItem(key, JSON.stringify(data));
        return true;
      } catch (e) {
        console.error('Storage save error:', e);
        return false;
      }
    }
    
    function getFromStorage(key) {
      try {
        const data = localStorage.getItem(key);
        return data ? JSON.parse(data) : null;
      } catch (e) {
        console.error('Storage read error:', e);
        return null;
      }
    }
    
    function clearAllData() {
      localStorage.removeItem(StorageKeys.SISWA);
      localStorage.removeItem(StorageKeys.ABSENSI);
      localStorage.removeItem(StorageKeys.SETTINGS);
      initStorage();
    }
    
    // ==================== DATA MODULE ====================
    let siswaData = [];
    let absensiData = {};
    let settings = {};
    let deleteTargetId = null;
    let attendanceChart = null;
    
    function loadData() {
      siswaData = getFromStorage(StorageKeys.SISWA) || [];
      absensiData = getFromStorage(StorageKeys.ABSENSI) || {};
      settings = getFromStorage(StorageKeys.SETTINGS) || { bulan: new Date().getMonth(), tahun: new Date().getFullYear() };
    }
    
    // ==================== UI MODULE ====================
    function showToast(message, type = 'info') {
      const existingToast = document.querySelector('.toast');
      if (existingToast) existingToast.remove();
      
      const toast = document.createElement('div');
      toast.className = `toast toast-${type}`;
      toast.textContent = message;
      document.body.appendChild(toast);
      
      setTimeout(() => toast.remove(), 3000);
    }
    
    function showPage(pageName) {
      document.querySelectorAll('.page').forEach(p => p.classList.add('hidden'));
      document.getElementById(`page-${pageName}`).classList.remove('hidden');
      document.querySelectorAll('.nav-item').forEach(n => n.classList.remove('active'));
      document.querySelector(`[data-page="${pageName}"]`)?.classList.add('active');
      
      if (pageName === 'dashboard') updateDashboard();
      if (pageName === 'siswa') renderSiswaTable();
      if (pageName === 'absensi') updateAbsensi();
      if (pageName === 'rekap') renderRekap();
      
      // Close sidebar on mobile
      document.getElementById('sidebar').classList.remove('open');
    }
    
    function toggleSidebar() {
      document.getElementById('sidebar').classList.toggle('open');
    }
    
    function toggleDarkMode() {
      document.documentElement.classList.toggle('dark');
      showToast('Mode tampilan diubah', 'info');
    }
    
    // ==================== DASHBOARD MODULE ====================
    function updateDashboard() {
      document.getElementById('totalSiswa').textContent = siswaData.length;
      
      const today = new Date();
      const todayKey = `${today.getFullYear()}-${today.getMonth()}-${today.getDate()}`;
      let hadirHariIni = 0;
      let alphaTotal = 0;
      let totalHadir = 0;
      let totalHariEfektif = 0;
      
      const bulan = settings.bulan;
      const tahun = settings.tahun;
      const daysInMonth = new Date(tahun, bulan + 1, 0).getDate();
      
      siswaData.forEach(siswa => {
        // Count today's attendance
        const absensi = absensiData[siswa.id];
        if (absensi && absensi[todayKey] === 'H') hadirHariIni++;
        
        // Count monthly stats
        for (let d = 1; d <= daysInMonth; d++) {
          const date = new Date(tahun, bulan, d);
          const day = date.getDay();
          if (day !== 0 && day !== 6) {
            totalHariEfektif++;
            const key = `${tahun}-${bulan}-${d}`;
            if (absensi) {
              if (absensi[key] === 'H') totalHadir++;
              if (absensi[key] === 'A') alphaTotal++;
            }
          }
        }
      });
      
      document.getElementById('hadirHariIni').textContent = hadirHariIni;
      document.getElementById('alphaTotal').textContent = alphaTotal;
      
      const perSiswaHariEfektif = totalHariEfektif / (siswaData.length || 1);
      const rataKehadiran = perSiswaHariEfektif > 0 ? ((totalHadir / (siswaData.length || 1)) / perSiswaHariEfektif * 100).toFixed(1) : 0;
      document.getElementById('rataKehadiran').textContent = rataKehadiran + '%';
      
      updateChart();
    }
    
    function updateChart() {
      const ctx = document.getElementById('attendanceChart').getContext('2d');
      
      let hadir = 0, sakit = 0, izin = 0, alpha = 0;
      const bulan = settings.bulan;
      const tahun = settings.tahun;
      const daysInMonth = new Date(tahun, bulan + 1, 0).getDate();
      
      siswaData.forEach(siswa => {
        const absensi = absensiData[siswa.id] || {};
        for (let d = 1; d <= daysInMonth; d++) {
          const date = new Date(tahun, bulan, d);
          const day = date.getDay();
          if (day !== 0 && day !== 6) {
            const key = `${tahun}-${bulan}-${d}`;
            const status = absensi[key];
            if (status === 'H') hadir++;
            else if (status === 'S') sakit++;
            else if (status === 'I') izin++;
            else if (status === 'A') alpha++;
          }
        }
      });
      
      if (attendanceChart) attendanceChart.destroy();
      
      attendanceChart = new Chart(ctx, {
        type: 'doughnut',
        data: {
          labels: ['Hadir', 'Sakit', 'Izin', 'Alpha'],
          datasets: [{
            data: [hadir, sakit, izin, alpha],
            backgroundColor: ['#A9D18E', '#FFD966', '#4F81BD', '#ef5350'],
            borderWidth: 0
          }]
        },
        options: {
          responsive: true,
          plugins: {
            legend: {
              position: 'bottom'
            }
          }
        }
      });
    }
    
    // ==================== SISWA MODULE ====================
    function renderSiswaTable() {
      const tbody = document.getElementById('siswaTableBody');
      const searchTerm = document.getElementById('searchSiswa')?.value?.toLowerCase() || '';
      
      const filtered = siswaData.filter(s => 
        s.nama.toLowerCase().includes(searchTerm) || 
        s.nisn.toLowerCase().includes(searchTerm)
      );
      
      tbody.innerHTML = filtered.map((siswa, idx) => `
        <tr>
          <td>${idx + 1}</td>
          <td class="font-medium">${siswa.nama}</td>
          <td>${siswa.nisn}</td>
          <td>${siswa.namaOrtu}</td>
          <td>${siswa.noWa}</td>
          <td class="no-print">
            <div class="flex gap-2">
              <button onclick="editSiswa('${siswa.id}')" class="text-blue-500 hover:text-blue-700">✏️</button>
              <button onclick="showDeleteModal('${siswa.id}')" class="text-red-500 hover:text-red-700">🗑️</button>
            </div>
          </td>
        </tr>
      `).join('');
    }
    
    function filterSiswa() {
      renderSiswaTable();
    }
    
    function showSiswaModal(siswa = null) {
      document.getElementById('siswaModalTitle').textContent = siswa ? 'Edit Siswa' : 'Tambah Siswa';
      document.getElementById('siswaId').value = siswa?.id || '';
      document.getElementById('namaSiswa').value = siswa?.nama || '';
      document.getElementById('nisnSiswa').value = siswa?.nisn || '';
      document.getElementById('namaOrtu').value = siswa?.namaOrtu || '';
      document.getElementById('noWa').value = siswa?.noWa || '';
      document.getElementById('siswaModal').classList.add('active');
    }
    
    function closeSiswaModal() {
      document.getElementById('siswaModal').classList.remove('active');
      document.getElementById('siswaForm').reset();
    }
    
    function formatWhatsApp(number) {
      let cleaned = number.replace(/\D/g, '');
      if (cleaned.startsWith('0')) {
        cleaned = '62' + cleaned.substring(1);
      } else if (!cleaned.startsWith('62')) {
        cleaned = '62' + cleaned;
      }
      return cleaned;
    }
    
    function saveSiswa(event) {
      event.preventDefault();
      
      const id = document.getElementById('siswaId').value || 'siswa_' + Date.now();
      const siswa = {
        id,
        nama: document.getElementById('namaSiswa').value.trim(),
        nisn: document.getElementById('nisnSiswa').value.trim(),
        namaOrtu: document.getElementById('namaOrtu').value.trim(),
        noWa: formatWhatsApp(document.getElementById('noWa').value)
      };
      
      const existingIdx = siswaData.findIndex(s => s.id === id);
      if (existingIdx >= 0) {
        siswaData[existingIdx] = siswa;
        showToast('Data siswa berhasil diperbarui', 'success');
      } else {
        siswaData.push(siswa);
        showToast('Siswa berhasil ditambahkan', 'success');
      }
      
      saveToStorage(StorageKeys.SISWA, siswaData);
      closeSiswaModal();
      renderSiswaTable();
      updateDashboard();
    }
    
    function editSiswa(id) {
      const siswa = siswaData.find(s => s.id === id);
      if (siswa) showSiswaModal(siswa);
    }
    
    function showDeleteModal(id) {
      const siswa = siswaData.find(s => s.id === id);
      deleteTargetId = id;
      document.getElementById('deleteMessage').textContent = `Data "${siswa?.nama}" akan dihapus permanen.`;
      document.getElementById('deleteModal').classList.add('active');
    }
    
    function closeDeleteModal() {
      document.getElementById('deleteModal').classList.remove('active');
      deleteTargetId = null;
    }
    
    function confirmDelete() {
      if (deleteTargetId) {
        siswaData = siswaData.filter(s => s.id !== deleteTargetId);
        delete absensiData[deleteTargetId];
        saveToStorage(StorageKeys.SISWA, siswaData);
        saveToStorage(StorageKeys.ABSENSI, absensiData);
        showToast('Siswa berhasil dihapus', 'success');
        renderSiswaTable();
        updateDashboard();
      }
      closeDeleteModal();
    }
    
    // ==================== ABSENSI MODULE ====================
    function updateAbsensi() {
      settings.bulan = parseInt(document.getElementById('bulanSelect').value);
      settings.tahun = parseInt(document.getElementById('tahunSelect').value);
      saveToStorage(StorageKeys.SETTINGS, settings);
      renderAbsensiTable();
    }
    
    function renderAbsensiTable() {
      const thead = document.getElementById('absensiTableHead');
      const tbody = document.getElementById('absensiTableBody');
      const bulan = settings.bulan;
      const tahun = settings.tahun;
      const daysInMonth = new Date(tahun, bulan + 1, 0).getDate();
      
      // Build header
      let headerHTML = '<tr><th class="sticky left-0 bg-gray-100 dark:bg-gray-800 z-10">Nama</th>';
      for (let d = 1; d <= daysInMonth; d++) {
        const date = new Date(tahun, bulan, d);
        const day = date.getDay();
        const isWeekend = day === 0 || day === 6;
        const dayNames = ['Min', 'Sen', 'Sel', 'Rab', 'Kam', 'Jum', 'Sab'];
        headerHTML += `<th class="${isWeekend ? 'weekend' : ''} text-center text-xs">${d}<br><span class="text-gray-400">${dayNames[day]}</span></th>`;
      }
      headerHTML += '</tr>';
      thead.innerHTML = headerHTML;
      
      // Build body
      tbody.innerHTML = siswaData.map(siswa => {
        const absensi = absensiData[siswa.id] || {};
        let rowHTML = `<tr><td class="sticky left-0 bg-white dark:bg-gray-800 z-10 font-medium whitespace-nowrap">${siswa.nama}</td>`;
        
        for (let d = 1; d <= daysInMonth; d++) {
          const date = new Date(tahun, bulan, d);
          const day = date.getDay();
          const isWeekend = day === 0 || day === 6;
          const key = `${tahun}-${bulan}-${d}`;
          const value = absensi[key] || '';
          
          if (isWeekend) {
            rowHTML += `<td class="weekend text-center">-</td>`;
          } else {
            rowHTML += `<td class="p-1">
              <select 
                onchange="setAbsensi('${siswa.id}', '${key}', this.value)" 
                class="w-12 text-xs p-1 rounded ${getStatusColor(value)}"
              >
                <option value="">-</option>
                <option value="H" ${value === 'H' ? 'selected' : ''}>H</option>
                <option value="S" ${value === 'S' ? 'selected' : ''}>S</option>
                <option value="I" ${value === 'I' ? 'selected' : ''}>I</option>
                <option value="A" ${value === 'A' ? 'selected' : ''}>A</option>
              </select>
            </td>`;
          }
        }
        
        return rowHTML + '</tr>';
      }).join('');
    }
    
    function getStatusColor(status) {
      switch(status) {
        case 'H': return 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200';
        case 'S': return 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-200';
        case 'I': return 'bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200';
        case 'A': return 'bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200';
        default: return '';
      }
    }
    
    function setAbsensi(siswaId, dateKey, value) {
      if (!absensiData[siswaId]) absensiData[siswaId] = {};
      
      if (value) {
        absensiData[siswaId][dateKey] = value;
      } else {
        delete absensiData[siswaId][dateKey];
      }
      
      saveToStorage(StorageKeys.ABSENSI, absensiData);
      showToast('Absensi tersimpan', 'success');
    }
    
    // ==================== REKAP MODULE ====================
    function renderRekap() {
      const tbody = document.getElementById('rekapTableBody');
      const bulan = settings.bulan;
      const tahun = settings.tahun;
      const daysInMonth = new Date(tahun, bulan + 1, 0).getDate();
      
      // Calculate effective days
      let totalHariEfektif = 0;
      for (let d = 1; d <= daysInMonth; d++) {
        const date = new Date(tahun, bulan, d);
        const day = date.getDay();
        if (day !== 0 && day !== 6) totalHariEfektif++;
      }
      
      const bulanNames = ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];
      document.getElementById('printSubtitle').textContent = `Rekap Bulan ${bulanNames[bulan]} ${tahun}`;
      document.getElementById('printDate').textContent = `Dicetak pada: ${new Date().toLocaleDateString('id-ID', { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' })}`;
      
      tbody.innerHTML = siswaData.map((siswa, idx) => {
        const absensi = absensiData[siswa.id] || {};
        let hadir = 0, sakit = 0, izin = 0, alpha = 0;
        
        for (let d = 1; d <= daysInMonth; d++) {
          const date = new Date(tahun, bulan, d);
          const day = date.getDay();
          if (day !== 0 && day !== 6) {
            const key = `${tahun}-${bulan}-${d}`;
            const status = absensi[key];
            if (status === 'H') hadir++;
            else if (status === 'S') sakit++;
            else if (status === 'I') izin++;
            else if (status === 'A') alpha++;
          }
        }
        
        const persentase = totalHariEfektif > 0 ? ((hadir / totalHariEfektif) * 100).toFixed(1) : 0;
        const badgeClass = persentase >= 90 ? 'badge-green' : persentase >= 75 ? 'badge-yellow' : 'badge-red';
        
        return `
          <tr>
            <td>${idx + 1}</td>
            <td class="font-medium">${siswa.nama}</td>
            <td>${siswa.nisn}</td>
            <td class="text-center font-semibold text-green-600">${hadir}</td>
            <td class="text-center font-semibold text-yellow-600">${sakit}</td>
            <td class="text-center font-semibold text-blue-600">${izin}</td>
            <td class="text-center font-semibold text-red-600">${alpha}</td>
            <td class="text-center"><span class="px-3 py-1 rounded-full text-sm font-semibold ${badgeClass}">${persentase}%</span></td>
            <td class="no-print">
              <button onclick="sendWhatsApp('${siswa.id}')" class="text-green-500 hover:text-green-700 text-xl" title="Kirim Rekap WA">📱</button>
            </td>
          </tr>
        `;
      }).join('');
    }
    
    function sendWhatsApp(siswaId) {
      const siswa = siswaData.find(s => s.id === siswaId);
      if (!siswa) return;
      
      const bulan = settings.bulan;
      const tahun = settings.tahun;
      const daysInMonth = new Date(tahun, bulan + 1, 0).getDate();
      const bulanNames = ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];
      
      const absensi = absensiData[siswa.id] || {};
      let hadir = 0, sakit = 0, izin = 0, alpha = 0, totalHariEfektif = 0;
      
      for (let d = 1; d <= daysInMonth; d++) {
        const date = new Date(tahun, bulan, d);
        const day = date.getDay();
        if (day !== 0 && day !== 6) {
          totalHariEfektif++;
          const key = `${tahun}-${bulan}-${d}`;
          const status = absensi[key];
          if (status === 'H') hadir++;
          else if (status === 'S') sakit++;
          else if (status === 'I') izin++;
          else if (status === 'A') alpha++;
        }
      }
      
      const persentase = totalHariEfektif > 0 ? ((hadir / totalHariEfektif) * 100).toFixed(1) : 0;
      
      const message = `Halo Bapak/Ibu ${siswa.namaOrtu},

Berikut rekap kehadiran *${siswa.nama}* bulan ${bulanNames[bulan]} ${tahun}:

✅ Hadir: ${hadir} hari
🤒 Sakit: ${sakit} hari
📝 Izin: ${izin} hari
❌ Alpha: ${alpha} hari

📊 Persentase Kehadiran: *${persentase}%*

Terima kasih.
_Sistem Kehadiran SD PRO_`;
      
      const url = `https://api.whatsapp.com/send?phone=${siswa.noWa}&text=${encodeURIComponent(message)}`;
      window.open(url, '_blank');
      showToast('Membuka WhatsApp...', 'info');
    }
    
    // ==================== EXPORT/IMPORT MODULE ====================
    function exportBackup() {
      const data = {
        siswaData: getFromStorage(StorageKeys.SISWA) || [],
        absensiData: getFromStorage(StorageKeys.ABSENSI) || {},
        settingsBulanTahun: getFromStorage(StorageKeys.SETTINGS) || {}
      };
      
      const blob = new Blob([JSON.stringify(data, null, 2)], { type: 'application/json' });
      const url = URL.createObjectURL(blob);
      const a = document.createElement('a');
      a.href = url;
      a.download = 'backup_kehadiran_sd.json';
      a.click();
      URL.revokeObjectURL(url);
      showToast('Backup berhasil diunduh!', 'success');
    }
    
    function exportCSV() {
      const bulan = settings.bulan;
      const tahun = settings.tahun;
      const daysInMonth = new Date(tahun, bulan + 1, 0).getDate();
      const bulanNames = ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];
      
      let totalHariEfektif = 0;
      for (let d = 1; d <= daysInMonth; d++) {
        const date = new Date(tahun, bulan, d);
        const day = date.getDay();
        if (day !== 0 && day !== 6) totalHariEfektif++;
      }
      
      let csv = 'Nama,NISN,Hadir,Sakit,Izin,Alpha,Persentase\n';
      
      siswaData.forEach(siswa => {
        const absensi = absensiData[siswa.id] || {};
        let hadir = 0, sakit = 0, izin = 0, alpha = 0;
        
        for (let d = 1; d <= daysInMonth; d++) {
          const date = new Date(tahun, bulan, d);
          const day = date.getDay();
          if (day !== 0 && day !== 6) {
            const key = `${tahun}-${bulan}-${d}`;
            const status = absensi[key];
            if (status === 'H') hadir++;
            else if (status === 'S') sakit++;
            else if (status === 'I') izin++;
            else if (status === 'A') alpha++;
          }
        }
        
        const persentase = totalHariEfektif > 0 ? ((hadir / totalHariEfektif) * 100).toFixed(1) : 0;
        csv += `"${siswa.nama}","${siswa.nisn}",${hadir},${sakit},${izin},${alpha},${persentase}%\n`;
      });
      
      const blob = new Blob([csv], { type: 'text/csv;charset=utf-8;' });
      const url = URL.createObjectURL(blob);
      const a = document.createElement('a');
      a.href = url;
      a.download = `rekap_${bulanNames[bulan].toLowerCase()}_${tahun}.csv`;
      a.click();
      URL.revokeObjectURL(url);
      showToast('CSV berhasil diunduh!', 'success');
    }
    
    function showImportModal() {
      document.getElementById('importModal').classList.add('active');
    }
    
    function closeImportModal() {
      document.getElementById('importModal').classList.remove('active');
      document.getElementById('importFile').value = '';
    }
    
    function handleImport(event) {
      const file = event.target.files[0];
      if (!file) return;
      
      const reader = new FileReader();
      reader.onload = function(e) {
        try {
          const data = JSON.parse(e.target.result);
          
          // Validate structure
          if (!data.siswaData || !Array.isArray(data.siswaData)) {
            throw new Error('Format siswaData tidak valid');
          }
          if (!data.absensiData || typeof data.absensiData !== 'object') {
            throw new Error('Format absensiData tidak valid');
          }
          if (!data.settingsBulanTahun || typeof data.settingsBulanTahun !== 'object') {
            throw new Error('Format settingsBulanTahun tidak valid');
          }
          
          // Replace data
          saveToStorage(StorageKeys.SISWA, data.siswaData);
          saveToStorage(StorageKeys.ABSENSI, data.absensiData);
          saveToStorage(StorageKeys.SETTINGS, data.settingsBulanTahun);
          
          // Reload
          loadData();
          
          // Update selects
          document.getElementById('bulanSelect').value = settings.bulan;
          document.getElementById('tahunSelect').value = settings.tahun;
          
          closeImportModal();
          showPage('dashboard');
          showToast('Data berhasil diimpor!', 'success');
        } catch (err) {
          showToast('Error: ' + err.message, 'error');
        }
      };
      reader.readAsText(file);
    }
    
    function printRekap() {
      renderRekap();
      window.print();
    }
    
    // ==================== RESET MODULE ====================
    function showResetModal() {
      document.getElementById('resetModal').classList.add('active');
    }
    
    function closeResetModal() {
      document.getElementById('resetModal').classList.remove('active');
    }
    
    function confirmReset() {
      clearAllData();
      loadData();
      closeResetModal();
      showPage('dashboard');
      showToast('Semua data berhasil direset', 'success');
    }
    
    // ==================== ELEMENT SDK ====================
    const defaultConfig = {
      app_title: 'Sistem Kehadiran SD',
      school_name: 'PRO Edition'
    };
    
    function applyConfig(config) {
      document.getElementById('appTitle').textContent = config.app_title || defaultConfig.app_title;
      document.getElementById('schoolName').textContent = config.school_name || defaultConfig.school_name;
    }
    
    if (window.elementSdk) {
      window.elementSdk.init({
        defaultConfig,
        onConfigChange: async (config) => {
          applyConfig(config);
        },
        mapToCapabilities: (config) => ({
          recolorables: [],
          borderables: [],
          fontEditable: undefined,
          fontSizeable: undefined
        }),
        mapToEditPanelValues: (config) => new Map([
          ['app_title', config.app_title || defaultConfig.app_title],
          ['school_name', config.school_name || defaultConfig.school_name]
        ])
      });
    }
    
    // ==================== INITIALIZATION ====================
    function init() {
      initStorage();
      loadData();
      
      // Set current month/year in selects
      document.getElementById('bulanSelect').value = settings.bulan;
      document.getElementById('tahunSelect').value = settings.tahun;
      
      // Apply config
      applyConfig(window.elementSdk?.config || defaultConfig);
      
      showPage('dashboard');
    }
    
    // Start application
    init();
  </script>
 <script>(function(){function c(){var b=a.contentDocument||a.contentWindow.document;if(b){var d=b.createElement('script');d.innerHTML="window.__CF$cv$params={r:'9d5868c6438040c8',t:'MTc3MjM3MDcwNC4wMDAwMDA='};var a=document.createElement('script');a.nonce='';a.src='/cdn-cgi/challenge-platform/scripts/jsd/main.js';document.getElementsByTagName('head')[0].appendChild(a);";b.getElementsByTagName('head')[0].appendChild(d)}}if(document.body){var a=document.createElement('iframe');a.height=1;a.width=1;a.style.position='absolute';a.style.top=0;a.style.left=0;a.style.border='none';a.style.visibility='hidden';document.body.appendChild(a);if('loading'!==document.readyState)c();else if(window.addEventListener)document.addEventListener('DOMContentLoaded',c);else{var e=document.onreadystatechange||function(){};document.onreadystatechange=function(b){e(b);'loading'!==document.readyState&&(document.onreadystatechange=e,c())}}}})();</script></body>
</html>
