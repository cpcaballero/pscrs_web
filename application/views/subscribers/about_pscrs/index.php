<main>
    <div class="container-fluid">
        <div class="row">
            <div class="col s12">
                <div class="col s12">
                    <h4><strong>Vision</strong></h4>
                    <?= (($about) ? $about->vision : "") ?>
                </div>
                <div class="col s12">
                    <h4><strong>Mission</strong></h4>
                    <?= (($about) ? $about->mission : "") ?>
                </div>
                <div class="col s12">
                    <h4><strong>President's Message</strong></h4>
                    <?= (($about) ? $about->pres_message : "") ?>
                </div>
            </div>
        </div>
    </div>
</main>