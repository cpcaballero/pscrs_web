<main>
    <div class="container-fluid">
        <div class="row">
            <div class="col s12">
                <div class="col s12">
                    <h5><strong>Tech News - View</strong></h5>
                </div>

                <div class="col s12 l12">
                    <div class="input-field col s12 l6">
                        <input placeholder="Enter information title" type="text" class="validate" value="<?= $news->title ?>" disabled>
                        <label for="title" data-error="wrong" data-success="right">Title</label>
                    </div>

                    <div class="col s12 l12">
                        Content
                    </div>
                    <div class="input-field col s12">
                        <textarea name="description" disabled><?= $news->description ?></textarea>
                    </div>

                    <!-- <div class="input-field col s12">
                        <h5>Image</h5>
                        <input type="file" disabled>
                    </div> -->

                    <div class="col s12 l12">
                        <label for="video_link">News Owner</label>
                    </div>
                    <div class="input-field col s12 l4">
                        <select class="select2" style="width:100%;" name="owner_user_id" id="owner_user_id" disabled>
                            <option value="" disabled selected>Place select owner</option>
                            <?php foreach ($users as $user) : ?>
                                <option value="<?= $user->id ?>" <?= (($user->id == $news->user_id) ? "selected" : "") ?>><?= $news->article_author ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="col s12 l12" style="margin-top:20px;">
                        <div class="row">
                            <div class="col s12 m6 l2" style="margin-bottom:10px;"><a href="<?= base_url('Admin_FE/technology_news') ?>" class="btn default darken-2 col s12 ">Cancel</a></div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</main>