<?= $this->extend('layout/member') ?>


<?= $this->section('style') ?>


<script src="<?= base_url("/assets/js/bootstrap-datepicker.min.js") ?>" defer></script>
<script src="<?= base_url("/assets/js/controller/daftar.js?v=1.1") ?>" defer></script>


<?= $this->endSection() ?>

<?= $this->section('content') ?>

<style>
  .hide {
    display: none;
  }

  .qrcode-warper {
    position: relative;
    vertical-align: middle;
    justify-content: center;
    display: flex;
  }

  .img-warper-qrcode {
    display: flex;
    justify-content: center;
    align-items: center;
    text-align: center;
    height: 250px;
    width: 250px;
  }
</style>

<div id="data-vue">
  <section id="section-1">
    <div class="container">
      <h2 class="text-center text-uppercase mt-5 mb-0">
        Form Pendaftaran
      </h2>
      <hr />
      <div class="row justify-content-center">
        <div class="col-md-8">
          <form id="form-daftar" method="post" enctype="multipart/form-data">
            <div class="form-group row">
              <label class="col-sm-3 col-form-label">Nama Kapal</label>
              <div class="col-sm-9">
                <input name="nama_kapal" type="text" class="form-control" required>
              </div>
            </div>
            <div class="form-group row">
              <label class="col-sm-3 col-form-label">Bendera</label>
              <div class="col-sm-9">
                <input name="bendera" type="text" class="form-control" required>
              </div>
            </div>
            <div class="form-group row">
              <label class="col-sm-3 col-form-label">GT</label>
              <div class="col-sm-4">
                <input name="gt" type="text" class="form-control" required>
              </div>
            </div>

            <div class="form-group row">
              <label class="col-sm-3 col-form-label">DWT</label>
              <div class="col-sm-4">
                <input name="dwt" type="text" class="form-control" required>
              </div>
            </div>
            <div class="form-group row">
              <label class="col-sm-3 col-form-label">Jenis Kapal</label>
              <div class="col-sm-6">
                <select name="jenis_kapal" class="form-control" required>
                  <?php foreach ($arrJenisKapal as $key => $arrVal) { ?>
                    <option value="<?= $arrVal["id"] ?>">
                      <?= $arrVal["nama"]; ?>
                    </option>
                  <?php } ?>
                </select>
              </div>
            </div>
            <div class="form-group row">
              <label class="col-sm-3 col-form-label">LOA</label>
              <div class="col-sm-4">
                <input name="loa" type="text" class="form-control" required>
              </div>
            </div>
            <div class="form-group row">
              <label class="col-sm-3 col-form-label">Pemilik / Principle</label>
              <div class="col-sm-9">
                <input name="pemilik" type="text" class="form-control" required>
              </div>
            </div>
            <div class="form-group row">
              <label for="inputPassword" class="col-sm-3 col-form-label">Nama Agen</label>
              <div class="col-sm-9">
                <input name="nama_agen" type="text" class="form-control" required>
              </div>
            </div>

            <div class="form-group row">
              <label class="col-sm-3 col-form-label">Nama Nahkoda</label>
              <div class="col-sm-9">
                <input name="nama_nahkoda" type="text" class="form-control" required>
              </div>
            </div>

            <div class="form-group row">
              <label class="col-sm-3 col-form-label">Trayek</label>
              <div class="col-sm-9">
                <input name="trayek" type="text" class="form-control" required>
              </div>
            </div>

            <div class="form-group row">
              <label for="staticEmail" class="col-sm-3 col-form-label">Jenis Pelayaran</label>
              <div class="col-sm-9">
                <input name="jenis_pelayaran" type="text" class="form-control" required>
              </div>
            </div>

            <div class="form-group row">
              <label class="col-sm-3 col-form-label">ETA</label>
              <div class="col-sm-4">
                <div class="input-group">
                  <input name="eta_date" type="text" class="form-control datepicker" data-date-format="yyyy-mm-dd" autocomplete="off" placeholder="ETA (date)" aria-label="ETA" required />
                  <div class="input-group-append">
                    <span class="input-group-text">
                      <i class="bi bi-calendar4-event"></i>
                    </span>
                  </div>
                </div>
              </div>
              <div class="col-sm-4">
                <div class="input-group">
                  <input name="eta_time" type="time" class="form-control" autocomplete="off" placeholder="ETA (time)" aria-label="ETA" required />
                  <div class="input-group-append">
                    <span class="input-group-text">
                      <i class="bi bi-clock"></i>
                    </span>
                  </div>
                </div>
              </div>
            </div>

            <div class="form-group row">
              <label class="col-sm-3 col-form-label">ETD</label>
              <div class="col-sm-4">
                <div class="input-group">
                  <input name="etd_date" type="text" class="form-control datepicker" data-date-format="yyyy-mm-dd" autocomplete="off" placeholder="ETD (date)" aria-label="ETD" required />
                  <div class="input-group-append">
                    <span class="input-group-text">
                      <i class="bi bi-calendar4-event"></i>
                    </span>
                  </div>
                </div>
              </div>
              <div class="col-sm-4">
                <div class="input-group">
                  <input name="etd_time" type="time" class="form-control" autocomplete="off" placeholder="ETA (time)" aria-label="ETA" required />
                  <div class="input-group-append">
                    <span class="input-group-text">
                      <i class="bi bi-clock"></i>
                    </span>
                  </div>
                </div>
              </div>
            </div>

            <div class="form-group row">
              <label class="col-sm-3 col-form-label">Pelabuhan Asal</label>
              <div class="col-sm-9">
                <input name="pelabuhan_asal" type="text" class="form-control" required>
              </div>
            </div>

            <div class="form-group row">
              <label class="col-sm-3 col-form-label">Pelabuhan Tujuan</label>
              <div class="col-sm-9">
                <input name="pelabuhan_tujuan" type="text" class="form-control" required>
              </div>
            </div>

            <div class="form-group row">
              <label class="col-sm-3 col-form-label">Labuh yang diminta</label>
              <div class="col-sm-9">
                <select name="labuh_diminta" type="text" class="form-control" required>
                  <option value=""> - </option>
                  <?php foreach ($arrLabuh as $key => $arrVal) { ?>
                    <option value="<?= $arrVal["id"] ?>">
                      <?= $arrVal["nama_dermaga"]; ?>
                    </option>
                  <?php } ?>
                </select>
              </div>
            </div>

            <div class="form-group row">
              <label class="col-sm-3 col-form-label">Tambat yang diminta</label>
              <div class="col-sm-9">
                <select name="tambat_diminta" type="text" class="form-control">
                  <option value=""> - </option>
                  <?php foreach ($arrTambat as $key => $arrVal) { ?>
                    <option value="<?= $arrVal["id"] ?>">
                      <?= $arrVal["nama_dermaga"]; ?>
                    </option>
                  <?php } ?>
                </select>
              </div>
            </div>

            <div class="form-group row">
              <label class="col-sm-3 col-form-label">PBM dan JPT yang ditunjuk</label>
              <div class="col-sm-9">
                <input name="pbm" type="text" class="form-control" required>
              </div>
            </div>

            <div class="form-group row">
              <label class="col-sm-3 col-form-label">Rencana Kerja Bogkar/Muat</label>
              <div class="col-sm-9">
                <select name="rkbm" class="form-control" required>
                  <option value="1">Ada</option>
                  <option value="0">Tidak Ada</option>
                </select>
              </div>
            </div>

            <div class="form-group row">
              <label class="col-sm-3 col-form-label">Rencana Kegiatan Kapal</label>
              <div class="col-sm-9">
                <select name="rencana_kegiatan" class="form-control" required>
                  <option value="1">Niaga</option>
                  <option value="0">Non Niaga</option>
                </select>
              </div>
            </div>

            <h3> Data Bongkar / Muat </h3>

            <button type="button" class="btn btn-sm btn-outline-warning mb-3" data-toggle="modal" data-target="#jenis-barang">
              <i class="bi bi-plus-lg"></i> Tambah Data Barang
            </button>
            <table class="table table-sm table-bordered">
              <tr>
                <th width="10%">No</th>
                <th width="40%">Uraian</th>
                <th width="20%" class="text-center" colspan="2">Bongkar</th>
                <th width="20%" class="text-center" colspan="2">Muat</th>
                <th width="10%" class="text-center">&times</th>
              </tr>
              <tr v-if="arrDataBarang.length < 1 && arrDataNotBarang.length < 1">
                <td colspan="7" class="text-center">Belum Ada Data</td>
              </tr>
              <tr v-else v-for="(item, index) in arrDataBarang">
                <td width="10%">{{index + 1}}</td>
                <td width="40%">{{item.uraian}}</th>
                <td width="15%" class="text-center">{{item.bongkar}} </td>
                <td width="5%" class="text-center">{{item.satuan}} </td>
                <td width="15%" class="text-center">{{item.muat}} </td>
                <td width="5%" class="text-center">{{item.satuan}} </td>
                <td width="10%" class="text-center">
                  <button @click="delete_item(item.id)" type="button" class="btn btn-sm btn-outline-danger">
                    &times
                  </button>
                </td>
              </tr>
              <tr v-if="jumlahBongkar > 0 || jumlahMuat > 0">
                <th colspan="2" class="text-center">Jumlah</th>
                <th width="15%" class="text-center"> {{jumlahBongkar}}</th>
                <th width="5%" class="text-center">T/M3</th>
                <th width="15%" class="text-center"> {{jumlahMuat}}</th>
                <th width="5%" class="text-center">T/M3</th>
                <th width="10%"></th>
              </tr>
              <tr v-for="(item, index) in arrDataNotBarang">
                <td width="10%">{{index + 1}}</td>
                <td width="40%">{{item.uraian}}</th>
                <td width="15%" class="text-center">{{item.bongkar}} </td>
                <td width="5%" class="text-center">{{item.satuan}} </td>
                <td width="15%" class="text-center">{{item.muat}} </td>
                <td width="5%" class="text-center">{{item.satuan}} </td>
                <td width="10%" class="text-center">
                  <button @click="delete_item(item.id)" type="button" class="btn btn-sm btn-outline-danger">
                    &times
                  </button>
                </td>
              </tr>
            </table>
            <h3> Upload Lampiran </h3>
            <div class="alert alert-info">
              File yang di unggah harus berupa <strong>pdf / jpg</strong> dan ukuran file tidak lebih dari <strong>5 MB</strong>
            </div>
            <?php foreach ($arrFileKet as $key => $arrVal) { ?>
              <div class="form-group row">
                <label class="col-md-1 col-2 col-form-label">
                  <?= $key + 1; ?>
                </label>
                <label class="col-md-7 col-10 col-form-label">
                  <?= $arrVal["keterangan"]; ?>
                </label>
                <div class="col-md-4 offset-md-0 offset-2">
                  <input type="file" name="file[<?= $arrVal["id"]; ?>]" id="file-<?= $arrVal["id"]; ?>" accept="application/pdf, image/jpg, image/jpeg">
                </div>
              </div>
            <?php } ?>


            <div class="form-group row">
              <div class="col-sm-9">
                <a href="<?= base_url("/"); ?>" class="btn btn-light">
                  <i class="bi bi-arrow-90deg-left"></i> Batal
                </a>
                <button v-on:click="submit($event)" type="submit" class="btn btn-primary" data-toggle="modal" data-target="#notif">
                  <i class="bi bi-arrow-up-right-square"></i> Ajukan Permohonan
                </button>
              </div>
            </div>

          </form>
        </div>
      </div>

    </div>
    <!-- Modal -->
    <div class="modal fade" id="jenis-barang" tabindex="-1" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="staticBackdropLabel">Data Barang!</h5>

            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>

          </div>
          <div class="modal-body">

            <div class="form-group row">
              <label class="col-sm-3 col-form-label">Uraian</label>
              <div class="col-sm-9">
                <select @change="search_jenis_barang()" v-model="jenis_barang_id" class="form-control">
                  <?php foreach ($arrJenisBarang as $key => $arrVal) { ?>
                    <option value="<?= $arrVal["id"]; ?>"><?= $arrVal["uraian"]; ?></option>
                  <?php } ?>
                </select>
              </div>
            </div>

            <div class="form-group row">
              <label class="col-sm-3 col-form-label">Bonkar</label>
              <div class="col-sm-9">
                <div class="input-group">
                  <input v-model="bongkar" type="number" step=".01" class="form-control" autocomplete="off" />
                  <div class="input-group-append">
                    <span class="input-group-text">
                      {{detailBarang.satuan}}
                    </span>
                  </div>
                </div>
              </div>
            </div>

            <div class="form-group row">
              <label class="col-sm-3 col-form-label">Muat</label>
              <div class="col-sm-9">
                <div class="input-group">
                  <input v-model="muat" type="number" step=".01" class="form-control" autocomplete="off" />
                  <div class="input-group-append">
                    <span class="input-group-text">
                      {{detailBarang.satuan}}
                    </span>
                  </div>
                </div>
              </div>
            </div>

          </div>
          <div class="modal-footer">
            <button @click="tambahkan_jenis_barang()" type="button" class="btn btn-primary">
              Tambahkan
            </button>
          </div>
        </div>
      </div>
    </div>


    <!-- Modal -->
    <div class="modal fade" id="notif" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="staticBackdropLabel">Notifikasi!</h5>
            <div v-if="!sendStatus && sendError">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
          </div>
          <div class="modal-body">
            <div v-if="sendStatus">
              <img src="<?= base_url("/assets/images/undraw_onprogress.png"); ?>" width="100%" />
              <p class="text-center">Permohonan sedang dikirim! harap menunggu Sebentar</p>
            </div>
            <div v-else>
              <div v-if="sendError">
                <img src="<?= base_url("/assets/images/undraw_error.png"); ?>" width="100%" />
                <p class="text-center">Permohonan gagal terkirim! Silahkan coba lagi</p>
                <ul>
                  <li v-for="error in errors">
                    {{error}}
                  </li>
                </ul>
              </div>
              <div v-else>

                <div class="qrcode-warper">
                  <div class="img-warper-qrcode">
                    <img width="250px" v-bind:src="qrcodeimg" width="100%" />
                  </div>
                  <div class="img-warper-qrcode" style="position: absolute; z-index:10;">
                    <img width="60px" height="60px" src="<?php echo base_url("/assets/images/ksop.png"); ?>" />
                  </div>
                </div>


                <p class="text-center">
                  Permohonan berhasil terkirim. Simpan qrcode diatas untuk keperluan
                  perbaikan dan bukti persetujuan tambat, atau simpan link berikut
                  <a v-bind:href="qrcodeurl" target="_blank">Form Update</a>.
                  <strong>Isi dari QRCode dan Link Tersebut hanya berlaku 7 hari setelah pendaftaran.</strong>
                </p>
                <pre>{{qrcodeurl}}</pre>
              </div>
            </div>
          </div>
          <div v-if="sendStatus" class="progress">
            <div class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width: 100%"></div>
          </div>
          <div v-else class="modal-footer">
            <button v-if="sendError" type="button" class="btn btn-secondary" data-dismiss="modal">
              Coba Lagi
            </button>
            <a v-else type="button" href="<?= base_url("/"); ?>" class="btn btn-primary">
              Oke
            </a>
          </div>
        </div>
      </div>
    </div>

  </section>
</div>

<?= $this->endSection() ?>


<?= $this->section('js') ?>

<script>
  var formconfig = <?= json_encode($arrConfig); ?>
</script>

<script src="<?= base_url("/assets/js/bootstrap-datepicker.min.js") ?>" defer></script>
<script src="<?= base_url("/assets/js/controller/daftar.js?v=1.1") ?>" defer></script>


<?= $this->endSection() ?>