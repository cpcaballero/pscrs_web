<main>
    <div class="container-fluid">
        <div class="row">

            <div class="col s12">

                <div class="col s12">
                    <h5><strong>List of Experts</strong>&emsp;<a href="<?= base_url() ?>Admin_FE/member_settings" class="btn light-blue darken-2">Create</a></h5>
                </div>

                <div class="col s12">
                    <table id="expert_table">
                        <thead>
                            <tr>
                                <th>Expert Name</th>
                                <th>Field of Study</th>
                                <th>Contact Number</th>
                                <th>Email</th>
                                <th>Last Login</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                    </table>
                </div>

                <div class="input-field col s12">
                    <a href="<?= base_url('Admin_FE/expert_report') ?>" class="btn grey darken-2">Extract Report</a>
                </div>

            </div>

        </div>
    </div>
</main>