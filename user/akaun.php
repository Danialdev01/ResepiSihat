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
                    <?php include("../components/user/stats-cards.php")?>
                    
                    <form action="#">
                        <div class="grid gap-4 sm:grid-cols-2 sm:gap-6">
                            <div class="sm:col-span-2">
                                <label for="name" class="block mb-2 text-sm font-medium text-gray-900">Nama Pengguna</label>
                                <input type="text" name="name" id="name" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5" placeholder="Contoh: Danial Irfan" required="">
                            </div>
                            <div>
                                <label for="category" class="block mb-2 text-sm font-medium text-gray-900">Category</label>
                                <select id="category" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5">
                                    <option selected="">Select category</option>
                                    <option value="TV">TV/Monitors</option>
                                    <option value="PC">PC</option>
                                    <option value="GA">Gaming/Console</option>
                                    <option value="PH">Phones</option>
                                </select>
                            </div>
                            <div>
                                <label for="item-weight" class="block mb-2 text-sm font-medium text-gray-900">Item Weight (kg)</label>
                                <input type="number" name="item-weight" id="item-weight" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5" placeholder="12" required="">
                            </div> 
                            <div class="sm:col-span-2">
                                <label for="description" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Description</label>
                                <textarea id="description" rows="8" class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-primary-500 focus:border-primary-500" placeholder="Your description here"></textarea>
                            </div>
                        </div>
                        <button type="submit" class="inline-flex items-center px-5 py-2.5 mt-4 sm:mt-6 text-sm font-medium text-center text-white bg-primary-700 rounded-lg focus:ring-4 focus:ring-primary-200">
                            Add product
                        </button>
                    </form>
                </div>
            </div>
        </div>
        
        <!-- Mobile overlay -->
        <div class="overlay"></div>
    

    </main>

    <?php $location_index='..'; include('../components/footer.php')?>
    
</body>
</html>