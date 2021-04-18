<main>
    <div class="container-fluid">
        <div class="row">
            <div class="col s12">

                <div class="col s12">
                    <h5><strong>System Settings - View Notification</strong></h5>

                    <div class="input-field col s12 l6">
                        <input id="title" name="title" placeholder="Notification Title" type="text" class="validate" value="<?= $notif->title ?>">
                        <label for="subject">Title</label>
                    </div>

                    <div class="col s12 l12">
                        Content
                    </div>
                    <div class="input-field col s12 l8">
                        <textarea id="notification" name="description"><?= $notif->description ?></textarea>
                    </div>

                    <div class="input-field col s12 l8">
                        <select class="select2" style="width:100%;" name="recipient" id="recipient" disabled>
                            <option value="" disabled>Please recipient</option>
                            <?php foreach ($users as $user) : ?>
                                <option value="<?= $user->id ?>" <?= (($user->id == $notif->recipient) ? "selected" : "") ?>><?= $user->fullname ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="col s12 l12" style="margin-top:20px;">
                        <div class="row">
                            <div class="col s12 m6 l2" style="margin-bottom:10px;"><a href="<?= base_url('Admin_FE/system_settings') ?>" class="btn default darken-2 col s12 ">Go Back</a></div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</main>