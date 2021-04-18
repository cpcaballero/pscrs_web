<main>
    <div class="container-fluid">
        <div class="row">

            <div class="col s12">
                <div class="col s12 ">
                    <h5><strong>Marketplace - Create</strong></h5>
                </div>


                <div class="col s12 l12">
                    <form action="" id="create_product_form" method="post">

                        <div class="file-field input-field">
                            <div class="btn">
                                <span>Upload Primary Photo</span>
                                <input type="file" name="product_image">
                            </div>
                            <div class="file-path-wrapper">
                                <input class="file-path validate" type="text">
                            </div>
                        </div>
                        <div class="file-field input-field">
                            <div class="btn">
                                <span>Upload Gallery Photos</span>
                                <input type="file" name="other_images[]" multiple>
                            </div>
                            <div class="file-path-wrapper">
                                <input class="file-path validate" type="text">
                            </div>
                        </div>


                        <div class="input-field col s12 l12">
                            <input type="text" id="item_name" name="item_name" class="validate">
                            <label for="item_name" data-error="wrong" data-success="right">Item Name</label>
                        </div>

                        <div class="col s12 l12">
                            Description
                        </div>
                        <div class="input-field col s12 l12">
                            <textarea id="description" name="description"></textarea>
                        </div>

                        <div class="input-field col s12 l12">
                            <input type="number" id="available_stocks" name="available_stocks" class="validate">
                            <label for="available_stocks" data-error="wrong" data-success="right">Available Stocks</label>
                        </div>

                        <div class="input-field col s12 l12">
                            <input type="number" id="unit_price" name="unit_price" class="validate">
                            <label for="unit_price" data-error="wrong" data-success="right">Unit Price</label>
                        </div>

                        <div class="col s12 l12" style="margin-top:20px;">
                            <div class="row">
                                <div class="col s12 m6 l2" style="margin-bottom:10px;"><button type="submit" id="create_product" class="btn light-blue darken-2 col s12 create">Create Item</button></div>
                                <div class="col s12 m6 l2" style="margin-bottom:10px;"><a href="<?= base_url() ?>Subscribers_FE/marketplace_manage" class="btn default darken-2 col s12">Cancel</a></div>
                            </div>
                        </div>

                        <input type="hidden" name="active_user" value="<?= $_SESSION['account']['details']['id'] ?>">

                    </form>

                </div>
            </div>

        </div>
    </div>
</main>