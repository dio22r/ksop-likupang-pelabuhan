<?= $this->extend('layout/admin',) ?>

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

              <div v-if="alert_show" class="alert alert-danger" role="alert">
                <ul class="m-0">
                  <li v-for="msg in alert_msg">
                    {{msg}}
                  </li>
                </ul>
              </div>

              <form id="form" method="POST" action="<?= base_url("/registration"); ?>" v-on:submit='submit($event)'>
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
                  <div class="g-recaptcha" data-sitekey="6Ldn_T0bAAAAAJ91SqDahIiePHe9a-K_DD4Yvx2j"></div>
                </div>

                <div class="form-group">
                  <button type="button" v-on:click='submit($event);' class="btn btn-primary"><i class="bi bi-envelope-fill"></i> Simpan</button>
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