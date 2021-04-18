<main>
    <div class="container-fluid">
        <div class="row">

            <div class="col s12">

                <div class="col s12">
                    <h5><strong>Ask The Experts</strong></h5>
                </div>

                <div class="col s12">
                    <?php if ($_SESSION['account']['details']['is_expert']) : ?>
                        <table id="experts_table">
                            <thead>
                                <tr>
                                    <th><span>Client Name</span></th>
                                    <th>Email Address</th>
                                    <th>Contact Number</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                        </table>
                    <?php else : ?>
                        <table id="experts_table">
                            <thead>
                                <tr>
                                    <th><span>Expert Name</span></th>
                                    <th>User ID</th>
                                    <th>Field of Study</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                        </table>
                    <?php endif; ?>

                </div>

            </div>
        </div>
    </div>
</main>