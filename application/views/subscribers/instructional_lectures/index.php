<main>
    <div class="container-fluid" style="padding-left:20px; padding-right:20px;">
        <div class="row">

            <div class="col s12">
                <h4><strong>Instructional Lectures</strong></h4>
            </div>
        </div>

        <?php if ($videos) : ?>
            <table class="datatables">
                <thead>
                    <th></th>
                </thead>
                <tbody>
                    <?php foreach ($videos as $video) : ?>
                        <tr>
                            <td>
                                <div class="row">

                                    <div class="col s12 l4 video-container black">
                                        <?php $video_ref = explode('/', $video->video_link); ?>
                                        <iframe src="https://player.vimeo.com/video/<?= $video_ref[3] ?>?title=0&byline=0&portrait=0" frameborder="0" allowfullscreen class="responsive-video"></iframe>
                                    </div>

                                    <div class="col s12 l8">
                                        <div class="row">

                                            <div class="col s12 l8">
                                                <h5 style="margin-bottom:0px;"><strong><?= $video->video_title ?></strong></h5>
                                                <p style="margin-bottom:0px;"><?= date('F d, Y', strtotime($video->video_date_created)) ?></p>
                                            </div>

                                            <div class="col s12 l4">

                                                <div class="right">

                                                    <?php if (count($ratings) > 0) : ?>
                                                        <?php $is_rated = false; ?>

                                                        <?php foreach ($ratings as $rate) : ?>

                                                            <?php if ($rate->lecture_id == $video->video_id) : ?>

                                                                <?php for ($i = 0; $i < $rate->rating_ave; $i++) : ?>
                                                                    <span class="fa fa-star checked"></span>
                                                                <?php endfor; ?>

                                                                <?php for ($j = 0; $j < 5 - $rate->rating_ave; $j++) : ?>
                                                                    <span class="fa fa-star unchecked"></span>
                                                                <?php endfor; ?>
                                                                <?php $is_rated = true; ?>
                                                            <?php endif; ?>



                                                        <?php endforeach; ?>
                                                        <?php if (!$is_rated) : ?>
                                                            <?php for ($j = 0; $j < 5; $j++) : ?>
                                                                <span class="fa fa-star unchecked"></span>
                                                            <?php endfor; ?>
                                                        <?php endif; ?>

                                                    <?php else : ?>
                                                        <?php for ($j = 0; $j < 5; $j++) : ?>
                                                            <span class="fa fa-star unchecked"></span>
                                                        <?php endfor; ?>
                                                    <?php endif; ?>
                                                </div>

                                            </div>

                                            <div class="col s12">
                                                <img src="<?= (($video->user_img_thumb) ? $video->user_img_thumb : base_url('assets/images/avatar.png')) ?>" alt="" class="circle responsive-img" style="width:3em; margin-bottom:-1em;">
                                                <p style="display:inline;">&ensp;<?= $video->user_fullname ?></p>

                                                <?php $show_desc  = "show_description('" . $video->video_id . "')"; ?>
                                                <?php $rate_video  = "rate_video('" . $video->video_id . "')"; ?>
                                                <?= character_limiter($video->video_desc, 250, "... <a onclick=" . $show_desc . ">see more</a>") ?>
                                            </div>

                                            <div class="col s12 l12 right">

                                                <a class="btn btn-small grey darken-2 white-text" onclick="<?= $rate_video ?>"><small>Rate this video</small></a>
                                                <a class="btn btn-small grey darken-2 white-text" href="<?= base_url() ?>Subscribers_FE/feedback_and_suggestions"><small>Send us feedback</small></a>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                                <hr>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>

        <?php else : ?>
            <div class="row">
                <div class="col s12">
                    <h6><strong>No videos found!</strong></h6>
                </div>
            </div>

        <?php endif; ?>

        <div id="video_desc" class="modal">
            <div class="modal-content">
                <h5><strong id="video_title"></strong></h5>
                <hr>
                <div id="video_description"></div>
            </div>
            <div class="modal-footer">
                <a href="#!" class=" modal-action modal-close btn-flat">close</a>
            </div>
        </div>

        <div id="rate_video" class="modal" style="width:20rem;">
            <div class="modal-content center-align">
                <h5 id="rate_title"><strong>Rate this video</strong></h5>
                <div class="rate" style="margin-left:1em;"></div>
            </div>
            <div class="modal-footer">
                <a href="#" class=" modal-action modal-close btn-flat">Close</a>
            </div>
        </div>
        <!-- 
        <div class="col s12 center">
            <a class="btn teal lighten-2">Load More</a>
        </div> -->
    </div>
</main>