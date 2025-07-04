<script src="https://cdn.jsdelivr.net/npm/flowbite@3.1.2/dist/flowbite.min.js"></script>
<script src="<?php echo $location_index?>/src/assets/js/preline.js"></script>

<script type="module">
    // Import the functions you need from the SDKs you need
    import { initializeApp } from "https://www.gstatic.com/firebasejs/10.7.1/firebase-app.js";
    import { getMessaging, getToken } from "https://www.gstatic.com/firebasejs/10.7.1/firebase-messaging.js";

    const firebaseConfig = {
        apiKey: "AIzaSyDbHbhlD3d26Lh8Y3czT-HX-_S9j6WbHBs",
        authDomain: "danial-dwa.firebaseapp.com",
        projectId: "danial-dwa",
        storageBucket: "danial-dwa.firebasestorage.app",
        messagingSenderId: "191915090507",
        appId: "1:191915090507:web:ac2c85de6b55f8e00b23ce",
        measurementId: "G-L5T278KECV"
    };


    // Initialize Firebase
    const app = initializeApp(firebaseConfig);
    const messaging = getMessaging(app);

    <?php

    //Verify User
    $verify = verifySessionUser($token_name, $secret_key, $connect);

        $verify = json_decode($verify, true);
        $id_user = NULL;
        if($verify['status'] == "success"){

            $user_value = decryptUser($_SESSION[$token_name], $secret_key);
            $id_user = $user_value['id_user'];
        }

    ?>

    navigator.serviceWorker.register("<?php echo $location_index?>/sw.js").then(registration => {

        <?php if($verify['status'] == "success"){?>
        getToken(messaging, {
            // register and create token
            serviceWorkerRegistration: registration,
            vapidKey: 'BGQ-u02J1uKMGV7IoDAFbr1uRuhvTIc3yDFFaXETqYf0LBFqtw5FoY596TWP5ZnlkVcNalScJjWeKE-uNqIHh8M' }).then((currentToken) => {
            if (currentToken) {
                // console.log("Token is: "+currentToken);

                // Save token 
                fetch('<?php echo $location_index?>/backend/requests/save_token.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                    },
                    body: JSON.stringify({ 
                        user_device_token: currentToken,
                        user_session_token: '<?php echo $_SESSION[$token_name]; ?>' 
                    })
                })
                .then(response => {
                    if (!response.ok) {
                        return response.text().then(text => {
                            throw new Error(`Server error: ${text}`);
                        });
                    }
                    return response.json();
                })
                .then(data => console.log('Success:', data))
                .catch(error => {
                    console.error('Error:' + error);
                    // You can show a user-friendly message here if needed
                });
            } else {
                // Show permission request UI
                console.log('No registration token available. Request permission to generate one.');
                // ...
            }
        }).catch((err) => {
            console.log('An error occurred while retrieving token. ', err);
            // ...
        });
        <?php }?>
    });

</script>