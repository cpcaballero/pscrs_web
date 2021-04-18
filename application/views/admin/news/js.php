<script>
    $(document).ready(function() {
        //     // Materialize initialization
        $('.select2').select2();
        $('.normal_select').formSelect();
    });
</script>
<script>
    if ($('textarea').length == 1) {
        var editor = CKEDITOR.replace('description');
    }
    var base_url = "<?= base_url() ?>";
    var token = "<?php echo $_SESSION['account']['token'] ?>";
    var active_user = "<?php echo $_SESSION['account']['details']['id'] ?>";
    var news_table = $('#news_table').DataTable({
        "pageLength": 10,
        "responsive": true
    });

    //get news for index
    function get_news() {
        $.ajax({
            type: "get",
            url: base_url + "api/news/News",
            headers: {
                "Authorization": "Bearer " + token
            },
            dataType: "json",
            success: function(res) {
                if (res.success) {
                    news = res.success.data;
                    var counter = 1;
                    news_table.clear().draw();

                    news.forEach(element => {
                        var del_id = "delete_news('" + element.news_id + "')";
                        var del = '<button onclick="' + del_id + '" class="btn btn-small red darken-2"><span class="fa fa-trash"></span></button>&nbsp';

                        var blk_id = "unpublish_news('" + element.news_id + "')";
                        var blk = '<button onclick="' + blk_id + '" class="btn btn-small black darken-2"><span class="fa fa-ban"></span></button>&nbsp';

                        var alw_id = "publish_news('" + element.news_id + "')";
                        var alw = '<button onclick="' + alw_id + '" class="btn btn-small green darken-2"><span class="fa fa-check"></span></button>&nbsp';
                        var status;

                        if (element.status == 1) {
                            status = blk;
                        } else {
                            status = alw;
                        }
                        // //get the news number from vimeo link
                        // var news_ref;
                        // news_ref = element.news_link.split('/');

                        // var news = '<iframe src="https://player.vimeo.com/news/' + news_ref[3] + '?title=0&byline=0&portrait=0" style="top:0;left:0;width:100%;height:100%;" frameborder="0" allow="autoplay; fullscreen; picture-in-picture" allowfullscreen></iframe>';

                        

                        news_table.row.add([
                            element.title,
                            element.description.substr(0, 80),
                            element.status === "1" ? 'Published' : 'Not Published',
                            '<a href="' + base_url + 'Admin_FE/technology_news_view/' + element.news_id + '" class="btn btn-small light-blue darken-2"><span class="fa fa-eye"></span></a>&nbsp;' +
                            '<a href="' + base_url + 'Admin_FE/technology_news_update/' + element.news_id + '" class="btn btn-small yellow darken-2"><span class="fa fa-pencil"></span></a>&nbsp;' +
                            del +
                            status
                        ]).draw(false);

                    });
                } else {
                    news_table.clear().draw();
                }

            }
        });
    }
    get_news();

    $('#create_news_submit').click(function(e) {
        e.preventDefault();
        $.ajax({
            type: "post",
            url: base_url + "api/news/News",
            data: {
                'title': $('#title').val(),
                'description': editor.getData(),
                'owner_user_id': $('#owner_user_id').val(),
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
                            window.location.replace(base_url + "Admin_FE/technology_news_create");
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


    $('#update_news_submit').click(function(e) {
        e.preventDefault();
        $.ajax({
            type: "post",
            url: base_url + "api/news/Update",
            data: {
                'id': $('#id').val(),
                'title': $('#title').val(),
                'description': editor.getData(),
                'owner_user_id': $('#owner_user_id').val(),
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
                            window.location.replace(base_url + "Admin_FE/technology_news_update/" + $('#id').val());
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

    function delete_news(id) {
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
                    url: base_url + "api/news/News/" + id,
                    type: "DELETE",
                    headers: {
                        "Authorization": "Bearer " + token
                    },
                    dataType: "JSON",
                    success: function(res) {
                        if (res.success) {
                            Swal.fire({
                                title: 'Success!',
                                html: 'News deleted',
                                icon: 'success',
                                timer: 1300,
                                showConfirmButton: false,
                                showDenyButton: false,
                                showCancelButton: false,
                            }).then(() => {
                                get_news();
                            })
                        } else {
                            Swal.fire(
                                'Warning!',
                                res.error.message,
                                'warning'
                            ).then(() => {
                                get_news();
                            })
                        }
                    }
                });
            }
        })
    }


    function unpublish_news(id) {
        Swal.fire({
            title: 'Are you sure?',
            text: 'Do yo want to unpublish this news?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Okay'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: base_url + "api/news/Block/",
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
                                html: 'News unpublished',
                                icon: 'success',
                                timer: 1300,
                                showConfirmButton: false,
                                showDenyButton: false,
                                showCancelButton: false,
                            }).then(() => {
                                get_news();
                            })
                        } else {
                            Swal.fire(
                                'Warning!',
                                res.error.message,
                                'warning'
                            ).then(() => {
                                get_news();
                            })
                        }
                    }
                });
            }
        })
    }


    function publish_news(id) {
        Swal.fire({
            title: 'Are you sure?',
            text: 'Do yo want to publish this news?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Okay'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: base_url + "api/news/Allow",
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
                                html: 'news published',
                                icon: 'success',
                                timer: 1300,
                                showConfirmButton: false,
                                showDenyButton: false,
                                showCancelButton: false,
                            }).then(() => {
                                get_news();
                            })
                        } else {
                            Swal.fire(
                                'Warning!',
                                res.error.message,
                                'warning'
                            ).then(() => {
                                get_news();
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
            url: base_url + "api/reports/NewsReport",
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
            url: base_url + "api/reports/NewsReport",
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
        // $('.collapsible').collapsible();
        // $('.dropdown-trigger').dropdown();
        // $('.materialboxed').materialbox();
        // $('select').material_select();
        $('.modal').modal();
    });
</script>