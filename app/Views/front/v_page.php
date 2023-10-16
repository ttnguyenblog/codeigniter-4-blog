<div class="container p-4">
    <?php
    echo $content;
    ?>
</div>

<script>
    const navigationBarItems = document.querySelectorAll('.navigation-bar ul .about');
    navigationBarItems.forEach(item => {
            item.classList.add('active');
       
    });
</script>