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
    var videos_table = $('#video_table').DataTable({
        "pageLength": 10,
        "responsive": true
    });

    // get surgical videos for index
    function get_videos() {
        console.log("get videos")
        $.ajax({
            type: "get",
            url: base_url + "api/surgical/Videos",
            headers: {
                "Authorization": "Bearer " + token
            },
            dataType: "json",
            success: function(res) {
                if (res.success) {
                    videos = res.success.data;
                    var counter = 1;
                    videos_table.clear().draw();

                    videos.forEach(element => {
                        var del_id = "delete_video('" + element.video_id + "')";
                        var del = '<button onclick="' + del_id + '" class="btn btn-small red darken-2"><span class="fa fa-trash"></span></button>&nbsp';

                        var blk_id = "unpublish_video('" + element.video_id + "')";
                        var blk = '<button onclick="' + blk_id + '" class="btn btn-small black darken-2"><span class="fa fa-ban"></span></button>&nbsp';

                        var alw_id = "publish_video('" + element.video_id + "')";
                        var alw = '<button onclick="' + alw_id + '" class="btn btn-small green darken-2"><span class="fa fa-check"></span></button>&nbsp';
                        var status;

                        if (element.video_status == 1) {
                            status = blk;
                        } else {
                            status = alw;
                        }
                        //get the video number from vimeo link
                        var video_ref;
                        video_ref = element.video_link.split('/');

                        var video = '<iframe src="https://player.vimeo.com/video/' + video_ref[3] + '?title=0&byline=0&portrait=0" style="top:0;left:0;width:100%;height:100%;" frameborder="0" allow="autoplay; fullscreen; picture-in-picture" allowfullscreen></iframe>';

                        var video_details = '<strong>' + element.video_title + "</strong></br>" + element.video_desc

                        videos_table.row.add([
                            video,
                            video_details.substr(0, 80),
                            element.video_link,
                            '<a href="' + base_url + 'Admin_FE/surgical_view/' + element.video_id + '" class="btn btn-small light-blue darken-2"><span class="fa fa-eye"></span></a>&nbsp;' +
                            '<a href="' + base_url + 'Admin_FE/surgical_update/' + element.video_id + '" class="btn btn-small yellow darken-2"><span class="fa fa-pencil"></span></a>&nbsp;' +
                            del +
                            status
                        ]).draw(false);

                    });
                } else {
                    videos_table.clear().draw();
                }

            }
        });
    }

    // delete surgical video
    function delete_video(id) {
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
                    url: base_url + "api/surgical/Videos/" + id,
                    type: "DELETE",
                    headers: {
                        "Authorization": "Bearer " + token
                    },
                    dataType: "JSON",
                    success: function(res) {
                        if (res.success) {
                            Swal.fire({
                                title: 'Success!',
                                html: 'Video deleted',
                                icon: 'success',
                                timer: 1300,
                                showConfirmButton: false,
                                showDenyButton: false,
                                showCancelButton: false,
                            }).then(() => {
                                get_videos();
                            })
                        } else {
                            Swal.fire(
                                'Warning!',
                                res.error.message,
                                'warning'
                            ).then(() => {
                                get_videos();
                            })
                        }
                    }
                });
            }
        })
    }
    // delete surgical video

    // unpublish surgical video
    function unpublish_video(id) {
        Swal.fire({
            title: 'Are you sure?',
            text: 'Do yo want to unpublish this video?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Okay'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: base_url + "api/surgical/Block/",
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
                                html: 'Video unpublished',
                                icon: 'success',
                                timer: 1300,
                                showConfirmButton: false,
                                showDenyButton: false,
                                showCancelButton: false,
                            }).then(() => {
                                get_videos();
                            })
                        } else {
                            Swal.fire(
                                'Warning!',
                                res.error.message,
                                'warning'
                            ).then(() => {
                                get_videos();
                            })
                        }
                    }
                });
            }
        })
    }
    // unpublish surgical video

    // publish surgical video
    function publish_video(id) {
        Swal.fire({
            title: 'Are you sure?',
            text: 'Do yo want to publish this video?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Okay'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: base_url + "api/surgical/Allow",
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
                                html: 'Video unpublished',
                                icon: 'success',
                                timer: 1300,
                                showConfirmButton: false,
                                showDenyButton: false,
                                showCancelButton: false,
                            }).then(() => {
                                get_videos();
                            })
                        } else {
                            Swal.fire(
                                'Warning!',
                                res.error.message,
                                'warning'
                            ).then(() => {
                                get_videos();
                            })
                        }
                    }
                });
            }
        })
    }
    // publish surgical video

    // create surgical video
    $('#create_video_submit').click(function() {
        $.ajax({
            type: "post",
            url: base_url + "api/surgical/Videos",
            data: {
                'title': $('#title').val(),
                'description': editor.getData(),
                'video_link': $('#video_link').val(),
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
                            window.location.replace(base_url + "Admin_FE/surgical_create");
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
    // create surgical video

    // update surgical video
    $('#update_video_submit').click(function() {
        $.ajax({
            type: "post",
            url: base_url + "api/surgical/Update",
            data: {
                'id': $('#id').val(),
                'title': $('#title').val(),
                'description': editor.getData(),
                'video_link': $('#video_link').val(),
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
                            window.location.replace(base_url + "Admin_FE/surgical_update/" + $('#id').val());
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
    // update surgical video

    // export surgical report CSV
    $("#report_csv_download").on("click", function (e ){
        e.preventDefault();
        export_csv();
    });
    function export_csv() {
        console.log('csv')
        $.ajax({
            type: "post",
            url: base_url + "api/reports/SurgicalReport",
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
            url: base_url + "api/reports/SurgicalReport",
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

    get_videos();

    
</script>