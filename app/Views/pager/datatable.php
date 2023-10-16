<nav class="dataTable-pagination">
    <ul class="dataTable-pagination-list">
       
        <?php
        foreach ($pager->links() as $link) {
            $activeclass = $link['active'] ? 'active' : '';
        ?>
            <li class="<?php echo $activeclass ?>">
                <a href='<?php echo $link['uri'] ?>'><?php echo $link['title'] ?></a>
            </li>
        <?php
        }
        ?>
    </ul>
</nav>