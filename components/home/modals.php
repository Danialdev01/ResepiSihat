<!-- Main modal -->
<div id="signin-modal" tabindex="-1" aria-hidden="true" class="fixed top-0 left-0 right-0 z-50 hidden w-full p-4 overflow-x-hidden overflow-y-auto md:inset-0 h-[calc(100%-1rem)] max-h-full">
    <div class="relative w-full max-w-md max-h-full mx-auto">
        <!-- Modal content -->
        <div class="modal-content relative bg-white rounded-lg shadow">
            <!-- Close button -->
            <button type="button" class="absolute top-3 right-2.5 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center" data-modal-hide="signin-modal">
                <i class="fas fa-times"></i>
                <span class="sr-only">Close modal</span>
            </button>
            
            <!-- Modal header -->
            <div class="px-6 py-4 border-b">
                <h3 class="text-xl font-semibold text-gray-900">
                    Daftar Masuk ke Akaun Anda
                </h3>
            </div>
            
            <!-- Modal body -->
            <div class="px-6 py-6">
                <!-- Google login button -->
                <?php 
                    include("./backend/functions/google-login.php");
                    $google_login_url = generateGoogleUrl($clientId, $clientSecret, $redirectUri);
                ?>
                <center>
                    <a href="<?php echo $google_login_url?>">
                        <button type="button" class="text-white bg-primary-600 hover:bg-primary-700 focus:ring-4 focus:outline-none focus:ring-[#4285F4]/50 font-medium rounded-lg text-sm px-5 py-2.5 text-center inline-flex items-center dark:focus:ring-[#4285F4]/55 me-2 mb-2">
                            <svg class="w-4 h-4 me-2" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 18 19">
                            <path fill-rule="evenodd" d="M8.842 18.083a8.8 8.8 0 0 1-8.65-8.948 8.841 8.841 0 0 1 8.8-8.652h.153a8.464 8.464 0 0 1 5.7 2.257l-2.193 2.038A5.27 5.27 0 0 0 9.09 3.4a5.882 5.882 0 0 0-.2 11.76h.124a5.091 5.091 0 0 0 5.248-4.057L14.3 11H9V8h8.34c.066.543.095 1.09.088 1.636-.086 5.053-3.463 8.449-8.4 8.449l-.186-.002Z" clip-rule="evenodd"/>
                            </svg>
                            Sign in dengan Google
                        </button>
                    </a>
                </center>
                
                <div class="flex items-center mb-6">
                    <div class="flex-1 border-t border-gray-300"></div>
                    <span class="px-3 text-gray-500 text-sm">atau</span>
                    <div class="flex-1 border-t border-gray-300"></div>
                </div>
                
                <!-- Email/Password form -->
                <form method="post" action="<?php echo $location_index?>/backend/user.php" class="space-y-4">
                    <input type="hidden" name="token" value="<?php echo $token?>">
                    <div>
                        <label for="email" class="block mb-2 text-sm font-medium text-gray-900">Emel atau Nama Pengguna</label>
                        <input type="text" name="email" id="email" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5" placeholder="nama@contoh.com" required>
                    </div>
                    <div>
                        <label for="password" class="block mb-2 text-sm font-medium text-gray-900">Kata Laluan</label>
                        <input type="password" name="password" id="password" placeholder="••••••••" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5" required>
                    </div>
                    <div class="flex justify-between items-center">
                        <div class="flex items-start">
                            <div class="flex items-center h-5">
                                <input id="remember" type="checkbox" class="w-4 h-4 border border-gray-300 rounded bg-gray-50 focus:ring-3 focus:ring-primary-300">
                            </div>
                            <label for="remember" class="ml-2 text-sm text-gray-700">Ingat saya</label>
                        </div>
                        <a href="#" class="text-sm text-primary-600 hover:underline">Lupa kata laluan?</a>
                    </div>
                    <button type="submit" class="w-full text-white bg-primary-600 hover:bg-primary-700 focus:ring-4 focus:outline-none focus:ring-primary-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center">
                        Daftar Masuk
                    </button>
                </form>
            </div>
            
            <!-- Modal footer -->
            <div class="px-6 py-4 border-t border-gray-200 rounded-b-lg text-center">
                <p class="text-sm text-gray-700">
                    Belum mempunyai akaun? 
                    <a href="<?php echo $location_index?>/signup.php" class="text-primary-600 hover:underline font-medium">Daftar di sini</a>
                </p>
            </div>
        </div>
    </div>
</div>