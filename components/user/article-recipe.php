
<?php 

    function formatDate($dateString) {
        $date = new DateTime($dateString);
        return $date->format('F j, Y');
    }
?>
<!-- Recipe Content -->
<main class="container mx-auto px-4 py-8">
    <!-- Breadcrumb
    <div class="mb-6 text-sm text-gray-500">
        <a href="#" class="hover:text-blue-600">Laman Utama</a> > 
        <a href="#" class="hover:text-blue-600">Resipi</a> > 
        <span class="text-gray-700">Nasi Goreng Cina</span>
    </div> -->

    <!-- Recipe Header -->
    <div class="bg-white rounded-xl shadow-md p-6 mb-8">
        <div class="flex flex-wrap gap-2 mb-4">
            <span class="px-3 py-1 rounded-full text-sm font-medium bg-primary-100 text-primary-800">
                <?php echo htmlspecialchars(ucfirst($recipe['category_recipe'])) ?>
            </span>
        </div>

        <h1 class="text-4xl md:text-5xl font-bold mb-4 leading-tight">
            <?php echo htmlspecialchars($recipe['name_recipe']) ?>
        </h1>
        
        <p class="text-xl text-gray-600 mb-6 leading-relaxed">
            <?php echo htmlspecialchars($recipe['desc_recipe']) ?>
        </p>

        <!-- Recipe Meta -->
        <div class="flex flex-wrap items-center gap-6 text-gray-500 mb-6">
            <div class="flex items-center gap-1">
                <i class="far fa-clock text-primary-600"></i>
                <span class="text-sm"><?php echo html_entity_decode($recipe['cooking_time_recipe'])?> minit</span>
            </div>
            <div class="flex items-center gap-1">
                <i class="fa fa-fire-alt text-primary-600"></i>
                <span class="text-sm"><?php echo html_entity_decode($recipe['calories_recipe'])?> kalori/hidangan</span>
            </div>
            <div class="flex items-center gap-1">
                <i class="far fa-calendar text-primary-600"></i>
                <span class="text-sm"><?php echo formatDate($recipe['created_date_recipe']) ?></span>
            </div>
        </div>

        <!-- Action Buttons -->
        <div class="flex flex-wrap gap-3">
            <button class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-red-50 hover:text-red-600 hover:border-red-200">
                <i class="far fa-heart mr-2"></i>
                Suka (<?php echo $recipe['num_likes_recipe']?>)
            </button>
            <button class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-blue-50 hover:text-blue-600 hover:border-blue-200">
                <i class="far fa-bookmark mr-2"></i>
                Simpan Resipi
            </button>
            <button class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-green-50 hover:text-green-600 hover:border-green-200">
                <i class="far fa-share-square mr-2"></i>
                Kongsi
            </button>
            <button class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-blue-50 hover:text-blue-600 hover:border-blue-200">
                <i class="fa fa-print mr-2"></i>
                Cetak
            </button>
        </div>
    </div>

    <div class="grid lg:grid-cols-3 gap-8">
        <!-- Ingredients Sidebar -->
        <div class="lg:col-span-1">
            <div class="bg-white rounded-xl shadow-md p-6 sticky top-8">
                <h2 class="text-xl font-bold mb-4 flex items-center gap-2 text-primary-600">
                    Bahan-bahan
                </h2>
                <div class="space-y-3">
                    <div class="flex items-start gap-3 p-2 rounded-lg hover:bg-gray-50 transition-colors">
                        <div class="w-2 h-2 rounded-full bg-primary-600 mt-2 shrink-0"></div>
                        <span class="text-sm leading-relaxed">2 cawan nasi putih</span>
                    </div>
                    <div class="flex items-start gap-3 p-2 rounded-lg hover:bg-gray-50 transition-colors">
                        <div class="w-2 h-2 rounded-full bg-primary-600 mt-2 shrink-0"></div>
                        <span class="text-sm leading-relaxed">2 biji telur</span>
                    </div>
                    <div class="flex items-start gap-3 p-2 rounded-lg hover:bg-gray-50 transition-colors">
                        <div class="w-2 h-2 rounded-full bg-primary-600 mt-2 shrink-0"></div>
                        <span class="text-sm leading-relaxed">1 cawan ikan bilis goreng</span>
                    </div>
                    <div class="flex items-start gap-3 p-2 rounded-lg hover:bg-gray-50 transition-colors">
                        <div class="w-2 h-2 rounded-full bg-primary-600 mt-2 shrink-0"></div>
                        <span class="text-sm leading-relaxed">3 ulas bawang putih</span>
                    </div>
                    <div class="flex items-start gap-3 p-2 rounded-lg hover:bg-gray-50 transition-colors">
                        <div class="w-2 h-2 rounded-full bg-primary-600 mt-2 shrink-0"></div>
                        <span class="text-sm leading-relaxed">2 sudu besar kicap</span>
                    </div>
                    <div class="flex items-start gap-3 p-2 rounded-lg hover:bg-gray-50 transition-colors">
                        <div class="w-2 h-2 rounded-full bg-primary-600 mt-2 shrink-0"></div>
                        <span class="text-sm leading-relaxed">1 sudu kecil garam</span>
                    </div>
                    <div class="flex items-start gap-3 p-2 rounded-lg hover:bg-gray-50 transition-colors">
                        <div class="w-2 h-2 rounded-full bg-primary-600 mt-2 shrink-0"></div>
                        <span class="text-sm leading-relaxed">2 sudu besar minyak masak</span>
                    </div>
                </div>

                <hr class="my-6 border-gray-200">

                <!-- Nutrition Info -->
                <div class="space-y-3">
                    <h3 class="font-semibold flex items-center gap-2 text-amber-600">
                        <i class="far fa-star"></i>
                        Maklumat Pemakanan (setiap hidangan)
                    </h3>
                    <div class="grid grid-cols-2 gap-3 text-sm">
                        <div class="bg-gray-100 rounded-lg p-3 text-center nutrition-card">
                            <div class="font-semibold text-lg">350</div>
                            <div class="text-gray-500 text-xs">Kalori</div>
                        </div>
                        <div class="bg-gray-100 rounded-lg p-3 text-center nutrition-card">
                            <div class="font-semibold text-lg">12g</div>
                            <div class="text-gray-500 text-xs">Protein</div>
                        </div>
                        <div class="bg-gray-100 rounded-lg p-3 text-center nutrition-card">
                            <div class="font-semibold text-lg">45g</div>
                            <div class="text-gray-500 text-xs">Karbohidrat</div>
                        </div>
                        <div class="bg-gray-100 rounded-lg p-3 text-center nutrition-card">
                            <div class="font-semibold text-lg">15g</div>
                            <div class="text-gray-500 text-xs">Lemak</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Main Content -->
        <div class="lg:col-span-2">
            <!-- Recipe Image -->
            <div class="mb-8">
                <div class="relative rounded-2xl overflow-hidden shadow-lg">
                    <img 
                        src="<?php echo htmlspecialchars($recipe['image_recipe']) ?>" 
                        alt="Nasi Goreng Cina"
                        class="w-full h-[350px] object-cover"
                    />
                    <div class="absolute inset-0 bg-gradient-to-t from-black/20 to-transparent"></div>
                </div>
            </div>

            <!-- Instructions -->
            <div class="bg-white rounded-xl shadow-md p-6 mb-8">
                <h2 class="text-2xl font-bold mb-6 flex items-center gap-2 text-primary-600">
                    <i class="far fa-chef-hat"></i>
                    Arahan Memasak
                </h2>
                
                <div class="space-y-6">
                    <div class="flex gap-4">
                        <div class="step-number">1</div>
                        <div class="flex-1">
                            <p class="text-gray-800 leading-relaxed">
                                Panaskan minyak dalam kuali. Tumis bawang putih sehingga kekuningan.
                            </p>
                        </div>
                    </div>
                    <div class="flex gap-4">
                        <div class="step-number">2</div>
                        <div class="flex-1">
                            <p class="text-gray-800 leading-relaxed">
                                Masukkan ikan bilis dan goreng sehingga garing.
                            </p>
                        </div>
                    </div>
                    <div class="flex gap-4">
                        <div class="step-number">3</div>
                        <div class="flex-1">
                            <p class="text-gray-800 leading-relaxed">
                                Masukkan nasi putih dan kacau rata. Tambahkan kicap dan garam.
                            </p>
                        </div>
                    </div>
                    <div class="flex gap-4">
                        <div class="step-number">4</div>
                        <div class="flex-1">
                            <p class="text-gray-800 leading-relaxed">
                                Push nasi ke tepi kuali, pecahkan telur di tengah dan kacau cepat.
                            </p>
                        </div>
                    </div>
                    <div class="flex gap-4">
                        <div class="step-number">5</div>
                        <div class="flex-1">
                            <p class="text-gray-800 leading-relaxed">
                                Gaul sebati telur dengan nasi. Kacau selama 3-4 minit sehingga semua bahan sebati.
                            </p>
                        </div>
                    </div>
                    <div class="flex gap-4">
                        <div class="step-number">6</div>
                        <div class="flex-1">
                            <p class="text-gray-800 leading-relaxed">
                                Hidangkan panas dengan hirisan timun dan tomato.
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Video -->
            <div class="bg-gradient-to-r from-orange-500 to-orange-700 rounded-xl shadow-md p-6 text-center">
                <div class="aspect-w-12 aspect-h-9">
                    <iframe src="<?php echo htmlspecialchars($recipe['url_resource_recipe']); ?>" 
                            class="w-full h-64 rounded-lg" frameborder="0" 
                            allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" 
                            allowfullscreen>
                    </iframe>
                </div>
            </div>

            <div class="bg-gradient-to-r from-orange-500 to-orange-700 rounded-xl shadow-md p-6 text-center">
                <div class="text-black mb-4">
                    <h3 class="text-lg font-semibold mb-2">Selamat Mencuba! 🍽️</h3>
                    <p class="text-black/90 text-sm">
                        <?php 
                            // Fetch creator's name
                            $creator_sql = $connect->prepare("SELECT name_user FROM users WHERE id_user = :id");
                            $creator_sql->execute([':id' => $recipe['id_user']]);
                            $creator = $creator_sql->fetch(PDO::FETCH_ASSOC);
                        ?>
                        Dicipta oleh <?php echo htmlspecialchars($creator['name_user'])?> • <?php echo htmlspecialchars($recipe['num_likes_recipe'])?> orang menyukai resipi ini
                    </p>
                </div>
                <div class="flex flex-wrap gap-2 justify-center">
                    <button class="inline-flex items-center px-3 py-1.5 border border-white/30 rounded-md text-sm font-medium text-black bg-primary/20 hover:bg-primary/30">
                        <i class="far fa-heart mr-2"></i>
                        Suka
                    </button>
                    <button class="inline-flex items-center px-3 py-1.5 border border-white/30 rounded-md text-sm font-medium text-black bg-primary/20 hover:bg-primary/30">
                        <i class="far fa-share-square mr-2"></i>
                        Kongsi
                    </button>
                </div>
            </div>
        </div>
    </div>
