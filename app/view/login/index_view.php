<?php if(!defined('ROOT_PATH')) exit('Can not access'); ?>
<!-- khong duoc phep truy cap truc tiep vao file view -->

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <!-- link css tu thu muc public -->
    <!-- ban chat tat ca deu chay qua file index.php -->
    <link rel="stylesheet" href="public/css/bootstrap.css" />
</head>
<body>
    <div class="container">
        <div class="row">
            <div class="col-12 col-sm-12 col-md-6 offset-3">
                <h5 class="text-center my-3"> Login user ! </h5>
                <form class="p-3 border" method="post" action="index.php?c=login&m=handleLogin">
                    <div class="mb-3">
                        <label>Username</label>
                        <input type="text" class="form-control" name="username" />
                    </div>
                    <div class="mb-3">
                        <label>Password</label>
                        <input type="password" class="form-control" name="password" />
                    </div>
                    <button type="submit" class="btn btn-primary" name="btnLogin"> Login </button>
                </form>
            </div>
        </div>
    </div>
</body>
</html>