<main>
    <div class="container-fluid">
        <div class="row">
            <div class="col s12">

                <div class="col s12">
                    <h5><strong>Instructional Lectures - Update</strong></h5>

                </div>

                <div class="col s12 l12">

                    <form action="" id="update_lecture_form" method="post">

                        <div class="input-field col s12 l12">
                            <input type="text" id="title" name="title" class="validate" value="<?= $lecture->video_title ?>">
                            <label for="title" data-error="wrong" data-success="right">Title</label>
                        </div>

                        <div class="col s12 l12">
                            Description
                        </div>
                        <div class="input-field col s12 l12">
                            <textarea id="description" name="description" class="materialize-textarea"><?= $lecture->video_desc ?></textarea>
                        </div>

                        <div class="input-field col s12 l12">
                            <input type="text" id="video_link" name="video_link" class="validate" value="<?= $lecture->video_link ?>">
                            <label for="video_link" data-error="wrong" data-success="right">Lecture Link</label>
                        </div>

                        <div class="col s12 l12">
                            <label for="video_link">Video Owner</label>
                        </div>
                        <div class="input-field col s12 l4">
                            <select class="select2" style="width:100%;" name="owner_user_id" id="owner_user_id">
                                <option value="" disabled>Please select owner</option>
                                <?php foreach ($users as $user) : ?>
                                    <option value="<?= $user->id ?>" <?= (($user->id == $lecture->user_id) ? "selected" : "") ?>><?= $user->fullname ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <div class="col s12 l12" style="margin-top:20px;">
                            <div class="row">
                                <div class="col s12 m6 l2" style="margin-bottom:10px;"><button type="button" id="update_lecture_submit" class="btn light-blue darken-2 col s12">Update</button></div>
                                <div class="col s12 m6 l2" style="margin-bottom:10px;"><a href="<?= base_url('Admin_FE/instructional_lectures') ?>" class="btn default darken-2 col s12">Cancel</a></div>
                            </div>
                        </div>

                        <input type="hidden" name="active_user" value="<?= $_SESSION['account']['details']['id'] ?>">
                        <input type="hidden" name="id" id="id" value="<?= $lecture->video_id ?>">
                    </form>

                </div>

            </div>
        </div>
    </div>
</main>