<div class="container">

    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="shadow pb-3 my-5 card horizontal ">

                <div class="card-image px-5 pt-5">
                    <img src="<?= base_url() ?>assets/images/pscrs.png" width="100%">
                </div>
                <div class="card-stacked">
                    <div class="card-content px-3">
                        <form action="#" method="post">

                            <div class="card-body">
                                <h5 class="card-title">Profile Registration</h5>

                                <div class=form-group>
                                    <h6 class="card-title">First Name</h6>
                                    <div class="input-group">
                                        <input name="fname" type="text" id="fname" style="width:100%;" required class="input-area">
                                        <label for="fname" class="label">Enter First Name</label>
                                    </div>

                                    <h6 class="card-title">Last Name</h6>
                                    <div class="input-group">
                                        <input name="lname" type="text" id="lname" style="width:100%;" required class="input-area">
                                        <label for="lname" class="label">Enter Last Name</label>
                                    </div>

                                    <h6 class="card-title">Middle Name</h6>
                                    <div class="input-group">
                                        <input name="mname" type="text" id="mname" style="width:100%;" required class="input-area">
                                        <label for="mname" class="label">Enter Middle Name</label>
                                    </div>

                                    <h6 class="card-title">Email</h6>
                                    <div class="input-group">
                                        <input name="email_address" type="text" id="email_address" style="width:100%;" required class="input-area">
                                        <label for="email_address" class="label">Enter Email</label>
                                    </div>

                                    <h6 class="card-title">Contact Number</h6>
                                    <div class="input-group">
                                        <input name="contact_number" type="number" id="contact_number" style="width:100%;" required class="input-area">
                                        <label for="contact_number" class="label">Enter Contact Number</label>
                                    </div>

                                    <h6 class="card-title">Password</h6>
                                    <div class="input-group">
                                        <input name="pass" type="password" id="pass" style="width:100%;" required class="input-area" min_length>
                                        <label for="pass" class="label">Enter Password</label>
                                    </div>

                                    <h6 class="card-title">Re-enter Password</h6>
                                    <div class="input-group">
                                        <input name="repass" type="password" id="repass" style="width:100%;" required class="input-area">
                                        <label for="repass" class="label">Enter Password Again</label>
                                    </div>

                                    <!-- add recaptcha-->
                                    <!-- add recaptcha-->

                                    <div class=form-group>
                                        <div class="row">
                                            <div class="col-sm-12 col-lg-6 mb-3">
                                                <button class="btn btn-primary shadow-sm col-md-12" type="submit">Register</button>
                                            </div>
                                            <div class="col-sm-12 col-lg-6 mb-3">
                                                <a href="<?= base_url('Login_FE') ?>" class="btn btn-defaultf shadow-sm col-md-12" type="submit">Login</a>
                                            </div>
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