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
                            window.location.replace(base_url + "Admin_FE/marketplace_manage");
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
                            window.location.replace(base_url + "Admin_FE/marketplace_create");
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
                        
                        var flag_id = "unpublish_item('" + element.product_id + "')";
                        var flag = '<button onclick="' + flag_id + '" class="btn btn-small red darken-2  white-text">Flag product as inappropriate</button>&nbsp';

                        var unflag_id = "publish_item('" + element.product_id + "')";
                        var unflag = '<button onclick="' + unflag_id + '" class="btn btn-small green darken-2 white-text">Remove "Flagged as inappropriate"</button>&nbsp';
                        var status;

                        if (element.is_flagged == 0) {
                            status = flag;
                        } else {
                            status = unflag;
                        }

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
                        if(element.product_status == "1" && element.is_deleted == "0"){
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
                                                <a class="btn btn-small grey darken-2 white-text" href="<?= base_url() ?>Admin_FE/marketplace_item_view/${element.product_id}">View Product</a>
                                                ${status}
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
    
    


    function unpublish_item(id) {
        Swal.fire({
            title: 'Are you sure?',
            text: 'Do you want to Flag this product as inappropriate? Seller must contact you to bring this product back to marketplace list. Only view will be affected and will prevent future transaction. Current/ongoing transactions with this item will be retained and processable.',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Okay'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: base_url + "api/marketplace/Flag",
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
                                html: 'Product flagged as inappropriate',
                                icon: 'success',
                                timer: 1300,
                                showConfirmButton: false,
                                showDenyButton: false,
                                showCancelButton: false,
                            }).then(() => {
                                get_other_products();
                            })
                        } else {
                            Swal.fire(
                                'Warning!',
                                res.error.message,
                                'warning'
                            ).then(() => {
                                get_other_products();
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
            text: 'Do you want to Unflag this product as inappropriate? This product will be brought back to the marketplace list. Other members will be able to see and transact about this product',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Okay'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: base_url + "api/marketplace/Unflag",
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
                                html: 'Product flag is now removed',
                                icon: 'success',
                                timer: 1300,
                                showConfirmButton: false,
                                showDenyButton: false,
                                showCancelButton: false,
                            }).then(() => {
                                get_other_products();
                            })
                        } else {
                            Swal.fire(
                                'Warning!',
                                res.error.message,
                                'warning'
                            ).then(() => {
                                get_other_products();
                            })
                        }
                    }
                });
            }
        })
    }

    

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
    
    

    // export transaction report CSV
    $("#report_csv_download").on("click", function (e ){
        e.preventDefault();
        export_csv();
    });
    function export_csv() {
        console.log('csv')
        $.ajax({
            type: "post",
            url: base_url + "api/reports/BillingReport",
            data: {
                'report_date': $("#report_date").val(),
                'report_type': 'csv',
                'active_user': active_user
            },
            headers: {
                "Authorization": "Bearer " + token,
            },
            async: true,
            dataType: "json",
            success: function(res) {
                if (res.success) {
                    Swal.fire({
                        title: 'Success!',
                        html: 'Report downloading shortly',
                        icon: 'success',
                        timer: 3000,
                        showConfirmButton: false,
                        showDenyButton: false,
                        showCancelButton: false,
                    }).then(() => { 
                        let csvContent = atob(res.success.data);
                        var blob = new Blob([csvContent], {type: "data:application/octet-stream;base64"});
                        var a = document.createElement('a');
                        var url = window.URL.createObjectURL(blob);
                        a.href = url;
                        a.download = res.success.filename;
                        document.body.append(a);
                        a.click();
                        a.remove();
                        window.URL.revokeObjectURL(url);
                    })
                } else {
                    Swal.fire(
                        'Warning!',
                        res.error.message,
                        'warning'
                    )
                }
            },
            error : function(err){
                console.log(err)
            }
        });
    }
    // export transaction report CSV

    // export transaction report PDF
    $("#report_pdf_download").on("click", function (e ){
        e.preventDefault();
        export_pdf();
    });
    function export_pdf() {
        console.log('pdf')
        $.ajax({
            type: "post",
            url: base_url + "api/reports/BillingReport",
            data: {
                'report_date': $("#report_date").val(),
                'report_type': 'pdf',
                'active_user': active_user
            },
            headers: {
                "Authorization": "Bearer " + token,
            },
            async: true,
            dataType: "json",
            success: function(res) {
                if (res.success) {
                    Swal.fire({
                        title: 'Success!',
                        html: 'Report downloading shortly',
                        icon: 'success',
                        timer: 3000,
                        showConfirmButton: false,
                        showDenyButton: false,
                        showCancelButton: false,
                    }).then(() => {
                        var a = document.createElement('a');
                        var url = "data:application/pdf;base64," + res.success.data.trim();
                        a.href = url;
                        a.download = res.success.filename;
                        document.body.append(a);
                        a.click();
                        a.remove();
                        window.URL.revokeObjectURL(url);
                    })
                } else {
                    Swal.fire(
                        'Warning!',
                        res.error.message,
                        'warning'
                    )
                }
            },
            error : function(err){
                console.log(err)
            }
        });
    }
    // export transaction report PDF


    // export product report CSV
    $("#report_csv_download_product").on("click", function (e ){
        e.preventDefault();
        export_csv_product();
    });
    function export_csv_product() {
        console.log('csv')
        $.ajax({
            type: "post",
            url: base_url + "api/reports/ProductReport",
            data: {
                'report_date': $("#report_date").val(),
                'report_type': 'csv',
                'active_user': active_user
            },
            headers: {
                "Authorization": "Bearer " + token,
            },
            async: true,
            dataType: "json",
            success: function(res) {
                if (res.success) {
                    Swal.fire({
                        title: 'Success!',
                        html: 'Report downloading shortly',
                        icon: 'success',
                        timer: 3000,
                        showConfirmButton: false,
                        showDenyButton: false,
                        showCancelButton: false,
                    }).then(() => { 
                        let csvContent = atob(res.success.data);
                        var blob = new Blob([csvContent], {type: "data:application/octet-stream;base64"});
                        var a = document.createElement('a');
                        var url = window.URL.createObjectURL(blob);
                        a.href = url;
                        a.download = res.success.filename;
                        document.body.append(a);
                        a.click();
                        a.remove();
                        window.URL.revokeObjectURL(url);
                    })
                } else {
                    Swal.fire(
                        'Warning!',
                        res.error.message,
                        'warning'
                    )
                }
            },
            error : function(err){
                console.log(err)
            }
        });
    }
    // export product report CSV

    // export product report PDF
    $("#report_pdf_download_product").on("click", function (e ){
        e.preventDefault();
        export_pdf_product();
    });
    function export_pdf_product() {
        console.log('pdf')
        $.ajax({
            type: "post",
            url: base_url + "api/reports/ProductReport",
            data: {
                'report_date': $("#report_date").val(),
                'report_type': 'pdf',
                'active_user': active_user
            },
            headers: {
                "Authorization": "Bearer " + token,
            },
            async: true,
            dataType: "json",
            success: function(res) {
                if (res.success) {
                    Swal.fire({
                        title: 'Success!',
                        html: 'Report downloading shortly',
                        icon: 'success',
                        timer: 3000,
                        showConfirmButton: false,
                        showDenyButton: false,
                        showCancelButton: false,
                    }).then(() => {
                        var a = document.createElement('a');
                        var url = "data:application/pdf;base64," + res.success.data.trim();
                        a.href = url;
                        a.download = res.success.filename;
                        document.body.append(a);
                        a.click();
                        a.remove();
                        window.URL.revokeObjectURL(url);
                    })
                } else {
                    Swal.fire(
                        'Warning!',
                        res.error.message,
                        'warning'
                    )
                }
            },
            error : function(err){
                console.log(err)
            }
        });
    }
    // export product report PDF

</script>