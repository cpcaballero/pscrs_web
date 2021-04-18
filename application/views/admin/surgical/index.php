<main>
    <div class="container-fluid">
        <div class="row">

            <div class="col s12">

                <div class="col s12 ">
                    <h5><strong>Surgical Videos</strong>&emsp;<a href=" <?= base_url() ?>Admin_FE/surgical_create" class="btn light-blue darken-2">Create</a></h5>
                </div>

                <div class="col s12">
                    <table id="video_table">
                        <thead>
                            <tr>
                                <th width="20%"></th>
                                <th>Details</th>
                                <th>Link</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                    </table>
                </div>
                <div class="input-field col s12 m6 l2">
                    <a href="<?= base_url('Admin_FE/surgical_report') ?>" class="btn grey darken-2 col s12">Extract Report</a>
                </div>

            </div>

        </div>
    </div>
</main>