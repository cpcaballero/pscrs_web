<main>
    <div class="container-fluid">
        <div class="row">
            <div class="col s12">

                <div class="col s12">
                    <h5><strong>Surgical Videos - View</strong>
                </div>

                <div class="col s12 l12">
                    <div class="input-field col s12 l12">
                        <input readonly type="text" id="title" name="title" value="<?= $video->video_title ?>">
                        <label for="title">Title</label>
                    </div>

                    <div class="col s12 l12">
                        Description
                    </div>
                    <div class="input-field col s12 l12">
                        <textarea readonly id="description" name="description"><?= $video->video_desc ?></textarea>
                    </div>

                    <div class="input-field col s12 l12">
                        <input readonly type="text" id="video_link" name="video_link" value="<?= $video->video_link ?>">
                        <label for="video_link">Video Link</label>
                    </div>

                    <div class="col s12 l12">
                        <label for="video_link">Video Owner</label>
                    </div>
                    <div class="input-field col s12 l4">
                        <select class="select2" style="width:100%;" name="owner_user_id" id="owner_user_id" disabled>
                            <option value="" disabled selected>Place select owner</option>
                            <?php foreach ($users as $user) : ?>
                                <option value="<?= $user->id ?>" <?= (($user->id == $video->user_id) ? "selected" : "") ?>><?= $user->fullname ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="input-field col s12 l12">
                        <a href="<?= base_url('Admin_FE/surgical_videos') ?>" class="btn default darken-2 col s4 l2 ">Cancel</a>
                    </div>

                </div>

            </div>
        </div>
    </div>
</main>