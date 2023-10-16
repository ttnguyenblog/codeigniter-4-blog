<div class="container p-4">

    <div class="container">
        <div class="row">
            <h2 class="mb-3">Blog</h2>
            <?php foreach ($record as $key => $value) { ?>
                <div class="col-lg-4 col-md-6 mb-4">
                    <div class="card rounded shadow border-0">
                        <div class="bg-image">
                            <img class="w-100 " style="width: 250px; height:250px;" src="/upload/<?php echo $value['post_thumbnail'] ?>" alt="" />
                        </div>

                        <div class="card-body p-3">
                            <a href="<?php echo set_post_link($value['post_id']) ?>" class="text-dark">
                                <h4><?php echo $value['post_title'] ?></h4>

                            </a>
                            <p class="text-muted small">
                                <a href="#!" style="text-decoration: none;"><?php echo post_author($value['username']) ?></a> on <?php echo $value['post_time'] ?>
                            </p>
                            <p><?php echo $value['post_description'] ?></p>
                            <a class="btn btn-outline-dark" href="<?php echo set_post_link($value['post_id']) ?>">Read more</a>
                        </div>
                        </a>
                    </div>
                </div>

            <?php } ?>
            <hr class="my-4" />
        </div>
    </div>
    <?php echo $pager->simpleLinks('ft', 'front') ?>
</div>

<script>
    const navigationBarItems = document.querySelectorAll('.navigation-bar ul .blog');
    navigationBarItems.forEach(item => {
            item.classList.add('active');
       
    });
</script>