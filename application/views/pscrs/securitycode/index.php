<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-6">

            <div class="card horizontal shadow my-5 ">
                <form action="<?= base_url() ?>User/login" method="post">

                    <div class="card-body">
                        <h5 class="card-title">Enter Security Code</h5>

                        <label class="mb-4">
                            Please check your email for a message with your code.
                        </label>
                        <div class="row">
                            <div class="col-sm-12 col-lg-6 mb-3">
                                <div class="input-group">
                                    <input type="hidden" name="id" value="<?= $_SESSION['temp_details']['id'] ?>">
                                    <input type="text" name="token" id="token" required class="input-area">
                                    <label for="inputfield" class="label">Enter Code</label>
                                </div>
                            </div>
                            <div class="col-sm-12 col-lg-6 text-right mb-3">
                                <label>
                                    We sent your code to:
                                </label>

                                <div>
                                    <label>
                                        ###########
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="row justify-content-end">
                                <div class="col-sm-12 col-lg-3 mb-3">
                                    <button class="btn btn-primary btn-sm shadow-sm col-md-12" type="submit">Confirm</button>
                                </div>
                                <div class="col-sm-12 col-lg-3 mb-3">
                                    <a href="<?= base_url('Login_FE') ?>" class="btn btn-outline-primary btn-sm shadow-sm col-md-12" type="submit">Cancel</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- 
<div class="container">

    <div class="child">

        <div class=" shadow p-3 mb-5 bg-white rounded changepwcard horizontal ">

            <div class="card-stacked" style="width: 32rem; ">
                <div class="card-content" style="background-color: #ffffff; height: 18rem;"><br>

                    <form action="<?= base_url() ?>User/login" method="post">

                        <div class="card-body">
                            <h5 class="card-title">Enter Security Code</h5>

                            <label class="form-check-label" for="flexRadioDefault1">
                                Please check your email for a message with your code, Your code is 6 number long.
                            </label>

                            <div class="input-group textcode">
                                <input type="hidden" name="id" value="<?= $_SESSION['temp_details']['id'] ?>">
                                <input type="text" name="token" id="token" style="width: 10rem;" required class="input-area">
                                <label for="inputfield" class="label">Enter Code</label>
                            </div>

                            <div class="code">
                                <label class="form-check-label" for="flexRadioDefault1">
                                    We sent your code to:
                                </label>

                                <div class="sentcode">
                                    <label class="form-check-label" for="flexRadioDefault1">
                                        ###########
                                    </label>
                                    <div>
                                        <button type="submit" class="btn btn-primary btncode">Confirm</button>
                                        <a href="<?= base_url('Login_FE') ?>" class="btn btn-outline-primary btncode1">cancel</a>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </form>

                </div>
            </div>
        </div>
    </div>
</div> -->