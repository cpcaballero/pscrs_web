<script>
    var base_url = "<?= base_url() ?>";


    $('form').submit(function(e) {
        e.preventDefault();
        $.ajax({
            type: "get",
            url: base_url + "api/user/Forgot/" + $('#token').val(),
            dataType: "json",
            success: function(response) {
                if (response) {
                    if (response.success) {
                        // window.location.replace(base_url + "Login_FE");
                        Swal.fire({
                            title: 'Password reset successful!',
                            html: response.success.message,
                            icon: 'success',
                            showDenyButton: false,
                            showCancelButton: false,
                        }).then((result) => {
                            if (result.isConfirmed) {
                                window.location.replace(base_url + "Login_FE");
                            }
                        })
                    } else {
                        Swal.fire({
                            title: 'Warning',
                            html: response.error.message,
                            icon: 'warning',
                            timer: 2000,
                            showConfirmButton: false,
                            showDenyButton: false,
                            showCancelButton: false,
                        })
                    }
                }
            }
        });
    });
</script>