<?= $this->extend('layout/default') ?>

<?= $this->section('content') ?>

<style>
  .hide {
    display: none;
  }
</style>
<div id="data-vue">
  <section id="section-1">
    <div class="container">
      <h2 class="text-center text-uppercase mt-5 mb-0">
        Tutorial
      </h2>
      <hr />
      <div class="row justify-content-center">
        <div class="col-lg-7 col-md-10 ">

          <p class="text-center">
            <img class="mb-2 mb-md-4" height="50px" src="<?= base_url('/assets/images/Kerja-dengan-hati.png') ?>" alt="..." />
          </p>
          <!-- 
          <div class="mb-3 text-center">
            <a class="btn btn-primary" target="_blank" href="#" role="button">E-Book: User Guide SIAPMENANTI</a>
          </div> -->

          <style>
            iframe .ytp-chrome-top.ytp-show-cards-title {
              display: none;
            }
          </style>
          <!-- <div class="card mb-2">
            <div class="card-header">
              Halaman Utama
            </div>
            <div class="card-body">
              <iframe width="100%" height="315" src="https://www.youtube.com/embed/JBakENzSgdY" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
            </div>
          </div> -->

          <div class="card mb-2">
            <div class="card-header">
              Pengajuan Layanan (Form)
            </div>
            <div class="card-body">
              <!-- <iframe width="100%" height="315" src="https://www.youtube.com/embed/xjNpWcnONxk" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe> -->
            </div>
          </div>

          <div class="card mb-2">
            <div class="card-header">
              Revisi Pengajuan Layanan
            </div>

            <div class="card-body">
              <!-- <iframe width="100%" height="315" src="https://www.youtube.com/embed/N_cyA7k4vGw" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe> -->
            </div>
          </div>

        </div>
      </div>


    </div>
  </section>

</div>

<?= $this->endSection() ?>