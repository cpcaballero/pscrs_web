<main>
    <div class="container-fluid">
        <div class="row">

            <div class="col s12">

                <div class="col s12">
                    <h5><strong>Tech News</strong>&emsp;<a href="<?= base_url() ?>Admin_FE/technology_news_create" class="btn light-blue darken-2">Create</a></h5>
                </div>

                <div class="col s12">
                    <table id="news_table">
                        <thead>
                            <tr>
                                <th>News Title</th>
                                <th>Content</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>

                        <tbody>
                            
                        </tbody>
                    </table>
                </div>
                <div class="input-field col s12 m6 l2">
                    <a href="<?= base_url('Admin_FE/technology_news_report') ?>" class="btn grey darken-2 col s12">Extract Report</a>
                </div>
                

            </div>

        </div>
    </div>
</main>