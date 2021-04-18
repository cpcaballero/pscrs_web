<main>
    <div class="container-fluid">
        <div class="row">
            <div class="col s12">
                <div class="col s12 ">
                    <h5><strong>Ask The Expert - Conversations Report</strong></h5>
                </div>
                
                <div class="col s12 ">
                    <form action="" method="post">
                        <div class="input-field col s12 l3">
                            <select name="report_date" id="report_date" required>
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
                                <th width="10%">Convsersation Id</th>
                                <th>Sender</th>
                                <th>Is Sender an Expert?</th>
                                <th>Sender Field of Study</th>
                                <th>Receiver</th>
                                <th>Is Receiver an Expert?</th>
                                <th>Receiver Field of Study</th>
                                <th>Last Message Date</th>
                                <th>Last Messsage Content</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (isset($expert_conversations) && $expert_conversations) : ?>
                                <?php foreach ($expert_conversations['result']->result() as $conversation) : ?>
                                    <tr>
                                        <td style="width:10%; word-wrap: break-word; word-break: break-all; ">
                                        <?= $conversation->convo_id ?></td>
                                        </td>
                                        <td><?= $conversation->sender_name ?></td>
                                        <td><?= $conversation->sender_is_expert == "1" ? "Yes" : "No" ?></td>
                                        <th><?= $conversation->sender_field_study == '' ? 'N/A' : $conversation->sender_field_study ?></td>
                                        <th><?= $conversation->receiver_name ?></td>
                                        <th><?= $conversation->receiver_is_expert == "1" ? "Yes" : "No" ?></td>
                                        <th><?= $conversation->receiver_field_study == '' ? 'N/A' : $conversation->receiver_field_study ?></td>
                                        <td><?= date('F j, Y h:i:s A', strtotime($conversation->msg_date)) ?></td>
                                        <th><?= $conversation->msg_content ?></td>
                                        
                                        
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