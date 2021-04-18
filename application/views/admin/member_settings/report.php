<main>
    <div class="container-fluid">
        <div class="row">

            <div class="col s12">
                <div class="col s12 ">
                    <h5><strong>Member Last Login - Report</strong></h5>
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
                        <a href="<?= base_url('Admin_FE/member_settings') ?>" class="btn waves-effect waves-light right yellow darken-2" style="margin-right:5px;">Go Back
                            <i class="material-icons right">arrow_back</i>
                        </a>
                    </form>
                </div>

                <div class="col s12">
                    <table>
                        <thead>
                            <tr>
                                <!-- fullname,email_address,contact_number,role,last_login -->
                                <th>Name</th>
                                <th>Contact Number</th>
                                <th>Email Address</th>
                                <th>Role</th>
                                <th>Member Type</th>
                                <th>Last Login</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (isset($last_login) && $last_login) : ?>
                                <?php $i = 1; ?>
                                <?php foreach ($last_login['result']->result() as $login) : ?>
                                    <tr>
                                        <td>
                                            <?= $i++ ?>
                                        </td>
                                        <td><?= $login->fullname ?></td>
                                        <td><?= $login->contact_number ?></td>
                                        <th><?= $login->email_address ?></td>
                                        <th><?= $login->role ?></td>
                                        <th><?= $login->is_expert == "0" ? "Expert" : "Regular" ?></td>
                                        <td><?= date('F j, Y h:i:s A', strtotime($login->last_login)) ?></td>
                                        
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