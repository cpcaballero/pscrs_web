<main>
    <div class="container-fluid">
        <div class="row">

            <div class="col s12">

                <div class="col s12 ">
                    <h5><strong>Marketplace - View Your Product</strong>&emsp; <a href="<?= base_url() ?>Subscribers_FE/marketplace_manage" class="btn light-blue darken-2">Back to my items</a></h5>
                </div>
                <div class="col s12">
                    <hr class="solid">
                    <div class="row valign-wrapper">

                        <div class="col s4">
                            <img src="<?= base_url() . $product->item_image_original ?>" alt="" class="responsive-img materialboxed" style="height: 280px;"> <!-- notice the "circle" class -->
                        </div>
                        <div class="content col s8" style="padding: 0px;">
                            <div class="col s12">
                                <div class="col s9">
                                    <p>
                                        <strong><?= $product->item_name; ?></strong><br />
                                        <small><?php 
                                            if($product->product_datetime_modified === NULL){
                                                $phpdate = strtotime( $product->product_datetime_created );
                                            }
                                            else{
                                                $phpdate = strtotime( $product->product_datetime_modified );
                                                echo $product->product_datetime_modified;
                                            }
                                            echo date( "F j, Y, g:i a", $phpdate );
                                        ?></small>
                                    </p>
                                    
                                </div>
                                <div class="col s3 right-align">
                                    <p>
                                        ₱ <?= number_format($product->unit_price, 2, '.', ''); ?>
                                        <br/>
                                        <?php if($product->available_stocks > 1 ): ?>
                                            <span style="padding:2px;" class="green lighten-2 white-text text-lighten-2">In stock: <?= $product->available_stocks; ?></span>
                                        <?php else: ?>
                                            <span style="padding:2px;" class="red lighten-2 white-text text-lighten-2">In stock: <?= $product->available_stocks; ?></span>
                                        <?php endif; ?>
                                    </p>
                                </div>

                            </div>

                            <div class="col s12">
                                <div class="col s1">
                                    <img src="https://i.pinimg.com/originals/0c/3b/3a/0c3b3adb1a7530892e55ef36d3be6cb8.png" alt="" class="circle responsive-img" style="width: 100%;">
                                </div>
                                <div class="col s11">
                                    <h6 class="black-text">
                                        <?= $product->product_seller_name; ?>
                                    </h6>
                                </div>
                            </div>
                            <div class="col s12">
                                <p><?= $product->description; ?></p>
                            </div>
                            <div class="col s12">
                                <!-- <a class="btn btn-small grey darken-2 white-text" href="#"><small>Buy now</small></a> -->
                            </div>
                        </div>
                    </div>
                    <hr class="solid">
                    <?php if($gallery_images->num_rows() > 0): ?>
                        <h6>Other images of this product:</h6>
                        <div class="row valign-wrapper">
                            
                            <div class="col s12">
                                <?php foreach ($gallery_images->result() as $image): ?>
                                    <img src="<?= base_url() . $image->image_path ?>" class="materialboxed col" style="height: 100px; width: auto; "> <!-- random image -->
                                <?php endforeach; ?>
                            </div>
                        </div>
                    <?php endif;?> 
                </div>

            </div>

        </div>
    </div>
</main>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        
        var materialBoxElem = document.querySelectorAll('.materialboxed');
        var materialBoxInstance = M.Materialbox.init(materialBoxElem);
    });


    
</script>