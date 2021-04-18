<script>
    var message = CKEDITOR.replace('message');

    var base_url = "<?= base_url() ?>";
    var token = "<?php echo $_SESSION['account']['token'] ?>";
    var active_user = "<?php echo $_SESSION['account']['details']['id'] ?>";

    $('form').submit(function(e) {
        e.preventDefault();

        $.ajax({
            type: "POST",
            url: base_url + 'api/feedback/Feedback',
            data: {
                'id': 1,
                'name': $('#name').val(),
                'email': $('#email').val(),
                'contact_number': $('#contact_number').val(),
                'address': $('#address').val(),
                'subject': $('#subject').val(),
                'message': message.getData()
            },
            dataType: "JSON",
            headers: {
                "Authorization": "Bearer " + token
            },
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
                        window.location.replace(base_url + "Subscribers_FE/feedback_and_suggestions");
                    })
                } else {
                    Swal.fire(
                        'Warning!',
                        res.error.message,
                        'warning'
                    )
                }

            }
        });
    })
</script>