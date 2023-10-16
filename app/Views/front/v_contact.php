<div class="container p-4">
    <h2>Liên hệ</h2>
    <p>Chào bạn! Nếu bạn có câu hỏi liên quan tới nội dung bài viết, vui lòng để lại comment ngay phía dưới bài hoặc sử dụng form này. Quyên sẽ trả lời bạn trong thời gian sớm nhất có thể (từ 1 – 3 ngày làm việc).</p>

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

    <form id="contactForm" data-sb-form-api-token="API_TOKEN" action="" method="POST">
        <div class="form-floating mb-3">
            <input class="form-control" id="name" type="text" name="contact_name" value="<?php echo (isset($contact_name)) ? $contact_name : "" ?>" placeholder="Enter your name..." data-sb-validations="required" />
            <label for="name">Name</label>
            <div class="invalid-feedback" data-sb-feedback="name:required">
                A name is required.
            </div>
        </div>
        <div class="form-floating mb-3"">
            <input class="form-control" id="email" type="email" name="contact_email" value="<?php echo (isset($contact_email)) ? $contact_email : "" ?>" placeholder="Enter your email..." data-sb-validations="required,email" />
            <label for="email">Email address</label>
            <div class="invalid-feedback" data-sb-feedback="email:required">
                An email is required.
            </div>
            <div class="invalid-feedback" data-sb-feedback="email:email">
                Email is not valid.
            </div>
        </div>
        <div class="form-floating mb-3">
            <input class="form-control" id="phone" type="tel" name="contact_tel" value="<?php echo (isset($contact_tel)) ? $contact_tel : "" ?>" placeholder="Enter your phone number..." data-sb-validations="required" />
            <label for="phone">Phone Number</label>
            <div class="invalid-feedback" data-sb-feedback="phone:required">
                A phone number is required.
            </div>
        </div>
        <div class="form-floating">
            <textarea class="form-control" id="message" name="contact_message" placeholder="Enter your message here..." style="height: 12rem" data-sb-validations="required"><?php echo (isset($contact_message)) ? $contact_message : "" ?></textarea>
            <label for="message">Message</label>
            <div class="invalid-feedback" data-sb-feedback="message:required">
                A message is required.
            </div>
        </div>
        <br />
        <!-- Submit success message-->
        <!---->
        <!-- This is what your users will see when the form-->
        <!-- has successfully submitted-->
        <div class="d-none" id="submitSuccessMessage">
            <div class="text-center mb-3">
                <div class="fw-bolder">Form submission successful!</div>
                To activate this form, sign up at
                <br />
                <a href="https://startbootstrap.com/solution/contact-forms">https://startbootstrap.com/solution/contact-forms</a>
            </div>
        </div>
        <!-- Submit error message-->
        <!---->
        <!-- This is what your users will see when there is-->
        <!-- an error submitting the form-->
        <div class="d-none" id="submitErrorMessage">
            <div class="text-center text-danger mb-3">
                Error sending message!
            </div>
        </div>
        <!-- Submit Button-->
        <!-- <button class="btn btn-primary text-uppercase disabled" id="submitButton" type="submit">
            Send
        </button> -->
        <input class="btn btn-outline-secondary text-uppercase" type="submit" name="submit" value="Gửi" />
    </form>
</div>

<script>
    const navigationBarItems = document.querySelectorAll('.navigation-bar ul .contact');
    navigationBarItems.forEach(item => {
            item.classList.add('active');
       
    });
</script>