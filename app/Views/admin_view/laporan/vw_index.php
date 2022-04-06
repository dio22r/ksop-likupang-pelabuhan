<?= $this->extend('layout/admin') ?>

<?= $this->section('content') ?>

<style>
  .hide {
    display: none;
  }
</style>

<script>
  var jsConfig = <?= json_encode($arrConfig); ?>;
  console.log("test");
</script>


<div id="data-vue">

  <section id="content">

    <div class="container">
      <h1 class="display-4 text-center mt-2"> Laporan </h1>
      <div class="card text-center">
        <div class="card-header">
          <ul class="nav nav-tabs card-header-tabs">
            <li class="nav-item">
              <a class="nav-link active" id="bulan-tab" data-toggle="tab" href="#bulan" role="tab" aria-controls="bulan" aria-selected="true">Bulanan</a>
            </li>
            <li class="nav-item">
              <a class="nav-link " id="harian-tab" data-toggle="tab" href="#harian" role="tab" aria-controls="harian" aria-selected="true">Harian</a>
            </li>
            <li class="nav-item">
              <a class="nav-link " id="apbn-tab" data-toggle="tab" href="#apbn" role="tab" aria-controls="apbn" aria-selected="true" @click="apbn_on_change()">APBN</a>
            </li>
          </ul>
        </div>
        <div class="card-body">
          <div class="tab-content" id="myTabContent">
            <!-- tab bulanan -->
            <div class="tab-pane fade show active" id="bulan" role="tabpanel" aria-labelledby="bulan-tab">
              <div class="form-row  justify-content-center">
                <div class="col-sm-3">
                  <div class="input-group input-group-sm mb-3">
                    <select class="form-control" name="year" v-model="mdl_year" @change="get_all()">
                      <?php foreach ($arrYears as $key => $val) { ?>
                        <option value="<?= $val ?>"><?= $val ?></option>
                      <?php } ?>
                    </select>
                  </div>
                </div>
              </div>
              <div class="row justify-content-center">
                <div class="col-sm-12">
                  <div class="row">
                    <div class="col-lg-3 col-6 mb-3">
                      <div class="card  text-white bg-warning">
                        <div class="card-body">
                          <h5 class="card-title">Menunggu</h5>
                          <h1> {{dataStatistik.menunggu}} </h1>
                        </div>
                      </div>
                    </div>
                    <div class="col-lg-3 col-6 mb-3">
                      <div class="card text-white bg-success">
                        <div class="card-body">
                          <h5 class="card-title">Dietujui</h5>
                          <h1> {{dataStatistik.diterima}} </h1>
                        </div>
                      </div>
                    </div>
                    <div class="col-lg-3 col-6 mb-3">
                      <div class="card text-white bg-danger">
                        <div class="card-body">
                          <h5 class="card-title">Ditolak</h5>
                          <h1> {{dataStatistik.ditolak}} </h1>
                        </div>
                      </div>
                    </div>
                    <div class="col-lg-3 col-6 mb-3">
                      <div class="card text-white bg-primary">
                        <div class="card-body">
                          <h5 class="card-title">Total Pengajuan</h5>
                          <h1> {{dataStatistik.total}} </h1>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>

              <table class="table table-bordered table-hover table-sm">
                <tr>
                  <th width="7%">No.</th>
                  <th width="25%">Bulan</th>
                  <th width="17%">Disetujui</th>
                  <th width="17%">Ditolak</th>
                  <th width="17%">Total</th>
                  <th width="17%">Laporan</th>
                </tr>
                <tr v-if="items.length < 1">
                  <th colspan="6" class="text-center">Belum ada data</th>
                </tr>
                <tr v-else v-for="(item, index) in items">
                  <td>{{index + 1}}</td>
                  <td>{{item.nama}}</td>
                  <td>{{item.diterima}}</td>
                  <td>{{item.ditolak}}</td>
                  <td>{{parseInt(item.diterima) + parseInt(item.ditolak)}}</td>
                  <td>
                    <button @click="print_laporan_bulanan(item.num)" data-toggle="modal" data-target="#detail-modal" class="btn btn-sm btn-success">
                      <i class="bi bi-printer"></i> Print
                    </button>
                    <!--
                    <button data-href="<?= base_url("/admin/laporan/stat_harian") ?>" class="btn btn-sm btn-outline-primary">
                      <i class="bi bi-eye"></i> Detail
                    </button>
                    -->
                  </td>
                </tr>
              </table>
            </div>
            <!-- eof tab bulanan -->

            <!-- tab harian -->
            <div class="tab-pane fade" id="harian" role="tabpanel" aria-labelledby="harian-tab">

              <div class="row justify-content-center">
                <div class="col-sm-5 mb-3">
                  <div class="input-group">
                    <div class="input-group-append">
                      <span class="input-group-text"><i class="bi bi-calendar4-event"></i></span>
                    </div>
                    <input id="datepicker" type="text" class="form-control datepicker" autocomplete="off" data-date-format="yyyy-mm-dd" placeholder="Tanggal Laporan">
                    <div class="input-group-append">
                      <button @click="print_laporan_harian()" data-toggle="modal" data-target="#detail-modal" class="btn btn-primary"><i class="bi bi-search"></i></button>
                    </div>
                  </div>
                </div>
              </div>
            </div>

            <!-- eof tab harian -->


            <!-- tab Apbn -->
            <div class="tab-pane fade" id="apbn" role="tabpanel" aria-labelledby="apbn-tab">
              <div class="form-row justify-content-center">

                <div class="col-md-4">
                  <div class="input-group input-group-sm mb-3">
                    <select class="form-control" name="year" v-model="mdl_apbn_year" @change="apbn_on_change()">
                      <?php foreach ($arrYears as $key => $val) { ?>
                        <option value="<?= $val ?>"><?= $val ?></option>
                      <?php } ?>
                    </select>
                  </div>
                </div>

                <div class="col-md-4">
                  <div class="input-group input-group-sm mb-3">
                    <select class="form-control" name="year" v-model="mdl_apbn_bulan" @change="apbn_on_change()">
                      <option value="">Semua Bulan</option>
                      <?php foreach ($arrBulan as $key => $val) { ?>
                        <option value="<?= $key ?>"><?= $val ?></option>
                      <?php } ?>
                    </select>
                  </div>
                </div>

                <div class="col-md-2">
                  <div class="input-group input-group-sm mb-3">
                    <button @click="apbn_print($event)" data-toggle="modal" data-target="#detail-modal" class="btn btn-sm btn-success">
                      <i class="bi bi-printer"></i> Print
                    </button>
                  </div>
                </div>


              </div>

              <div class="row justify-content-center">
                <div class="col-lg-3 col-6 mb-3">
                  <div class="card text-white bg-primary">
                    <div class="card-body">
                      <h5 class="card-title">Total Data</h5>
                      <h1> {{apbn_statistik.diterima}} </h1>
                    </div>
                  </div>
                </div>
              </div>


              <table class="table table-bordered table-hover table-sm">
                <tr>
                  <th width="7%">No.</th>
                  <th width="20%">Tgl. Daftar</th>
                  <th width="23%">Keagenan</th>
                  <th width="30%">Nama Kapal</th>
                  <th width="10%">Bendera</th>
                  <th width="10%">Status</th>
                </tr>
                <tr v-if="apbn_data.length < 1">
                  <th colspan="6" class="text-center">Belum ada data</th>
                </tr>
                <tr v-else v-for="(item, index) in apbn_data" data-toggle="modal" data-target="#apbn-modal" v-on:click="apbn_detail(item.id, $event)">
                  <td>{{index + apbn_count_start}}</td>
                  <td>{{item.created_at}}</td>
                  <td>{{item.nama_agen}}</td>
                  <td>{{item.nama_kapal}}</td>
                  <td>{{item.bendera}}</td>
                  <td>
                    <span v-if="item.status == 1" class="badge badge-success">Disetujui</span>
                    <span v-if="item.status == 0" class="badge badge-secondary">Menunggu</span>
                    <span v-if="item.status == -1" class="badge badge-danger">Ditolak</span>

                  </td>
                </tr>
              </table>

              <nav aria-label="Page navigation example">
                <ul class="pagination justify-content-center">
                  <li class="page-item" v-bind:class="[ apbn_current_page == 1 ? 'disabled' :'' ]"><a class="page-link prev" v-on:click="apbn_pagination(-1, $event)" href="#">Prev.</a></li>
                  <li class="page-item"><a class="page-link" v-on:click="apbn_pagination(-2, $event)" v-bind:class="[ apbn_current_page - 2 <= 0 ? 'hide' : '' ]" href="#">{{ apbn_current_page - 2 }}</a></li>
                  <li class="page-item"><a class="page-link" v-on:click="apbn_pagination(-1, $event)" v-bind:class="[ apbn_current_page - 1 <= 0 ? 'hide' : '' ]" href="#">{{ apbn_current_page - 1 }}</a></li>
                  <li class="page-item active"><a class="page-link" href="#">{{ apbn_current_page }}</a></li>
                  <li class="page-item"><a class="page-link" v-on:click="apbn_pagination(1, $event)" v-bind:class="[ apbn_current_page + 1 > apbn_total_page ? 'hide' : '' ]" href="#">{{ apbn_current_page + 1 }}</a></li>
                  <li class="page-item"><a class="page-link" v-on:click="apbn_pagination(2, $event)" v-bind:class="[ apbn_current_page + 2 > apbn_total_page ? 'hide' : '' ]" href="#">{{ apbn_current_page + 2 }}</a></li>
                  <li class="page-item" v-bind:class="[ apbn_current_page == apbn_total_page ? 'disabled' :'' ]"><a class="page-link next" v-on:click="apbn_pagination(1, $event)" href="#">Next</a></li>
                </ul>
              </nav>
            </div>
            <!-- eof tab apbn -->

          </div>
        </div>
      </div>
    </div>
  </section>

  <div class="hide">
    <iframe src="#" id="iframe-print-laporan"></iframe>
  </div>

  <div class="modal fade" id="detail-modal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Print Data!</h5>
          <button type="button" id="btn-close" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <div class="alert alert-info"> Harap menunggu file print sedang dipersiapkan! </div>
          <div class="progress">
            <div class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" aria-valuenow="75" aria-valuemin="0" aria-valuemax="100" style="width: 100%"></div>
          </div>
        </div>
      </div>
    </div>
  </div>



  <div class="modal fade" id="apbn-modal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Detail Kapal!</h5>
          <button type="button" id="btn-close" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div v-if="retrieve_process">
          <div class="modal-body">
            <table class="table table-sm table-bordered">
              <tr>
                <th>Tanggal Daftar</th>
                <td>{{ detail_kapal.created_at }}</td>
              </tr>
              <tr>
                <th width="30%">Nama Agen</th>
                <td width="70%">{{ detail_kapal.nama_agen }}</td>
              </tr>
              <tr>
                <th width="30%">Nama Kapal</th>
                <td width="70%">{{ detail_kapal.nama_kapal }}</td>
              </tr>
              <tr>
                <th>Nama Nahkoda</th>
                <td>{{ detail_kapal.nama_nahkoda }}</td>
              </tr>
              <tr>
                <th>Jenis Kapal</th>
                <td>{{ detail_kapal.nama_jenis_kapal }}</td>
              </tr>
              <tr>
                <th>Bendera</th>
                <td>{{ detail_kapal.bendera }}</td>
              </tr>
              <tr>
                <th>GT / DWT</th>
                <td>{{ detail_kapal.gt }} / {{ detail_kapal.dwt }}</td>
              </tr>
              <tr>
                <th>LOA</th>
                <td>{{ detail_kapal.loa }}</td>
              </tr>
              <tr>
                <th>Status</th>
                <td>
                  <span v-if="detail_kapal.status == 1" class="badge badge-success">Disetujui</span>
                  <span v-if="detail_kapal.status == 0" class="badge badge-secondary">Menunggu</span>
                  <span v-if="detail_kapal.status == -1" class="badge badge-danger">Ditolak</span>
                </td>
              </tr>
              <tr>
                <th>User Validator</th>
                <td>{{ detail_kapal.user_nama }}</td>
              </tr>
            </table>
          </div>

          <div class="modal-footer">
            <a v-bind:href="'<?= base_url("/admin/pengoprasian-kapal/detail"); ?>/' + detail_kapal.id + '?backurl=laporan'" class="btn btn-sm btn-light">
              <i class="bi bi-eye"></i> Lihat Detail
            </a>
          </div>

        </div>
        <div v-else>
          <div class="progress">
            <div class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" aria-valuenow="75" aria-valuemin="0" aria-valuemax="100" style="width: 100%"></div>
          </div>
        </div>
      </div>
    </div>
  </div>

</div>


<?= $this->endSection() ?>