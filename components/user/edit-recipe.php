<!-- Recipe Editor Content -->
<div class="p-6">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold text-gray-900">Edit Resipi</h1>
        <a href="recipes.php" class="text-primary-600 hover:text-primary-800 flex items-center">
            <svg class="w-5 h-5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
            </svg>
            Kembali ke Senarai Resipi
        </a>
    </div>

    <div class="bg-white rounded-lg shadow-md p-6 mb-6">
        <form action="../backend/recipe.php" method="POST" enctype="multipart/form-data" id="recipe-form">
            <input type="hidden" name="token" value="<?php echo $token?>">
            <input type="hidden" name="id_recipe" value="<?php echo $recipe['id_recipe']?>">
            
            <!-- Recipe Image - Made Larger -->
            <div class="mb-6">
                <label class="block mb-2 text-sm font-medium text-gray-900">Gambar Resipi</label>
                <div class="flex flex-col items-center">
                    <img id="recipe-image-preview" src="<?php echo $recipe['image_recipe'] ?>" 
                            alt="Recipe Image" class="w-full max-w-2xl h-64 object-cover rounded-lg mb-4">
                    <div class="flex flex-col items-center">
                        <input type="file" id="recipe-image" name="image_recipe" accept="image/*" class="hidden">
                        <label for="recipe-image" class="cursor-pointer bg-primary-600 text-white py-2 px-4 rounded-lg hover:bg-primary-700 transition mb-2">
                            Tukar Gambar
                        </label>
                        <p class="text-sm text-gray-500">SVG, PNG, JPG (MAX. 5MB)</p>
                    </div>
                </div>
            </div>
            
            <!-- Video Link -->
            <div class="mb-6">
                <label for="video_recipe" class="block mb-2 text-sm font-medium text-gray-900">Pautan Video (YouTube, Vimeo, dll.)</label>
                <input type="url" name="video_recipe" id="video_recipe" value="<?php echo htmlspecialchars($recipe['video_recipe']); ?>" 
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5" 
                        placeholder="Contoh: https://www.youtube.com/embed/abc123">
                <p class="text-sm text-gray-500 mt-1">Masukkan pautan embed video (bukan pautan biasa)</p>
                
                <!-- Video Preview -->
                <?php if (!empty($recipe['video_recipe'])): ?>
                <div class="mt-4">
                    <label class="block mb-2 text-sm font-medium text-gray-900">Pratonton Video</label>
                    <div class="aspect-w-12 aspect-h-9">
                        <iframe src="<?php echo htmlspecialchars($recipe['video_recipe']); ?>" 
                                class="w-full h-64 rounded-lg" frameborder="0" 
                                allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" 
                                allowfullscreen>
                        </iframe>
                    </div>
                </div>
                <?php endif; ?>
            </div>
            
            <!-- Basic Information -->
            <div class="grid gap-6 mb-6 md:grid-cols-2">
                <div>
                    <label for="name_recipe" class="block mb-2 text-sm font-medium text-gray-900">Nama Resipi</label>
                    <input type="text" name="name_recipe" id="name_recipe" value="<?php echo htmlspecialchars($recipe['name_recipe']); ?>" 
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5" required>
                </div>
                <div>
                    <label for="category_recipe" class="block mb-2 text-sm font-medium text-gray-900">Kategori</label>
                    <select name="category_recipe" id="category_recipe" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5">
                        <option value="sarapan" <?php echo $recipe['category_recipe'] == 'sarapan' ? 'selected' : ''; ?>>Sarapan</option>
                        <option value="makan tengahari" <?php echo $recipe['category_recipe'] == 'makan tengahari' ? 'selected' : ''; ?>>Makan Tengahari</option>
                        <option value="makan malam" <?php echo $recipe['category_recipe'] == 'makan malam' ? 'selected' : ''; ?>>Makan Malam</option>
                        <option value="pencuci mulut" <?php echo $recipe['category_recipe'] == 'pencuci mulut' ? 'selected' : ''; ?>>Pencuci Mulut</option>
                        <option value="snek" <?php echo $recipe['category_recipe'] == 'snek' ? 'selected' : ''; ?>>Snek</option>
                    </select>
                </div>
                <div>
                    <label for="cooking_time_recipe" class="block mb-2 text-sm font-medium text-gray-900">Masa Memasak (minit)</label>
                    <input type="number" name="cooking_time_recipe" id="cooking_time_recipe" value="<?php echo $recipe['cooking_time_recipe']; ?>" 
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5">
                </div>
                <div>
                    <label for="calories_recipe" class="block mb-2 text-sm font-medium text-gray-900">Kalori</label>
                    <input type="number" name="calories_recipe" id="calories_recipe" value="<?php echo $recipe['calories_recipe']; ?>" 
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5">
                </div>
            </div>
            
            <!-- Description -->
            <div class="mb-6">
                <label for="desc_recipe" class="block mb-2 text-sm font-medium text-gray-900">Penerangan Resipi</label>
                <textarea name="desc_recipe" id="desc_recipe" rows="3" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5"><?php echo htmlspecialchars($recipe['desc_recipe']); ?></textarea>
            </div>
            
            <!-- Ingredients (WYSIWYG Editor) -->
            <div class="mb-6">
                <label for="ingredient_recipe" class="block mb-2 text-sm font-medium text-gray-900">Bahan-bahan</label>
                <div id="ingredient-editor" class="border border-gray-300 rounded-lg overflow-hidden">
                    <!-- Editor will be initialized here -->
                </div>
                <textarea id="ingredient_recipe" name="ingredient_recipe" class="hidden"><?php echo htmlspecialchars($recipe['ingredient_recipe']); ?></textarea>
            </div>
            
            <!-- Tutorial (WYSIWYG Editor) -->
            <div class="mb-6">
                <label for="tutorial_recipe" class="block mb-2 text-sm font-medium text-gray-900">Arahan Memasak</label>
                <div id="tutorial-editor" class="border border-gray-300 rounded-lg overflow-hidden">
                    <!-- Editor will be initialized here -->
                </div>
                <textarea id="tutorial_recipe" name="tutorial_recipe" class="hidden"><?php echo htmlspecialchars($recipe['tutorial_recipe']); ?></textarea>
            </div>
            
            <!-- Visibility -->
            <div class="mb-6">
                <label class="block mb-2 text-sm font-medium text-gray-900">Visibility</label>
                <div class="flex items-center">
                    <div class="flex items-center mr-4">
                        <input id="visibility-public" type="radio" value="1" name="visibility_recipe" 
                                class="w-4 h-4 text-primary-600 focus:ring-primary-500" 
                                <?php echo $recipe['visibility_recipe'] == 1 ? 'checked' : ''; ?>>
                        <label for="visibility-public" class="ml-2 text-sm font-medium text-gray-900">Awam</label>
                    </div>
                    <div class="flex items-center">
                        <input id="visibility-private" type="radio" value="0" name="visibility_recipe" 
                                class="w-4 h-4 text-primary-600 focus:ring-primary-500" 
                                <?php echo $recipe['visibility_recipe'] == 0 ? 'checked' : ''; ?>>
                        <label for="visibility-private" class="ml-2 text-sm font-medium text-gray-900">Peribadi</label>
                    </div>
                </div>
            </div>
            
            <!-- Buttons -->
            <div class="flex justify-end space-x-4">
                <a href="recipes.php" class="px-5 py-2.5 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100 hover:text-primary-700 focus:z-10 focus:ring-4 focus:ring-gray-100">
                    Batal
                </a>
                <button type="submit" name="update_recipe" class="px-5 py-2.5 text-sm font-medium text-center text-white bg-primary-700 rounded-lg hover:bg-primary-800 focus:ring-4 focus:ring-primary-300">
                    Simpan Perubahan
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Quill WYSIWYG Editor -->
<link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">
<script src="https://cdn.quilljs.com/1.3.6/quill.min.js"></script>

