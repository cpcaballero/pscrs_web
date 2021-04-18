<main>
    <div class="container-fluid">
        <div class="row">
            <div class="col s12">

                <div class="col s12">
                    <h5><strong>System Settings - Edit Admin</strong></h5>

                    <div class="row">
                        <div class="input-field col s4">
                            <input id="fname" name="fname" placeholder="Enter Firstname" type="text" class="validate" value="<?= $admin->fname ?>">
                            <label for="fname">First Name</label>
                        </div>
                        <div class="input-field col s4">
                            <input id="mname" name="mname" placeholder="Enter Middlename" type="text" class="validate" value="<?= $admin->mname ?>">
                            <label for="mname">Middle Name</label>
                        </div>
                        <div class="input-field col s4">
                            <input id="lname" name="lname" placeholder="Enter Lastname" type="text" class="validate" value="<?= $admin->lname ?>">
                            <label for="lname">Last Name</label>
                        </div>
                        <div class="input-field col s6">
                            <input id="contact_number" name="contact_number" placeholder="Enter Contact Number" type="number" class="validate" value="<?= $admin->contact_number ?>">
                            <label for="contact_number">Contact Number</label>
                        </div>
                        <div class="input-field col s6">
                            <input id="email_address" name="email_address" placeholder="Enter Email Address" type="email" class="validate" value="<?= $admin->email_address ?>">
                            <label for="email_address">Email Address</label>
                        </div>
                        <div class="input-field col s6">
                            <select name="is_expert" id="is_expert">
                                <option value="" disabled selected>Expert</option>
                                <option value="1" <?= (($admin->is_expert) ? "selected" : "") ?>>Yes</option>
                                <option value="0" <?= ((!$admin->is_expert) ? "selected" : "") ?>>No</option>
                            </select>
                        </div>
                        <div class="input-field col s12" id="field_of_study" style="display:none;">
                            <label for="field_study">Field of Study</label><br>
                            <textarea name="field_study" id="field_study"><?= $admin->field_study ?>
                            </textarea>
                        </div>
                        <input name="active_user" type="hidden" value="<?= $_SESSION['account']['details']['id'] ?>">
                        <input name="role" type="hidden" id="role" value="admin">
                        <input id="id" name="id" type="hidden" value="<?= $admin->id ?>">
                        <div class="col s12 right-align">
                            <button type="submit" class="btn light-blue darken-2 update_admin" id="update_admin_submit">Update</button>
                            <a class="btn teal lighten-2" href="<?= base_url() ?>Admin_FE/system_settings">Cancel</a>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</main>