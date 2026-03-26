<?php
session_start();

/* 🔐 Optional: Admin check */
if(!isset($_SESSION['admin'])){
    die("Access Denied!");
}

/* DELETE FUNCTION */
function deleteFolder($folder){
    if(!file_exists($folder)) return;

    if(is_file($folder)){
        unlink($folder);
        return;
    }

    $files = scandir($folder);

    foreach($files as $file){
        if($file != "." && $file != ".."){
            $path = $folder . "/" . $file;

            if(is_dir($path)){
                deleteFolder($path);
            } else {
                unlink($path);
            }
        }
    }

    rmdir($folder);
}

/* DELETE REQUEST */
if(isset($_GET['site'])){

    $site = preg_replace("/[^a-zA-Z0-9_-]/", "", $_GET['site']);
    $dir = "sites/" . $site;

    if(is_dir($dir)){
        deleteFolder($dir);
    }
}

/* REDIRECT */
header("Location: sites.php");
exit();
?>