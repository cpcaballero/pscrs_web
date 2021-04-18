<main>
    <div class="container-fluid">
        <div class="row">

            <div class="col s12">
                <div class="col s12 ">
                    <h5><strong>Marketplace Product - Report</strong></h5>
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

                        <button class="btn waves-effect waves-light right" style="margin-right:5px;" id="report_csv_download_product" name="csv">CSV
                            <i class="material-icons right">download</i>
                        </button>
                        <button class="btn waves-effect waves-light right" style="margin-right:5px;" id="report_pdf_download_product" name="pdf">PDF
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
                                <th>Description</th>
                                <th>Available Stocks</th>
                                <th>Unit Price</th>
                                <th>Product Created</th>
                                <th>Product Status</th>
                                <th>Admin-Flagged Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (isset($products) && $products) : ?>
                                <?php $i = 1; ?>
                                <?php foreach ($products['result']->result() as $product) : ?>
                                    <tr>
                                        <td>
                                            <?= $i++ ?>
                                        </td>
                                        <td><?= $product->product_seller_name ?></td>
                                        <td><?= $product->item_name ?></td>
                                        <th><?= $product->description ?></td>
                                        <th><?= $product->available_stocks ?></td>
                                        <th><?= $product->unit_price ?></td>
                                        <th><?= $product->product_datetime_created ?></td>
                                        <th><?= $product->product_status == 1 ? "Published by seller" : "Not published by seller" ?></td>
                                        <td><?= $product->product_status == 1 ? "Flagged as inappropriate" : "Not flagged" ?></td>
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