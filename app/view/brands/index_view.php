<?php if(!defined('ROOT_PATH')) exit('Can not access'); ?>
<!-- khong duoc phep truy cap truc tiep vao file view -->

<div class="container-fluid">
    <div class="row">
        <div class="col">
            <p> This is brands page !</p>
            <a class="btn btn-primary" href="index.php?c=brand&m=add"> Add brand</a>
        </div>
    </div>
    <div class="row mt-5">
        <div class="col">
            <table class="table table-hover table-striped">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Name</th>
                        <th>Logo</th>
                        <th>Status</th>
                        <th colspan="2" width="5%" class="text-center">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($brands as $key => $item):?>
                        <tr>
                            <td><?= $key + 1 ?></td>
                            <td><?= $item['name']; ?></td>
                            <td>
                                <img width="30%" class="img-fluid" src="<?= PATH_UPLOAD_BRAND_LOGO.$item['logo']; ?>" />
                            </td>
                            <td>
                                <?= $item['status'] == STATUS_ACTIVE ? LABEL_ACTIVE : LABEL_DEACTIVE; ?>
                            </td>
                            <td>
                                <a class="btn btn-info" href="index.php?c=brand&m=edit&id=<?= $item['id']; ?>">Edit</a>
                            </td>
                            <td>
                                <button class="btn btn-danger">Delete</button>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>