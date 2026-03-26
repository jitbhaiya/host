<?php
session_start();

/* LOGIN */
$username = "JIT";
$password = "PRIME";

/* LOGIN */
if(isset($_POST['login'])){
    if($_POST['user'] === $username && $_POST['pass'] === $password){
        $_SESSION['admin'] = true;
    } else {
        $error = "Wrong Login!";
    }
}

/* LOGOUT */
if(isset($_GET['logout'])){
    session_destroy();
    header("Location: admin.php");
    exit();
}

/* LOGIN PAGE */
if(!isset($_SESSION['admin'])){
?>
<!DOCTYPE html>
<html>
<head>
<title>Admin Login</title>
<style>
body{background:#000;color:white;display:flex;justify-content:center;align-items:center;height:100vh;font-family:sans-serif;}
.card{background:#020617;padding:20px;border-radius:10px;width:260px;text-align:center;}
input,button{width:100%;padding:10px;margin-top:10px;border:none;border-radius:5px;}
button{background:#0ea5e9;color:white;}
</style>
</head>
<body>
<div class="card">
<h2>Admin Login</h2>
<?php if(isset($error)) echo "<p style='color:red'>$error</p>"; ?>
<form method="post">
<input name="user" placeholder="Username">
<input type="password" name="pass" placeholder="Password">
<button name="login">Login</button>
</form>
</div>
</body>
</html>
<?php exit(); }

/* BASE */
$base = "sites";

/* CREATE FOLDER */
if(!is_dir($base)){
    mkdir($base,0755,true);
}

/* PATH */
$path = isset($_GET['path']) ? $_GET['path'] : $base;

/* SECURITY */
if(strpos($path,"..") !== false){
    $path = $base;
}

/* DELETE FUNCTION */
function deleteItem($path){
    if(is_file($path)){
        unlink($path);
    } elseif(is_dir($path)){
        foreach(scandir($path) as $f){
            if($f != "." && $f != ".."){
                deleteItem($path."/".$f);
            }
        }
        rmdir($path);
    }
}

/* DELETE */
if(isset($_GET['delete'])){
    $file = $_GET['delete'];
    if(strpos($file,"sites") === 0){
        deleteItem($file);
    }
    header("Location: admin.php");
    exit();
}

/* FILE LIST */
$files = scandir($path);
?>

<!DOCTYPE html>
<html>
<head>
<title>Admin Panel</title>
<meta name="viewport" content="width=device-width, initial-scale=1">

<style>
body{margin:0;background:#000;color:white;font-family:sans-serif;}

.header{
padding:15px;
display:flex;
justify-content:space-between;
background:#111;
}

.card{
background:#1e293b;
margin:10px;
padding:10px;
border-radius:10px;
}

button{
padding:6px 10px;
margin-top:5px;
border:none;
border-radius:5px;
cursor:pointer;
}

.open{background:#0ea5e9;color:white;}
.delete{background:red;color:white;}
.view{background:#22c55e;color:black;}
</style>
</head>

<body>

<div class="header">
<span>⚡ Admin Panel</span>
<a href="?logout=true" style="color:red;">Logout</a>
</div>

<?php if($path != "sites"){ ?>
<a href="admin.php?path=<?php echo dirname($path); ?>" style="margin:10px;">⬅ Back</a>
<?php } ?>

<?php foreach($files as $file):

if($file == "." || $file == "..") continue;

$full = $path . "/" . $file;
?>

<div class="card">

<b><?php echo htmlspecialchars($file); ?></b><br>

<?php if(is_dir($full)){ ?>

<a href="?path=<?php echo $full; ?>">
<button class="open">📁 Open</button>
</a>

<a href="?delete=<?php echo $full; ?>" onclick="return confirm('Delete folder?')">
<button class="delete">Delete</button>
</a>

<?php } else { ?>

<a href="view.php?file=<?php echo $full; ?>">
<button class="view">👀 View</button>
</a>

<a href="<?php echo $full; ?>" target="_blank">
<button class="open">Open</button>
</a>

<a href="?delete=<?php echo $full; ?>" onclick="return confirm('Delete file?')">
<button class="delete">Delete</button>
</a>

<?php } ?>

</div>

<?php endforeach; ?>

</body>
</html>