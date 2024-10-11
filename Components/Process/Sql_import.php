<?php

    require "../../conf.php";

    function random_lower_srting($length = 8) {
        $characters = 'abcdefghijklmnopqrstuvwxyz';
        $charactersLength = strlen($characters);
        $randomString = '';
    
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[random_int(0, $charactersLength - 1)];
        }
    
        return $randomString;
    };
    function random_Upper_srting($length = 2) {
        $characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
    
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[random_int(0, $charactersLength - 1)];
        }
    
        return $randomString;
    };

    $resultPassword = random_Upper_srting().random_lower_srting().rand(0,100000).".";
    $newDbName = $_POST['DBname'] ?? null;
    $newUsername = $_POST['Username'] ?? null;
    $newPassword = $resultPassword;
    $sqlname = $_FILES['SQLFiles']['name'];
    $sqltmp = $_FILES['SQLFiles']['tmp_name'];
    $filepath = ROOT_DIR."/cache/";

    $basename = pathinfo($sqlname, PATHINFO_FILENAME);
    $extension = pathinfo($sqlname, PATHINFO_EXTENSION);

    $targetFile = $filepath.$basename.$extension;
    if ($extension != "sql") {
    $LOG->Alert("Sorry, only SQL files are allowed.");
    // var_dump($sqltmp,$extension,$basename);
    $Control->header($url,"Components/sql_import_form.php");
    exit;
    }

    if (move_uploaded_file($sqltmp,$targetFile)) {
        $cache = "Cached file successfully";
    }else {
        echo "Something went worngs. Failed to cache file.";
        
        exit;
    }
    if ($newDbName && $newUsername != null) {
        try {
           
            $conn->exec("CREATE DATABASE IF NOT EXISTS `$newDbName` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;");
            $Credatabase =  "Database '$newDbName' created successfully.<br>";
        

            $conn->exec("CREATE USER '$newUsername'@'localhost' IDENTIFIED BY '$newPassword';");
            $conn->exec("GRANT ALL PRIVILEGES ON `$newDbName`.* TO '$newUsername'@'localhost';");
            $conn->exec("FLUSH PRIVILEGES;");
            $CreUser =  "User '$newUsername' created and granted access to '$newDbName'.<br>";
        
            $conn = new PDO("mysql:host=$Mysqlhost;dbname=$newDbName", $adminusername, $adminpassword);
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        
            // Read the SQL file contents
            $sqlContent = file_get_contents($targetFile);
            
            // Split the SQL content into individual statements
            $sqlStatements = explode(';', $sqlContent);
            
            // Execute each statement one by one
            foreach ($sqlStatements as $statement) {
                $statement = trim($statement);
                if (!empty($statement)) {
                    $conn->exec($statement);
                }
            }
            $ImportSatus =  "SQL file imported into database '$newDbName' successfully.";
            $LOG->writeLog("username:".$newUsername.",Password:".$resultPassword);
            unset($targetFile);
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
            unset($targetFile);
        }
    }else {
        $LOG->Alert("Username or Database name is empty.");
        $Control->header($url,"Components/sql_import_form.php");
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Import Status</title>
    <?php $LOAD->loadheader()?>
</head>
<body>
<div class="container">
    <div class="row">
        <div class="col-5">
            <h1>Import SQL Status</h1>
            <p class="fs-5">Error code : <?php $_FILES['SQLFiles']['error']?></p>
            <p class="fs-5">Create Database : <?php $Credatabase?></p>
            <p class="fs-5">Create User : <?php $CreUser?></p>
            <p class="fs-5">Import Database : <?php $ImportSatus?></p>
            <p class="fs-4">Now you can use username and password to connect your database.</p>
            <p class="fs-5">Username : <?php $newUsername?></p>
            <p class="fs-5">Password : <?php $newPassword?></p>
            <p class="fs-6">Warning: If the username creation process fails, your username will not be created and the database will not be accessible. Please try again later or contact your system administrator.</p>
        </div>
    </div>
</div>
<?php $LOAD->loadfooter()?>
</body>
</html>