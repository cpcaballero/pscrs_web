<main>
    <div class="container-fluid">
        <div class="row">

            <form id="create_member_form" action="" method=" post">
                <div class="col s12">
                    <div class="col s12">
                        <h5><strong>Member Settings - Create Member</strong></h5>
                    </div>

                    <div class="row col s12">
                        <div class="input-field col s4">
                            <input id="fname" name="fname" type="text" class="validate">
                            <label for="fname">First Name</label>
                        </div>
                        <div class="input-field col s4">
                            <input id="mname" name="mname" type="text" class="validate">
                            <label for="mname">Middle Name</label>
                        </div>
                        <div class="input-field col s4">
                            <input id="lname" name="lname" type="text" class="validate">
                            <label for="lname">Last Name</label>
                        </div>
                        <div class="input-field col s6">
                            <input id="contact_number" name="contact_number" type="number" class="validate">
                            <label for="contact_number">Contact Number</label>
                        </div>
                        <div class="input-field col s6">
                            <input id="email_address" name="email_address" type="email" class="validate">
                            <label for="email_address">Email Address</label>
                        </div>
                        <div class="input-field col s6">
                            <input id="password" name="pass" type="password" class="validate">
                            <label for="password">Password</label>
                        </div>
                        <div class="input-field col s6">
                            <select name="is_expert" id="is_expert">
                                <option value="" disabled selected>Expert</option>
                                <option value="1">Yes</option>
                                <option value="0">No</option>
                            </select>
                        </div>
                        <div class="input-field col s12" id="field_of_study" style="display:none;">
                            <label for="field_study">Field of Study</label><br>
                            <textarea name="field_study" id="field_study">
                            </textarea>
                        </div>
                        <input name="active_user" type="hidden" value="<?= $_SESSION['account']['details']['id'] ?>">
                        <input name="role" type="hidden" value="member">

                        <div class="input-field col s12 right-align">
                            <button id="create_member_submit" type="button" class="btn light-blue darken-2 create">Create</button>
                            <a href="<?= base_url('Admin_FE/member_settings') ?>" class="btn teal darken-2">Cancel</a>
                        </div>
                    </div>
                </div>
            </form>

        </div>
    </div>
</main>