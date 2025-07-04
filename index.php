<?php $location_index = "."; include('./components/head.php');?>

<body>
    <?php 

        if(isset($_SESSION[$token_name]) || isset($_COOKIE[$token_name])){

            include("./backend/functions/system.php");
            include("./backend/functions/user.php");
            include("./backend/models/user.php");

            $verify = verifySessionUser($token_name, $secret_key, $connect);
    
            $verify = json_decode($verify, true);
    
            if($verify['status'] == "success"){
    
                $user_value = decryptUser($_SESSION[$token_name], $secret_key);
                $id_user = $user_value['id_user'];
        
                $user_sql = $connect->prepare("SELECT * FROM users WHERE id_user = :id_user");
                $user_sql->execute([
                    ":id_user" => $id_user
                ]);
                $user = $user_sql->fetch(PDO::FETCH_ASSOC);
        
                if($user['status_user'] == 2){
                    header("Location:./user/");
                    $_SESSION[$token_name . "type"] = "admin";
                }
    
                elseif($user['status_user'] == 1){
                    header("Location:./guest/");
                    $_SESSION[$token_name . "type"] = "user";
                }
            }
        }

        include("./backend/functions/google-login.php");
        $google_login_url = generateGoogleUrl($clientId, $clientSecret, $redirectUri);
    ?>
        <?php include "./components/alert.php";?>

    <main>
        <center>
            <section class="text-left max-w-4xl">
                <div class="flex flex-col items-center justify-center px-6 py-8 mx-auto md:h-screen lg:py-0">
                    <div class="w-full bg-white rounded-lg shadow dark:border md:mt-0 sm:max-w-md xl:p-0 dark:bg-gray-800 dark:border-gray-700">
                        <div class="p-6 space-y-4 md:space-y-6 sm:p-8">
                            <h1 class="text-xl font-bold leading-tight tracking-tight text-gray-900 md:text-2xl dark:text-white">
                                Log In
                            </h1>
                            <form class="space-y-4 md:space-y-6" action="./backend/user.php" method="post">
                                <input type="hidden" name="token" value="<?php echo $token?>">
                                <div>
                                    <label for="email_user" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Email</label>
                                    <input type="email" name="email_user" id="email_user" class="bg-gray-50 border border-gray-300 text-gray-900 rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="name@domain.com" required="">
                                </div>
                                <div>
                                    <label for="password_user" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Password</label>
                                    <input type="password" name="password_user" id="password_user" placeholder="••••••••" class="bg-gray-50 border border-gray-300 text-gray-900 rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" required="">
                                </div>
                                <div class="flex items-center justify-between">
                                    <div class="flex items-start">
                                        <div class="flex items-center h-5">
                                            <input id="remember" aria-describedby="remember" type="checkbox" class="w-4 h-4 border border-gray-300 rounded bg-gray-50 focus:ring-3 focus:ring-primary-300 dark:bg-gray-700 dark:border-gray-600 dark:focus:ring-primary-600 dark:ring-offset-gray-800">
                                        </div>
                                        <div class="ml-3 text-sm">
                                            <label for="remember" class="text-gray-500 dark:text-gray-300">Remember me</label>
                                        </div>
                                    </div>
                                    <a href="#" class="text-sm font-medium text-primary-600 hover:underline dark:text-primary-500">Forgot password?</a>
                                </div>
                                <button name="signin" type="submit" class="w-full text-white bg-primary-600 hover:bg-primary-700 focus:ring-4 focus:outline-none focus:ring-primary-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-primary-600 dark:hover:bg-primary-700 dark:focus:ring-primary-800">Sign in</button>
                                <center>
                                    <a href="<?php echo $google_login_url?>">
                                        <button type="button" class="text-white bg-[#4285F4] hover:bg-[#4285F4]/90 focus:ring-4 focus:outline-none focus:ring-[#4285F4]/50 font-medium rounded-lg text-sm px-5 py-2.5 text-center inline-flex items-center dark:focus:ring-[#4285F4]/55 me-2 mb-2">
                                            <svg class="w-4 h-4 me-2" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 18 19">
                                            <path fill-rule="evenodd" d="M8.842 18.083a8.8 8.8 0 0 1-8.65-8.948 8.841 8.841 0 0 1 8.8-8.652h.153a8.464 8.464 0 0 1 5.7 2.257l-2.193 2.038A5.27 5.27 0 0 0 9.09 3.4a5.882 5.882 0 0 0-.2 11.76h.124a5.091 5.091 0 0 0 5.248-4.057L14.3 11H9V8h8.34c.066.543.095 1.09.088 1.636-.086 5.053-3.463 8.449-8.4 8.449l-.186-.002Z" clip-rule="evenodd"/>
                                            </svg>
                                            Sign in with Google
                                        </button>
                                    </a>
                                </center>
                                <p class="text-sm font-light text-gray-500 dark:text-gray-400">
                                    Don't have an account yet? <a href="./signup.php" class="font-medium text-primary-600 hover:underline dark:text-primary-500">Sign up</a>
                                </p>
                            </form>
                        </div>
                    </div>
                </div>
            </section>
        </center>
    </main>

    <?php $location_index='.'; include('./components/footer.php')?>
    
</body>
</html>