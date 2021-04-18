<main>
    <div class="container-fluid">
        <div class="row">

            <div class="col s12">
                <div class="col s12 ">
                    <h5><strong>Marketplace Transactions - Report</strong></h5>
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
                        <a href="<?= base_url('Admin_FE/system_settings') ?>" class="btn waves-effect waves-light right yellow darken-2" style="margin-right:5px;">Go Back
                            <i class="material-icons right">arrow_back</i>
                        </a>
                    </form>
                </div>

                <div class="col s12">
                    <table>
                        <thead>
                            <tr>
                                <th width="10%">Order Ref #</th>
                                <th>Seller Name</th>
                                <th>Product Name</th>
                                <th>Quantity</th>
                                <th>Total</th>
                                <th>Buyer Name</th>
                                <th>Mode of Payment</th>
                                <th>Date Ordered</th>
                                <th>Date Purchased</th>
                                <th>
                                    Payment Transaction Reference<br/>
                                    <small>Bank Deposit Ref# / any notes </small>
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (isset($transactions) && $transactions) : ?>
                                <?php $i = 1; ?>
                                <?php foreach ($transactions['result']->result() as $transaction) : ?>
                                    <tr>
                                        <td>
                                            <?= date('Ymd', strtotime($transaction->datetime_ordered)) . "-" . $transaction->id ?>
                                        </td>
                                        <td><?= $transaction->seller ?></td>
                                        <td><?= $transaction->item_name ?></td>
                                        <th><?= $transaction->quantity ?></td>
                                        <th><?= $transaction->total ?></td>
                                        <th><?= $transaction->fullname ?></td>
                                        <th><?= $transaction->mode_of_payment ?></td>
                                        <td><?= date('F j, Y h:i:s A', strtotime($transaction->datetime_ordered)) ?></td>
                                        <td><?= date('F j, Y h:i:s A', strtotime($transaction->payment_date)) ?></td>
                                        <td><?= $transaction->payment_transaction_reference ?></td>
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