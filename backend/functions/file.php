<?php

function uploadFile($id, $file, $type_destination){

    try{

        // Validate file type and size
        $allowedTypes = ['image/jpeg', 'image/png', 'image/gif', 'image/webp'];
        $maxFileSize = 5 * 1024 * 1024; // 5MB
        
        if (!in_array($file['type'], $allowedTypes)) {

            return encodeObj("400", "Hanya fail imej (JPEG, PNG, GIF, WEBP) yang dibenarkan", "error");
            exit;
        }
        
        if ($file['size'] > $maxFileSize) {

            return encodeObj("400", "Saiz fail terlalu besar. Maksimum 5MB dibenarkan", "error");
            exit;
        }
        
        // Create uploads directory if it doesn't exist
        $uploadDir = '../uploads/'. $type_destination .'/';
        if (!file_exists($uploadDir)) {
            mkdir($uploadDir, 0777, true);
        }
            
        // Generate unique filename
        $fileExtension = pathinfo($file['name'], PATHINFO_EXTENSION);
        $fileName = $id . '.' . $fileExtension;
        $filePath = $uploadDir . $fileName;
        
        // Move uploaded file
        if (!(move_uploaded_file($file['tmp_name'], $filePath))) {
                return encodeObj("400", "Ralat upload", "error");
            exit;
        } 
    
        $status = encodeObj("200", "Loggin Success", "success");
    
        $file_value = [
            "file_path" => $filePath,
            "file_name" => $fileName,
        ];
    
        $file_value = json_encode($file_value);
        return addJson($status, $file_value);

    }
    catch(Exception $e){

        redirectWithAlert($_SERVER["HTTP_REFERER"] , "error", "$e");

    }
    

}

?>