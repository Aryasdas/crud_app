<!-- The uploadFile function is a PHP utility function designed to handle file uploads -->

<?php 
function uploadFile($file,$target_dir){
 $target_file = $target_dir.base_name($file["name"]);
}
if (move_uploaded_file($file["tmp_name"], $target_file)) {
    return $target_file;
} else {
    return false;
}

?>