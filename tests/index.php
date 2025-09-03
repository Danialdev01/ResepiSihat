<?php 
$location_index = ".."; 
include('../components/head.php');

// Assume we have a recipe ID from URL parameter
$recipe_id = isset($_GET['id']) ? intval($_GET['id']) : 0;

// Fetch recipe data from database (pseudo-code)
// For demonstration, using example data
$recipe = [
    'id_recipe' => 6,
    'id_user' => 1,
    'name_recipe' => 'Nasi goreng ikan bilis',
    'desc_recipe' => 'Nasi goreng yang penuh rasa dan sesuai untuk masa ...',
    'image_recipe' => 'https://images.unsplash.com/photo-1603360946369-dc9bb6258143?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1170&q=80',
    'category_recipe' => 'makan tengahari',
    'tags' => ['nasi', 'goreng', 'malaysia'],
    'calories_recipe' => 450,
    'cooking_time_recipe' => 30,
    'servings' => 4,
    'num_likes_recipe' => 42,
    'created_date_recipe' => '2025-07-20',
    'author_name' => 'Chef Ali',
    'ingredient_recipe' => [
        '2 cawan nasi putih',
        '2 biji telur',
        '1 cawan ikan bilis goreng',
        '3 ulas bawang putih',
        '2 sudu besar kicap',
        '1 sudu kecil garam',
        '2 sudu besar minyak masak'
    ],
    'instructions_recipe' => "Panaskan minyak dalam kuali.\nTumis bawang putih sehingga kekuningan.\nMasukkan ikan bilis dan goreng hingga rangup.\nCelah tengah, masukkan telur dan kacau.\nMasukkan nasi dan kacau rata.\nTambahkan kicap dan garam, kacau sebati.\nHidangkan panas."
];
?>

<body>
    <?php include("../components/user/header.php")?>

    <main>
        <div class="dashboard-grid">
            <?php include("../components/user/nav.php")?>
            
            <!-- Main Content -->
            <div class="main-content">
                <?php include("../components/user/top-bar.php")?>
                
                <?php include("../components/user/article-recipe.php")?>
            </div>
        </div>
        
        <!-- Mobile overlay -->
        <div class="overlay"></div>
    </main>

    <?php $location_index='..'; include('../components/footer.php')?>
    
</body>
</html>