<?php if(!defined('ROOT_PATH')) exit('Can not access'); ?>
<!-- khong duoc phep truy cap truc tiep vao file view -->

<div class="container-fluid">
    <div class="row">
        <div class="col">
            <a class="btn btn-primary" href="index.php?c=brand&m=add"> Add brand</a>
            <a class="btn btn-primary ml-1" href="index.php?c=brand"> View All</a>
        </div>
        <form class="d-none d-sm-inline-block form-inline mr-auto ml-md-3 my-2 my-md-0 mw-100 navbar-search">
            <div class="input-group">
                <input value="<?= htmlentities($keyword); ?>" id="js-nameBranch" type="text" class="form-control small" placeholder="Search for...">
                <div class="input-group-append">
                    <button id="js-searchBrand" class="btn btn-primary" type="button">
                        <i class="fas fa-search fa-sm"></i>
                    </button>
                </div>
            </div>
        </form>
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
                        <tr id="js-brand-<?= $item['id']; ?>">
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
                                <button id="<?= $item['id']; ?>" class="btn btn-danger js-delete-brand">Delete</button>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>