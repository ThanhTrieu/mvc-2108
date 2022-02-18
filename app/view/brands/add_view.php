<?php if(!defined('ROOT_PATH')) exit('Can not access'); ?>
<!-- khong duoc phep truy cap truc tiep vao file view -->

<div class="container-fluid">
    <div class="row">
        <div class="col">
            <p> This is add brand page !</p>
            <a class="btn btn-primary" href="index.php?c=brand"> List brands</a>
        </div>
    </div>
    <div class="row mt-5">
        <div class="col">
            
            <?php if(!empty($messagesError)): ?>
                <ul>
                    <?php foreach($messagesError as $err): ?>
                        <?php if(!empty($err)): ?>
                            <li class="text-danger"><?= $err; ?></li>
                        <?php endif; ?>
                    <?php endforeach; ?>
                </ul>
            <?php endif; ?>

            <?php if(!empty($messagesExists)): ?>
                <p class="text-danger"><b><?= $messagesExists; ?></b> da ton tai</p>
            <?php endif; ?>

            <?php if(!empty($messagesFail)): ?>
                <p class="text-danger"><b><?= $messagesFail; ?></b> da ton tai</p>
            <?php endif; ?>

            <form class="border p-3" method="post" action="index.php?c=brand&m=handleAdd" enctype="multipart/form-data"> 
                <div class="mb-3">
                    <label for="nameBrand" class="form-label">Name (*)</label>
                    <input type="text" class="form-control" id="nameBrand" name="nameBrand">
                </div>
                <div class="mb-3">
                    <label for="logoBrand" class="form-label">Logo (*)</label>
                    <input type="file" class="form-control" id="logoBrand" name="logoBrand">
                </div>
                <div class="mb-3">
                    <label class="form-label" for="description">Description</label>
                    <textarea class="form-control" id="description" name="description" rows="8"></textarea>
                </div>
                <button type="submit" class="btn btn-primary" name="btnAddBrand">Submit</button>
            </form>
        </div>
    </div>
</div>