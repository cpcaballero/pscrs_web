<main>
    <div class="container-fluid">
        <div class="row">

            <div class="col s12">

                <div class="col">
                    <h5><strong>Marketplace</strong></h5>
                    <!-- &emsp;<a href="<?= base_url() ?>Subscribers_FE/marketplace_manage" class="btn light-blue darken-2">My Items</a>
                    &emsp;<a href="<?= base_url() ?>Subscribers_FE/marketplace_messages" class="btn light-blue darken-2">My Messages</a> -->
                </div>
                <div class="input-field col s4 ">
                    <i class="material-icons prefix">find_in_page</i>
                    <input type="text" id="search_item" placeholder="Search for item or seller names and hit Enter" name="search_item" class="validate" />
                    <label for="search_item">Search</label>
                </div>

                <div id="marketplace_items"></div>
                
                <br/><br/><br/>
                <div class="input-field col s12 m6 l2">
                    <a href="<?= base_url('Admin_FE/marketplace_product_report') ?>" class="btn grey darken-2 col s12">Extract Report</a>
                </div>
                <!-- <div class="col s12 center">
                    <a class="btn teal lighten-2">Load More</a>
                </div> -->


            </div>

        </div>
    </div>
</main>