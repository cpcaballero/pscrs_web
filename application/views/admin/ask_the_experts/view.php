<main>
    <div class="container-fluid">
        <div class="row">

            <div class="col s12">

                <div class="col s12">
                    <h5><strong>Expert View</strong></h5>
                </div>

                <div class="col s12">
                    <div class="card horizontal">
                        <div class="card-image col s3 light-blue darken-1">
                            <img class="responsive-img" src="<?= (($expert->profile_orig) ? $expert->profile_orig : base_url('assets/images/avatar.png')) ?>">

                            <div class="row center">
                                <div class="input-field col s12">
                                    <span>Full Name</span>
                                    <h4><strong><?= $expert->fullname ?></strong></h4>
                                </div>
                            </div>
                        </div>
                        <div class="card-stacked">
                            <div class="card-content light-blue lighten-3">
                                <div class="row">
                                    <div class="col s12 flow-text">
                                        <div class="col s6">
                                            <h5>Contact Number: <br><strong><?= $expert->contact_number ?></strong></h5>
                                        </div>
                                        <div class="col s6">
                                            <h5>Email Address: <strong><?= $expert->email_address ?></strong></h5>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col s12 flow-text">
                                        <div class="col s6">
                                            <h5>Field of Study:</h5>
                                        </div>
                                        <div class="col s12"><br>
                                            <?= $expert->field_study ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="input-field col s12 right-align">
                    <a href="<?= base_url('Admin_FE/ask_the_experts') ?>" class="btn teal darken-2">Cancel</a>
                </div>

            </div>

        </div>

    </div>
    </div>
</main>