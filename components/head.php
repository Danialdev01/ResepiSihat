<?php 
    require_once("$location_index/config/connect.php");
    session_start();

    include "$location_index/backend/functions/csrf-token.php";
    $token = generateCSRFToken();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="<?php echo $location_index?>/src/assets/css/output.css">
    <link rel="stylesheet" href="<?php echo $location_index?>/node_modules/flowbite/dist/flowbite.min.css">
    <link rel="shortcut icon" href="<?php echo $location_index?>/src/assets/images/logo.png" type="image/x-icon">

    <!-- for chart -->
    <!-- <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script> -->
    <!-- <script src="https://cdn.jsdelivr.net/npm/apexcharts@latest/dist/apexcharts.min.js"></script> -->
    <!-- <script src="https://cdn.jsdelivr.net/npm/chart.js"></script> -->

    <!-- for datatable -->
    <!-- <link rel="stylesheet" href="https://czdn.datatables.net/2.1.4/css/dataTables.dataTables.css" /> -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
    <script src="https://cdn.datatables.net/2.1.4/js/dataTables.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/simple-datatables@9.0.3"></script>
    <!-- <script src="https://cdn.tailwindcss.com/3.3.0"></script> -->

    <!-- Include Amplitude JS Visualizations -->
    <!-- <script type="text/javascript" src="https://521dimensions.com/img/open-source/amplitudejs/visualizations/michaelbromley.js"></script> -->

    <script src="<?php echo $location_index?>/src/assets/js/selectoption.js"></script>

    <!-- <script src="https://cdn.jsdelivr.net/npm/amplitudejs@latest/dist/amplitude.min.js"></script> -->

    <style>
        @media (prefers-color-scheme: light) {
            input{
              color: black !important;
            }
        }

        [class^="select-dropdown-container-"] {
            background-color: white !important; /* Example style */
        }
    </style>
    <title>
        <?php
            if(isset($title)){echo $title;}
            else{echo $webname;}
        ?>
    </title>
    <link rel="manifest" href="<?php echo $location_index?>/manifest.json">

</head>
