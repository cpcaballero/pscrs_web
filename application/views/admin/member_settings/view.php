<main>
    <div class="container-fluid">
        <div class="row">

            <div class="col s12">
                <div class="col s12">
                    <h4><strong>Member View</strong></h4>
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
                            <div class="card-content">
                                <div class="row">
                                    <div class="col s12 flow-text">
                                        <div class="col s6">
                                            <h5>Username:</h5>
                                            <h5>Contact Number:</h5>
                                            <h5>Email Address:</h5>
                                            <h5>Role:</h5>
                                            <h5>Expert:</h5>
                                            <h5>Status:</h5>
                                            <h5>Last Login:</h5>
                                        </div>

                                        <div class="col s6">
                                            <h5><strong><?= $expert->username ?></strong></h5>
                                            <h5><strong><?= $expert->contact_number ?></strong></h5>
                                            <h5><strong><?= $expert->email_address ?></strong></h5>
                                            <h5><strong><?= strtoupper($expert->role) ?></strong></h5>
                                            <h5><strong><?= (($expert->is_expert) ? "YES" : "NO") ?></strong></h5>
                                            <h5><strong><?= (($expert->status) ? "ALLOWED" : "BLOCKED") ?></strong></h5>
                                            <h5><strong><?= ((strtotime($expert->last_login) >= 0) ? date('F d, Y h:i:s A', strtotime($expert->last_login)) : "N/A") ?></strong></h5>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="input-field col s12 right-align">
                    <a href="<?= base_url('Admin_FE/member_settings') ?>" class="btn teal darken-2">Cancel</a>
                </div>
            </div>

        </div>
    </div>
</main>