<?php $location_index = ".."; include('../components/head.php');?>

<body>
    <?php include("../components/user/header.php")?>

    <div class="p-4 sm:ml-64">
        <div class="p-4 border-2 border-gray-200 border-dashed rounded-lg dark:border-gray-700 mt-14">
            <div class="grid grid-cols-3 gap-4 mb-4">
                <div class="flex items-center justify-center h-24 rounded-sm bg-gray-50 dark:bg-gray-800">
                    <!-- benda -->
                    <?php 
                        $id_user = $user['id_user'];
                        
                        $todo_user_sql = $connect->prepare("SELECT * FROM todos WHERE id_user = :id_user AND status_todo = 1");
                        $todo_user_sql->execute([
                            ":id_user" => $id_user
                        ]);

                        $bil_todo_user = $todo_user_sql->rowCount();
                    ?>
                    <div id="jh-stats-positive" class="flex flex-col justify-center px-4 pb-4 pt-2">
                        <div>
                            <p class="text-3xl font-semibold text-center text-gray-800 dark:text-white"><?php echo $bil_todo_user ?></p>
                            <p class="text-lg text-center text-gray-500">Todos</p>
                        </div>
                    </div>
                </div>
                <div class="flex items-center justify-center h-24 rounded-sm bg-gray-50 dark:bg-gray-800">
                    <?php 

                        $reminder_user_sql = $connect->prepare("SELECT * FROM reminders WHERE id_user = :id_user AND status_reminder = 1");
                        $reminder_user_sql->execute([
                            ":id_user" => $id_user
                        ]);

                        $bil_reminder_user = $reminder_user_sql->rowCount();

                    ?>
                    <div id="jh-stats-positive" class="flex flex-col justify-center px-4 pb-4 pt-2">
                        <div>
                            <p class="text-3xl font-semibold text-center text-gray-800 dark:text-white"><?php echo $bil_reminder_user ?></p>
                            <p class="text-lg text-center text-gray-500">Reminders</p>
                        </div>
                    </div>
                </div>
                <div class="flex items-center justify-center h-24 rounded-sm bg-gray-50 dark:bg-gray-800">
                    <?php 

                        $project_user_sql = $connect->prepare("SELECT * FROM projects WHERE id_user = :id_user AND status_project != 0");
                        $project_user_sql->execute([
                            ":id_user" => $id_user
                        ]);

                        $bil_project_user = $project_user_sql->rowCount();

                    ?>
                    <div id="jh-stats-positive" class="flex flex-col justify-center px-4 pb-4 pt-2">
                        <div>
                            <p class="text-3xl font-semibold text-center text-gray-800 dark:text-white"><?php echo $bil_project_user ?></p>
                            <p class="text-lg text-center text-gray-500">Projects</p>
                        </div>
                    </div>
                </div>
            </div>

            <?php $location_index = ".."; require('../components/user/todo/todo_table.php');?>

            <br><br><br><br><br>
            <?php $location_index = ".."; require('../components/user/all_reminders.php');?>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/flowbite@3.1.2/dist/flowbite.min.js"></script>
    <?php $location_index='..'; include('../components/footer.php')?>
    
</body>
</html>