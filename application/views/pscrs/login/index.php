<div class="container">

    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="shadow pb-3 my-5 card horizontal ">

                <div class="card-image px-5 pt-5">
                    <img src="<?= base_url() ?>assets/images/pscrs.png" width="100%">
                </div>

                <div class="card-stacked" style="width:100%;">
                    <div class="card-content  px-3"><br>

                        <form action="<?= base_url() ?>User/login" method="post">

                            <div class=form-group>
                                <div class="container-sm">
                                    <div class="input-group">
                                        <input type="text" name="username" style="width:100%;" required class="input-area">
                                        <label for="inputfield" class="label">Username</label>
                                    </div>
                                </div>

                                <div class=form-group>
                                    <div class="container-sm">
                                        <div class="input-group mb-3">
                                            <input type="password" name="password" style="width:100%;" required class="input-area">
                                            <label for="inputfield" class="label">Password</label>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <div class="row px-3">
                                        <div class="col-sm-12 col-lg-6">
                                            <a class="text-black-50" href="<?= base_url('Login_FE/forgotpassword') ?>">Forgot password?</a>
                                        </div>
                                        <div class="col-sm-12 col-lg-6">
                                            <a id="signup_link" class="text-black-50" href="<?= base_url('Login_FE/signup') ?>">No account? Sign up here.</a>
                                        </div>
                                    </div>


                                    <div class="container-sm">
                                        <div class=form-group>
                                            <button class="btn btn-primary full " type="submit">Login</button>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </form>

                    </div>
                </div>

            </div>
        </div>
    </div>
</div>