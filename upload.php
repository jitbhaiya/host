<?php
$result = "";
$link = "";

/* AUTO DOMAIN */
$base_url = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off' ? "https://" : "http://") . $_SERVER['HTTP_HOST'];

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $sitename = preg_replace("/[^a-zA-Z0-9_-]/", "", $_POST["sitename"]);
    $target_dir = "sites/" . $sitename;

    if (!is_dir($target_dir)) {
        mkdir($target_dir, 0755, true);
    }

    if (isset($_FILES["file"]) && $_FILES["file"]["error"] == 0) {

        $fileName = $_FILES["file"]["name"];
        $tmpFile = $_FILES["file"]["tmp_name"];
        $ext = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));

        /* ================= ZIP UPLOAD ================= */
        if ($ext === "zip") {

            $zip = new ZipArchive;

            if ($zip->open($tmpFile) === TRUE) {
                $zip->extractTo($target_dir);
                $zip->close();

                /* 🔥 FIX: extra folder auto remove */
                $files = scandir($target_dir);
                foreach($files as $f){
                    if($f != "." && $f != ".." && is_dir($target_dir."/".$f)){
                        $inner = $target_dir."/".$f;
                        $innerFiles = scandir($inner);

                        foreach($innerFiles as $if){
                            if($if != "." && $if != ".."){
                                rename($inner."/".$if, $target_dir."/".$if);
                            }
                        }
                        rmdir($inner);
                    }
                }

                /* 🔥 AUTO INDEX DETECT */
                $found = false;
                $files = scandir($target_dir);

                foreach($files as $f){
                    if(strtolower($f) == "index.html" || strtolower($f) == "index.php"){
                        $found = true;
                        break;
                    }
                }

                /* 🔥 if no index → convert first html */
                if(!$found){
                    foreach($files as $f){
                        if(strpos($f, ".html") !== false){
                            rename($target_dir."/".$f, $target_dir."/index.html");
                            $found = true;
                            break;
                        }
                    }
                }

                if($found){
                    $link = $base_url . "/sites/" . $sitename . "/";
                    $result = "success";
                } else {
                    $result = "noindex";
                }

            } else {
                $result = "error";
            }

        } 
        /* ================= SINGLE FILE ================= */
        else {

            if($ext == "html"){
                move_uploaded_file($tmpFile, $target_dir . "/index.html");
            }
            elseif($ext == "php"){
                move_uploaded_file($tmpFile, $target_dir . "/index.php");
            }
            else{
                move_uploaded_file($tmpFile, $target_dir . "/" . $fileName);
            }

            $link = $base_url . "/sites/" . $sitename . "/";
            $result = "success";
        }

    } else {
        $result = "nofile";
    }

} else {
    $result = "invalid";
}
?>

<!DOCTYPE html>
<html>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Upload Result</title>

<style>
body{
    margin:0;
    font-family:sans-serif;
    background:linear-gradient(135deg,#667eea,#764ba2);
    display:flex;
    justify-content:center;
    align-items:center;
    height:100vh;
    color:white;
}

.card{
    background:rgba(255,255,255,0.1);
    backdrop-filter:blur(15px);
    padding:25px;
    border-radius:15px;
    width:90%;
    max-width:350px;
    text-align:center;
}

button{
    width:100%;
    padding:12px;
    margin-top:10px;
    border:none;
    border-radius:10px;
    font-weight:bold;
    cursor:pointer;
}

.open{background:#2ecc71;color:white;}
.copy{background:#3498db;color:white;}
.home{background:#e67e22;color:white;}

.rgb-text{
    font-weight:bold;
    font-size:14px;
    word-break:break-all;
    margin-top:10px;
    background:linear-gradient(90deg,red,orange,yellow,green,cyan,blue,violet);
    background-size:400%;
    -webkit-background-clip:text;
    -webkit-text-fill-color:transparent;
    animation:rgbMove 5s linear infinite;
}

@keyframes rgbMove{
    0%{background-position:0%;}
    100%{background-position:400%;}
}
</style>
</head>

<body>

<div class="card">

<?php if($result == "success"){ ?>

<h2>🚀 Your Website is Ready</h2>
<p class="rgb-text"><?php echo $link; ?></p>

<a href="<?php echo $link; ?>" target="_blank">
<button class="open">Open Website</button>
</a>

<button class="copy" onclick="copyLink()">Copy Link</button>

<?php } elseif($result == "noindex"){ ?>

<h2>⚠ No HTML Found</h2>
<p>No index or HTML file found in ZIP</p>

<?php } elseif($result == "error"){ ?>

<h2>❌ ZIP Error</h2>

<?php } elseif($result == "nofile"){ ?>

<h2>⚠ No File Uploaded</h2>

<?php } else { ?>

<h2>❌ Invalid Request</h2>

<?php } ?>

<button class="home" onclick="location.href='index.html'">Go Home</button>

</div>

<script>
function copyLink(){
    navigator.clipboard.writeText("<?php echo $link; ?>");
    alert("✅ Link Copied!");
}
</script>

</body>
</html>