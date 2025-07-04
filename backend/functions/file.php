<?php

function uploadFile($file, $type_destination){

    //* File name not set
    if($file["name"] == NULL || $file["name"] == ""){
        return encodeObj("400", "File tidak sah", "error");
        exit;
    }

    //* File is not found
    if($file["error"] == 4){
        return encodeObj("400", "File not found", "error");
        exit;

    }
    
    //* Identify file extention
    $fileName = $file["name"];
    $fileSize = $file["size"];
    $TmpName = $file["tmp_name"];
    $validImageExtension = ['jpg', 'png', 'mp3', 'wav'];
    $imageExtension = explode('.', $fileName);
    $imageExtension = strtolower(end($imageExtension));

    //* Wrong file extention
    // if(!in_array($imageExtension, $validImageExtension)){
    //     return encodeObj("400", "File type not valid", "error");
    //     exit;

    // }

    //* Image is correct
    try{

        $newImageName = uniqid();
        $newImageName .= '.' . $imageExtension;
        $destination = __DIR__ . "/../../src/uploads" . $type_destination . "/" . $newImageName;
        move_uploaded_file($TmpName, $destination);
    
        $status = encodeObj("200", "Berjaya Tambah File", "success");
        $file = [
            "FileName" => $newImageName,
            "destination" => $destination,
            "extention" => $imageExtension
        ];
    
        $file = json_encode($file);
    
        return addJson($status, $file);
    }
    catch(Exception $e){
        return encodeObj("400", "File upload error : $e", "error");
    }
}

?>