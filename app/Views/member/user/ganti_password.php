<?= $this->extend('layout/member') ?>

<?= $this->section('content') ?>

<div id="data-vue">
  <section id="section-1">
    <div class="container">
      <h1 class="display-4 text-center mt-2">Ganti Password</h1>
      <div class="row justify-content-center">
        <div class="col-md-8">
          <div class="card">
            <div class="card-header">Form User</div>
            <div class="card-body">


              <?php if ($errors) { ?>
                <div class="alert alert-danger" role="alert">
                  <ul class="m-0">
                    <?php foreach ($errors as $value) { ?>
                      <li><?= $value ?></li>
                    <?php } ?>
                  </ul>
                </div>
              <?php } ?>

              <?php if ($success) { ?>
                <div class="alert alert-success" role="alert">
                  <ul class="m-0">
                    <?php foreach ($success as $value) { ?>
                      <li><?= $value ?></li>
                    <?php } ?>
                  </ul>
                </div>
              <?php } ?>

              <form id="form" method="POST" action="<?= $actionUrl; ?>">
                <div class="form-group">
                  <label for="exampleInputEmail1">Password Lama</label>
                  <input type="password" class="form-control" name="password_old" placeholder="***">
                </div>
                <div class="form-group">
                  <label for="exampleInputPassword1">Password Baru</label>
                  <input type="password" class="form-control" name="password" placeholder="****">
                </div>
                <div class="form-group">
                  <label for="exampleInputPassword1">Ulangi Password</label>
                  <input type="password" class="form-control" name="re_password" placeholder="****">
                </div>

                <div class="form-group">
                  <button type="submit" class="btn btn-primary"><i class="bi bi-envelope-fill"></i> Simpan</button>
                </div>

              </form>
            </div>
          </div>


        </div>
      </div>
    </div>
  </section>
</div>
<?= $this->endSection() ?>