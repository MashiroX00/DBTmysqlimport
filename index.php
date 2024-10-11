<?php 
require "conf.php";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>
    <?php $LOAD->loadheader();?>
</head>
<body>

<div class="container">
    <div class="row mt-5">
        <div class="col-3"><a href="<?php echo $url?>Components/sql_import_form.php" class="btn btn-dark">Import SQL</a></div>
        <div class="col-3"></div>
    </div>
</div>

<?php $LOAD->loadfooter();?>
</body>
</html>