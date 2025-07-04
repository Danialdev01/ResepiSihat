
<?php

function saveDeviceToken($id_user, $device_token, $connect){

    try{

        $check_device_token_sql = $connect->prepare("SELECT * FROM tokens WHERE device_token = :device_token");
        $check_device_token_sql->execute([
            ':device_token' => $device_token
        ]);
    
        if($check_device_token_sql->rowCount() > 0){
            return encodeObj("400", "Token Already set", "error");
            exit;
        }
    
        $check_user_token_sql = $connect->prepare("SELECT * FROM tokens WHERE id_user = :id_user");
        $check_user_token_sql->execute([
            ':id_user' => $id_user
        ]);
    
        if($check_device_token_sql->rowCount() > 10){
            $delete_oldest_user_token_sql = $connect->prepare("
                DELETE FROM tokens WHERE (id_user, created_date_token) IN (
                    SELECT id_user, created_date_token
                    FROM tokens
                    WHERE id_user = :id_user
                    ORDER BY created_date_token ASC
                    LIMIT 1
                )
            ");
    
            $delete_oldest_user_token_sql->execute([
                ":id_user" => $id_user
            ]);
        }
        
    
        $save_device_token_sql = $connect->prepare("INSERT INTO tokens(id, id_user, device_token, created_date_token, status_token) VALUES (NULL, :id_user , :device_token, :created_date_token, 1)"); 
        $save_device_token_sql->execute([
            ":id_user" => $id_user,
            ":device_token" => $device_token,
            ":created_date_token" => date("Y-m-d")
        ]);


        $status = encodeObj("200", "Save Token to Database", "success");
                
        $data = [
            "id_token" => $connect->lastInsertId(),
            "id_user" => $id_user,
            "device_token" => $device_token,
        ];
        
        $data = json_encode($data);
        return addJson($status, $data); 
    }
    catch(Exception $e){
        $status = encodeObj("400", "Error Save Token", "error");

    }

}