<main>
    <div class="container-fluid">
        <div class="row">

            <div class="col s12">
                <div class="col s12">
                    <h5><strong>Billing Info</strong></h5>
                </div>

                <form class="">
                    <div class="input-field row col s12 l12">
                        <div class="input-field col s6 l6 row ">
                            <input type="text" id="item_name" name="item_name" class="validate" disabled value="<?= $billing->item_name ?>">
                            <label for="item_name" data-error="wrong" data-success="right">Item Name</label>
                        </div>
                        <div class="input-field col s3 l3">
                            <input type="text" id="quantity" name="quantity" class="validate" disabled value="<?= $billing->quantity ?>">
                            <label for="quantity" data-error="wrong" data-success="right">Quantity</label>
                        </div>
                        <div class="input-field col s3 l3">
                            <input type="text" id="total" name="total" class="validate" disabled value="<?= $billing->total ?>">
                            <label for="total" data-error="wrong" data-success="right">Total Amount</label>
                        </div>
                    </div>

                    <div class="input-field row col s12 l12">
                        <div class="input-field col s6 l6">
                            <input type="text" id="buyer_name" name="buyer_name" class="validate" disabled value="<?= $billing->fullname ?>">
                            <label for="buyer_name" data-error="wrong" data-success="right">Buyer Name</label>
                        </div>
                        <div class="input-field col s6 l6">
                            <input type="text" id="mode_of_payment" name="mode_of_payment" class="validate" disabled value="<?= $billing->mode_of_payment ?>">
                            <label for="mode_of_payment" data-error="wrong" data-success="right">Mode of Payment</label>
                        </div>
                    </div>

                    <div class="input-field row col s12 l12">
                        <div class="input-field col s4 l4">
                            <input type="text" id="item_name" name="item_name" class="validate" disabled value="<?= $billing->datetime_created ?>">
                            <label for="item_name" data-error="wrong" data-success="right">Date Ordered</label>
                        </div>
                        <div class="input-field col s4 l4">
                            <input type="text" id="item_name" name="item_name" class="validate" disabled value="<?= $billing->payment_date ?>">
                            <label for="item_name" data-error="wrong" data-success="right">Payment Date</label>
                        </div>
                    </div>
                </form>

            </div>

        </div>
    </div>
</main>