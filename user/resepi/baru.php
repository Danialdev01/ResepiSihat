<?php $location_index = "../.."; include('../../components/head.php');?>

<body>
    <?php include("../../components/user/header.php")?>

    <main>

        <div class="dashboard-grid">

            <?php include("../../components/user/nav.php")?>
        
        <!-- Main Content -->
        <div class="main-content">
            <?php include("../../components/user/top-bar.php")?>
            
            <!-- Main Dashboard Content -->
            <div class="p-6">
                
                <form action="#">

                    <div class="bg-white rounded-lg shadow-md mt-6 p-3 flex flex-wrap gap-2">
                        <button class="toolbar-btn p-2 rounded-lg" title="Bold" onclick="formatText('bold')">
                            <i class="fas fa-bold text-gray-700"></i>
                        </button>
                        <button class="toolbar-btn p-2 rounded-lg" title="Italic" onclick="formatText('italic')">
                            <i class="fas fa-italic text-gray-700"></i>
                        </button>
                        <button class="toolbar-btn p-2 rounded-lg" title="Heading" onclick="formatText('heading')">
                            <i class="fas fa-heading text-gray-700"></i>
                        </button>
                        <button class="toolbar-btn p-2 rounded-lg" title="Link" onclick="formatText('link')">
                            <i class="fas fa-link text-gray-700"></i>
                        </button>
                        <button class="toolbar-btn p-2 rounded-lg" title="Image" onclick="formatText('image')">
                            <i class="fas fa-image text-gray-700"></i>
                        </button>
                        <button class="toolbar-btn p-2 rounded-lg" title="Video" onclick="formatText('video')">
                            <i class="fas fa-video text-gray-700"></i>
                        </button>
                        <button class="toolbar-btn p-2 rounded-lg" title="Code" onclick="formatText('code')">
                            <i class="fas fa-code text-gray-700"></i>
                        </button>
                        <button class="toolbar-btn p-2 rounded-lg" title="List" onclick="formatText('list')">
                            <i class="fas fa-list text-gray-700"></i>
                        </button>
                        <button class="toolbar-btn p-2 rounded-lg" title="Numbered List" onclick="formatText('numberedList')">
                            <i class="fas fa-list-ol text-gray-700"></i>
                        </button>
                        <button class="toolbar-btn p-2 rounded-lg" title="Quote" onclick="formatText('quote')">
                            <i class="fas fa-quote-right text-gray-700"></i>
                        </button>
                        <button class="toolbar-btn p-2 rounded-lg" title="Table" onclick="formatText('table')">
                            <i class="fas fa-table text-gray-700"></i>
                        </button>
                        <button class="toolbar-btn p-2 rounded-lg" title="Upload Media" onclick="toggleUploadModal()">
                            <i class="fas fa-cloud-upload-alt text-gray-700"></i>
                        </button>
                        <div class="flex items-center ml-auto">
                            <span class="text-sm text-gray-500 mr-3">Words: <span id="word-count">0</span></span>
                            <button class="px-3 py-1 bg-green-100 text-green-700 rounded-lg text-sm">
                                <i class="fas fa-sync mr-1"></i> Auto Preview
                            </button>
                        </div>
                    </div>
                    <br><br>
                    
                    <div class="grid gap-4 sm:grid-cols-2 sm:gap-6">
                        <div class="sm:col-span-2">
                            <label for="name" class="block mb-2 text-sm font-medium text-gray-900">Nama Resepi</label>
                            <input type="text" name="name" id="name" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5" placeholder="Contoh: Danial Irfan" required="">
                        </div>
                        <div>
                            <label for="category" class="block mb-2 text-sm font-medium text-gray-900">Kategori</label>
                            <select id="category" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5">
                                <option value="sarapan" selected="">Sarapan</option>
                                <option value="snek">Snek</option>
                                <option value="makan tengahari">Makan Tengahari</option>
                                <option value="makan malam">Makan Malam</option>
                            </select>
                        </div>
                        <div>
                            <label for="item-weight" class="block mb-2 text-sm font-medium text-gray-900">Anggaran Masa Penyediaan</label>
                            <input type="number" name="item-weight" id="item-weight" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5" placeholder="" required="">
                        </div> 
                        <div class="sm:col-span-2">
                            <label for="description" class="block mb-2 text-sm font-medium text-gray-900">Kaedah Penyediaan</label>
                            <textarea id="description" rows="8" class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-primary-500 focus:border-primary-500" placeholder="Your description here"></textarea>
                        </div>
                    </div>
                    <button type="submit" class="inline-flex items-center px-5 py-2.5 mt-4 sm:mt-6 text-sm font-medium text-center text-white bg-primary-700 rounded-lg focus:ring-4 focus:ring-primary-200">
                        Tambah Resepi
                    </button>
                </form>
            </div>
        </div>
    </div>
    
    <!-- Mobile overlay -->
    <div class="overlay"></div>
    
    <script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/1.8.1/flowbite.min.js"></script>
    <script>
        // Mobile menu toggle
        const mobileMenuButton = document.getElementById('mobile-menu-button');
        const sidenav = document.querySelector('.sidenav');
        const overlay = document.querySelector('.overlay');
        
        mobileMenuButton.addEventListener('click', function() {
            sidenav.classList.toggle('active');
            overlay.classList.toggle('active');
        });
        
        overlay.addEventListener('click', function() {
            sidenav.classList.remove('active');
            overlay.classList.remove('active');
        });
        
        // Simulate progress bar animations
        document.querySelectorAll('.progress-fill').forEach(bar => {
            const width = bar.style.width;
            bar.style.width = '0';
            setTimeout(() => {
                bar.style.width = width;
            }, 300);
        });
    </script>

    </main>

    <?php $location_index='../..'; include('../../components/footer.php')?>
    
</body>
</html>