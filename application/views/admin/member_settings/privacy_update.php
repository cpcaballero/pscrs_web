<main>
    <div class="container-fluid">
        <div class="row">
            <div class="col s12">
                <div class="col s12">
                    <h5><strong>Data Privacy Policy</strong></h5>
                    <textarea id="data_privacy" name="data_privacy"><?= $settings->data_privacy ?></textarea>
                </div>
                <div class="input-field col s12 right-align">
                    <button id="create_privacy_submit" type="button" class="btn light-blue darken-2 create">Submit</button>
                    <a href="<?= base_url('Admin_FE/member_settings') ?>" class="btn teal darken-2">Cancel</a>
                </div>
            </div>
        </div>
    </div>
</main>