<?php

    include("$location_index/backend/functions/system.php");
    include("$location_index/backend/functions/user.php");
    include("$location_index/backend/models/user.php");

    // include("$location_index/backend/functions/points.php");
    // include("$location_index/backend/models/points.php");

    $verify = verifySessionUser($token_name, $secret_key, $connect);

    $verify = json_decode($verify, true);

    if($verify['status'] != "success"){
        
        //TODO betulkan
        // header("Location:$location_index/");
        echo "<script>window.location.href = '../'</script>";
        alert_message("error", "User Not Logged In");
    }

    $user_value = decryptUser($_SESSION[$token_name], $secret_key);
    $id_user = $user_value['id_user'];

    $user_sql = $connect->prepare("SELECT * FROM users WHERE id_user = :id_user");
    $user_sql->execute([
        ":id_user" => $id_user
    ]);
    $user = $user_sql->fetch(PDO::FETCH_ASSOC);
?>

<style>
    .dashboard-grid {
            display: grid;
            grid-template-columns: 260px 1fr;
            min-height: 100vh;
        }
        
        @media (max-width: 768px) {
            .dashboard-grid {
                grid-template-columns: 1fr;
            }
            .sidenav {
                transform: translateX(-100%);
                position: fixed;
                z-index: 50;
                height: 100vh;
                transition: transform 0.3s ease;
            }
            .sidenav.active {
                transform: translateX(0);
            }
            .overlay {
                display: none;
                position: fixed;
                top: 0;
                left: 0;
                right: 0;
                bottom: 0;
                background: rgba(0,0,0,0.5);
                z-index: 40;
            }
            .overlay.active {
                display: block;
            }
        }
        
        .nav-link {
            transition: all 0.3s ease;
            border-left: 3px solid transparent;
        }
        
        .nav-link:hover, .nav-link.active {
            background-color: #f0fdf4;
            border-left-color: #22c55e;
            color: #166534;
        }
        
        .nav-link:hover i, .nav-link.active i {
            color: #22c55e;
        }
        
        .card {
            transition: all 0.3s ease;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05), 0 2px 4px -1px rgba(0, 0, 0, 0.03);
        }
        
        .card:hover {
            transform: translateY(-3px);
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.07), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
        }
        
        .progress-bar {
            height: 8px;
            border-radius: 4px;
            overflow: hidden;
        }
        
        .progress-fill {
            height: 100%;
            background-color: #22c55e;
            transition: width 0.5s ease;
        }
        
        .meal-card {
            transition: all 0.3s ease;
            overflow: hidden;
        }
        
        .meal-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1);
        }
        
        .meal-card:hover img {
            transform: scale(1.05);
        }
        
        .meal-card img {
            transition: transform 0.5s ease;
        }
        
        .badge {
            display: inline-block;
            padding: 3px 8px;
            border-radius: 12px;
            font-size: 0.75rem;
            font-weight: 600;
        }
        
        .badge-primary {
            background-color: #dcfce7;
            color: #166534;
        }
        
        .badge-secondary {
            background-color: #fef3c7;
            color: #92400e;
        }
        
        .notification-dot {
            position: absolute;
            top: 8px;
            right: 8px;
            width: 10px;
            height: 10px;
            border-radius: 50%;
            background-color: #ef4444;
        }
</style>


<?php include  $location_index ."/components/alert.php";?>
<?php include  $location_index ."/components/user/modals.php";?>