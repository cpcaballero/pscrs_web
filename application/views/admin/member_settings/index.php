
<main>
    <div class="container-fluid">
        <div class="row">

            <div class="col s12">
                <h5><strong>Member Settings</strong></h5>
            </div>

            <div class="col s12">
                <h5><strong>Members</strong>&emsp;<a href="<?= base_url() ?>Admin_FE/member_settings_create" class="btn light-blue darken-2">Create</a>
            </div>

            <div class="col s12">
                <table id="users_table">
                    <thead>
                        <tr>
                            <th width="40px">Photo</th>
                            <th>Name</th>
                            <th>Contact Number</th>
                            <th>Email Address</th>
                            <th>Role</th>
                            <th>Expert</th>
                            <th width="15%">Actions</th>
                        </tr>
                    </thead>
                </table>
            </div>

            <div class="input-field col s12 m6 l2">
                    <a href="<?= base_url('Admin_FE/members_report') ?>" class="btn grey darken-2 col s12">Extract Report</a>
                </div>



            <div class="col s12" style="margin-top: 3%;">
                <h5><strong>FAQs, Terms and Conditions, Data Privacy Policy</strong></h5>
            </div>

            <div class="col s12">
                <table class="">

                    <thead>
                        <tr>
                            <th>Title</th>
                            <th>Description</th>
                            <th>Actions</th>
                        </tr>
                    </thead>

                    <tbody>
                        <tr>
                            <td style="width: 100px;">FAQs</td>
                            <td id="faqs_data"></td>
                            <td style="width: 148px;">
                                <div class="row" style="margin-left: 0%;">
                                    <a href="<?= base_url() ?>Admin_FE/member_settings_faqs_update" class="btn btn-small teal lighten-2"><i class="material-icons">visibility</i></a>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td style="width: 100px;">Terms and Conditions</td>
                            <td id="terms_data"></td>
                            <td style="width: 148px;">
                                <div class="row" style="margin-left: 0%;">
                                    <a href="<?= base_url() ?>Admin_FE/member_settings_terms_update" class="btn btn-small teal lighten-2"><i class="material-icons">visibility</i></a>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td style="width: 100px;">Data Privacy Policy</td>
                            <td id="privacy_data"></td>
                            <td style="width: 148px;">
                                <div class="row" style="margin-left: 0%;">
                                    <a href="<?= base_url() ?>Admin_FE/member_settings_privacy_update" class="btn btn-small teal lighten-2"><i class="material-icons">visibility</i></a>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>



            <div class="col s12" style="margin-top: 3%;">
                <h5><strong>Calendar Events</strong>&emsp;<a href="<?= base_url() ?>Admin_FE/member_settings_create_event" class="btn light-blue darken-2">Create</a>
            </div>

            <div class="col s12">
                <table id="events_table">
                    <thead>
                        <tr>
                            <th>Title</th>
                            <th>Description</th>
                            <th>Date</th>
                            <th width="15%">Actions</th>
                        </tr>
                    </thead>
                </table>
            </div>

            <!-- <div class="input-field col s12">
                <a href="" class="btn grey darken-2">Extract Report (CSV)</a>
                <a href="" class="btn grey darken-2">Extract Report (PDF)</a>
            </div> -->
        </div>
    </div>
</main>

<div id="event_details" class="modal">
    <div class="modal-content">
        <div class="container-fluid">
            <div class="row">
                <div class="col s12">
                    <div class="col s12 card-panel">
                        <div class="col s2 center">
                            <p style="margin-bottom: 0px;"><strong>SAT</strong></p>
                            <h3 class="" style="margin-top: 0px;">7</h3>
                        </div>
                        <div class="col s10" style=" border-left: 3px solid #0288d1;">
                            <h5><strong id="event_title"></strong></h5>
                            <small id="event_date">Event location</small>
                            <div id="event_description"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal-footer">
        <a href="#!" class=" modal-action modal-close btn-flat">close</a>
    </div>
</div>
