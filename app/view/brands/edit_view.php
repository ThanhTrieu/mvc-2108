<?php if(!defined('ROOT_PATH')) exit('Can not access'); ?>
<!-- khong duoc phep truy cap truc tiep vao file view -->

<div class="container-fluid">
    <div class="row">
        <div class="col">
            <p> This is edit brand page !</p>
            <a class="btn btn-primary" href="index.php?c=brand"> List brands</a>
        </div>
    </div>
    <div class="row mt-5">
        <div class="col">
            
            <?php if(!empty($error)): ?>
                <ul>
                    <?php foreach($error as $err):?>
                        <?php if(!empty($err)): ?>
                            <li class="text-danger"><?= $err; ?></li>
                        <?php endif; ?>
                    <?php endforeach; ?>
                </ul>
            <?php endif; ?>

            <?php if(!empty($exists)): ?>
                <h6 class="text-danger"> <i> <?= $exists; ?> </i> da ton tai - vui long chon ten thuong hieu khac</h6>
            <?php endif; ?>

            <?php if(!empty($fail)): ?>
                <h6 class="text-danger"> <?= $fail; ?></h6>
            <?php endif; ?>

            <form class="border p-3" method="post" action="index.php?c=brand&m=handleEdit&id=<?= $info['id']; ?>" enctype="multipart/form-data"> 
                <div class="mb-3">
                    <label for="nameBrand" class="form-label">Name (*)</label>
                    <input type="text" class="form-control" id="nameBrand" name="nameBrand" value="<?= $info['name']; ?>">
                </div>
                <div class="mb-3">
                    <label for="logoBrand" class="form-label">Logo</label>
                    <input type="file" class="form-control" id="logoBrand" name="logoBrand">
                    <img width="10%" class="img-fluid mt-3" src="<?= PATH_UPLOAD_BRAND_LOGO . $info['logo']; ?>" />
                </div>
                <div class="mb-3">
                    <label class="form-label" for="statusBrand">Status</label>
                    <select class="form-control" id="statusBrand" name="statusBrand">
                        <option
                            <?= $info['status'] == STATUS_ACTIVE ? "selected='selected'" : ""; ?>
                            value="<?= STATUS_ACTIVE; ?>"
                        ><?= LABEL_ACTIVE; ?></option>
                        <option
                            <?= $info['status'] == STATUS_DEACTIVE ? "selected='selected'" : ""; ?>
                            value="<?= STATUS_DEACTIVE; ?>"
                        ><?= LABEL_DEACTIVE; ?></option>
                    </select>
                </div>
                <div class="mb-3">
                    <label class="form-label" for="description">Description</label>
                    <textarea class="form-control" id="description" name="description" rows="8"><?= $info['descriptions']; ?></textarea>
                </div>
                <button type="submit" class="btn btn-primary" name="btnEditBrand">Submit</button>
            </form>
        </div>
    </div>
</div>