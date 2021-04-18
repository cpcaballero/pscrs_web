<script>
    var base_url = "<?= base_url() ?>";
    var token = "<?php echo $_SESSION['account']['token'] ?>";
    var active_user = "<?php echo $_SESSION['account']['details']['id'] ?>";

    $('.datatables').DataTable();
    $(document).ready(function() {
        $('.modal').modal();
    });

    var billing_table = $('#billing_table').DataTable({
        "pageLength": 10,
        "responsive": true
    });

    var billing_seller_table = $('#billing_seller_table').DataTable({
        "pageLength": 10,
        "responsive": true
    });

    $.ajax({
        type: "get",
        url: base_url + "api/user/Users/" + active_user,
        headers: {
            "Authorization": "Bearer " + token
        },
        dataType: "json",
        success: function(res) {
            if (res.success) {
                $('#name').val(res.success.data.fullname);
                $('#email').val(res.success.data.email_address);
                $('#contact_number').val(res.success.data.contact_number);
            }
        }
    });
    $.ajax({
        type: "get",
        url: base_url + "api/member/Faqs",
        headers: {
            "Authorization": "Bearer " + token
        },
        dataType: "json",
        success: function(res) {
            if (res.success) {
                $('#faqs_data').html(res.success.data[0].faq);
                $('#terms_data').html(res.success.data[0].terms_conditions);
                $('#privacy_data').html(res.success.data[0].data_privacy);
            }
        }
    });

    $('.update_profile').click(function() {
        Swal.fire({
            title: 'Are you sure?',
            text: "You want to update this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, update it!'
        }).then((result) => {
            if (result.isConfirmed) {
                Swal.fire(
                    'Updated!',
                    'Profile has been Updated.',
                    'success'
                )
            }
        })
    });

    $('.change_pass').click(function() {
        $.ajax({
            type: "post",
            url: base_url + "api/auth/Change",
            data: {
                'token': token,
                'old_pass': $('#old_pass').val(),
                'new_pass': $('#new_pass').val(),
                'retype_pass': $('#retype_pass').val(),
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
                            window.location.replace(base_url + "Subscribers_FE/profile_settings/");
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

    function update_billing(marketplace_transaction_id, payment_transaction_reference, payment_date){
        console.log(marketplace_transaction_id)
        console.log(typeof payment_transaction_reference)
        console.log(payment_date)

        $("#payment_transaction_reference").val(payment_transaction_reference == "null" ? "" : payment_transaction_reference);
        $("#payment_date").val(payment_date);
        $("#marketplace_transaction_id").val(marketplace_transaction_id);
        $("#update_billing").modal("open");
        
    }

    function submit_billing_update(){
        console.log($("#payment_date").val())
        console.log($("#marketplace_transaction_id").val())
        console.log($("#payment_transaction_reference").val())
        if($("#payment_date").val() != "" && $("#payment_date").val() != "0000-00-00" &&$("#payment_transaction_reference").val() != "" ){
            $.ajax({
                type: "post",
                url: base_url + "api/billing/Billing",
                headers: {
                    "Authorization": "Bearer " + token
                },
                data: {
                    'active_user': active_user,
                    'marketplace_transaction_id': $('#marketplace_transaction_id').val(),
                    'payment_date': $('#payment_date').val(),
                    'payment_transaction_reference': $('#payment_transaction_reference').val(),
                },
                dataType: "json",
                success: function(res) {
                    if (res) {
                        if (res.success) {
                            $("#update_billing").modal("close");
                            Swal.fire({
                                title: 'Success!',
                                html: res.success.message,
                                icon: 'success',
                                timer: 1300,
                                showConfirmButton: false,
                                showDenyButton: false,
                                showCancelButton: false,
                            }).then(() => {
                                window.location.replace(base_url + "Subscribers_FE/profile_settings/");
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
        }
        else{
            alert("Both payment date and payment transaction reference are required")
        }
        
    }

    function get_billing() {
        $.ajax({
            type: "get",
            url: base_url + "api/billing/Billing/user/" + active_user,
            headers: {
                "Authorization": "Bearer " + token
            },
            dataType: "json",
            success: function(res) {
                if (res.success) {
                    billing = res.success.data;

                    var counter = 1;
                    billing_table.clear().draw();

                    billing.forEach(element => {
                        let datetime = element.datetime_created.split(" ")
                        console.log(datetime)
                        let date = datetime[0].split("-").join("")
                        let reference_order = date + " - " + element.id
                        billing_table.row.add([
                            reference_order,
                            element.seller,
                            element.item_name,
                            element.quantity,
                            element.total,
                            element.datetime_created,
                            element.payment_date == "0000-00-00 00:00:00" ? "Not yet paid" : element.payment_date,
                            element.payment_transaction_reference
                            // '<a href="' + base_url + 'Admin_FE/viewbilling/' + element.id + '" class="btn btn-small light-blue darken-2"><span class="fa fa-eye"></span></a>&nbsp;'
                        ]).draw(false);

                    });
                } else {
                    billing_table.clear().draw();
                }

            }
        });
    }
    get_billing();

    


    $(document).ready(function() {
        // Materialize initialization
        // $('.collapsible').collapsible();
        // $('.dropdown-trigger').dropdown();
        // $('.materialboxed').materialbox();
        // $('.modal').modal();
        // $('select').formSelect();
    });
</script>