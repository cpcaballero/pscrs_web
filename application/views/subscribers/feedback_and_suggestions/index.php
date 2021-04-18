<main>
    <div class="container-fluid" style="padding-left: 20px; padding-right:20px;">
        <div class="row">
            <div class="col s12">
                <h5><strong>Contact Us</strong></h5>
            </div>

            <div class="col s12 ">
                <?php if (isset($contact[0])) : ?>
                    <p class="valign-wrapper"><i class="material-icons">email</i>&ensp;<?= $contact[0]->email ?></p>
                    <p class="valign-wrapper"><i class="material-icons">local_phone</i>&ensp;<?= $contact[0]->telephone ?> </p>
                    <p class="valign-wrapper"><i class="material-icons">place</i> <?= $contact[0]->address ?> </p>
                <?php else : ?>
                    <p class="valign-wrapper"><i class="material-icons">email</i>&ensp;N/A</p>
                    <p class="valign-wrapper"><i class="material-icons">local_phone</i>&ensp;N/A</p>
                    <p class="valign-wrapper"><i class="material-icons">place</i>&ensp;N/A</p>
                <?php endif; ?>

            </div>

            <div class="col s12">
                <h5><strong>Send Us Feedback or Suggestion</strong></h5>
            </div>

            <div class="col s12 ">
                <form>
                    <input type="hidden" name="name" id="name" value="<?= $_SESSION['account']['details']['fullname'] ?>">
                    <input type="hidden" name="email" id="email" value="<?= $_SESSION['account']['details']['email'] ?>">
                    <input type="hidden" name="contact_number" id="contact_number" value="<?= $_SESSION['account']['details']['contact_number'] ?>">
                    <div class="input-field">
                        <input type="text" id="subject" name="subject" class="validate">
                        <label for="subject" data-error="wrong" data-success="right">Subject</label>
                    </div>

                    <div class="input-field">
                        <textarea name="message"></textarea>
                    </div>
                    <div class="right">
                        <div class="input-field col s12" style="padding:0px;">
                            <button class="btn light-blue darken-2 col s12" type="submit">Send Feedback
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</main>