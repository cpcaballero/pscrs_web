<main>
    <div class="container-fluid">
        <div class="row">

            <div class="col s12">

                <div class="col s12 ">
                    <h5><strong>System Settings</strong> </h5>
                </div>

                <?php if ($_SESSION['account']['details']['role'] == "superadmin") : ?>

                    <div class="col s12">
                        <h5><strong>Admin</strong>&emsp;<a href=" <?= base_url() ?>Admin_FE/createadmin" class="btn light-blue darken-2">Create</a></h5>
                    </div>


                    <div class="col s12">
                        <table id="users_table">
                            <thead>
                                <tr>
                                    <th>Photo</th>
                                    <th>Name</th>
                                    <th>Admin ID</th>
                                    <th>Contact Number</th>
                                    <th>Email</th>
                                    <th>Last Log in</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                        </table>
                    </div>

                <?php endif; ?>


                <div class="col s12">
                    <h5><strong>Billing Information</strong></h5>
                    
                    <table id="billing_table">
                        <thead>
                            <tr>
                                <th>Order Ref Number</th>
                                <th>Seller</th>
                                <th>Item Name</th>
                                <th>Quantity</th>
                                <th>Amount</th>
                                <th>Date Ordered</th>
                                <th>Mode of Payment</th>
                                <th>Buyer</th>
                                <th>Date Purchased</th>
                                <th>
                                    Payment Transaction Reference<br/>
                                    <small>Bank Deposit Ref# / any notes </small>
                                </th>
                            </tr>
                        </thead>

                        <tbody>

                        </tbody>
                    </table>
                    <div class="input-field col s12 m6 l2">
                        <a href="<?= base_url('Admin_FE/marketplace_report') ?>" class="btn grey darken-2 col s12">Extract Report</a>
                    </div>
                </div>

                <div class="col s12">
                    <h5><strong>Push Notifications</strong>&emsp;<a href=" <?= base_url() ?>Admin_FE/createnotification" class="btn light-blue darken-2">Create</a></h5>

                    <div class="col s12">
                        <table id="notification_table">
                            <thead>
                                <tr>
                                    <th>Title</th>
                                    <th>Content</th>
                                    <th>Status</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>

                            <tbody>

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

        </div>
    </div>
</main>