<main>
    <div class="container-fluid">
        <div class="row">

            <div class="col s12">

                <div class="col s4">
                    <h5><strong>Marketplace</strong>
                    &emsp;<a href="<?= base_url() ?>Subscribers_FE/marketplace_manage" class="btn light-blue darken-2">My Items</a>
                    &emsp;<a href="<?= base_url() ?>Subscribers_FE/marketplace_messages" class="btn light-blue darken-2">My Messages</a>
                </div>
                <div class="input-field col s4 ">
                    <i class="material-icons prefix">find_in_page</i>
                    <input type="text" id="search_item" placeholder="Search for item or seller names and hit Enter" name="search_item" class="validate" />
                    <label for="search_item">Search</label>
                </div>

                <div id="marketplace_items"></div>
                

                <!-- <div class="col s12 center">
                    <a class="btn teal lighten-2">Load More</a>
                </div> -->


            </div>

        </div>
    </div>
    <div id="rate_seller" class="modal" style="width:20rem;">
        <div class="modal-content center-align">
            <h5 id="rate_title"><strong>Rate this seller</strong></h5>
            <div class="rate" style="margin-left:1em;"></div>
        </div>
        <div class="modal-footer">
            <a href="#" class=" modal-action modal-close btn-flat">Close</a>
        </div>
    </div>
</main>