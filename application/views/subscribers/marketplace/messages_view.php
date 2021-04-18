<main>
    <div class="container-fluid">
        <div class="row">
            <div class="col s12" style="margin-bottom: 3%; margin-top:1%;">
                    <a href="<?= base_url('Subscribers_FE/marketplace_messages') ?>" class="btn default darken-2">Go To My Messages</a>
            </div>
            <div class="col s12">

                <div class="col s12 ">
                    <h5><strong>Marketplace - Message</strong></h5>
                </div>
                <div class="col s12" style="margin-bottom: 3%;">
                    <div class="col s3 l1">
                        <img width="100%" src="<?= ((!empty($seller->profile_thumb)) ?  $seller->profile_orig : base_url('assets/images/avatar.png')) ?>" alt="" class="circle responsive-img ">
                    </div>
                    <div class="col s9 l11">
                        <h5 style="margin-bottom: 0px;"><strong><?= $seller->fullname ?></strong></h5>
                        <p style="margin-bottom: 0px; margin-top: 5px;"><strong>User ID: </strong> <?= $seller->id ?></p>
                    </div>
                </div>

                <div class="col s12 myBox">
                    <?php $msg_count = 0; ?>
                    <?php $db_convo_id = false; ?>
                    <?php if ($thread) : ?>
                        <?php foreach ($thread as $content) : ?>
                            <?php $db_convo_id = $content->convo_id; ?>
                            <div class="col s8 card message <?= (($content->sender_id != $_SESSION['account']['details']['id']) ? "grey lighten-5" : "right teal lighten-2") ?>">
                                <h6 style="padding:8px;" class="<?= (($content->sender_id == $_SESSION['account']['details']['id']) ? "white-text" : "black-text") ?>"><?= $content->msg_content ?></h6>
                            </div>
                            <?php $msg_count += 1; ?>

                        <?php endforeach; ?>
                    <?php endif; ?>
                    <?php if ($msg_count <= 0) : ?>
                        <h5><strong>No Messages yet.</strong></h5>
                    <?php endif; ?>
                </div>
            </div>
        </div>
        <div class="row grey lighten-2">
            <div class="col s9 l10">
                <div class="input-field valign-wrapper">
                    <input name="message" id="message" type="text" class="validate">
                    <input type="hidden" id="convo_id" name="convo_id" value="<?= $db_convo_id ? $db_convo_id : $convo_id ?>">
                </div>
            </div>
            <div class="col s3 l2">
                <div class="input-field valign-wrapper">
                    <button type="button" onclick="send_message('<?= $_SESSION['account']['details']['id'] ?>','<?= $seller->id ?>')" class="btn light-blue darken-2 col s12"><i class="material-icons">near_me</i></button>
                </div>
            </div>
        </div>
    </div>
</main>