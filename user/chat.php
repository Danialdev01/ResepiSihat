<?php
include('../config/connect.php');

// API Key Groq (ganti dengan API key Anda)
$groqApiKey = $ai_api_key;

// Get user info (assuming user is logged in and user_id is stored in session)
$userId = $_SESSION['user_id'] ?? 1; // Default to 1 for demo if not set
$userStatus = 'free'; // Default status, should be fetched from database

// Fetch user status from database
try {
    $stmt = $connect->prepare("SELECT status_user FROM users WHERE id_user = ?");
    $stmt->execute([$userId]);
    $user = $stmt->fetch();
    if ($user) {
        $userStatus = $user['status_user'] == 2 ? 'premium' : 'free';
    }
} catch (PDOException $e) {
    // Log error but continue with default status
    error_log("Error fetching user status: " . $e->getMessage());
}

// Set usage limits
$usageLimit = ($userStatus === 'premium') ? 1000 : 5; // Premium users have higher limit

// Get today's usage count - count user messages from responses table
$usageCount = 0;
try {
    $stmt = $connect->prepare("
        SELECT COUNT(*) as usage_count 
        FROM responses r
        JOIN users u ON r.id_user = u.id_user
        WHERE u.id_user = ? 
        AND r.status_response = '0'
    ");
    $stmt->execute([$userId]);
    $result = $stmt->fetch();
    $usageCount = $result['usage_count'];
} catch (PDOException $e) {
    error_log("Error fetching usage count: " . $e->getMessage());
}

// Check if user has exceeded limit
$hasExceededLimit = ($userStatus === 'free' && $usageCount >= $usageLimit);

// Get all previous messages from responses table for the user
$allMessages = [];
try {
    $stmt = $connect->prepare("
        SELECT r.text_user_response, r.text_ai_response, r.created_date_response, c.id_chat
        FROM responses r
        JOIN chats c ON r.id_chat = c.id_chat
        WHERE c.id_user = ? 
        AND r.status_response = 'active'
        ORDER BY r.created_date_response ASC
    ");
    $stmt->execute([$userId]);
    $allMessages = $stmt->fetchAll();
} catch (PDOException $e) {
    error_log("Error fetching all messages: " . $e->getMessage());
}

// Build conversation from all messages
$conversationHistory = [];
foreach ($allMessages as $message) {
    if (!empty($message['text_user_response'])) {
        $conversationHistory[] = [
            'role' => 'user',
            'content' => $message['text_user_response'],
            'timestamp' => $message['created_date_response']
        ];
    }
    if (!empty($message['text_ai_response'])) {
        $conversationHistory[] = [
            'role' => 'assistant',
            'content' => $message['text_ai_response'],
            'timestamp' => $message['created_date_response']
        ];
    }
}

// If we have a current chat in session, use it, otherwise create a new one
if (!isset($_SESSION['id_chat'])) {
    try {
        $stmt = $connect->prepare("INSERT INTO chats (id_user, title_chat, created_date_chat, status_chat) 
                                   VALUES (?, 'Percakapan Baru', NOW(), 'active')");
        $stmt->execute([$userId]);
        $_SESSION['id_chat'] = $connect->lastInsertId();
    } catch (PDOException $e) {
        error_log("Error creating new chat: " . $e->getMessage());
    }
}

// Fungsi untuk berinteraksi dengan Groq AI
function chatWithAI($messages) {
    global $groqApiKey;
    $url = 'https://api.groq.com/openai/v1/chat/completions';
    
    $data = [
        "model" => "llama-3.1-8b-instant",
        "messages" => $messages,
        "temperature" => 0.7,
        "max_tokens" => 1024,
        "top_p" => 1,
        "frequency_penalty" => 0,
        "presence_penalty" => 0
    ];

    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        'Content-Type: application/json',
        'Authorization: Bearer ' . $groqApiKey
    ]);

    $response = curl_exec($ch);
    curl_close($ch);

    return json_decode($response, true);
}

// Fungsi BARU: Ekstrak kata kunci dari percakapan
function extractKeywords($conversation) {
    global $groqApiKey;
    $url = 'https://api.groq.com/openai/v1/chat/completions';
    
    // Format percakapan untuk analisis
    $formattedConv = "";
    foreach ($conversation as $msg) {
        if ($msg['role'] == 'user') {
            $formattedConv .= "Pengguna: " . $msg['content'] . "\n";
        } else if ($msg['role'] == 'assistant') {
            $formattedConv .= "AI: " . $msg['content'] . "\n";
        }
    }
    
    $messages = [
        [
            "role" => "system",
            "content" => '
                        Pastikan output dalam Bahasa Melayu.
                        Berdasarkan input pengguna, pastikan kata kunci tersebut mempunyai kaitan dengan percakapan pengguna.
                        Fokus pada: bahan utama, jenis masakan, kategori (contoh: ayam, sayur, rendah kalori, vegetarian, makanan Itali). 
                        Keluarkan HANYA kata kunci penting dalam bentuk senarai dipisahkan koma.
                        Berikan jenis bahan yang terlibat, jenis kategori makanan, kata kunci makanan, dan jenis makanan.

                        Contoh sekiranya makanan tinggi kalori ("berikan saya contoh resepi yang berasaskan ayam"): MAKA output tersebut akan menjadi "ayam, tinggi protein, makanan tengahhari, protein"

                        Contoh sekiranya makanan rendah kalori ("berikan saya contoh resepi yang boleh merendahkan berat badan"): "salad, rendah kalori, makanan tengahhari, sayur"

                        Contoh sekiranya makanan mengikut kaedah masakan ("berikan saya contoh resepi melibatkan kaedah goreng"): "goreng, makanan tengahhari"

                        Contoh sekiranya makanan mengikut jenis bahan ("berikan saya contoh resepi nasi"): "nasi, makanan tengahhari, kabohidrat"

                        Sekiranya pengguna masukkan input "Saya hendak kuruskan badan, apa contoh resepi yang sesuai" MAKA output "salad, sayuran, rendah kalori"

                        Sekiranya pengguna masukkan input "Saya hendak bina badan, apa contoh resepi yang sesuai" MAKA output "ayam, ikan, tinggi kalori"

                        PENTING: Berikan kata kunci dalam bentuk perkataan SAHAJA.
                        JANGAN libatkan cara pemasakan KECUALI sekiranya pengguna menyatakan ia secara spesifik.
                        PENTING: Hanya berikan output dalam bentuk perkataan kecil seperti contoh : "ayam, tinggi kalori, ikan,"
                        PASTIKAN Bahan utama terdapat dalam kata kunci utama.
                        SEKIRANYA pengguna tidak menyatakan spesifik kaedah masakan seperti goreng MAKA JANGAN letakkan kaedah masakan sebagai kata kunci seperti goreng, rebus.
                        CONTOH YANG SALAH : "rendah kalori * protein" ATAU " makanan tengahhari * nasi " pastikan kata kunci tersebut dalam bentuk perkataan seperti "nasi, makanan tengahhari, kabohidrat"
                        PASTIKAN di dalam output tiada simbol lain seperti * atau \ atau "
                        '
        ],
        [
            "role" => "user",
            "content" => "Dari percakapan berikut, ekstrak 3-5 kata kunci utama untuk pencarian resepi:\n\n" . $formattedConv
        ]
    ];

    $data = [
        "model" => "llama-3.1-8b-instant",
        "messages" => $messages,
        "temperature" => 0.333,
        "max_tokens" => 100,
        "top_p" => 1,
        "frequency_penalty" => 0,
        "presence_penalty" => 0
    ];

    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        'Content-Type: application/json',
        'Authorization: Bearer ' . $groqApiKey
    ]);

    $response = curl_exec($ch);
    curl_close($ch);

    $result = json_decode($response, true);
    $keywords = $result['choices'][0]['message']['content'] ?? '';
    
    // Bersihkan dan format kata kunci
    $keywords = str_replace(['.', '"', "'"], '', $keywords);
    $keywords = explode(',', $keywords);
    $keywords = array_map('trim', $keywords);
    $keywords = array_filter($keywords);
    
    return array_slice($keywords, 0, 5); // Ambil maksimal 5 kata kunci
}

