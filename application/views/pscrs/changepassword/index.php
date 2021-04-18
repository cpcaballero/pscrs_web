<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-6">

            <div class="card horizontal shadow pb-3 my-5 ">

                <form action="#" method="post">
                    <div class="card-body">
                        <h5 class="card-title">Find your account</h5>

                        <div class="form-group">
                            <label class="mb-4">
                                Please enter email to search your account
                            </label>
                            <div class="input-group">
                                <input type="text" name="email" style="width:100%;" required class="input-area">
                                <label for="inputfield" class="label">Enter Email Address</label>
                            </div>
                        </div>
                        <!-- <div class="form-group">
                            <button type="submit" class="btn btn-primary">Confirm</button>
                            <a href="<?= base_url('Login_FE') ?>" class="btn btn-outline-primary">cancel</a>
                        </div> -->
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