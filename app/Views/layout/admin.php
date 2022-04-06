<!DOCTYPE html>
<html lang="en">

<head>

  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">
  <title><?= APPS_NAME; ?> <?= $page_title ?></title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css" integrity="sha384-B0vP5xmATw1+K9KRQjQERJvTumQW0nPEzvF6L/Z6nronJ3oUOFUFpCjEUQouq2+l" crossorigin="anonymous">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css">
  <link rel="stylesheet" href="<?= base_url("assets/css/admin.css"); ?>">

  <?php if (isset($arrCss)) { ?>
    <?php foreach ($arrCss as $key => $val) { ?>
      <link rel="stylesheet" href="<?= $val ?>">
    <?php } ?>
  <?php } ?>


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

  <section id="menu" class="bg-color-menu">
    <div class="container">
      <?= view_cell('\App\Libraries\AdminWidget::menu', ["active_id" => $ctl_id]) ?>
    </div>
  </section>

  <?= $this->renderSection('content') ?>

  <div class="container mt-3 mb-3">
    <div class="footer text-center">
      <p class="text-center m-0">
        <img class="" height="100px" src="/assets/images/siapmenanti-256.png" alt="..." />
      </p>

      <p class="font-weight-light">Copyright &copy; 2021 &mdash; KSOP Kelas II Bitung </p>
    </div>
  </div>
</body>

</html>