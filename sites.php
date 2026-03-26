<?php
$folders = glob("sites/*", GLOB_ONLYDIR);

/* AUTO DOMAIN DETECT */
$base_url = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off' ? "https://" : "http://") . $_SERVER['HTTP_HOST'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>My Websites</title>

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
    justify-content:space-between;
    padding:15px;
    align-items:center;
}

.logo{
    font-size:18px;
    font-weight:bold;
}

/* TITLE */
.title{
    padding:15px;
    font-size:20px;
    font-weight:bold;
}

/* CARD */
.card{
    background:white;
    margin:15px;
    padding:15px;
    border-radius:15px;
    box-shadow:0 5px 15px rgba(0,0,0,0.08);
}

/* SITE ROW */
.site{
    display:flex;
    justify-content:space-between;
    align-items:center;
}

.site-name{
    font-size:16px;
    font-weight:bold;
}

.date{
    font-size:12px;
    color:gray;
}

/* STATUS */
.status{
    padding:5px 10px;
    border-radius:20px;
    font-size:12px;
    color:white;
}

.active{background:#2ecc71;}
.broken{background:#e74c3c;}

/* BUTTONS */
.buttons{
    margin-top:10px;
    display:flex;
    gap:10px;
}

.btn{
    flex:1;
    padding:10px;
    border:none;
    border-radius:10px;
    color:white;
    cursor:pointer;
    font-size:13px;
}

.visit{background:#2d6cdf;}
.copy{background:#3b82f6;}
.delete{background:#e74c3c;}

.empty{
    text-align:center;
    margin-top:50px;
    color:#777;
}

/* NAV */
.nav{
    position:fixed;
    bottom:0;
    width:100%;
    background:white;
    display:flex;
    justify-content:space-around;
    padding:10px;
    box-shadow:0 -2px 10px rgba(0,0,0,0.1);
}

.nav a{
    text-decoration:none;
    color:#555;
}
</style>

</head>

<body>

<div class="header">
    <div class="logo">🚀 Jit Bhaiya Host</div>
</div>

<div class="title">🌐 My Websites</div>

<?php if(empty($folders)){ ?>
    <div class="empty">❌ No website uploaded yet</div>
<?php } ?>

<?php foreach($folders as $folder):

$name = basename($folder);
$safeName = htmlspecialchars($name);

/* 🔥 SMART FILE DETECT */
$link = "#";
$status = "NO INDEX";
$statusClass = "broken";

$files = scandir($folder);

foreach($files as $f){
    if($f != "." && $f != ".."){

        // priority: index.html / index.php
        if(strtolower($f) == "index.html" || strtolower($f) == "index.php"){
            $link = $base_url . "/sites/" . $safeName . "/" . $f;
            $status = "ACTIVE";
            $statusClass = "active";
            break;
        }

        // fallback: any html file
        if(strpos($f, ".html") !== false){
            $link = $base_url . "/sites/" . $safeName . "/" . $f;
            $status = "ACTIVE";
            $statusClass = "active";
        }
    }
}

/* REAL DATE */
$date = date("d M Y", filemtime($folder));
?>

<div class="card">

<div class="site">
    <div>
        <div class="site-name"><?php echo $safeName; ?></div>
        <div class="date"><?php echo $date; ?></div>
    </div>

    <div class="status <?php echo $statusClass; ?>">
        <?php echo $status; ?>
    </div>
</div>

<div class="buttons">

<?php if($link != "#"){ ?>
<a href="<?php echo $link; ?>" target="_blank" style="flex:1;">
<button class="btn visit">Visit</button>
</a>
<?php } ?>

<button class="btn copy" onclick="copyLink('<?php echo $link; ?>')">Copy</button>

<a href="delete.php?site=<?php echo urlencode($safeName); ?>" style="flex:1;"
onclick="return confirm('Delete this website?')">
<button class="btn delete">Delete</button>
</a>

</div>

</div>

<?php endforeach; ?>

<div class="nav">
    <a href="index.html">🏠 Home</a>
    <a href="#">🌐 Sites</a>
</div>

<script>
function copyLink(link){
    if(link === "#"){
        alert("❌ No HTML file found!");
        return;
    }
    navigator.clipboard.writeText(link);
    alert("✅ Link Copied!");
}
</script>

</body>
</html>