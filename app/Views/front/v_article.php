<div class="container p-4">
    <h1><?php echo $title; ?></h1>
    <p>
        Post by <a href="#!" style="text-decoration: none;"><?php echo post_author($author) ?></a> on <?php echo $time ?>
    </p>
    <div class="d-flex justify-content-center">
        <img class="img-fluid mb-3" style="width: 60%;" src="/upload/<?php echo $thumbnail ?>" alt="">
    </div>

    <?php
    echo $content;
    ?>

</div>