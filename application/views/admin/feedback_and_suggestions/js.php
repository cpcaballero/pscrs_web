<script>
    // CKEDITOR.replace('content');

    var base_url = "<?= base_url() ?>";
    var token = "<?php echo $_SESSION['account']['token'] ?>";
    var active_user = "<?php echo $_SESSION['account']['details']['id'] ?>";
    var videos_table = $('.datatables').DataTable({
        "pageLength": 10,
        "responsive": true
    });

    get_contact();

    $('#contact_details_update').click(function() {
        Swal.fire({
            title: 'Are you sure?',
            text: 'Do yo want to update the contact details?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Okay'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: base_url + "api/contact-us/Contact",
                    type: "POST",
                    data: $('#ContactDetailsForm').serialize(),
                    headers: {
                        "Authorization": "Bearer " + token
                    },
                    dataType: "JSON",
                    success: function(res) {
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
                                get_contact();
                            })
                        } else {
                            Swal.fire(
                                'Warning!',
                                res.error.message,
                                'warning'
                            ).then(() => {
                                get_contact();
                            })
                        }
                    }
                });
            }
        })
    });

    function get_contact() {
        $.ajax({
            type: "get",
            url: base_url + "api/contact-us/Contact",
            headers: {
                "Authorization": "Bearer " + token
            },
            dataType: "json",
            success: function(res) {
                if (res.success) {
                    $('#address').val('');
                    $('#email').val('');
                    $('#telephone').val('');
                    $('#address').val(res.success.data[0].address);
                    $('#email').val(res.success.data[0].email);
                    $('#telephone').val(res.success.data[0].telephone);
                }
            }
        });
    }

    function view_feedback(id) {

        $.ajax({
            type: "get",
            url: base_url + "api/feedback/Feedback/" + id,
            headers: {
                "Authorization": "Bearer " + token
            },
            success: function(res) {
                if (res.success) {
                    $('#view_sender').text(res.success.data.name);
                    $('#view_email').text(res.success.data.email);
                    $('#view_contact').text(res.success.data.contact_number);
                    $('#view_subject').text(res.success.data.subject);
                    $('#view_message').html(res.success.data.message);
                    $('#view_date').text(res.success.data.sent_datetime);
                }
                $('#view_feedback').modal('open');
            }
        });

    }

    function delete_feedback(id) {
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
                    url: base_url + "api/feedback/Feedback/" + id,
                    type: "DELETE",
                    headers: {
                        "Authorization": "Bearer " + token
                    },
                    dataType: "JSON",
                    success: function(res) {
                        if (res.success) {
                            Swal.fire({
                                title: 'Success!',
                                html: 'Feedback deleted',
                                icon: 'success',
                                timer: 1300,
                                showConfirmButton: false,
                                showDenyButton: false,
                                showCancelButton: false,
                            }).then(() => {
                                window.location.replace(base_url + "Admin_FE/feedback_and_suggestions");
                            })
                        } else {
                            Swal.fire(
                                'Warning!',
                                res.error.message,
                                'warning'
                            ).then(() => {
                                window.location.replace(base_url + "Admin_FE/feedback_and_suggestions");
                            })
                        }
                    }
                });
            }
        })
    }

    // export surgical report CSV
    $("#report_csv_download").on("click", function (e ){
        e.preventDefault();
        export_csv();
    });
    function export_csv() {
        console.log('csv')
        $.ajax({
            type: "post",
            url: base_url + "api/reports/GetFeedbacks",
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
    // export surgical report CSV

    // export surgical report PDF
    $("#report_pdf_download").on("click", function (e ){
        e.preventDefault();
        export_pdf();
    });
    function export_pdf() {
        console.log('pdf')
        $.ajax({
            type: "post",
            url: base_url + "api/reports/GetFeedbacks",
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
    // export surgical report PDF

    $(document).ready(function() {
        // Materialize initialization
        $('.collapsible').collapsible();
        $('.dropdown-trigger').dropdown();
        $('.materialboxed').materialbox();
        $('select').formSelect();
        $('.modal').modal();
    });
</script>
