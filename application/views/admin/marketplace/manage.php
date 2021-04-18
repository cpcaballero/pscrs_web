<main>
    <div class="container-fluid">
        <div class="row">

            <div class="col s12">

                <div class="col s12 ">
                    <h5><strong>My Items</strong>&emsp;<a href="<?= base_url() ?>Subscribers_FE/marketplace_create" class="btn light-blue darken-2">Create Item</a>
                    &emsp;<a href="<?= base_url() ?>Subscribers_FE/marketplace_messages" class="btn light-blue darken-2">Messages</a></h5>
                </div>

                <form>
                    <!-- <div class="input-field col s">
                        <button class="btn light-blue darken-2" type="submit">Search
                        </button>
                    </div>
                    <div class="input-field col s4">
                        <input placeholder="Search..." id="" type="text" class="validate">
                    </div> -->
                </form>

                <div class="col s12">
                    <table id="products_table">
                        <thead>
                            <tr>
                                <th>Image</th>
                                <th>Item Name</th>
                                <th>Description</th>
                                <th>Available Stocks</th>
                                <th>Unit Price</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                    </table>
                </div>

            </div>

        </div>
    </div>
</main>