<main>
    <div class="container-fluid">
        <div class="row">
            <br/><br/>
            <div class="col s12">
                <div class="col s12 ">
                    <h5><strong>Marketplace - Update</strong></h5>
                </div>


                <div class="col s12 l12">
                    <form action="" id="update_product_form" method="post">

                        <div class="file-field input-field">
                            <div class="btn">
                                <span>Upload Primary Photo (leave blank to keep current)</span>
                                <input type="file" name="product_image">
                            </div>
                            <div class="file-path-wrapper">
                                <input class="file-path validate" type="text">
                            </div>
                        </div>
                        <div class="input-field">
                            <span>Current Primary:</span><br/>
                            <img src="<?= base_url() . $product->item_image_original ?>" alt="" class="responsive-img" style="height: 180px;"> <!-- notice the "circle" class -->
                        </div>
                        <div class="file-field input-field">
                            <div class="btn">
                                <span>Upload Gallery Photos (leave blank to keep current)</span>
                                <input type="file" name="other_images[]" multiple>
                            </div>
                            <div class="file-path-wrapper">
                                <input class="file-path validate" type="text">
                            </div>
                        </div>
                        <?php if($gallery_images->num_rows() > 0): ?>
                        <div class="input-field">
                            <span>Current Gallery Photos</span><br/>
                            <span class="col s12 l12">
                                <?php foreach ($gallery_images->result() as $image): ?>
                                    <img src="<?= base_url() . $image->image_path ?>" class="col" style="height: 100px; width: auto; "> <!-- random image -->
                                <?php endforeach; ?>
                            </span>
                        </div>
                        <?php endif; ?>
                        

                        <div class="input-field col s12 l12">
                            <input type="text" id="item_name" name="item_name" class="validate" value="<?= $product->item_name;?>">
                            <label for="item_name" data-error="wrong" data-success="right">Item Name</label>
                        </div>

                        <div class="col s12 l12">
                            Description
                        </div>
                        <div class="input-field col s12 l12">
                            <textarea id="description" name="description"><?= $product->description;?></textarea>
                        </div>

                        <div class="input-field col s12 l12">
                            <input type="number" id="available_stocks" name="available_stocks" class="validate" value="<?= $product->available_stocks;?>">
                            <label for="available_stocks" data-error="wrong" data-success="right">Available Stocks</label>
                        </div>

                        <div class="input-field col s12 l12">
                            <input type="number" id="unit_price" name="unit_price" class="validate" value="<?= $product->unit_price;?>">
                            <label for="unit_price" data-error="wrong" data-success="right">Unit Price</label>
                        </div>

                        <div class="col s12 l12" style="margin-top:20px;">
                            <div class="row">
                                <div class="col s12 m6 l2" style="margin-bottom:10px;"><button type="submit" id="update_product" class="btn light-blue darken-2 col s12 update">Update Item</button></div>
                                <div class="col s12 m6 l2" style="margin-bottom:10px;"><a href="<?= base_url() ?>Subscribers_FE/marketplace_manage" class="btn default darken-2 col s12">Cancel</a></div>
                            </div>
                        </div>

                        <input type="hidden" name="active_user" value="<?= $_SESSION['account']['details']['id'] ?>">
                        <input type="hidden" name="id" value="<?= $product->product_id ?>">
                    </form>

                </div>
            </div>

        </div>
    </div>
</main>