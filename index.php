<?php
/* 🔥 Website Count */
$folders = glob(__DIR__ . "/sites/*", GLOB_ONLYDIR);
$count = count($folders);
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Jit Bhaiya Host</title>

<style>
*{margin:0;padding:0;box-sizing:border-box;}

body{
    font-family:'Segoe UI',sans-serif;
    background:#f5f7fb;
    padding-bottom:70px;
}

/* HEADER */
.header{
    display:flex;
    align-items:center;
    padding:15px;
}

.logo{
    display:flex;
    align-items:center;
    font-size:18px;
}

.logo img{
    width:40px;
    border-radius:10px;
    margin-right:10px;
}

/* CARD */
.card{
    background:white;
    margin:15px;
    padding:20px;
    border-radius:15px;
    box-shadow:0 5px 15px rgba(0,0,0,0.08);
}

/* FORM */
input, button{
    width:100%;
    padding:12px;
    margin-top:12px;
    border-radius:10px;
    border:1px solid #ddd;
    font-size:14px;
}

input:focus{
    outline:none;
    border-color:#2d6cdf;
}

button{
    background:linear-gradient(45deg,#2d6cdf,#1a4dbf);
    color:white;
    border:none;
    font-weight:bold;
    cursor:pointer;
}

button:hover{opacity:0.9;}

.warning{
    color:orange;
    font-size:12px;
    margin-top:6px;
}

/* STATS */
.stats{
    display:flex;
    justify-content:space-around;
    text-align:center;
}

.stat h2{
    color:#2d6cdf;
}

/* NAVBAR */
.nav{
    position:fixed;
    bottom:0;
    width:100%;
    background:white;
    display:flex;
    justify-content:space-around;
    padding:10px 0;
    box-shadow:0 -2px 10px rgba(0,0,0,0.1);
}

.nav a{
    text-align:center;
    font-size:12px;
    text-decoration:none;
    color:#555;
    flex:1;
}

.nav a:hover{
    color:#2d6cdf;
}
</style>
</head>

<body>

<!-- HEADER -->
<div class="header">
    <div class="logo">
        <img src="https://cdn-icons-png.flaticon.com/512/888/888879.png">
        <b>Jit Bhaiya Host</b>
    </div>
</div>

<!-- UPLOAD -->
<div class="card">

<h3>☁ Upload Website</h3>
<p style="font-size:13px;color:#777;margin-top:5px;">
Upload HTML, PHP or ZIP files and host instantly.
</p>

<form action="upload.php" method="post" enctype="multipart/form-data">

<input type="text" name="sitename" placeholder="Enter Site Name (no spaces)" required>

<input type="file" name="file" accept=".zip,.html,.php" required>

<div class="warning">⚠ Only ZIP, HTML, PHP allowed</div>

<button type="submit">🚀 Upload Now</button>

</form>

</div>

<!-- STATS -->
<div class="card stats">

<div class="stat">
<h2><?php echo $count; ?></h2>
<p>Websites</p>
</div>

<div class="stat">
<h2>FREE</h2>
<p>Status</p>
</div>

</div>

<!-- NAV -->
<div class="nav">
<a href="index.php">🏠<br>Home</a>
<a href="sites.php">🌐<br>Sites</a>
</div>

</body>
</html>