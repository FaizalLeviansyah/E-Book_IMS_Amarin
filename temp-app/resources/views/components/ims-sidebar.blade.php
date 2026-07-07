<aside class="w-80 bg-gray-900 text-gray-100 min-h-screen shadow-2xl font-sans border-r border-gray-800 flex flex-col">
    <!-- Header Sidebar -->
    <div class="p-6 border-b border-gray-800 flex-shrink-0">
        <h2 class="text-xl font-bold tracking-wider text-white">IMS PORTAL</h2>
        <p class="text-xs text-gray-400 mt-1 uppercase tracking-widest">PT Amarin Ship Management</p>
    </div>

    <!-- Menu Navigasi -->
    <nav class="flex-1 p-4 space-y-2 overflow-y-auto custom-scrollbar">

        <!-- BAGIAN 2.8 -->
        <div x-data="{ expanded: true }" class="mb-1">
            <button @click="expanded = !expanded" class="w-full flex items-center justify-between p-2.5 bg-gray-800 hover:bg-gray-700 rounded-lg transition-colors duration-200 shadow-sm border border-gray-700">
                <span class="text-sm font-semibold text-gray-200">2.8. Operation / Operasi</span>
                <svg :class="expanded ? 'rotate-180' : ''" class="w-4 h-4 text-gray-400 transition-transform duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
            </button>

            <ul x-show="expanded" x-collapse class="pl-3 mt-2 space-y-1 border-l-2 border-gray-700 ml-3">

                <!-- 2.8.2 -->
                <li x-data="{ subExpanded: false }">
                    <button @click="subExpanded = !subExpanded" class="w-full flex items-center justify-between p-2 text-xs font-medium text-gray-400 hover:text-white rounded transition-colors duration-200 group">
                        <span class="text-left group-hover:translate-x-1 transition-transform">2.8.2. Requirements / Persyaratan</span>
                        <svg :class="subExpanded ? 'rotate-180' : ''" class="w-3 h-3 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                    </button>
                    <ul x-show="subExpanded" x-collapse class="pl-4 mt-1 space-y-1 mb-2">
                        <li><a href="#" class="block p-1.5 text-[11px] text-gray-500 hover:text-blue-400">2.8.2.1. Komunikasi Pelanggan</a></li>
                        <li><a href="#" class="block p-1.5 text-[11px] text-gray-500 hover:text-blue-400">2.8.2.2. Review of Requirements Related to Products and Services<br><span class="text-gray-600">Tinjauan Persyaratan Terkait dengan Produk dan Layanan</span></a></li>
                        <li><a href="#" class="block p-1.5 text-[11px] text-gray-500 hover:text-blue-400">2.8.2.3. Changes to Requirements for Products and Services<br><span class="text-gray-600">Perubahan Persyaratan untuk Produk dan Layanan</span></a></li>
                    </ul>
                </li>

                <!-- 2.8.3 -->
                <li>
                    <a href="#" class="block p-2 text-xs text-gray-400 hover:text-white hover:bg-gray-800 rounded transition-colors">
                        2.8.3. Control of Externally Provided Products and Services<br>
                        <span class="text-[11px] text-gray-500">Kontrol Produk dan Layanan yang Disediakan Secara Eksternal</span>
                    </a>
                </li>

                <!-- 2.8.4 -->
                <li x-data="{ subExpanded: true }" class="mt-1">
                    <button @click="subExpanded = !subExpanded" class="w-full flex items-center justify-between p-2 text-xs font-medium text-gray-400 hover:text-white rounded transition-colors duration-200 group">
                        <span class="text-left group-hover:translate-x-1 transition-transform">2.8.4. Production and Service Provision<br><span class="text-[11px] text-gray-500">Penyediaan Produksi dan Layanan</span></span>
                        <svg :class="subExpanded ? 'rotate-180' : ''" class="w-3 h-3 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                    </button>
                    <ul x-show="subExpanded" x-collapse class="pl-4 mt-1 space-y-1 mb-2 border-l border-gray-700 ml-1">
                        <li><a href="#" class="block p-1.5 text-[11px] text-gray-500 hover:text-blue-400">2.8.4.1. Control of Production and Service Provision<br><span class="text-gray-600">Kontrol Penyediaan Produksi dan Layanan</span></a></li>
                        <li><a href="#" class="block p-1.5 text-[11px] text-gray-500 hover:text-blue-400">2.8.4.2. Identification and Traceability<br><span class="text-gray-600">Identifikasi dan Ketertelusuran</span></a></li>
                        <li><a href="#" class="block p-1.5 text-[11px] text-gray-500 hover:text-blue-400">2.8.4.3. Customer Property<br><span class="text-gray-600">Properti Pelanggan</span></a></li>
                        <li><a href="#" class="block p-1.5 text-[11px] text-gray-500 hover:text-blue-400">2.8.4.4. Control of Non-Conforming Product<br><span class="text-gray-600">Kontrol Produk yang Tidak Sesuai</span></a></li>
                    </ul>
                </li>
            </ul>
        </div>

        <!-- BAGIAN 2.9 -->
        <div x-data="{ expanded: true }" class="mb-1">
            <button @click="expanded = !expanded" class="w-full flex items-center justify-between p-2.5 bg-gray-800 hover:bg-gray-700 rounded-lg transition-colors duration-200 shadow-sm border border-gray-700">
                <span class="text-sm font-semibold text-gray-200">2.9. Performance Evaluation<br><span class="text-xs font-normal text-gray-400">Evaluasi Kinerja</span></span>
                <svg :class="expanded ? 'rotate-180' : ''" class="w-4 h-4 text-gray-400 transition-transform duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
            </button>

            <ul x-show="expanded" x-collapse class="pl-3 mt-2 space-y-1 border-l-2 border-gray-700 ml-3">
                <li x-data="{ subExpanded: true }">
                    <button @click="subExpanded = !subExpanded" class="w-full flex items-center justify-between p-2 text-xs font-medium text-gray-400 hover:text-white rounded transition-colors duration-200 group">
                        <span class="text-left group-hover:translate-x-1 transition-transform">2.9.1. Monitoring, Measurement, Analysis<br><span class="text-[11px] text-gray-500">Pemantauan, Pengukuran, Analisis...</span></span>
                        <svg :class="subExpanded ? 'rotate-180' : ''" class="w-3 h-3 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                    </button>
                    <ul x-show="subExpanded" x-collapse class="pl-4 mt-1 space-y-1 border-l border-gray-700 ml-1">
                        <li><a href="#" class="block p-1.5 text-[11px] text-gray-500 hover:text-blue-400">2.9.1.1. General / Umum</a></li>
                        <li x-data="{ deepExpanded: true }">
                            <button @click="deepExpanded = !deepExpanded" class="w-full flex items-center justify-between p-1.5 text-[11px] text-gray-500 hover:text-blue-400">
                                <span class="text-left">2.9.1.2. Customer Satisfaction<br><span class="text-gray-600">Kepuasan Pelanggan</span></span>
                                <svg :class="deepExpanded ? 'rotate-180' : ''" class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                            </button>
                            <ul x-show="deepExpanded" x-collapse class="pl-3 mt-1 space-y-1 border-l border-gray-700 ml-2">
                                <li><a href="#" class="block p-1.5 text-[11px] text-gray-500 hover:text-blue-300">2.9.1.2.1. Responsibilities<br><span class="text-gray-600">Tanggung Jawab</span></a></li>
                            </ul>
                        </li>
                    </ul>
                </li>
            </ul>
        </div>

        <!-- RELEVANT FORMS -->
        <div x-data="{ expanded: false }" class="mb-1 mt-4">
            <button @click="expanded = !expanded" class="w-full flex items-center justify-between p-2.5 bg-gray-800/50 hover:bg-gray-700 border border-dashed border-gray-700 rounded-lg transition-colors duration-200">
                <span class="text-sm font-semibold text-gray-300">Relevant Forms</span>
                <svg :class="expanded ? 'rotate-180' : ''" class="w-4 h-4 text-gray-400 transition-transform duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
            </button>
            <ul x-show="expanded" x-collapse class="pl-3 mt-2 space-y-1 border-l-2 border-gray-700 ml-3">
                <li><a href="#" class="block p-2 text-xs text-gray-500 hover:text-blue-400">Form 2.8 - Customer Communication Record</a></li>
                <li><a href="#" class="block p-2 text-xs text-gray-500 hover:text-blue-400">Form 2.9 - Satisfaction Survey</a></li>
            </ul>
        </div>

    </nav>
</aside>
