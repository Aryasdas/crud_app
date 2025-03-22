<!-- The uploadFile function is a PHP utility function designed to handle file uploads -->
<?php
function uploadFile($file, $target_dir) {
    if (!isset($file)) {
        echo "Error: File variable is not set.";
        return false;
    }

    if (!is_array($file)) {
        echo "Error: File variable is not an array.";
        return false;
    }

    $target_file = $target_dir . basename($file["name"]);

    if (move_uploaded_file($file["tmp_name"], $target_file)) {
        return $target_file;
    } else {
        echo "Error: Failed to upload file.";
        return false;
    }
}
?>