
<?php
function uploadFile($file, $target_dir) {
    // Check if the file variable is set and is an array
    if (!isset($file) || !is_array($file)) {
        echo "Error: File variable is not set or is not an array.";
        return false;
    }

    // Check if the file was uploaded successfully
    if (!isset($file['error']) || $file['error'] !== UPLOAD_ERR_OK) {
        echo "Error: File upload failed.";
        return false;
    }

    // Create the target directory if it doesn't exist
    if (!is_dir($target_dir)) { mkdir($target_dir);}

    // Move the uploaded file to the target directory
    $target_file = $target_dir . basename($file["name"]);
    if (move_uploaded_file($file["tmp_name"], $target_file)) {
        return $target_file;
    } else {
        echo "Error: Failed to upload file.";
        return false;
    }
}

?>