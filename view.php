<?php

$base = realpath("sites");
$file = "";
$content = "No file selected!";

if(isset($_GET['file'])){

    $requested = $_GET['file'];
    $real = realpath($requested);

    /* SECURITY CHECK */
    if($real && strpos($real, $base) === 0 && is_file($real)){

        $file = basename($real);
        $content = htmlspecialchars(file_get_contents($real));

    } else {
        $content = "Access Denied!";
    }
}

?>

<!DOCTYPE html>
<html>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>View Code</title>

<style>
body{
    margin:0;
    font-family:monospace;
    background:#0f172a;
    color:#00ffcc;
}

/* HEADER */
.header{
    padding:10px;
    background:#111827;
    display:flex;
    justify-content:space-between;
    align-items:center;
}

/* BUTTON */
button{
    padding:5px 10px;
    border:none;
    border-radius:5px;
    background:#22c55e;
    color:white;
    cursor:pointer;
}

/* FILE NAME */
.filename{
    text-align:center;
    margin:10px;
    color:white;
}

/* CODE BOX */
.code-box{
    padding:15px;
    overflow:auto;
    white-space:pre-wrap;
    word-break:break-word;
}
</style>

</head>

<body>

<div class="header">
    <a href="admin.php" style="color:white;text-decoration:none;">⬅ Back</a>
    <span>📄 Code Viewer</span>
    <button onclick="copyCode()">Copy</button>
</div>

<div class="filename">
<b><?php echo $file; ?></b>
</div>

<div class="code-box" id="code">
<pre><?php echo $content; ?></pre>
</div>

<script>
function copyCode(){
    let text = document.getElementById("code").innerText;
    navigator.clipboard.writeText(text);
    alert("Code Copied!");
}
</script>

</body>
</html>