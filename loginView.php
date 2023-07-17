<div class="login-logo">
    <a href="../../index2.html"><b>Admin</b></a>
</div>
<div class="card">
    <div class="card-body login-card-body">
        <p class="login-box-msg">Sign in to start your session</p>
        <?php
        if ($session->confirmation) {
            echo '<div class="alert alert-danger">' . $session->confirmation . '</div>';
        }
        ?>
        <form action="<?= $formAction; ?>" method="post">
            <input type="hidden" name="redirect_url" value="<?= $redirect_url; ?>">
            <div class="input-group mb-3">
                <input type="text" class="form-control <?php if ($session->username) {
                                                            echo "is-invalid";
                                                        } ?>" placeholder="Username" name="username">
                <div class="input-group-append">
                    <div class="input-group-text">
                        <span class="fas fa-user"></span>
                    </div>
                </div>
                <?php if ($session->username) {
                    echo '<span class="error invalid-feedback">' . $session->username . '</span>';
                } ?>
            </div>
            <div class="input-group mb-3">
                <input type="password" class="form-control <?php if ($session->password) {
                                                                echo "is-invalid";
                                                            } ?>" placeholder=" Password" name="password">
                <div class="input-group-append">
                    <div class="input-group-text">
                        <span class="fas fa-lock"></span>
                    </div>
                </div>
                <?php if ($session->password) {
                    echo '<span class="error invalid-feedback">' . $session->password . '</span>';
                } ?>
            </div>
            <div class="input-group mb-3">
                <i class="mb-1" style="color: red;"><?php print_r($session->errorCaptcha) ?></i>
                <img id="captcha_image" src="" class="img-fluid" alt="kode unik" style="width: -webkit-fill-available;">
            </div>
            <div class="input-group mb-3">
                <input type="text" class="form-control <?php if ($session->captcha) {
                                                            echo "is-invalid";
                                                        } ?>" name="captcha" autocomplete="off" placeholder="Masukan Kode Captcha">
                <div class="input-group-append">
                    <div class="input-group-text">
                        <span class="fas fa-puzzle-piece"></span>
                    </div>
                </div>
                <?php if ($session->captcha) {
                    echo '<span class="error invalid-feedback">' . $session->captcha . '</span>';
                } ?>
            </div>
            <div class="row">
                <div class="col-12">
                    <button type="submit" class="btn btn-primary btn-block">Sign In</button>
                </div>
            </div>
        </form>
    </div>
</div>

<script>
    let urlCaptcha = window.location.origin + '/system_login/get_captcha'
    $(document).ready(function() {
        $("#captcha_image").attr("src", urlCaptcha);
        // $("#refresh_capcta").click(function() {
        //     $("#captcha_image").attr("src", urlCaptcha + "?" + Math.random());
        // });
    });
</script>