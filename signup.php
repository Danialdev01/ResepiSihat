<?php $location_index = "."; include('./components/head.php');?>

<body>

    <main>
        <?php $location_index = "."; require('./components/home/nav.php')?>

        <section id="features" class="pt-20">
            <div class="min-h-screen flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8">
                <div class="w-full max-w-md space-y-8">
                    <div class="text-center">
                        <h2 class="text-3xl font-extrabold text-gray-900">
                            Daftar Akaun Baru
                        </h2>
                        <p class="mt-2 text-gray-600">
                            Sertai komuniti ResepiSihat untuk rancangan pemakanan sihat.
                        </p>
                    </div>

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

                    <div class="flex items-center">
                        <div class="flex-1 border-t border-gray-300"></div>
                        <span class="px-3 text-gray-500 text-sm">atau</span>
                        <div class="flex-1 border-t border-gray-300"></div>
                    </div>

                    <!-- Signup Form -->
                    <form class="mt-8 space-y-6" action="#" method="POST">
                        <div class="rounded-md shadow-sm space-y-4">
                            <div>
                                <label for="username" class="block text-sm font-medium text-gray-700 mb-1">Nama Pengguna</label>
                                <input id="username" name="username" type="text" required class="form-input relative block w-full px-3 py-2.5 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-lg focus:outline-none focus:ring-primary-500 focus:border-primary-500 focus:z-10 sm:text-sm" placeholder="cth: aisyahtan">
                            </div>
                            <div>
                                <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Alamat Emel</label>
                                <input id="email" name="email" type="email" autocomplete="email" required class="form-input relative block w-full px-3 py-2.5 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-lg focus:outline-none focus:ring-primary-500 focus:border-primary-500 focus:z-10 sm:text-sm" placeholder="nama@contoh.com">
                            </div>
                            <div>
                                <label for="password" class="block text-sm font-medium text-gray-700 mb-1">Kata Laluan</label>
                                <input id="password" name="password" type="password" autocomplete="current-password" required class="form-input relative block w-full px-3 py-2.5 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-lg focus:outline-none focus:ring-primary-500 focus:border-primary-500 focus:z-10 sm:text-sm" placeholder="••••••••">
                            </div>
                            <div>
                                <label for="confirm-password" class="block text-sm font-medium text-gray-700 mb-1">Sahkan Kata Laluan</label>
                                <input id="confirm-password" name="confirm-password" type="password" required class="form-input relative block w-full px-3 py-2.5 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-lg focus:outline-none focus:ring-primary-500 focus:border-primary-500 focus:z-10 sm:text-sm" placeholder="••••••••">
                            </div>
                        </div>

                        <div class="flex items-center">
                            <input id="terms" name="terms" type="checkbox" class="checkbox h-4 w-4 text-primary-600 focus:ring-primary-500 border-gray-300 rounded">
                            <label for="terms" class="ml-2 block text-sm text-gray-700">
                                Saya bersetuju dengan <a href="#" class="text-primary-600 hover:underline">Terma & Syarat</a>
                            </label>
                        </div>

                        <div>
                            <button type="submit" class="group relative w-full flex justify-center py-2.5 px-4 border border-transparent text-sm font-medium rounded-lg text-white bg-primary-600 hover:bg-primary-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500">
                                <span class="absolute left-0 inset-y-0 flex items-center pl-3">
                                    <i class="fas fa-user-plus text-primary-200"></i>
                                </span>
                                Daftar Akaun
                            </button>
                        </div>
                    </form>

                    <div class="text-center">
                        <p class="text-sm text-gray-600">
                            Sudah mempunyai akaun? 
                            <a data-modal-target="signin-modal" data-modal-toggle="signin-modal" class="cursor-pointer font-medium text-primary-600 hover:underline">Daftar Masuk</a>
                        </p>
                    </div>
                </div>
            </div>
        </section>
    </main>

    <?php $location_index='.'; include('./components/footer.php')?>
    
</body>
</html>