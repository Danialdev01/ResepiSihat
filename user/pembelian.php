<?php $location_index = ".."; include('../components/head.php');?>

<body>
    <?php include("../components/user/header.php")?>

    <main>

        <div class="dashboard-grid">

                <?php include("../components/user/nav.php")?>
            
            <!-- Main Content -->
            <div class="main-content">
                <?php include("../components/user/top-bar.php")?>
                
                <!-- Main Dashboard Content -->
                <div class="p-6">
                    

                    <table id="default-table">
                        <thead>
                            <tr>
                                <th>
                                    <span class="flex items-center">
                                        Nama Resepi
                                        <svg class="w-4 h-4 ms-1" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m8 15 4 4 4-4m0-6-4-4-4 4"/>
                                        </svg>
                                    </span>
                                </th>
                                <th data-type="date" data-format="YYYY/DD/MM">
                                    <span class="flex items-center">
                                        Bilangan bahan
                                        <svg class="w-4 h-4 ms-1" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m8 15 4 4 4-4m0-6-4-4-4 4"/>
                                        </svg>
                                    </span>
                                </th>
                                <th>
                                    <span class="flex items-center">
                                        Aktiviti
                                        <svg class="w-4 h-4 ms-1" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m8 15 4 4 4-4m0-6-4-4-4 4"/>
                                        </svg>
                                    </span>
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td class="font-medium text-gray-900 whitespace-nowrap">Nasi Ayam</td>
                                <td>12</td>
                                <td>
                                    <button type="button" class="focus:outline-none text-white bg-red-700 hover:bg-red-800 focus:ring-4 focus:ring-red-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 dark:bg-red-600 dark:hover:bg-red-700 dark:focus:ring-red-900">Buang</button>
                                </td>
                            </tr>
                            <tr>
                                <td class="font-medium text-gray-900 whitespace-nowrap">Salad Kacang</td>
                                <td>8</td>
                                <td>
                                    <button type="button" class="focus:outline-none text-white bg-red-700 hover:bg-red-800 focus:ring-4 focus:ring-red-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 dark:bg-red-600 dark:hover:bg-red-700 dark:focus:ring-red-900">Buang</button>
                                </td>
                            </tr>
                            <tr>
                                <td class="font-medium text-gray-900 whitespace-nowrap">Ayam Goreng</td>
                                <td>4</td>
                                <td>
                                    <button type="button" class="focus:outline-none text-white bg-red-700 hover:bg-red-800 focus:ring-4 focus:ring-red-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 dark:bg-red-600 dark:hover:bg-red-700 dark:focus:ring-red-900">Buang</button>
                                </td>
                            </tr>
                        </tbody>
                    </table>

                    <script>
                        if (document.getElementById("default-table") && typeof simpleDatatables.DataTable !== 'undefined') {
                            const dataTable = new simpleDatatables.DataTable("#default-table", {
                                searchable: false,
                                perPageSelect: false
                            });
                        }
                    </script>
                    
                </div>
                <center>
                    <a href="../src/ORDERING SUGAR 4.pdf">
                        <button type="button" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800">Cetak Pembelian</button>
                    </a>
                </center>
            </div>
        </div>

    
        <!-- Mobile overlay -->
        <div class="overlay"></div>
    
    </main>

    <?php $location_index='..'; include('../components/footer.php')?>
    
</body>
</html>