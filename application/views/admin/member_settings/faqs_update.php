<main>
    <div class="container-fluid">
        <div class="row">
            <div class="col s12">
                <div class="col s12">
                    <h5><strong>FAQs</strong></h5>
                    <textarea id="faqs" name="faqs"><?= $settings->faq ?></textarea>
                </div>
                <div class="input-field col s12 right-align">
                    <button id="create_faq_submit" type="button" class="btn light-blue darken-2 create">Submit</button>
                    <a href="<?= base_url('Admin_FE/member_settings') ?>" class="btn teal darken-2">Cancel</a>
                </div>
            </div>
        </div>
    </div>
</main>