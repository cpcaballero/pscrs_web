<script>
    var vision = CKEDITOR.replace('vision');
    var mission = CKEDITOR.replace('mission');
    var pres_message = CKEDITOR.replace('pres_message');

    var base_url = "<?= base_url() ?>";
    var token = "<?php echo $_SESSION['account']['token'] ?>";
    var active_user = "<?php echo $_SESSION['account']['details']['id'] ?>";

    // update surgical video

    $('#about_pscrs_update').click(function(e) {

        $.ajax({
            type: "post",
            url: base_url + "api/about/Update",
            data: {
                'id': 1,
                'mission': mission.getData(),
                'vision': vision.getData(),
                'pres_message': pres_message.getData(),
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
                            window.location.replace(base_url + "Admin_FE/about_pscrs/");
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

    // $('.update').click(function() {
    //     Swal.fire({
    //         title: 'Are you sure?',
    //         text: "You want to update this!",
    //         icon: 'warning',
    //         showCancelButton: true,
    //         confirmButtonColor: '#3085d6',
    //         cancelButtonColor: '#d33',
    //         confirmButtonText: 'Yes, update it!'
    //     }).then((result) => {
    //         if (result.isConfirmed) {
    //             Swal.fire(
    //                 'Updated!',
    //                 'Your content has been Updated.',
    //                 'success'
    //             )
    //         }
    //     })
    // });

    // document.addEventListener('DOMContentLoaded', function() {
    //     var elems = document.querySelectorAll('.dropdown-trigger');
    //     var instances = M.Dropdown.init(elems, options);
    // });

    // $(document).ready(function() {
    //     // Materialize initialization
    //     $('.collapsible').collapsible();
    //     $('.dropdown-trigger').dropdown();
    //     $('.materialboxed').materialbox();
    //     $('select').material_select();
    //     $('.modal').modal();
    // });
</script>