<main>
    <div class="container-fluid">
        <div class="row">

            <div class="col s12">

                <div class="col s12">
                    <h5><strong>Feedback and Suggestions</strong></h5>
                </div>


                <div class="col s12">
                    <table class="datatables">
                        <thead>
                            <tr>
                                <th>Sender</th>
                                <th>Subject</th>
                                <th>Description</th>
                                <th>Date Sent</th>
                                <th>Actions</th>
                            </tr>
                        </thead>

                        <tbody>
                            <?php if ($feedbacks) : ?>
                                <?php foreach ($feedbacks as $feedback) : ?>
                                    <tr>
                                        <td><?= $feedback->name ?></td>
                                        <td><?= $feedback->subject ?></td>
                                        <td><?= character_limiter($feedback->message, 100, '...') ?></td>
                                        <td><?= date('F d, Y h:i:s A', strtotime($feedback->sent_datetime)) ?></td>
                                        <td style="width: 148px;">
                                            <div class="row">
                                                <button onclick="view_feedback('<?= $feedback->id ?>')" class="btn btn-small teal lighten-2"><i class="material-icons">visibility</i></button>
                                                <button onclick="delete_feedback('<?= $feedback->id ?>')" class="btn btn-small red darken-2 delete"><i class="material-icons">delete</i></button>
                                            </div>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>

                <div class="input-field col s12 m6 l2">
                    <a href="<?= base_url('Admin_FE/feedback_and_suggestions_report') ?>" class="btn grey darken-2 col s12">Extract Report</a>
                </div>

                <div class="col s12">
                    <h5><strong>Contact Information</strong></h5>
                </div>

                <div class="col s12">
                    <form action="" method="post" id="ContactDetailsForm">

                        <div class="input-field">
                            <h6>Contact Number</h6>
                        </div>
                        <div class="input-field">
                            <input name="telephone" id="telephone">
                        </div>

                        <div class="input-field">
                            <h5>Email Address</h5>
                        </div>
                        <div class="input-field">
                            <input name="email" id="email">
                        </div>

                        <div class="input-field">
                            <h5>Address</h5>
                        </div>
                        <div class="input-field">
                            <input name="address" id="address">
                        </div>

                    </form>

                    <div class="input-field col s12 right-align">
                        <button class="btn light-blue darken-2" id='contact_details_update'>update</button>
                    </div>
                </div>

            </div>

        </div>
    </div>
</main>

<div id="view_feedback" class="modal">
    <div class="modal-content">
        <div class="row">
            <div class="col s12 l6">
                <h5><strong id="view_sender"></strong></h5>
                <strong>
                    <p style="margin-top:0px; margin-bottom:0px;" id="view_email"></p>
                </strong>
                <strong>
                    <p style="margin-top:0px; margin-bottom:0px;" id="view_contact"></p>
                </strong>
            </div>
            <div class="col s12 l6 right-align">
                <h5><strong>Date Sent</strong></h5>
                <p id="view_date"></p>
            </div>
            <div class="col s12">
                <h5><strong>Subject</strong></h5>
                <p id="view_subject"></p>
            </div>
            <div class="col s12">
                <h5><strong>Message</strong></h5>
                <p id="view_message"></p>
            </div>

        </div>

    </div>
    <div class="modal-footer">
        <a href="#" class=" modal-action modal-close btn-flat">Close</a>
    </div>
</div>