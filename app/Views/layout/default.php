<!DOCTYPE html>
<html lang="en">

<head>

    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <title><?= APPS_NAME; ?> UPP Likupang | <?= $page_title ?></title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css" integrity="sha384-B0vP5xmATw1+K9KRQjQERJvTumQW0nPEzvF6L/Z6nronJ3oUOFUFpCjEUQouq2+l" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css">
    <link rel="stylesheet" href="<?= base_url("assets/css/admin.css"); ?>">

    <?php if (isset($arrCss)) { ?>
        <?php foreach ($arrCss as $key => $val) { ?>
            <link rel="stylesheet" href="<?= $val ?>">
        <?php } ?>
    <?php } ?>


    <!-- <script src='https://www.google.com/recaptcha/api.js' defer></script> -->

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js" crossorigin="anonymous" defer></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-Piv4xVNRyMGpqkS2by6br4gNJ7DXjqk09RmUpJ8jgGtD7zP9yug3goQfGII0yAns" crossorigin="anonymous" defer></script>
    <script src="https://cdn.jsdelivr.net/npm/vue@2.6.12" defer></script>
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js" defer></script>

    <?php if (isset($arrJs)) { ?>
        <?php foreach ($arrJs as $key => $val) { ?>
            <script src="<?= $val; ?>" defer></script>
        <?php } ?>
    <?php } ?>

</head>

<body>
    <header class="masthead bg-color-menu text-white text-center pt-2 pt-md-4">
        <div class="container">

            <div class="row">
                <div class="col-md-6 text-md-left text-center">
                    <a class="navbar-brand" href="/">
                        <img class="" src="<?= base_url('assets/images/ksop-likupang.png') ?>" alt="..." />
                    </a>
                </div>
                <!-- Masthead Avatar Image-->
                <div class="col-md-6 text-md-right text-center">
                    <!-- <img class="mb-2 mb-md-4" height="70px" src="/assets/images/siapmenanti.png" alt="..." /> -->
                    <img class="" src="<?= base_url('assets/images/Kerja-dengan-hati.png') ?>" alt="..." />
                </div>
                <!-- Masthead Heading-->
            </div>
            <div class="row">
                <div class="col-12">
                    <h2 class="text-master-color-red font-weight-bold">Elektronik Sistem Tambat Labuh</h2>
                    <h3 class="font-weight-bold">e-Sitabuh</h3>
                </div>
            </div>
        </div>
    </header>
    <?= $this->renderSection('content') ?>


    <?= $this->include('admin_widget/footer') ?>
</body>

</html>