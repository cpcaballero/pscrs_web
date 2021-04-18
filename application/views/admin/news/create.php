<main>
    <div class="container-fluid">
        <div class="row">

            <div class="col s12">
                <div class="col s12">
                    <h5><strong>Tech News - Create</strong></h5>
                </div>

                <div class="col s12 l12">
                    <form action="" id="create_news_form" method="post">
                        <div class="input-field col s12 l6">
                            <input type="text" name="title" id="title" class="validate" value="">
                            <label for="title" data-error="wrong" data-success="right">Title</label>
                        </div>

                        <div class="col s12 l12">
                            Content
                        </div>
                        <div class="input-field col s12">
                            <textarea id="description" name="content"></textarea>
                        </div>

                        <!-- <div class="input-field col s12">
                            <h5>Image</h5>
                            <input type="file">
                        </div> -->

                        <div class="col s12 l12">
                            <label for="video_link">News Owner</label>
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
                                <div class="col s12 m6 l2" style="margin-bottom:10px;"><button type="button" id="create_news_submit" class="btn light-blue darken-2 col s12">Create News</button></div>
                                <div class="col s12 m6 l2" style="margin-bottom:10px;"><a href="<?= base_url('Admin_FE/technology_news') ?>" class="btn default darken-2 col s12 ">Cancel</a></div>
                            </div>
                        </div>

                        <input type="hidden" name="active_user" value="<?= $_SESSION['account']['details']['id'] ?>">
                    </form>


                </div>
            </div>

        </div>
    </div>
</main>