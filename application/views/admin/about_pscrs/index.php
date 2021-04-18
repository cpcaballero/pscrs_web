<main>
    <div class="container-fluid">
        <div class="row">

            <div class="col s12">

                <div class="col s12">
                    <h5><strong>About PSCRS</strong></h5>
                </div>

                <div class="col s12">
                    <div class="col s12 card">
                        <form>
                            <div class="input-field">
                                <h5>Vision</h5>
                            </div>
                            <div class="input-field">
                                <textarea name="vision"><?= (($about) ? $about->vision : "") ?></textarea>
                            </div>

                            <div class="input-field">
                                <h5>Mission</h5>
                            </div>
                            <div class="input-field">
                                <textarea name="mission"><?= (($about) ? $about->mission : "") ?></textarea>
                            </div>

                            <div class="input-field">
                                <h5>President Message</h5>
                            </div>
                            <div class="input-field">
                                <textarea name="pres_message"><?= (($about) ? $about->pres_message : "") ?></textarea>
                            </div>


                        </form>

                        <div class="input-field col s12 right-align">
                            <button class="btn light-blue darken-2" id='about_pscrs_update'>update</button>
                        </div>
                    </div>
                </div>


            </div>

        </div>
    </div>
</main>