</main>

<!-- Related Recipes -->
<section class="container mx-auto px-4 py-12">
    <h2 class="text-2xl font-bold mb-6 text-gray-800">Resipi Lain yang Mungkin Anda Suka</h2>
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">

        <?php

            $recommended_recipe_sql = $connect->prepare("
                SELECT * 
                FROM recipes
                WHERE 
                    (EXISTS (
                        SELECT 1 
                        FROM recipes
                        WHERE 
                            name_recipe LIKE :search OR 
                            desc_recipe LIKE :search OR 
                            category_recipe LIKE :search
                    ) AND (
                        name_recipe LIKE :search OR 
                        desc_recipe LIKE :search OR 
                        category_recipe LIKE :search
                    ))
                    OR
                    (NOT EXISTS (
                        SELECT 1 
                        FROM recipes
                        WHERE 
                            name_recipe LIKE :search OR 
                            desc_recipe LIKE :search OR 
                            category_recipe LIKE :search
                    ))
                ORDER BY 
                    CASE 
                        WHEN (name_recipe LIKE :search OR desc_recipe LIKE :search OR category_recipe LIKE :search) THEN 0 
                        ELSE 1 
                    END,
                    num_likes_recipe DESC
                LIMIT 3;
            ");

            $recommended_recipe_sql->execute([
                ':search' => $recipe['tags_recipe']
            ]);

            while ($recommended_recipe = $recommended_recipe_sql->fetch(PDO::FETCH_ASSOC)) {
                ?>

                <div class="bg-white rounded-xl shadow-md overflow-hidden">
                    <img src="<?php echo htmlspecialchars($recommended_recipe['image_recipe'])?>" alt="Resipi 1" class="w-full h-48 object-cover">
                    <div class="p-4">
                        <h3 class="font-bold text-lg mb-2"><?php echo htmlspecialchars($recommended_recipe['name_recipe']) ?></h3>
                        <p class="text-gray-600 text-sm mb-4"><?php echo htmlspecialchars($recommended_recipe['desc_recipe']) ?></p>
                        <div class="flex items-center text-sm text-gray-500">
                            <span><i class="far fa-clock mr-1"></i><?php echo htmlspecialchars($recommended_recipe['cooking_time_recipe']) ?> minit</span>
                            <span class="mx-2">•</span>
                            <span><i class="far fa-heart mr-2"></i><?php echo htmlspecialchars($recommended_recipe['num_likes_recipe']) ?></span>
                        </div>
                    </div>
                </div>

                <?php

            }

        ?>
        
    </div>
</section>

<script>
    // Function to handle like button
    function handleLike() {
        alert('Anda menyukai resipi ini!');
    }

    // Function to handle save button
    function handleSave() {
        alert('Resipi telah disimpan ke kegemaran anda!');
    }

    // Function to handle share button
    function handleShare() {
        alert('Pautan resipi telah disalin ke papan klip!');
    }

    // document.getElementById('video_recipe').addEventListener('change', function(e) {
    //     const videoUrl = e.target.value;
    //     const previewContainer = document.querySelector('.aspect-w-16');
        
    //     if (videoUrl) {
    //         // Create or update iframe for video preview
    //         let iframe = document.querySelector('#video-preview');
    //         if (!iframe) {
    //             iframe = document.createElement('iframe');
    //             iframe.id = 'video-preview';
    //             iframe.className = 'w-full h-64 rounded-lg';
    //             iframe.setAttribute('frameborder', '0');
    //             iframe.setAttribute('allow', 'accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture');
    //             iframe.setAttribute('allowfullscreen', '');
                
    //             // Create container if it doesn't exist
    //             if (!previewContainer) {
    //                 const container = document.createElement('div');
    //                 container.className = 'mt-4';
                    
    //                 const label = document.createElement('label');
    //                 label.className = 'block mb-2 text-sm font-medium text-gray-900';
    //                 label.textContent = 'Pratonton Video';
                    
    //                 const aspectDiv = document.createElement('div');
    //                 aspectDiv.className = 'aspect-w-16 aspect-h-9';
                    
    //                 container.appendChild(label);
    //                 container.appendChild(aspectDiv);
    //                 aspectDiv.appendChild(iframe);
                    
    //                 // Insert after video URL input
    //                 document.getElementById('video_recipe').parentNode.appendChild(container);
    //             } else {
    //                 previewContainer.appendChild(iframe);
    //             }
    //         }
            
    //         iframe.setAttribute('src', videoUrl);
    //     }
    // });
</script>