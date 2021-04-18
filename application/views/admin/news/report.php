<main>
    <div class="container-fluid">
        <div class="row">

            <div class="col s12">
                <div class="col s12 ">
                    <h5><strong>Technology News - Report</strong></h5>
                </div>

                <div class="col s12 ">
                    <form action="" method="post">
                        <div class="input-field col s12 l3">
                            <select class="normal_select" name="report_date" id="report_date" required>
                                <option value="today" <?= (($selected_date == 'today') ? "selected" : "") ?>>Today</option>
                                <option value="month" <?= (($selected_date == 'month') ? "selected" : "") ?>>This Month</option>
                                <option value="year" <?= (($selected_date == 'year') ? "selected" : "") ?>>This Year</option>
                            </select>
                            <label>Report Date</label>
                        </div>

                        <button class="btn waves-effect waves-light right" style="margin-right:5px;" id="report_csv_download" name="csv">CSV
                            <i class="material-icons right">download</i>
                        </button>
                        <button class="btn waves-effect waves-light right" style="margin-right:5px;" id="report_pdf_download" name="pdf">PDF
                            <i class="material-icons right">download</i>
                        </button>
                        <button class="btn waves-effect waves-light right light-blue darken-2" style="margin-right:5px;" type="submit" name="view">View
                            <i class="material-icons right">remove_red_eye</i>
                        </button>
                        <a href="<?= base_url('Admin_FE/technology_news') ?>" class="btn waves-effect waves-light right yellow darken-2" style="margin-right:5px;">Go Back
                            <i class="material-icons right">arrow_back</i>
                        </a>
                    </form>
                </div>

                <div class="col s12">
                    <table>
                        <thead>
                            <tr>
                                <th width="10%">#</th>
                                <th>News Title</th>
                                <th>Content</th>
                                <th>Author</th>
                                <th>Date Created</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (isset($news) && $news) : ?>
                                <?php $i = 1; ?>
                                <?php foreach ($news['result']->result() as $article) : ?>
                                    <tr>
                                        <td>
                                            <?= $i++ ?>
                                        </td>
                                        <td><?= $article->title ?></td>
                                        <td><?= $article->description ?></td>
                                        <th><?= $article->article_author ?></td>
                                        <td><?= date('F j, Y h:i:s A', strtotime($article->datetime_created)) ?></td>
                                        <td><?= (($article->status) ? 'POSTED' : 'NOT POSTED') ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>
</main>