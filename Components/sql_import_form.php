<?php
require "./../conf.php";
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SQL Import</title>
    <?php $LOAD->loadheader(); ?>
</head>

<body>

    <div class="container ">
        <div class="row mt-5">
            <div class="col-6">
                <h2 class="mb-3">Upload SQL file to server</h2>
                <?php $LOG->showalert(); ?>
                <form action="<?php echo $url."Components/Process/Sql_import.php"?>" method="post" enctype="multipart/form-data">
                <div class="form-floating mb-3">
                        <input type="text" class="form-control" id="floatingInput" name="Username">
                        <label for="floatingInput">Username</label>
                    </div>
                    <div class="form-floating mb-3">
                        <input type="text" class="form-control" id="floatingInput1" name="DBname">
                        <label for="floatingInput1">Database Name.</label>
                    </div>
                    <div class="input-group mb-3">
                        <input type="file" class="form-control" id="inputGroupFile02" name="SQLFiles">
                        <label class="input-group-text" for="inputGroupFile02">Upload</label>
                    </div>
                    <div>
                        <button type="submit" class="btn btn-primary">Upload</button>
                    </div>
                    
                </form>
                <p class="mt-2">
                        **Password generated automatically.
                    </p>
            </div>

        </div>
    </div>

    <?php $LOAD->loadfooter(); ?>
</body>

</html>