// Fungsi untuk mencari resepi berdasarkan kata kunci
function searchRecipesByKeywords($keywords) {
    global $connect;
    
    if (empty($keywords)) return [];
    
    $where = [];
    $params = [];
    
    foreach ($keywords as $keyword) {
        if (strlen($keyword) > 2) {
            $where[] = "(name_recipe LIKE ? OR desc_recipe LIKE ? OR ingredient_recipe LIKE ? OR category_recipe LIKE ?)";
            $params[] = "%$keyword%";
            $params[] = "%$keyword%";
            $params[] = "%$keyword%";
            $params[] = "%$keyword%";
        }
    }
    
    if (empty($where)) return [];
    
    $sql = "SELECT * FROM recipes WHERE (" . implode(' OR ', $where) . ") LIMIT 10";
    $stmt = $connect->prepare($sql);
    $stmt->execute($params);
    
    return $stmt->fetchAll();
}

// Tangani pengiriman pesan via AJAX
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action'])) {
    $action = $_POST['action'];
    
    if ($action === 'send_message' && isset($_POST['message'])) {
        // Check if user has exceeded their usage limit
        if ($hasExceededLimit) {
            header('Content-Type: application/json');
            echo json_encode([
                'success' => false,
                'error' => 'Anda telah mencapai had penggunaan percuma untuk hari ini. Sila naik taraf ke akaun premium untuk terus menggunakan perkhidmatan ini.'
            ]);
            exit;
        }
        
        $userMessage = trim($_POST['message']);
        
        if (!empty($userMessage)) {
            // Build conversation for AI
            $conversationForAI = [
                [
                    'role' => 'system',
                    'content' => '...' // system message content
                ]
            ];
            
            // Add previous messages to context
            foreach ($conversationHistory as $msg) {
                $conversationForAI[] = ['role' => $msg['role'], 'content' => $msg['content']];
            }
            
            // Add current user message
            $conversationForAI[] = ['role' => 'user', 'content' => $userMessage];
            
            // Kirim pesan ke AI
            $response = chatWithAI($conversationForAI);
            
            // Dapatkan respons AI
            if (isset($response['choices'][0]['message']['content'])) {
                $aiResponse = $response['choices'][0]['message']['content'];
                
                // EKSTRAK KATA KUNCI DARI PERCAKAPAN
                $keywords = extractKeywords($conversationForAI);
                
                // Cari resepi berdasarkan kata kunci
                $recipes = searchRecipesByKeywords($keywords);
                
                // Simpan ke database
                try {
                    // Simpan pesan dan respons
                    $stmt = $connect->prepare("INSERT INTO responses (id_chat, text_user_response, text_ai_response, created_date_response, status_response) 
                                           VALUES (?, ?, ?, NOW(), 'active')");
                    $stmt->execute([$_SESSION['id_chat'], $userMessage, $aiResponse]);
                    
                    // Update usage count - increment by 1 for the new message
                    $usageCount++;
                    $hasExceededLimit = ($userStatus === 'free' && $usageCount >= $usageLimit);
                    
                } catch (PDOException $e) {
                    // Tangani error
                    $aiResponse .= "\n\n[Error: Gagal menyimpan ke database]";
                }
                
                // Return response dalam format JSON
                header('Content-Type: application/json');
                echo json_encode([
                    'success' => true,
                    'aiResponse' => nl2br(htmlspecialchars($aiResponse)),
                    'keywords' => $keywords,
                    'recipes' => $recipes,
                    'usageCount' => $usageCount,
                    'usageLimit' => $usageLimit,
                    'hasExceededLimit' => $hasExceededLimit
                ]);
                exit;
            } else {
                header('Content-Type: application/json');
                echo json_encode([
                    'success' => false,
                    'error' => 'Maaf, terjadi kesalahan saat memproses permintaan Anda.'
                ]);
                exit;
            }
        }
    }
    elseif ($action === 'reset_chat') {
        // Reset percakapan dengan membuat chat baru
        try {
            $stmt = $connect->prepare("INSERT INTO chats (id_user, title_chat, created_date_chat, status_chat) 
                                       VALUES (?, 'Percakapan Baru', NOW(), 'active')");
            $stmt->execute([$userId]);
            $_SESSION['id_chat'] = $connect->lastInsertId();
        } catch (PDOException $e) {
            error_log("Error creating new chat: " . $e->getMessage());
        }
        
        // Return response reset
        header('Content-Type: application/json');
        echo json_encode([
            'success' => true,
            'message' => 'Percakapan telah direset'
        ]);
        exit;
    }
}
?>

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
                        <div class="min-h-screen flex flex-col">
                    
                            <!-- Main Content -->
                            <main class="flex-grow container mx-auto px-4 py-8">
                                <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                                    <!-- Chat Section -->
                                    <div class="lg:col-span-2 bg-white rounded-xl shadow-lg p-6">
                                        
                                        <div class="bg-gray-100 rounded-xl p-4 mb-6">
                                            <!-- Usage Counter -->
                                            <div class="usage-counter flex justify-between items-center mb-4 px-2">
                                                <div class="text-sm text-gray-600">
                                                    <?php if ($userStatus === 'free'): ?>
                                                        <span id="usage-text">Penggunaan: <?php echo $usageCount; ?>/<?php echo $usageLimit; ?></span>
                                                    <?php else: ?>
                                                        <span id="usage-text">Penggunaan: <?php echo $usageCount; ?> (Tidak Terhad - Premium)</span>
                                                    <?php endif; ?>
                                                </div>
                                                <?php if ($hasExceededLimit): ?>
                                                    <div class="text-sm text-red-600 font-medium">
                                                        Had harian dicapai. <a href="../premium/upgrade.php" class="underline">Naik Taraf</a>
                                                    </div>
                                                <?php endif; ?>
                                            </div>
                                            
                                            <div class="chat-container overflow-y-auto scrollbar-hidden max-h-[500px] pr-2" id="chat-messages">
                                                <?php if (empty($conversationHistory)): ?>
                                                    <div class="text-center py-10">
                                                        <div class="inline-block bg-gray-200 rounded-full p-4 mb-4">
                                                            <i class="fas fa-robot text-4xl text-primary"></i>
                                                        </div>
                                                        <h3 class="text-xl font-bold text-gray-700">Hai, saya AI Penasihat pemakanan anda !</h3>
                                                        <p class="text-gray-600 mt-2">Sila sampaikan keperluan resepi anda. Contoh:</p>
                                                        <div class="mt-4 grid grid-cols-1 sm:grid-cols-2 gap-3">
                                                            <div class="bg-white rounded-lg p-3 text-sm shadow">
                                                                "Resepi sarapan tinggi protein"
                                                            </div>
                                                            <div class="bg-white rounded-lg p-3 text-sm shadow">
                                                                "Makan tengah hari rendah kalori dengan ayam"
                                                            </div>
                                                            <div class="bg-white rounded-lg p-3 text-sm shadow">
                                                                "Resepi vegetarian untuk pemula"
                                                            </div>
                                                            <div class="bg-white rounded-lg p-3 text-sm shadow">
                                                                "Makanan penutup sihat tanpa gula"
                                                            </div>
                                                        </div>
                                                    </div>
                                                <?php else: ?>
                                                    <?php foreach ($conversationHistory as $msg): ?>
                                                        <div class="mb-4">
                                                            <?php if ($msg['role'] === 'user'): ?>
                                                                <div class="flex justify-end mb-2">
                                                                    <div class="bg-primary-500 text-white px-4 py-3 rounded-xl rounded-br-none max-w-[80%]">
                                                                        <?= nl2br(htmlspecialchars($msg['content'])) ?>
                                                                        <div class="text-xs text-primary-200 mt-1 text-right">
                                                                            <?= date('H:i', strtotime($msg['timestamp'])) ?>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            <?php else: ?>
                                                                <div class="flex items-start mb-2">
                                                                    <div class="bg-gray-200 rounded-full p-2 mr-3">
                                                                        <i class="fas fa-robot text-primary text-xl"></i>
                                                                    </div>
                                                                    <div class="bg-white px-4 py-3 rounded-xl rounded-bl-none max-w-[80%] shadow-sm">
                                                                        <?= nl2br(htmlspecialchars($msg['content'])) ?>
                                                                        <div class="text-xs text-gray-500 mt-1">
                                                                            <?= date('H:i', strtotime($msg['timestamp'])) ?>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            <?php endif; ?>
                                                        </div>
                                                    <?php endforeach; ?>
                                                <?php endif; ?>
                                            </div>
                                            
                                            <form id="chat-form" class="mt-6">
                                                <div class="flex">
                                                    <input type="text" id="user-message" name="message" placeholder="Ketik permintaan resepi anda..." 
                                                           class="flex-grow px-4 py-3 rounded-l-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent" 
                                                           <?= $hasExceededLimit ? 'disabled' : '' ?> required>
                                                    <button type="submit" id="send-button" class="bg-primary-500 hover:bg-secondary-500 text-white px-6 rounded-r-lg transition"
                                                        <?= $hasExceededLimit ? 'disabled' : '' ?>>
                                                        <i class="fas fa-paper-plane"></i>
                                                    </button>
                                                </div>
                                                <p class="text-gray-500 text-sm mt-2">Contoh: "Resepi makan tengah hari rendah kalori dengan ayam"</p>
                                            </form>
                                        </div>
                                    </div>
                                    
                                    <!-- Recipe Results & Keywords -->
                                    <div class="bg-white rounded-xl shadow-lg p-6">
                                        <!-- Keywords Section -->
                                        <div id="keywords-section"></div>
                                        
                                        <!-- Recipe Results -->
                                        <h2 class="text-xl font-bold text-gray-800 mb-6">Rekomendasi Resepi</h2>
                                        <div id="recipe-results" class="recipe-results">
                                            <div class="text-center py-10">
                                                <div class="inline-block bg-gray-100 rounded-full p-4 mb-4">
                                                    <i class="fas fa-utensils text-3xl text-primary"></i>
                                                </div>
                                                <h3 class="text-lg font-bold text-gray-700">Rekomendasi Resepi</h3>
                                                <p class="text-gray-600 mt-2">Resepi yang disyorkan akan muncul di sini</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </main>
                    
                        </div>
                        
                    </div>
                </div>
            </div>
        </main>
    
        <script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.3.0/flowbite.min.js"></script>
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script>
            $(document).ready(function() {
                // Fungsi untuk scroll ke bawah di chat container
                function scrollChatToBottom() {
                    const chatContainer = $('#chat-messages');
                    chatContainer.scrollTop(chatContainer[0].scrollHeight);
                }
                
                // Fungsi untuk menampilkan animasi loading
                function showLoading() {
                    return `
                        <div class="flex items-start mb-2">
                            <div class="bg-gray-200 rounded-full p-2 mr-3">
                                <i class="fas fa-robot text-primary text-xl"></i>
                            </div>
                            <div class="bg-white px-4 py-3 rounded-xl rounded-bl-none max-w-[80%] shadow-sm">
                                <div class="loading-dots">
                                    <span></span>
                                    <span></span>
                                    <span></span>
                                </div>
                            </div>
                        </div>
                    `;
                }
                
                // Fungsi untuk menampilkan pesan pengguna
                function appendUserMessage(message) {
                    const now = new Date();
                    const timeString = now.getHours().toString().padStart(2, '0') + ':' + now.getMinutes().toString().padStart(2, '0');
                    
                    const messageHtml = `
                        <div class="mb-4">
                            <div class="flex justify-end mb-2">
                                <div class="bg-primary-500 text-white px-4 py-3 rounded-xl rounded-br-none max-w-[80%]">
                                    ${message}
                                    <div class="text-xs text-primary-200 mt-1 text-right">${timeString}</div>
                                </div>
                            </div>
                        </div>
                    `;
                    $('#chat-messages').append(messageHtml);
                    scrollChatToBottom();
                }
                
                // Fungsi untuk menampilkan pesan AI
                function appendAiMessage(message) {
                    const now = new Date();
                    const timeString = now.getHours().toString().padStart(2, '0') + ':' + now.getMinutes().toString().padStart(2, '0');
                    
                    const messageHtml = `
                        <div class="mb-4">
                            <div class="flex items-start mb-2">
                                <div class="bg-gray-200 rounded-full p-2 mr-3">
                                    <i class="fas fa-robot text-primary text-xl"></i>
                                </div>
                                <div class="bg-white px-4 py-3 rounded-xl rounded-bl-none max-w-[80%] shadow-sm">
                                    ${message}
                                    <div class="text-xs text-gray-500 mt-1">${timeString}</div>
                                </div>
                            </div>
                        </div>
                    `;
                    $('#chat-messages').append(messageHtml);
                    scrollChatToBottom();
                }
                
                // Fungsi untuk menampilkan kata kunci
                function updateKeywords(keywords) {
                    if (keywords.length === 0) return;
                    
                    let badges = '';
                    keywords.forEach(keyword => {
                        badges += `
                            <a href="./resepi/komuniti.php?search=${keyword}">
                                <span class="keyword-badge bg-blue-100 text-blue-800 px-3 py-1 rounded-full text-sm flex items-center">
                                    <i class="fas fa-tag mr-1 text-xs"></i> ${keyword}
                                </span>
                            </a>
                        `;
                    });
                    
                    const html = `
                        <div class="mb-6">
                            <div class="flex justify-between items-center mb-3">
                                <h2 class="text-lg font-bold text-gray-800">Kata Kunci Pencarian</h2>
                                <span class="bg-primary-500 text-white text-xs px-2 py-1 rounded-full">
                                    ${keywords.length} ditemui
                                </span>
                            </div>
                            <div class="flex flex-wrap gap-2">
                                ${badges}
                            </div>
                        </div>
                    `;
                    
                    $('#keywords-section').html(html);
                }
                
                // Fungsi untuk menampilkan resepi
                function updateRecipes(recipes) {
                    if (recipes.length === 0) {
                        $('#recipe-results').html(`
                            <div class="text-center py-10">
                                <div class="inline-block bg-gray-100 rounded-full p-4 mb-4">
                                    <i class="fas fa-search text-3xl text-primary"></i>
                                </div>
                                <h3 class="text-lg font-bold text-gray-700">Resepi tidak ditemui</h3>
                                <p class="text-gray-600 mt-2">Sila cuba dengan kata kunci yang berbeza</p>
                            </div>
                        `);
                        return;
                    }
                    
                    let recipeCards = '';
                    recipes.forEach(recipe => {
                        recipeCards += `
                            <div class="recipe-card border border-gray-200 rounded-xl overflow-hidden hover:shadow-md">
                                <div class="bg-gray-200 border-2 border-dashed rounded-xl w-full h-48 flex items-center justify-center text-gray-400">
                                    <i class="fas fa-image text-4xl"></i>
                                </div>
                                <div class="p-4">
                                    <div class="flex justify-between items-start">
                                        <h3 class="font-bold text-lg text-gray-800">${recipe.name_recipe}</h3>
                                        <span class="bg-green-100 text-green-800 text-xs font-medium px-2.5 py-0.5 rounded-full">
                                            ${recipe.calories_recipe} kkal
                                        </span>
                                    </div>
                                    <p class="text-gray-600 text-sm mt-2">${recipe.desc_recipe.substring(0, 100)}...</p>
                                    
                                    <div class="flex justify-between mt-4 text-sm">
                                        <div>
                                            <i class="fas fa-clock text-gray-500 mr-1"></i>
                                            <span>${recipe.cooking_time_recipe} minit</span>
                                        </div>
                                        <div>
                                            <i class="fas fa-heart text-red-500 mr-1"></i>
                                            <span>${recipe.num_likes_recipe} suka</span>
                                        </div>
                                    </div>
                                    
                                    <div class="mt-4">
                                        <button class="w-full bg-primary hover:bg-secondary text-white py-2 rounded-lg transition flex items-center justify-center">
                                            <i class="fas fa-book-open mr-2"></i> Lihat Resepi Lengkap
                                        </button>
                                    </div>
                                </div>
                            </div>
                        `;
                    });
                    
                    $('#recipe-results').html(`
                        <div class="space-y-6">
                            ${recipeCards}
                        </div>
                    `);
                }
                
                // Event untuk mengirim pesan
                $('#chat-form').on('submit', function(e) {
                    e.preventDefault();
                    const message = $('#user-message').val().trim();
                    if (!message) return;
                    
                    // Tampilkan pesan pengguna
                    appendUserMessage(message);
                    
                    // Tampilkan animasi loading
                    const loadingHtml = showLoading();
                    $('#chat-messages').append(loadingHtml);
                    scrollChatToBottom();
                    
                    // Reset input
                    $('#user-message').val('');
                    
                    // Kirim permintaan AJAX
                    $.ajax({
                        url: '<?php echo $_SERVER['PHP_SELF']; ?>',
                        type: 'POST',
                        data: {
                            action: 'send_message',
                            message: message
                        },
                        dataType: 'json',
                        success: function(response) {
                            // Hapus animasi loading
                            $('.loading-dots').closest('.mb-4').remove();
                            
                            if (response.success) {
                                // Tampilkan respons AI
                                appendAiMessage(response.aiResponse);
                                
                                // Tampilkan kata kunci
                                updateKeywords(response.keywords);
                                
                                // Tampilkan resepi
                                updateRecipes(response.recipes);
                                
                                // Update usage counter
                                if (response.hasExceededLimit) {
                                    $('#usage-text').html('Penggunaan: ' + response.usageCount + '/' + response.usageLimit);
                                    $('#user-message').prop('disabled', true);
                                    $('#send-button').prop('disabled', true);
                                    $('#chat-form').after(
                                        '<div class="mt-4 p-3 bg-red-100 text-red-700 rounded-lg text-sm">' +
                                        'Anda telah mencapai had penggunaan percuma untuk hari ini. ' +
                                        '<a href="../premium/upgrade.php" class="font-medium underline">Naik taraf ke premium</a> untuk terus menggunakan.' +
                                        '</div>'
                                    );
                                } else {
                                    $('#usage-text').text('Penggunaan: ' + response.usageCount + '/' + response.usageLimit);
                                }
                            } else {
                                appendAiMessage(response.error);
                            }
                        },
                        error: function() {
                            // Hapus animasi loading
                            $('.loading-dots').closest('.mb-4').remove();
                            
                            appendAiMessage('Maaf, terjadi kesalahan saat memproses permintaan Anda.');
                        }
                    });
                });
                
                // Event untuk reset chat
                $('#reset-chat').on('click', function() {
                    $.ajax({
                        url: '<?php echo $_SERVER['PHP_SELF']; ?>',
                        type: 'POST',
                        data: {
                            action: 'reset_chat'
                        },
                        dataType: 'json',
                        success: function(response) {
                            if (response.success) {
                                // Reload the page to show empty chat
                                location.reload();
                            }
                        }
                    });
                });
                
                // Auto-scroll ke bawah saat halaman dimuat
                scrollChatToBottom();
            });
        </script>
</body>
</html>