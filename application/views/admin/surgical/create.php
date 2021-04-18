<main>
    <div class="container-fluid">
        <div class="row">
            <div class="col s12">

                <div class="col s12">
                    <h5><strong>Surgical Videos - Create</strong></h5>
                </div>

                <div class="col s12 l12">
                    <form action="" id="create_video_form" method="post">

                        <div class="input-field col s12 l12">
                            <input type="text" id="title" name="title" class="validate">
                            <label for="title" data-error="wrong" data-success="right">Title</label>
                        </div>

                        <div class="col s12 l12">
                            Description
                        </div>
                        <div class="input-field col s12 l12">
                            <textarea id="description" name="description"></textarea>
                        </div>

                        <div class="input-field col s12 l12">
                            <input type="text" id="video_link" name="video_link" class="validate">
                            <label for="video_link" data-error="wrong" data-success="right">Video Link</label>
                        </div>

                        <div class="input-field col s12 l4">
                            <select class="select2" style="width:100%;" name="owner_user_id" id="owner_user_id">
                                <option value="" disabled selected>Place select owner</option>
                                <?php foreach ($users as $user) : ?>
                                    <option value="<?= $user->id ?>"><?= $user->fullname ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="col s12 l12" style="margin-top:20px;">
                            <div class="row">
                                <div class="col s12 m6 l2" style="margin-bottom:10px;"><button type="button" id="create_video_submit" class="btn light-blue darken-2 col s12">Create Video</button></div>
                                <div class="col s12 m6 l2" style="margin-bottom:10px;"><a href="<?= base_url('Admin_FE/surgical_videos') ?>" class="btn default darken-2 col s12">Cancel</a></div>
                            </div>
                        </div>

                        <input type="hidden" name="active_user" value="<?= $_SESSION['account']['details']['id'] ?>">

                    </form>

                </div>

            </div>
        </div>
    </div>
</main>