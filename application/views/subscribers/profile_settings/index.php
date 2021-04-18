<main>
    <div class="container-fluid">
        <div class="row">
            <div class="col s12">
                <div class="col s12">
                    <h5><strong>Profile settings</strong></h5>
                </div>

                <div class="col s12 l3">
                    <form style="margin-top: 3%;">
                        <div class="input-field">
                            <input disabled placeholder="Enter your name" id="name" type="text" class="validate">
                            <label for="name"><strong>Name</strong></label>
                        </div>

                        <div class="input-field">
                            <input disabled placeholder="Enter your email" id="email" type="text" class="validate">
                            <label for="email"><strong>Email</strong></label>
                        </div>

                        <div class="input-field">
                            <input disabled placeholder="Enter your contact number" id="contact_number" type="text" class="validate">
                            <label for="contact_number"><strong>Contact Number</strong></label>
                        </div>

                        <div class="input-field">
                            <input placeholder="Enter your current password" id="old_pass" name="old_pass" type="password" class="validate">
                            <label for="password"><strong>Current Password</strong></label>
                        </div>

                        <div class="input-field">
                            <input placeholder="Enter your new password" id="new_pass" name="new_pass" type="password" class="validate">
                            <label for="password"><strong>New Password</strong></label>
                        </div>

                        <div class="input-field">
                            <input placeholder="Retype your new password" id="retype_pass" name="retype_pass" type="password" class="validate">
                            <label for="password_re"><strong>Re-type New Password</strong></label>
                        </div>

                        <div class="input-field">
                            <a class="btn light-blue darken-2 white-text col s12 l6 change_pass" href="#">Change Password</a>
                        </div>

                    </form>
                </div>

                <div class="col s12 l8 offset-l1 card">
                    <div style=" padding:2%;margin-top:10px; overflow:scroll; overflow-x:hidden; height:500px;">

                        <div class="col" style="padding-bottom:3%;">
                            <h5><strong>Calendar</strong></h5>
                        </div>

                        <div>
                            <?php if ($events) : ?>
                                <?php foreach ($events as $event) : ?>
                                    <div class="row" style="margin-top:3%;">
                                        <div class="col s12">
                                            <!-- <div class="col s2 center">
                                            <p style="margin-bottom: 0px;"><strong>SAT</strong></p>
                                            <h3 class="" style="margin-top: 0px;">7</h3>
                                        </div> -->
                                            <div class="col s12" style=" border-left: 3px solid #0288d1;">
                                                <h5><strong id="event_title"><?= $event->event_title ?></strong></h5>
                                                <small id="event_date"><?= date('F d, Y', strtotime($event->event_date)) ?></small>
                                                <br>
                                                <br>
                                                <div id="event_description"><?= $event->event_desc ?></div>
                                            </div>
                                        </div>
                                    </div>
                                    <hr>
                                <?php endforeach; ?>
                            <?php else : ?>
                                <div class="row">
                                    <div class="col s12 center" style="padding-top:2%;">
                                        <h5><strong>No events</strong></h5>
                                    </div>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">

            <div class="col s12 l12 right">
                <div class="input-field row">
                    <div class="col">
                        <a class="btn light-blue darken-2 white-text col s12" style="margin-right: 10px;" href="<?= base_url() ?>Subscribers_FE/profile_settings_FAQs">FAQs</a>
                    </div>
                    <div class="col">
                        <a class="btn light-blue darken-2 white-text col s12" style="margin-right: 10px;" href="<?= base_url() ?>Subscribers_FE/profile_settings_terms_and_conditions">Terms and Condition</a>
                    </div>
                    <div class="col">
                        <a class="btn light-blue darken-2 white-text col s12" style="margin-right: 10px;" href="<?= base_url() ?>Subscribers_FE/profile_settings_privacy_policy">Privacy Policy</a>
                    </div>
                    <div class="col">
                        <a class="btn light-blue darken-2 white-text col s12" style="margin-right: 10px;" href="<?= base_url() ?>Subscribers_FE/feedback_and_suggestions">Feedback and Suggestions</a>
                    </div>

                </div>
            </div>
        </div>
        <div class="row">
            <div class="col s12" style="overflow-x: scroll; overflow:auto;">
                <h5><strong>Billing Information - My Orders</strong></h5>

                <table id="billing_table">
                    <thead>
                        <tr>
                            <th>Order Reference</th>
                            <th>Seller Name</th>
                            <th>Item Name</th>
                            <th>Quantity</th>
                            <th>Total Amount</th>
                            <th>Date Ordered</th>
                            <th>Date Purchased</th>
                            <th>
                                Payment Transaction Reference<br/>
                                <small>Bank Deposit Ref# / any notes</small>
                            </th>
                        </tr>
                    </thead>

                    <tbody>

                    </tbody>
                </table>
            </div>

            <!-- <div class="col s12"><br>
                <a class="btn btn-small grey darken-2 white-text" href="<?= base_url() ?>Subscribers_FE/feedback_and_suggestions"><small>Send us feedback</small></a>

                <ul class="pagination right">
                    <li class=""><a href="#!"><i class="material-icons">chevron_left</i></a></li>
                    <li class=""><a href="#!"><i class="material-icons">chevron_right</i></a></li>
                </ul>

            </div> -->
        </div>

        <div class="row">
            <div class="col s12" style="overflow-x: scroll; overflow:auto;">
                <h5><strong>Billing Information - Orders To Me</strong></h5>

                <table id="billing_seller_table">
                    <thead>
                        <tr>
                            <th>Order Reference</th>
                            <th>Buyer Name</th>
                            <th>Item Name</th>
                            <th>Quantity</th>
                            <th>Total Amount</th>
                            <th>Date Ordered</th>
                            <th>Date Purchased</th>
                            <th>
                                Payment Transaction Reference<br/>
                                <small>Bank Deposit Ref# / any notes </small>
                            </th>
                            <th>Actions</th>
                        </tr>
                    </thead>

                    <tbody>

                    </tbody>
                </table>
            </div>
            <div id="update_billing" class="modal" style="width:20rem;">
                <div class="modal-content center-align">
                    <h5 id="rate_title"><strong>Update billing information</strong></h5>
                    <div class="input-field">
                        <input placeholder="Enter payment reference code" id="payment_transaction_reference" type="text" class="validate">
                        <label for="payment_transaction_reference"><strong>Payment Reference Code</strong></label>
                    </div>
                    <div class="input-field">
                        <input placeholder="Payment Date" id="payment_date" type="date" class="validate">
                        <label for="payment_date"><strong>Payment Date</strong></label>
                    </div>
                    <input type="hidden" id="marketplace_transaction_id" />
                </div>
                <div class="modal-footer">
                    <a class="modal-action btn-flat green darken-2 white-text" onclick="submit_billing_update()">Update</a>
                    <a href="#" class=" modal-action modal-close btn-flat">Close</a>
                </div>
            </div>
            <div class="col s12"><br>
                <a class="btn btn-small grey darken-2 white-text" href="<?= base_url() ?>Subscribers_FE/feedback_and_suggestions"><small>Send us feedback</small></a>

                <ul class="pagination right">
                    <li class=""><a href="#!"><i class="material-icons">chevron_left</i></a></li>
                    <li class=""><a href="#!"><i class="material-icons">chevron_right</i></a></li>
                </ul>

            </div>
        </div>
    </div>

</main>