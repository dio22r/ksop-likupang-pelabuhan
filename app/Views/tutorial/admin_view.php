<?= $this->extend('layout/admin') ?>

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
            <img class="mb-2 mb-md-4" height="200px" src="/assets/images/siapmenanti-256.png" alt="..." />
          </p>

          <style>
            iframe .ytp-chrome-top.ytp-show-cards-title {
              display: none;
            }
          </style>
          <div class="card mb-2">
            <div class="card-header">
              Menu Laporan
            </div>
            <div class="card-body">
              <iframe width="100%" height="315" src="https://www.youtube.com/embed/G2QyBBOB8o0" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
            </div>
          </div>

          <div class="card mb-2">
            <div class="card-header">
              Validasi Data Pengajuan
            </div>

            <div class="card-body">
              <iframe width="100%" height="315" src="https://www.youtube.com/embed/cL35hvsggHo" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
            </div>
          </div>

          <div class="card mb-2">
            <div class="card-header">
              Hapus Data Pengajuan
            </div>

            <div class="card-body">
              <iframe width="100%" height="315" src="https://www.youtube.com/embed/3NAlhKrSFcw" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
            </div>
          </div>

          <div class="card mb-2">
            <div class="card-header">
              Revisi Data Pengajuan
            </div>

            <div class="card-body">
              <iframe width="100%" height="315" src="https://www.youtube.com/embed/2asjX0wEWzw" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
            </div>
          </div>

        </div>
      </div>


    </div>
  </section>

</div>

<?= $this->endSection() ?>