<main>
    <div class="container-fluid">
        <div class="row">
            <div class="col s12">


                <div class="col s12">
                    <h5><strong>Admin Profile - Change Password</strong></h5>
                </div>



                <div class="col s12 l12">

                    <div class="col s3">
                        <img class="responsive-img" src="<?= base_url('assets/images/avatar.png') ?>">
                        <!-- <img class="responsive-img" src="<?= (($expert->profile_orig) ? $expert->profile_orig : base_url('assets/images/avatar.png')) ?>"> -->
                    </div>

                    <div class="col s9">
                        <form class="">
                            <div class="input-field col s12 l12">
                                <input disabled placeholder="Enter your name" id="name" type="text" class="validate" value="<?= $admin->fullname ?>">
                                <label for="name"><strong>Name</strong></label>
                            </div>

                            <div class="input-field col s12 l12">
                                <input disabled placeholder="Enter your email" id="email" type="text" class="validate" value="<?= $admin->email_address ?>">
                                <label for="email"><strong>Email</strong></label>
                            </div>

                            <div class="input-field col s12 l12">
                                <input disabled placeholder="Enter your contact number" id="contact_number" type="text" class="validate" value="<?= $admin->contact_number ?>">
                                <label for="contact_number"><strong>Contact Number</strong></label>
                            </div>

                            <div class="input-field col s4">
                                <input id="old_pass" name="old_pass" placeholder="Placeholder" type="password" class="validate">
                                <label for="old_pass">Current Password</label>
                            </div>

                            <div class="input-field col s4">
                                <input id="new_pass" name="new_pass" placeholder="Placeholder" type="password" class="validate">
                                <label for="new_pass">New Password</label>
                            </div>

                            <div class="input-field col s4">
                                <input id="retype_pass" name="retype_pass" placeholder="Placeholder" type="password" class="validate">
                                <label for="retype_pass">Confirm New Password</label>
                            </div>

                            <div class="col s12 right-align">
                                <a class="btn light-blue darken-2 change_pass">Update</a>
                                <a class="btn teal lighten-2" href="<?= base_url() ?>Admin_FE/system_settings">Cancel</a>
                            </div>
                        </form>
                    </div>

                </div>

            </div>
        </div>
    </div>
</main>