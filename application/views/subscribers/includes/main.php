<!DOCTYPE html>
<html lang="en">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>PSCRS </title>
    <link rel="icon" href="<?= base_url('assets/images/pscrs.png') ?>">
    <!-- CSS  -->
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link href="<?= base_url() ?>assets/css/materialize.css" type="text/css" rel="stylesheet" media="screen,projection" />
    <link href="<?= base_url() ?>assets/css/style.css" type="text/css" rel="stylesheet" media="screen,projection" />
    <link href="<?= base_url() ?>assets/css/datatables.min.css" type="text/css" rel="stylesheet" media="screen,projection" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

    <!--  Scripts-->
    <script src="<?= base_url() ?>assets/js/materialize.js"></script>
    <script src="https://cdn.ckeditor.com/4.16.0/basic/ckeditor.js"></script>


    <?php if (isset($css)) : ?>
        <?php $this->load->view($css); ?>
    <?php endif; ?>

</head>


<body>

    <?php if (isset($sidebar)) : ?>
        <?php $this->load->view($sidebar); ?>
    <?php endif; ?>

    <?php if (isset($navbar)) : ?>
        <?php $this->load->view($navbar); ?>
    <?php endif; ?>


    <?php if (isset($content)) : ?>
        <?php $this->load->view($content); ?>
    <?php endif; ?>


    <?php if (isset($footer)) : ?>
        <?php $this->load->view($footer); ?>
    <?php endif; ?>
    <script src="https://code.jquery.com/jquery-2.2.4.min.js" integrity="sha256-BbhdlvQf/xTY9gja0Dq3HiwQF8LaCRTXxZKRutelT44=" crossorigin="anonymous"></script>
    <script src="<?= base_url() ?>assets/js/materialize.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
    <script src="<?= base_url('assets/js/datatables.min.js') ?>"></script>

    <script>
        $('.dropdown-trigger').dropdown();
        $('.sidenav').sidenav();
    </script>

    <?php if (isset($js)) : ?>
        <?php $this->load->view($js); ?>
    <?php endif; ?>

</body>

</html>