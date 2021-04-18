<main>
    <div class="container-fluid">
        <div class="row">

            <div class="col s12">

                <div class="col s12 ">
                    <h5><strong>Marketplace</strong>
                </div>
                <div class="row">
                    <div class="col s5">
                        <div class="card">
                            <div class="card-image">
                                <div class="carousel carousel-slider center ">
                                    <div class="carousel-item red white-text" href="#one!">
                                        <img src="<?= base_url() . $product->item_image_original; ?>" alt="" class="responsive-img">
                                    </div>
                                    <?php foreach($gallery_images->result() as $image): ?>
                                        <div class="carousel-item amber white-text" href="#two!">
                                            <img src="<?= base_url() . $image->image_path; ?>" alt="gallery image" class="responsive-img">
                                        </div>
                                    <?php endforeach; ?>
                                </div>
                            </div>
                            <div class="card-content">
                                <h5><strong><?= $product->item_name; ?></strong> 
                                    &emsp;₱ <span id="ordering_unit_price"><?= $product->unit_price; ?></span> 
                                    <small>(<?= $product->available_stocks; ?> in stock)</small>
                                </h5>
                                <h6><strong><?= $product->description ?></strong></h6>
                                <br>

                                <!-- <input type="number" id="ordering_available_stocks" value="1" name="available_stocks" class="validate" min="1" step="1" max="<?= $product->available_stocks; ?>"> -->
                                <!-- <label for="available_stocks" data-error="wrong" data-success="right">Quantity</label> -->

                                <!-- <div class="input-field"> -->
                                    <!-- <select id="ordering_mode_of_payment"> -->
                                        <!-- <option value="" disabled selected>Choose your option</option> -->
                                        <!-- <option value="1">Paymaya</option> -->
                                        <!-- <option value="manual">Over the counter</option> -->
                                    <!-- </select> -->
                                    <!-- <label>Mode of Payment</label> -->
                                <!-- </div> -->

                                <!-- <input type="text" id="ordering_total_amount" name="total_amount" class="validate" value=<?= $product->unit_price; ?> disabled> -->
                                <!-- <label for="total_amount" data-error="wrong" data-success="right">Total</label> -->
                            </div>
                            <div class="card-action">
                                <!-- <input type="hidden"  name="active_user" value="<?= $_SESSION['account']['details']['id'] ?>">-->
                                <input type="hidden" id="product_id" name="id" value="<?= $product->product_id ?>"> 
                                <!-- <a class="btn btn-small green darken-2 white-text" href="#" id="order_now"><small>Order Item</small></a> -->
                                <a class="btn btn-small grey darken-2 white-text" href="<?= base_url() . 'Admin_FE/marketplace' ?>"><small>Return to Marketplace</small></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
</main>

