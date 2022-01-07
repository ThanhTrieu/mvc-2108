<?php if(!defined('ROOT_PATH')) exit('Can not access'); ?>
<!-- khong duoc phep truy cap truc tiep vao file view -->

<div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Ready to Leave?</h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">Select "Logout" below if you are ready to end your current session.</div>
            <div class="modal-footer">
                <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                <form method="post" action="index.php?c=login&m=logout">
                    <button class="btn btn-primary" type="submit" name="btnLogout">Logout</button>
                </form>
            </div>
        </div>
    </div>
</div>