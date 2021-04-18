<script>
    $(document).ready(function() {
        // Materialize initialization
        $('.select2').select2();
        $('.normal_select').formSelect();

    });
</script>
<script>
    if ($('#field_study').length == 1) {
        var field_study_editor = CKEDITOR.replace('field_study');
    }

    if ($('#notification').length == 1) {
        var notification_editor = CKEDITOR.replace('notification');
    }

    var base_url = "<?= base_url() ?>";
    var token = "<?php echo $_SESSION['account']['token'] ?>";
    var active_user = "<?php echo $_SESSION['account']['details']['id'] ?>";
    var users_table = $('#users_table').DataTable({
        "pageLength": 10,
        "responsive": true
    });

    var notification_table = $('#notification_table').DataTable({
        "pageLength": 10,
        "responsive": true
    });

    var billing_table = $('#billing_table').DataTable({
        "pageLength": 10,
        "responsive": true
    });

    get_users();

    if ($("#is_expert option:selected").val() == 1) {
        $("#field_of_study").show();
    } else {
        $("#field_of_study").hide();
    }

    $("#is_expert").change(function() {
        if ($("#is_expert option:selected").val() == 1) {
            $("#field_of_study").show();
        } else {
            $("#field_of_study").hide();
        }
    })

    function get_users() {
        $.ajax({
            type: "get",
            url: base_url + "api/user/Users",
            headers: {
                "Authorization": "Bearer " + token
            },
            dataType: "json",
            success: function(res) {
                if (res.success) {
                    users = res.success.data;
                    var counter = 1;
                    users_table.clear().draw();
                    var thumbnail;
                    users.forEach(element => {
                        if (element.profile_thumb) {
                            thumbnail = '<img src ="' + element.profile_thumb + '">';
                        } else {
                            thumbnail = '<img width="40px" src ="<?= base_url() . 'assets/images/avatar.png' ?>">';
                        }

                        var expert_blk_id = "expert_status('" + element.id + "')";
                        var expert_blk = '<button onclick="' + expert_blk_id + '" class="btn btn-small blue darken-2">EXPERT</button>&nbsp';

                        var del_id = "delete_user('" + element.id + "')";
                        var del = '<button onclick="' + del_id + '" class="btn btn-small red darken-2"><span class="fa fa-trash"></span></button>&nbsp';

                        var blk_id = "block_user('" + element.id + "')";
                        var blk = '<button onclick="' + blk_id + '" class="btn btn-small black darken-2"><span class="fa fa-ban"></span></button>&nbsp';

                        var alw_id = "allow_user('" + element.id + "')";
                        var alw = '<button onclick="' + alw_id + '" class="btn btn-small green darken-2"><span class="fa fa-check"></span></button>&nbsp';
                        var status;

                        if (element.status == 1) {
                            status = blk;
                        } else {
                            status = alw;
                        }

                        if (element.id != active_user && element.role == 'admin' && element.role != 'superadmin') {
                            users_table.row.add([
                                thumbnail,
                                element.fullname,
                                element.id,
                                element.contact_number,
                                element.email_address,
                                element.last_login,
                                '<a href="' + base_url + 'Admin_FE/adminprofile/' + element.id + '" class="btn btn-small light-blue darken-2"><span class="fa fa-eye"></span></a>&nbsp;' +
                                '<a href="' + base_url + 'Admin_FE/editadmin/' + element.id + '" class="btn btn-small yellow darken-2"><span class="fa fa-pencil"></span></a>&nbsp;' +
                                status
                            ]).draw(false);
                        }

                    });
                } else {
                    users_table.clear().draw();
                }
            }
        });
    }

    $('#create_admin_submit').click(function() {
        $.ajax({
            type: "post",
            url: base_url + "api/user/Users",
            data: {
                'id': $('#id').val(),
                'active_user': active_user,
                'fname': $('#fname').val(),
                'mname': $('#mname').val(),
                'lname': $('#lname').val(),
                'contact_number': $('#contact_number').val(),
                'email_address': $('#email_address').val(),
                'pass': $('#password').val(),
                'role': $('#role').val(),
                'is_expert': $("#is_expert option:selected").val(),
                'field_study': field_study_editor.getData()
            },
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
                            window.location.replace(base_url + "Admin_FE/createadmin");
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

    $('#update_admin_submit').click(function() {
        Swal.fire({
            title: 'Are you sure?',
            text: "Do you want to update this account?",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Update'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    type: "post",
                    url: base_url + "api/user/Update",
                    data: {
                        'id': $('#id').val(),
                        'active_user': active_user,
                        'fname': $('#fname').val(),
                        'mname': $('#mname').val(),
                        'lname': $('#lname').val(),
                        'contact_number': $('#contact_number').val(),
                        'email_address': $('#email_address').val(),
                        'username': $('#username').val(),
                        'is_expert': $("#is_expert option:selected").val(),
                        'field_study': field_study_editor.getData()
                    },
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
                                    window.location.replace(base_url + "Admin_FE/editadmin/" + $('#id').val());
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
        })
    });

    function block_user(id) {
        Swal.fire({
            title: 'Are you sure?',
            text: 'Do you want to block this account?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Okay'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: base_url + "api/user/Block/",
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
                                html: res.success.message,
                                icon: 'success',
                                timer: 1300,
                                showConfirmButton: false,
                                showDenyButton: false,
                                showCancelButton: false,
                            }).then(() => {
                                get_users();
                            })
                        } else {
                            Swal.fire(
                                'Warning!',
                                res.error.message,
                                'warning'
                            ).then(() => {
                                get_users();
                            })
                        }
                    }
                });
            }
        })
    }

    function allow_user(id) {
        Swal.fire({
            title: 'Are you sure?',
            text: 'Do you want to unblock this account?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Okay'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: base_url + "api/user/Allow",
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
                                html: res.success.message,
                                icon: 'success',
                                timer: 1300,
                                showConfirmButton: false,
                                showDenyButton: false,
                                showCancelButton: false,
                            }).then(() => {
                                get_users();
                            })
                        } else {
                            Swal.fire(
                                'Warning!',
                                res.error.message,
                                'warning'
                            ).then(() => {
                                get_users();
                            })
                        }
                    }
                });
            }
        })
    }

    $('.delete_billing').click(function() {
        Swal.fire({
            title: 'Are you sure?',
            text: "You want to delete this billing information!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, Delete it!'
        }).then((result) => {
            if (result.isConfirmed) {
                Swal.fire(
                    'Deleted!',
                    'Your billing information has been Deleted.',
                    'success'
                )
            }
        })
    });

    //get notification for index
    function get_notifications() {
        $.ajax({
            type: "get",
            url: base_url + "api/notification/Notify",
            headers: {
                "Authorization": "Bearer " + token
            },
            dataType: "json",
            success: function(res) {
                if (res.success) {
                    notification = res.success.data;

                    var counter = 1;
                    notification_table.clear().draw();

                    notification.forEach(element => {
                        var del_id = "delete_notification('" + element.id + "')";
                        var del = '<button onclick="' + del_id + '" class="btn btn-small red darken-2"><span class="fa fa-trash"></span></button>&nbsp';

                        var blk_id = "unpublish_notification('" + element.id + "')";
                        var blk = '<button onclick="' + blk_id + '" class="btn btn-small black darken-2"><span class="fa fa-ban"></span></button>&nbsp';

                        var alw_id = "publish_notification('" + element.id + "')";
                        var alw = '<button onclick="' + alw_id + '" class="btn btn-small green darken-2"><span class="fa fa-check"></span></button>&nbsp';
                        var status;

                        if (element.status == 1) {
                            status = blk;
                        } else {
                            status = alw;
                        }

                        notification_table.row.add([
                            element.title,
                            element.description.substr(0, 80),
                            element.status === "1" ? 'Published' : 'Not Published',
                            '<a href="' + base_url + 'Admin_FE/viewnotification/' + element.id + '" class="btn btn-small light-blue darken-2"><span class="fa fa-eye"></span></a>&nbsp;' +
                            '<a href="' + base_url + 'Admin_FE/editnotification/' + element.id + '" class="btn btn-small yellow darken-2"><span class="fa fa-pencil"></span></a>&nbsp;' +
                            del +
                            status
                        ]).draw(false);

                    });
                } else {
                    notification_table.clear().draw();
                }

            }
        });
    }
    get_notifications();

    $('#create_notification_submit').click(function(e) {
        e.preventDefault();
        $.ajax({
            type: "post",
            url: base_url + "api/Notification/Notify",
            data: {
                'title': $('#title').val(),
                'description': notification_editor.getData(),
                'recipient': $('#recipient').val(),
                'active_user': active_user,
            },
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
                            window.location.replace(base_url + "Admin_FE/createnotification");
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


    $('#update_notification_submit').click(function(e) {
        e.preventDefault();
        $.ajax({
            type: "post",
            url: base_url + "api/notification/Update",
            data: {
                'id': $('#id').val(),
                'title': $('#title').val(),
                'recipient': $('#recipient').val(),
                'description': notification_editor.getData(),
                'active_user': active_user,
            },
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
                            window.location.replace(base_url + "Admin_FE/editnotification/" + $('#id').val());
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

    function delete_notification(id) {
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
                    url: base_url + "api/notification/Notify/" + id,
                    type: "DELETE",
                    headers: {
                        "Authorization": "Bearer " + token
                    },
                    dataType: "JSON",
                    success: function(res) {
                        if (res.success) {
                            Swal.fire({
                                title: 'Success!',
                                html: 'Notification deleted',
                                icon: 'success',
                                timer: 1300,
                                showConfirmButton: false,
                                showDenyButton: false,
                                showCancelButton: false,
                            }).then(() => {
                                get_notifications();
                            })
                        } else {
                            Swal.fire(
                                'Warning!',
                                res.error.message,
                                'warning'
                            ).then(() => {
                                get_notifications();
                            })
                        }
                    }
                });
            }
        })
    }


    function unpublish_notification(id) {
        Swal.fire({
            title: 'Are you sure?',
            text: 'Do you want to unpublish this notification?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Okay'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: base_url + "api/notification/Block/",
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
                                html: 'notification unpublished',
                                icon: 'success',
                                timer: 1300,
                                showConfirmButton: false,
                                showDenyButton: false,
                                showCancelButton: false,
                            }).then(() => {
                                get_notifications();
                            })
                        } else {
                            Swal.fire(
                                'Warning!',
                                res.error.message,
                                'warning'
                            ).then(() => {
                                get_notifications();
                            })
                        }
                    }
                });
            }
        })
    }


    function publish_notification(id) {
        Swal.fire({
            title: 'Are you sure?',
            text: 'Do you want to publish this notification?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Okay'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: base_url + "api/notification/Allow",
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
                                html: 'notification unpublished',
                                icon: 'success',
                                timer: 1300,
                                showConfirmButton: false,
                                showDenyButton: false,
                                showCancelButton: false,
                            }).then(() => {
                                get_notifications();
                            })
                        } else {
                            Swal.fire(
                                'Warning!',
                                res.error.message,
                                'warning'
                            ).then(() => {
                                get_notifications();
                            })
                        }
                    }
                });
            }
        })
    }

    //get notification for index
    function get_billing() {
        $.ajax({
            type: "get",
            url: base_url + "api/billing/Billing",
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
                            element.mode_of_payment,
                            element.fullname,
                            element.payment_date,
                            element.payment_transaction_reference,
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
                            window.location.replace(base_url + "Admin_FE/adminprofile/" + active_user);
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


    $(document).ready(function() {
        $('.modal').modal();
    });
</script>