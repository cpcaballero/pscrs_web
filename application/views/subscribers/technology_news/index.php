<main>
    <div class="container-fluid" style="padding-left:20px; padding-right:20px;">
        <div class="row">

            <div class="col s12">
                <h4><strong>Technology News</strong></h4>
            </div>

            <?php if ($news) : ?>
                <table class="datatables">
                    <thead>
                        <th></th>
                    </thead>
                    <tbody>
                        <?php foreach ($news as $article) : ?>
                            <tr>
                                <td>
                                    <div class="col s12" style="padding-bottom:10px;">
                                        <div class="col s12 l8">
                                            <h5><?= $article->title ?></h5>
                                            <small><?= date('F d, Y', strtotime($article->datetime_created)) ?></small>
                                        </div>

                                        <div class="col s12 l4">
                                            <div class="right">

                                                <?php if (count($ratings) > 0) : ?>
                                                    <?php $is_rated = false; ?>

                                                    <?php foreach ($ratings as $rate) : ?>

                                                        <?php if ($rate->news_id == $article->news_id) : ?>

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

                                        <div class="col s12 " style="margin-top: 10px;">
                                            <img src="<?= (($article->user_img_thumb) ? $article->user_img_thumb : base_url('assets/images/avatar.png')) ?>" alt="" class="circle responsive-img" style="width:3em; margin-bottom:-1em;">
                                            <p style="display:inline;">&ensp;<?= $article->article_author ?></p>

                                            <?php $show_desc  = "show_description('" . $article->news_id . "')"; ?>
                                            <?php $rate_news  = "rate_news('" . $article->news_id . "')"; ?>
                                        </div>
                                        <div class="col s12" style="margin-top:30px;margin-bottom:30px;">
                                            <?= character_limiter($article->description, 250, "... <a onclick=" . $show_desc . ">see more</a>") ?>
                                        </div>
                                        <div class="col s12 l12 right">
                                            <a class="btn btn-small grey darken-2 white-text" onclick="<?= $rate_news ?>"><small>Rate this article</small></a>
                                            <a class="btn btn-small grey darken-2 white-text" href="<?= base_url() ?>Subscribers_FE/feedback_and_suggestions"><small>Send us feedback</small></a>
                                        </div>
                                    </div>

                                    <div class="col s12">
                                        <hr>
                                    </div>

                                <?php endforeach; ?>
                                </td>
                            </tr>
                    </tbody>
                </table>

            <?php else : ?>
                <div class="col s12">
                    <h6><strong>No articles found!</strong></h6>
                </div>
            <?php endif; ?>
            <div id="news_desc" class="modal">

                <div class="modal-content">
                    <h5><strong id="news_title"></strong></h5>
                    <hr>
                    <div id="news_description"></div>
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

        </div>

    </div>
</main>