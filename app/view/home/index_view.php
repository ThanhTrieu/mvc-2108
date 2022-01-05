<?php if(!defined('ROOT_PATH')) exit('Can not access'); ?>
<!-- khong duoc phep truy cap truc tiep vao file view -->

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>List products</title>
    <!-- link css tu thu muc public -->
    <!-- ban chat tat ca deu chay qua file index.php -->
    <link rel="stylesheet" href="public/css/bootstrap.css" />
</head>
<body>
    <div class="container">
        <div class="row">
            <div class="col">
                <h5 class="text-center my-3"> Danh sach san pham !</h5>
                <a class="btn btn-primary my-2" href="index.php?c=login&m=index"> Login </a>
                <table class="table table-striped table-hover">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Ten SP</th>
                            <th>Gia SP</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach($products as $item): ?>
                            <tr>
                                <td><?= $item['id']; ?></td>
                                <td><?= $item['name']; ?></td>
                                <td><?= number_format($item['price']); ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</body>
</html>