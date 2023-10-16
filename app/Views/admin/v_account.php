<div class="card-header">
    <i class="fas fa-table me-1"></i>
    <?php echo $titleTemplate ?>
</div>
<div class="card-body">
    <?php
    $session = \Config\Services::session();
    if ($session->getFlashdata('warning')) {
    ?>
        <div class="alert alert-warning">
            <ul>
                <?php
                foreach ($session->getFlashdata('warning') as $val) {
                ?>
                    <li><?php echo $val ?></li>
                <?php
                }
                ?>
            </ul>
        </div>
    <?php
    }
    if ($session->getFlashdata('success')) {
    ?>
        <div class="alert alert-success"><?php echo $session->getFlashdata('success') ?></div>
    <?php
    }
    ?>
    <form action="" method="POST" enctype="multipart/form-data">
        <div class="mb-3">
            <label for="input_full_name" class="form-label">Full Name</label>
            <input type="text" class="form-control" id="input_full_name" name="full_name" value="<?php echo (isset($full_name)) ? $full_name : "" ?>">
        </div>

        <div class="mb-3 col-lg-6">
            <h4>Change Password</h4>
        </div>

        <div class="mb-3">
            <label for="input_old_password" class="form-label">Password</label>
            <input type="password" class="form-control" id="input_old_password" name="password_old">
        </div>

        <div class="mb-3">
            <label for="input_new_password" class="form-label">New Password</label>
            <input type="password" class="form-control" id="input_new_password" name="password_new">
        </div>

        <div class="mb-3">
            <label for="input_new_password_cf" class="form-label">Confirm Password New</label>
            <input type="password" class="form-control" id="input_new_password_cf" name="password_new_cf">
        </div>

        <div>
            <input type="submit" name="submit" value="Save" class="btn btn-primary">
        </div>
    </form>
</div>