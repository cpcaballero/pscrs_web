<main>
    <div class="container-fluid">
        <div class="row">
            <div class="col s12">

                <div class="col s12">
                    <h5><strong>Instructional Lectures - View</strong></h5>

                </div>

                <div class="col s12 l12">

                    <form action="" id="create_lecture_form" method="post">

                        <div class="input-field col s12 l12">
                            <input disabled type="text" id="title" name="title" class="validate" value="<?= $lecture->video_title ?>">
                            <label for="title" data-error="wrong" data-success="right">Title</label>
                        </div>

                        <div class="col s12 l12">
                            Description
                        </div>
                        <div class="input-field col s12 l12">
                            <textarea disabled id="description" name="description"><?= $lecture->video_desc ?></textarea>
                        </div>

                        <div class="input-field col s12 l12">
                            <input disabled type="text" id="lectures_link" name="video_link" class="validate" value="<?= $lecture->video_link ?>">
                            <label for="lectures_link" data-error="wrong" data-success="right">Lecture Link</label>
                        </div>

                        <div class="col s12 l12">
                            <label for="video_link">Video Owner</label>
                        </div>
                        <div class="input-field col s12 l4">
                            <select class="select2" style="width:100%;" name="owner_user_id" id="owner_user_id" disabled>
                                <option value="" disabled>Please select owner</option>
                                <?php foreach ($users as $user) : ?>
                                    <option value="<?= $user->id ?>" <?= (($user->id == $lecture->user_id) ? "selected" : "") ?>><?= $user->fullname ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <div class="input-field col s12 l12">
                            <div class="row">
                                <div class="col s6 l2"><a href="<?= base_url('Admin_FE/instructional_lectures') ?>" class="btn default darken-2 col s12">Cancel</a></div>
                            </div>
                        </div>

                        <input type="hidden" name="active_user" value="<?= $_SESSION['account']['details']['id'] ?>">

                    </form>

                </div>

            </div>
        </div>
    </div>
</main>