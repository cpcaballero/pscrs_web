<script src="<?= base_url('assets/raterjs/') ?>/rater.min.js" charset="utf-8"></script>
<script>
    if ($('textarea').length == 1) {
        var editor = CKEDITOR.replace('description');
    }

    $(document).ready(function() {
        $('.modal').modal();
    });

    var base_url = "<?= base_url() ?>";
    var token = "<?php echo $_SESSION['account']['token'] ?>";
    var active_user = "<?php echo $_SESSION['account']['details']['id'] ?>";
    var products_table = $('#products_table').DataTable({
        "pageLength": 10,
        "responsive": true
    });
    var marketplace_messages_table = $('#marketplace_messages_table').DataTable({
        "pageLength": 10,
        "responsive": true
    });
    var parts = window.location.pathname.split('/');
    var lastSegment = parts.pop() || parts.pop();  // handle potential trailing slash

    if ($(".myBox").length == 1) {
        $('.myBox').scrollTop($(".myBox")[0].scrollHeight);
    }

    $('#update_product_form').on("submit", function(e) {
        e.preventDefault();
        var formData = new FormData(this);
        formData.set("description", editor.getData());
        formData.append("active_user", active_user);

        $.ajax({
            type: "post",
            enctype: 'multipart/form-data',
            processData: false,
            contentType: false,
            url: base_url + "api/marketplace/Update",
            data: formData,
            headers: {
                "Authorization": "Bearer " + token
            },
            dataType: "json",
            success: function(res) {
                if (res) {
                    if (res.success) {
                        Swal.fire({
                            title: 'Success!',
                            html: res.success.message,
                            icon: 'success',
                            timer: 1300,
                            showConfirmButton: false,
                            showDenyButton: false,
                            showCancelButton: false,
                        }).then(() => {
                            window.location.replace(base_url + "Subscribers_FE/marketplace_manage");
                        })
                    } else {
                        Swal.fire({
                            title: 'Warning',
                            html: res.error.message,
                            icon: 'warning',
                            showDenyButton: false,
                            showCancelButton: false,
                            confirmButtonText: 'Okay'
                        })
                    }
                }
            }
        });
    });

    $('#create_product_form').on("submit", function(e) {
        e.preventDefault();
        var formData = new FormData(this);
        formData.set("description", editor.getData());
        formData.append("active_user", active_user);

        $.ajax({
            type: "post",
            enctype: 'multipart/form-data',
            processData: false,
            contentType: false,
            url: base_url + "api/marketplace/Marketplace",
            data: formData,
            headers: {
                "Authorization": "Bearer " + token
            },
            dataType: "json",
            success: function(res) {
                if (res) {
                    if (res.success) {
                        Swal.fire({
                            title: 'Success!',
                            html: res.success.message,
                            icon: 'success',
                            timer: 1300,
                            showConfirmButton: false,
                            showDenyButton: false,
                            showCancelButton: false,
                        }).then(() => {
                            window.location.replace(base_url + "Subscribers_FE/marketplace_create");
                        })
                    } else {
                        Swal.fire({
                            title: 'Warning',
                            html: res.error.message,
                            icon: 'warning',
                            showDenyButton: false,
                            showCancelButton: false,
                            confirmButtonText: 'Okay'
                        })
                    }
                }
            }
        });
    });

    $("#ordering_available_stocks").on("change", function(e){
        let current_quantity = $(this).val()
        let unit_price = $("#ordering_unit_price").text()
        console.log(current_quantity * unit_price)
        $("#ordering_total_amount").val(parseInt(current_quantity) * parseInt(unit_price))
    });

    var gen_options = {
        max_value: 5,
        step_size: 1,
        readonly: true,
    };

    $(".gen_rate").rate(gen_options);

    function rate_seller(seller_id){
        $.ajax({
            type: "get",
            url: base_url + "api/user/Users/" + seller_id,
            headers: {
                "Authorization": "Bearer " + token
            },
            success: function(res) {
                var options = {
                    max_value: 5,
                    step_size: 1,
                    initial_value: 0,
                    readonly: false,
                    change_once: false, // Determines if the rating can only be set once
                    // ajax_method: 'POST',
                    // url: base_url + "api/surgical/Rate/",
                    // additional_data: {
                    //     'id': id,
                    //     'active_user': active_user,
                    //     'rating': 5
                    // }, // Additional data to send to the server
                    only_select_one_symbol: false, // If set to true, only selects the hovered/selected symbol and nothing prior to it
                };

                $(".rate").rate(options);

                $(".rate").on("change", function(ev, data) {
                    $.ajax({
                        type: "POST",
                        url: base_url + "api/marketplace/Rate/",
                        data: {
                            'id': seller_id,
                            'active_user': active_user,
                            'rating': data.to
                        },
                        dataType: "JSON",
                        headers: {
                            "Authorization": "Bearer " + token
                        },
                        success: function(res) {
                            if (res.success.status) {
                                Swal.fire({
                                    title: 'Success!',
                                    html: res.success.message,
                                    icon: 'success',
                                    showDenyButton: false,
                                    showCancelButton: false,
                                }).then(() => {
                                    $('#rate_seller').modal('close');
                                    window.location.replace(base_url + "Subscribers_FE/marketplace");
                                })
                            } else {
                                Swal.fire({
                                    title: 'Warning!',
                                    html: res.success.message,
                                    icon: 'warning',
                                    showDenyButton: false,
                                    showCancelButton: false,
                                }).then(() => {
                                    $('#rate_seller').modal('close');
                                    window.location.replace(base_url + "Subscribers_FE/marketplace");
                                })
                            }
                        }
                    });
                });
                $('#rate_seller').modal('open');
            }
        });
    }

    function get_other_products() {
        $.ajax({
            type: "get",
            url: base_url + "api/marketplace/Marketplace",
            headers: {
                "Authorization": "Bearer " + token
            },
            dataType: "json",
            success: function(res) {
                if (res.success) {
                    var marketplace_items = $("#marketplace_items");
                    products = res.success.data;
                    var counter = 1;
                    marketplace_items.empty();
                    
                    products.forEach(element => {
                        let unchecked_star = '';
                        let rated_display  = '';
                        for(var a = 0; a < 5; a++){
                            unchecked_star += '<span class="fa fa-star unchecked"></span>';
                        }
                        console.log("rate is :" + element.rating)
                        for(var i = 1; i <= Math.floor(element.rating_ave); i++){
                            rated_display += '<span class="fa fa-star checked"></span>'
                        }
                        for (var j = 1; j <= (5 - Math.floor(element.rating_ave)); j++){
                            rated_display += '<span class="fa fa-star unchecked"></span>'
                        }
                        if(element.seller_id != active_user && element.product_status == "1" && element.is_deleted == "0" && element.is_flagged == "0"){
                            var product_item = `
                                <div class="col s12 marketplace_item">
                                    <hr class="solid">
                                    <div class="row valign-wrapper">

                                        <div class="col s4">
                                            <img src="${base_url}${element.item_image_thumb}" alt="product photo" class="responsive-img" style="height: 280px;"> <!-- notice the "circle" class -->
                                        </div>
                                        <div class="content col s8" style="padding: 0px;">
                                            <div class="col s12" style="margin-bottom: 10px;">
                                                <div class="col s9">
                                                    <h6><strong class="item_name">${element.item_name}</strong></h6>
                                                    <small>${element.product_datetime_modified ? element.product_datetime_modified : element.product_datetime_created}</small>
                                                </div>
                                                <div class="col s3 right-align">
                                                    <div>₱ ${element.unit_price}<br/>
                                                        ${ element.available_stocks > 1 
                                                            ? '<span style="padding:2px;" class="green lighten-2 white-text text-lighten-2">In stock: ' + element.available_stocks + ' </span>'
                                                            : '<span style="padding:2px;" class="red lighten-2 white-text text-lighten-2">In stock: ' + element.available_stocks + ' </span>'
                                                        }
                                                    </div>
                                                </div>

                                            </div>

                                            <div class="col s12">
                                                <div class="col s1">
                                                    <img src="https://i.pinimg.com/originals/0c/3b/3a/0c3b3adb1a7530892e55ef36d3be6cb8.png" alt="" class="circle" style="width: 60px;">
                                                </div>
                                                <div class="col s11">
                                                    <h6 class="black-text seller_name">
                                                        ${element.product_seller_name} <br/> 
                                                        ${ element.rating_ave == null ? unchecked_star : rated_display }
                                                    </h6>
                                                </div>
                                            </div>
                                            <div class="col s12">
                                                ${element.description}
                                            </div>
                                            <div class="col s12">
                                                <a class="btn btn-small grey darken-2 white-text" href="<?= base_url() ?>Subscribers_FE/marketplace_item_view/${element.product_id}"><small>View Product</small></a>
                                                <a class="btn btn-small grey darken-2 white-text" href="<?= base_url() ?>Subscribers_FE/marketplace_messages_view/${element.seller_id}/${active_user}"><small>Message Seller</small></a>
                                                <a class="btn btn-small grey darken-2 white-text" onclick="rate_seller(${element.seller_id})"><small>Rate the seller</small></a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            `
                            marketplace_items.append(product_item)
                        }
                    });
                } else {
                    marketplace_items.empty();
                }

            }
        });
    }
    
    function get_own_products() {
        $.ajax({
            type: "get",
            url: base_url + "api/marketplace/Marketplace",
            headers: {
                "Authorization": "Bearer " + token
            },
            dataType: "json",
            success: function(res) {
                if (res.success) {
                    products_table.clear().draw();
                    products = res.success.data;
                    products.forEach(element => {
                        if(element.seller_id == active_user && element.is_deleted == "0"){
                            var del_id = "delete_item('" + element.product_id + "')";
                            var del = '<button onclick="' + del_id + '" class="btn btn-small red darken-2"><span class="fa fa-trash"></span></button>&nbsp';

                            var blk_id = "unpublish_item('" + element.product_id + "')";
                            var blk = '<button onclick="' + blk_id + '" class="btn btn-small black darken-2"><span class="fa fa-ban"></span></button>&nbsp';

                            var alw_id = "publish_item('" + element.product_id + "')";
                            var alw = '<button onclick="' + alw_id + '" class="btn btn-small green darken-2"><span class="fa fa-check"></span></button>&nbsp';
                            var status;

                            if (element.product_status == 1) {
                                status = blk;
                            } else {
                                status = alw;
                            }
                            var product_thumb = '<img src=' + base_url + element.item_image_original + ' style="width: 200px; height: auto;" />';
                            products_table.row.add([
                                product_thumb,
                                element.item_name+ '<br/><br/><span style="padding:2px;" class="red lighten-2 white-text text-lighten-2">Admin flagged as inappropriate</span>',
                                element.description,
                                element.available_stocks,
                                '₱ ' + element.unit_price,
                                '<a href="' + base_url + 'Subscribers_FE/marketplace_view/' + element.product_id + '" class="btn btn-small light-blue darken-2"><span class="fa fa-eye"></span></a>&nbsp;' +
                                '<a href="' + base_url + 'Subscribers_FE/marketplace_update/' + element.product_id + '" class="btn btn-small yellow darken-2"><span class="fa fa-pencil"></span></a>&nbsp;' +
                                del +
                                status
                            ]).draw(false);
                        }
                    });
                } else {
                    products_table.clear().draw();
                }

            }
        });
    }

    function delete_item(product_id){
        Swal.fire({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: base_url + "api/marketplace/Marketplace/" + product_id,
                    type: "DELETE",
                    headers: {
                        "Authorization": "Bearer " + token
                    },
                    dataType: "JSON",
                    success: function(res) {
                        if (res.success) {
                            Swal.fire({
                                title: 'Success!',
                                html: 'Product deleted',
                                icon: 'success',
                                timer: 1300,
                                showConfirmButton: false,
                                showDenyButton: false,
                                showCancelButton: false,
                            }).then(() => {
                                get_own_products();
                            })
                        } else {
                            Swal.fire(
                                'Warning!',
                                res.error.message,
                                'warning'
                            ).then(() => {
                                get_own_products();
                            })
                        }
                    }
                });
            }
        })
    }

    function unpublish_item(id) {
        Swal.fire({
            title: 'Are you sure?',
            text: 'Do yo want to unpublish this product?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Okay'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: base_url + "api/marketplace/Block/",
                    type: "POST",
                    data: {
                        id: id,
                        active_user: active_user
                    },
                    headers: {
                        "Authorization": "Bearer " + token
                    },
                    dataType: "JSON",
                    success: function(res) {

                        if (res.success) {
                            Swal.fire({
                                title: 'Success!',
                                html: 'Product unpublished',
                                icon: 'success',
                                timer: 1300,
                                showConfirmButton: false,
                                showDenyButton: false,
                                showCancelButton: false,
                            }).then(() => {
                                get_own_products();
                            })
                        } else {
                            Swal.fire(
                                'Warning!',
                                res.error.message,
                                'warning'
                            ).then(() => {
                                get_own_products();
                            })
                        }
                    }
                });
            }
        })
    }


    function publish_item(id) {
        Swal.fire({
            title: 'Are you sure?',
            text: 'Do yo want to publish this product?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Okay'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: base_url + "api/marketplace/Allow",
                    type: "POST",
                    data: {
                        id: id,
                        active_user: active_user
                    },
                    headers: {
                        "Authorization": "Bearer " + token
                    },
                    dataType: "JSON",
                    success: function(res) {
                        if (res.success) {
                            Swal.fire({
                                title: 'Success!',
                                html: 'Product published',
                                icon: 'success',
                                timer: 1300,
                                showConfirmButton: false,
                                showDenyButton: false,
                                showCancelButton: false,
                            }).then(() => {
                                get_own_products();
                            })
                        } else {
                            Swal.fire(
                                'Warning!',
                                res.error.message,
                                'warning'
                            ).then(() => {
                                get_own_products();
                            })
                        }
                    }
                });
            }
        })
    }

    $('.delete_convo').click(function() {
        Swal.fire({
            title: 'Are you sure?',
            text: "You want to delete this conversation!",
            icon: 'error',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.isConfirmed) {
                Swal.fire(
                    'conversation Deleted!',
                    'Your conversation has been Deleted.',
                    'success'
                )
            }
        })
    });

    $("#order_now").on("click", function(e) {
        e.preventDefault();
        let total = $("#ordering_total_amount").val()
        Swal.fire({
            title: 'Confirming order',
            text: "Are you sure about your order?",
            icon: 'info',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, place my order'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: base_url + "api/marketplace/Order",
                    type: "POST",
                    data: {
                        id: $("#product_id").val(),
                        quantity: $("#ordering_available_stocks").val(),
                        active_user: active_user,
                        total: total,
                        mode_of_payment: $("#ordering_mode_of_payment").val()
                    },
                    headers: {
                        "Authorization": "Bearer " + token
                    },
                    dataType: "JSON",
                    success: function(res) {
                        if (res.success) {
                            Swal.fire({
                                title: 'Order Placed!',
                                html: `<div>
                                    <p>
                                        Please deposit your payment to the following bank details:<br/>
                                        Bank: XXXXXXXX<br/>
                                        Account Name: XXXXXXXX<br/>
                                        Account Number: XXXXXXX</br><br/>
                                        Total Amount Ordered: ₱ ${total}
                                    </p>
                                    <p>
                                        After payment, please send a copy of your deposit slip to XXXXXXXX so the seller can update your order status.<br/>
                                        Kindly indicate the order id: <b><u>${res.success.order_reference}</b></u>
                                    </p>
                                    <p>We suggest to take a photo/screenshot of this window for future references.</p>
                                </div>`,
                                icon: 'success',
                                confirmButtonText: 'Close',
                                showConfirmButton: true,
                                showDenyButton: false,
                                showCancelButton: false,
                            }).then(() => {
                                window.location.replace(base_url + "Subscribers_FE/marketplace");
                            })
                        } else {
                            Swal.fire(
                                'Warning!',
                                res.error.message,
                                'warning'
                            ).then(() => {
                                get_own_products();
                            })
                        }
                    }
                });
            }
        })
    })

    $("#search_item").on("change", function(e){
        console.log('triggered')
        let search_string = e.target.value;
        console.log(search_string)
        $('.marketplace_item').each(function(){
            console.log( $(this).find(".item_name").text().toUpperCase().indexOf(search_string.toUpperCase()))
            let item_name_bool = $(this).find(".item_name").text().toUpperCase().indexOf(search_string.toUpperCase()) != -1;
            let seller_name_bool = $(this).find(".seller_name").text().toUpperCase().indexOf(search_string.toUpperCase()) != -1
            if(item_name_bool || seller_name_bool){
                $(this).show();
            }
            else{
                $(this).hide();
            }
        });
    })

    $(document).ready(function() {
        $('.scrollspy').scrollSpy();
        $('.carousel.carousel-slider').carousel({
            fullWidth: true,
            indicators: true
        });
        $('select').formSelect();
    });


    if(lastSegment === "marketplace"){
        get_other_products()
    }
    else if(lastSegment === "marketplace_manage"){
        console.log("manage")
        get_own_products()
    }
    else if(lastSegment === "marketplace_messages"){
        console.log("marketplace_message")
        get_conversations()
    }


    /** MESSAGING */
   

    function get_conversations() {
        $.ajax({
            type: "get",
            url: base_url + "api/messaging/ConversationsMP/" + active_user,
            headers: {
                "Authorization": "Bearer " + token
            },
            dataType: "json",
            success: function(res) {
                console.log(res);
                if (res.success) {
                    experts = res.success.data;
                    var counter = 1;
                    marketplace_messages_table.clear().draw();
                    experts.forEach(element => {
                        marketplace_messages_table.row.add([
                            element.sender_name,
                            element.sender_email,
                            element.sender_contact,
                            '<a href="' + base_url + 'Subscribers_FE/marketplace_messages_view/' + element.sender_id + '/' + active_user +'" class="btn btn-small light-blue darken-2"><span class="fa fa-envelope"></span></a>'
                        ]).draw(false);
                    });
                } else {
                    marketplace_messages_table.clear().draw();
                }
            }
        });
        

    }


    function send_message(sender, receiver) {
        console.log({
            'message': $('#message').val(),
            'sender': sender,
            'receiver': receiver,
            'convo_id': $('#convo_id').val(),
        });
        $.ajax({
            type: "POST",
            url: base_url + "api/messaging/MessagesMP",
            data: {
                'message': $('#message').val(),
                'sender': sender,
                'receiver': receiver,
                'convo_id': $('#convo_id').val(),
            },
            dataType: "JSON",
            headers: {
                "Authorization": "Bearer " + token
            },
            success: function(res) {
                if (!res.success) {
                    Swal.fire(
                        'Warning!',
                        res.error.message,
                        'warning'
                    )
                } else {
                    window.location.replace(base_url + "Subscribers_FE/marketplace_messages_view/" + receiver + '/' + sender);
                }
            }
        });
    }


    /*** REPORT */

    function get_seller_billing() {
        $.ajax({
            type: "get",
            url: base_url + "api/billing/Sellerbilling/user/" + active_user,
            headers: {
                "Authorization": "Bearer " + token
            },
            dataType: "json",
            success: function(res) {
                if (res.success) {
                    billing = res.success.data;

                    var counter = 1;
                    billing_seller_table.clear().draw();

                    billing.forEach(element => {
                        let datetime = element.datetime_created.split(" ")
                        console.log(datetime)
                        let date = datetime[0].split("-").join("")
                        let reference_order = date + " - " + element.id
                        console.log(element.seller_id)
                        console.log(active_user)
                        if(element.seller_id == active_user){
                            billing_seller_table.row.add([
                                reference_order,
                                element.fullname,
                                element.item_name,
                                element.quantity,
                                element.total,
                                element.datetime_created,
                                element.payment_date == "0000-00-00 00:00:00" ? "Not yet paid" : element.payment_date,
                                element.payment_transaction_reference,
                                // '<span>actions</span>'
                                `<a class="btn btn-small grey darken-2 white-text" 
                                    onclick="update_billing(
                                        ${element.id}, 
                                        '${element.payment_transaction_reference 
                                            ? element.payment_transaction_reference  
                                            : null }', 
                                        '${element.payment_date}'
                                    )"><span class="fa fa-cog"></span></a>&nbsp;`
                                // '<a href="' + base_url + 'Admin_FE/viewbilling/' + element.id + '" class="btn btn-small light-blue darken-2"><span class="fa fa-eye"></span></a>&nbsp;'
                            ]).draw(false);
                        }
                        

                    });
                } else {
                    billing_seller_table.clear().draw();
                }

            }
        });
    }
    get_seller_billing();

    

</script>