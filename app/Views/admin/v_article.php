<?php

?>
<div class="card-header">
    <i class="fas fa-table me-1"></i>
    <?php echo $titleTemplate ?>
</div>
<div class="card-body">
    <div class="row mb-3">
        <div class="col-lg-3 pt-1 pb-1">
            <form action="" method="GET">
                <input type="text" placeholder="Keyword..." name="keyword" class="form-control" value="<?php echo $keyword ?>">
            </form>
        </div>
        <div class="col-lg-9 pt-1 pb-1 text-end">
            <a href="<?php echo site_url("admin/article/add") ?>" class="btn btn-xl btn-primary">+ Add New</a>
        </div>
    </div>
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
    <table class="table table-bordered">
        <thead>
            <tr>
                <th class="col-1">No.</th>
                <th class="col-6">Title</th>
                <th class="col-3">Date</th>
                <th class="col-2 text-center">Action</th>
            </tr>
        </thead>
        <tbody>
            <?php
            
            foreach ($record as $value) {
                $post_id = $value['post_id'];
                $link_edit = site_url("admin/article/edit/$post_id");
                $link_delete = site_url("admin/article/?action=delete&post_id=$post_id");
            ?>
                <tr>
                    <td><?php echo $number ?></td>
                    <td><?php echo $value['post_title'] ?></td>
                    <td><?php echo $value['post_time'] ?></td>
                    <td>
                        <a href='<?php echo $link_edit ?>' class="btn btn-sm btn-warning">Edit</a>
                        <a href="<?php echo $link_delete ?>" onclick="return confirm('Are you sure you want to delete this post?')" class="btn btn-sm btn-danger">Del</a>
                    </td>
                </tr>
            <?php
                $number++;
            }
            ?>
        </tbody>
    </table>
    <?php echo $pager->links('dt','datatable'); ?>
</div>