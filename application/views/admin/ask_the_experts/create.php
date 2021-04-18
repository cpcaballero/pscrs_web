<main>
    <div class="container-fluid">
        <div class="row">

            <div class="col s12">

                <div class="col s12">
                    <h5><strong>User List</strong>&emsp;<a href="<?= base_url() ?>Admin_FE/member_settings_create" class="btn light-blue darken-2">Create</a>
                </div>

                <div class="col s12">
                    <table id="users_table">
                        <thead>
                            <tr>
                                <th>Profile</th>
                                <th>Full Name</th>
                                <th>Username</th>
                                <th>Contact Number</th>
                                <th>Email Address</th>
                                <th>Expert Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <!-- <td>1</td> -->
                                <td><img class="responsive-img" src="<?= base_url() ?>storage/images/profile/thumb/MarcusCurioso1612258707_thumb.png"></td>
                                <td>Juan Dela Cruz</td>
                                <td>username</td>
                                <td>###-###-####</td>
                                <td>sample@gmail.com</td>
                                <td>
                                    <p>
                                        <label>
                                            <input type="checkbox" />
                                            <span>Expert</span>
                                        </label>
                                    </p>
                                </td>
                                <td style="width: 148px;">
                                    <div class="row">
                                        <a href="<?= base_url() ?>Admin_FE/ask_the_experts_user_view" class="btn btn-small teal lighten-2"><i class="material-icons">visibility</i></a>
                                        <a href="" class="btn btn-small black"><i class="material-icons">block</i></a>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <div class="input-field col s12">
                    <a href="<?= base_url('Admin_FE/expert_report') ?>" class="btn grey darken-2">Extract Report</a>
                </div>

            </div>

        </div>
    </div>
</main>