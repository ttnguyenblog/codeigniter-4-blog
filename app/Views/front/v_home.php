<!--start About Us-->
<div class="about-us">
    <div class="text">
        <h3>Hà Giang</h3>
        <div><i class="fas fa-asterisk"></i></div>
        <p>Hà Giang là tỉnh địa đầu của Tổ quốc, phía Đông giáp tỉnh Cao Bằng, phía Tây giáp tỉnh Yên Bái và Lào Cai, phía Nam giáp tỉnh Tuyên Quang, phía Bắc giáp Trung Quốc. Các cung đường Hà Giang quanh co, cheo leo vốn đầy thách thức cho người lái xe. Thế nhưng khi bạn phóng tầm mắt xung quanh, căng thẳng nhường lại chỗ cho cảm giác thư thái khi chiêm ngưỡng vẻ đẹp cao nguyên.</p>
        <div><a class="a-CTA" href="#" style=" text-decoration: none;">Chi tiết</a></div>
    </div>
    <div class="image-container">
        <div class="image image1">
            <img src="/home/assets/2.jpg" alt="Food Photo">
        </div>

    </div>
</div>
<!--End About Us-->

<!--start Recipes-->
<div class="recipes">
    <div class="image"></div>
    <div class="text">
        <h3>Sông Nho Quế</h3>
    </div>
</div>
<!--End Recipes-->

<!--start Menu-->
<div class="menu">
    <div class="box-model">
        <i class="fas fa-times fa-2x close"></i>
        <div class="arrow">
            <div class="arrow arrow-right"></div>
            <div class="arrow arrow-left"></div>
        </div>
        <div class="box-image-container">
            <div class="box-image">
                <img src="" alt="Food Photo">
            </div>
        </div>
    </div>
    <div class="menu-image-container">
        <div class="image active">
            <img src="/home/assets/4.jpg" alt="Food Photo">
        </div>
        <div class="image">
            <img src="/home/assets/5.jpg" alt="Food Photo">
        </div>
        <div class="image">
            <img src="/home/assets/6.jpg" alt="Food Photo">
        </div>
        <div class="image">
            <img src="/home/assets/7.jpg" alt="Food Photo">
        </div>
    </div>
    <div class="text">
        <h3>Ninh Bình</h3>
        <div><i class="fas fa-asterisk"></i></div>
        <p>Muốn đi du lịch để tận hưởng không khí yên bình và khám phá sự hùng vĩ của thiên nhiên đất trời thì chắc hẳn bạn không nên bỏ qua Ninh Bình. Mang trong mình nét đẹp hoài cổ hòa cùng khung cảnh bao la, bạn chắc chắn sẽ có được những trải nghiệm tuyệt vời khi đặt chân đến vùng đất này. </p>
        <div><a class="a-CTA" style=" text-decoration: none;" href="#">Xem thêm</a></div>
    </div>
</div>
<!--End Menu-->

<!--Start fixed-image-->
<div class="fixed-image">
    <div class="text">
        <h3>Tràng An - Ninh Bình</h3>
    </div>
</div>
<!--End fixed-image-->

<div class="container p-4">

    <div class="row">
        <div class="col-12">
            <h2 class="mb-3">Bài viết nổi bật</h2>
        </div>
    </div>

    <div class="container">
        <div class="row">
            <?php foreach ($record as $key => $value) { ?>
                <div class="col-lg-4 col-md-6 mb-4">
                    <div class="card rounded shadow border-0">
                        <div class="bg-image">
                            <img class="w-100" style="width: 250px; height:250px;" src="/upload/<?php echo $value['post_thumbnail'] ?>" alt="" />
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
        </div>
    </div>

</div>