<script>
    // Image preview functionality
    document.getElementById('recipe-image').addEventListener('change', function(e) {
        const file = e.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(event) {
                document.getElementById('recipe-image-preview').src = event.target.result;
            }
            reader.readAsDataURL(file);
        }
    });

    // Video URL change handler to update preview
    document.getElementById('video_recipe').addEventListener('change', function(e) {
        const videoUrl = e.target.value;
        const previewContainer = document.querySelector('.aspect-w-16');
        
        if (videoUrl) {
            // Create or update iframe for video preview
            let iframe = document.querySelector('#video-preview');
            if (!iframe) {
                iframe = document.createElement('iframe');
                iframe.id = 'video-preview';
                iframe.className = 'w-full h-64 rounded-lg';
                iframe.setAttribute('frameborder', '0');
                iframe.setAttribute('allow', 'accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture');
                iframe.setAttribute('allowfullscreen', '');
                
                // Create container if it doesn't exist
                if (!previewContainer) {
                    const container = document.createElement('div');
                    container.className = 'mt-4';
                    
                    const label = document.createElement('label');
                    label.className = 'block mb-2 text-sm font-medium text-gray-900';
                    label.textContent = 'Pratonton Video';
                    
                    const aspectDiv = document.createElement('div');
                    aspectDiv.className = 'aspect-w-16 aspect-h-9';
                    
                    container.appendChild(label);
                    container.appendChild(aspectDiv);
                    aspectDiv.appendChild(iframe);
                    
                    // Insert after video URL input
                    document.getElementById('video_recipe').parentNode.appendChild(container);
                } else {
                    previewContainer.appendChild(iframe);
                }
            }
            
            iframe.setAttribute('src', videoUrl);
        }
    });

    // Initialize Quill Editors
    const ingredientToolbarOptions = [
        [{ 'header': [3, 4, false] }],
        ['bold', 'italic'],
        [{ 'list': 'ordered'}, { 'list': 'bullet' }],
        ['clean']
    ];

    const tutorialToolbarOptions = [
        [{ 'header': [2, 3, false] }],
        ['bold', 'italic'],
        [{ 'list': 'ordered'}, { 'list': 'bullet' }],
        ['clean']
    ];

    const ingredientEditor = new Quill('#ingredient-editor', {
        modules: {
            toolbar: ingredientToolbarOptions
        },
        theme: 'snow'
    });

    const tutorialEditor = new Quill('#tutorial-editor', {
        modules: {
            toolbar: tutorialToolbarOptions
        },
        theme: 'snow'
    });

    // Set initial content
    ingredientEditor.root.innerHTML = document.getElementById('ingredient_recipe').value;
    tutorialEditor.root.innerHTML = document.getElementById('tutorial_recipe').value;

    // Update hidden textareas before form submission
    document.getElementById('recipe-form').addEventListener('submit', function(e) {
        document.getElementById('ingredient_recipe').value = ingredientEditor.root.innerHTML;
        document.getElementById('tutorial_recipe').value = tutorialEditor.root.innerHTML;
    });
</script>

<style>
    /* Custom styles for larger image and video elements */
    #recipe-image-preview {
        max-height: 384px;
        object-fit: cover;
    }

    .aspect-w-16 {
        position: relative;
        padding-bottom: 56.25%; /* 16:9 aspect ratio */
        height: 0;
        overflow: hidden;
    }

    .aspect-w-16 iframe {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        border: 0;
    }

    /* Quill editor customizations */
    .ql-toolbar.ql-snow {
        border-top: 1px solid #ccc;
        border-left: 1px solid #ccc;
        border-right: 1px solid #ccc;
        border-bottom: none;
        border-radius: 0.5rem 0.5rem 0 0;
    }

    .ql-container.ql-snow {
        border: 1px solid #ccc;
        border-radius: 0 0 0.5rem 0.5rem;
        min-height: 200px;
    }

    #ingredient-editor, #tutorial-editor {
        min-height: 200px;
    }
</style>