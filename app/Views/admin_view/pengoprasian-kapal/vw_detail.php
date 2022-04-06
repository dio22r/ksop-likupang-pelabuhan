<?= $this->extend('layout/admin') ?>

<?= $this->section('content') ?>

<style>
  .hide {
    display: none;
  }
</style>

<div id="data-vue">

  <section id="content">

    <div class="container">
      <h1 class="display-4 text-center mt-2"> Detail Verifikasi </h1>
      <div class="card">
        <div class="card-header">
          ~
        </div>
        <div class="card-body">

          <div class="mb-3">
            <a href="<?= $backUrl ?>" class="btn btn-light btn-sm">
              <i class="bi bi-arrow-90deg-left"></i> Kembali
            </a>
            <button @click="click_print(<?= $arrData["id"]; ?>, $event)" data-toggle="modal" data-target="#detail-modal" class="btn btn-success btn-sm">
              <i class="bi bi-printer"></i> print
            </button>
          </div>


          <table class="table table-sm table-borderless">
            <tr>
              <th width="20%">Status</th>
              <td width="80%">
                <?php if ($arrData["deleted_at"]) { ?>
                  <span class="badge badge-danger">
                    <i class="bi bi-trash-fill"></i> dihapus
                  </span>
                <?php } else { ?>
                  <?php if ($arrData["status"] == 1) { ?>
                    <span class="badge badge-success">Disetujui</span>
                  <?php } elseif ($arrData["status"] == -1) { ?>
                    <span class="badge badge-danger">Ditolak</span>
                  <?php } elseif ($arrData["status"] == 2) { ?>
                    <span class="badge badge-warning">Menunggu Perbaikan</span>
                  <?php } else { ?>
                    <span class="badge badge-secondary">Menunggu</span>
                  <?php } ?>
                <?php } ?>
              </td>
            </tr>
            <tr>
              <th>Divalidasi Oleh</th>
              <td>
                <?= isset($arrValidasi["user_nama"]) ? $arrValidasi["user_nama"] : " - "; ?> /
                <?= isset($arrValidasi["created_at"]) ? $arrValidasi["created_at"] : " - "; ?>
              </td>
            </tr>
            <tr>
              <th>Keterangan</th>
              <td><?= isset($arrValidasi["keterangan"]) ? nl2br($arrValidasi["keterangan"]) : " - "; ?></td>
            </tr>
          </table>

          <table class="table table-sm table-bordered">

            <tr>
              <th>Tanggal Daftar</th>
              <td><?= $arrData["created_at"]; ?></td>
            </tr>
            <tr>
              <th width="30%">Nama Kapal</th>
              <td width="70%"><?= $arrData["nama_kapal"]; ?></td>
            </tr>
            <tr>
              <th>Bendera</th>
              <td><?= $arrData["bendera"]; ?></td>
            </tr>
            <tr>
              <th>GT / DWT / Jenis Kapal</th>
              <td><?= $arrData["gt"] . " / " . $arrData["dwt"] . " / " . $arrData["nama_jenis_kapal"]; ?></td>
            </tr>
            <tr>
              <th>LOA</th>
              <td><?= $arrData["loa"]; ?></td>
            </tr>
            <tr>
              <th>Pemilik / Principle</th>
              <td><?= $arrData["pemilik"]; ?></td>
            </tr>
            <tr>
              <th>Nama Agen</th>
              <td><?= $arrData["nama_agen"]; ?></td>
            </tr>
            <tr>
              <th>Nama Nahkoda</th>
              <td><?= $arrData["nama_nahkoda"]; ?></td>
            </tr>
            <tr>
              <th>Trayek</th>
              <td><?= $arrData["trayek"]; ?></td>
            </tr>
            <tr>
              <th>Jenis Pelayaran</th>
              <td><?= $arrData["jenis_pelayaran"]; ?></td>
            </tr>
            <tr>
              <th>ETA / ETD</th>
              <td>
                <?= $arrData["etd_date"] . " " . $arrData["etd_time"]; ?> /
                <?= $arrData["eta_date"] . " " . $arrData["eta_time"]; ?>
              </td>
            </tr>
            <tr>
              <th>Pelabuhan Asal / Tujuan</th>
              <td><?= $arrData["pelabuhan_asal"] . " / " . $arrData["pelabuhan_tujuan"]; ?></td>
            </tr>
            <tr>
              <th>Labuh yang diminta</th>
              <td><?= $arrData["labuh"]; ?></td>
            </tr>
            <tr>
              <th>Tambat yang diminta</th>
              <td><?= $arrData["tambat"]; ?></td>
            </tr>
            <tr>
              <th>Dock yang diminta</th>
              <td><?= $arrData["dock"]; ?></td>
            </tr>
            <tr>
              <th>PBM dan JPT yang ditunjuk</th>
              <td><?= $arrData["pbm"]; ?></td>
            </tr>
            <tr>
              <th>Rencana Kerja Bongkar / Muat</th>
              <td><?= $arrData["rkbm"]; ?></td>
            </tr>

            <tr>
              <th>Rencana Kegiatan Kapal</th>
              <td><?= $arrData["rencana_kegiatan"] ? "Niaga" : "Non-Niaga"; ?></td>
            </tr>
          </table>


          <h5>Data Barang </h5>

          <table class="table table-sm table-bordered">
            <tr>
              <th width="10%">No</th>
              <th width="40%">Uraian</th>
              <th width="25%" class="text-center" colspan="2">Bongkar</th>
              <th width="25%" class="text-center" colspan="2">Muat</th>

            </tr>
            <?php if (count($arrDataBarang["barang"]) < 1 && count($arrDataBarang["nonbarang"]) < 1) { ?>
              <tr>
                <td colspan="7" class="text-center">Belum Ada Data</td>
              </tr>
            <?php } ?>

            <?php
            $totalBongkar = 0;
            $totalMuat = 0;
            ?>

            <?php foreach ($arrDataBarang["barang"] as $key => $arrVal) { ?>
              <tr>
                <td width="10%"><?= $key + 1 ?></td>
                <td width="40%"><?= $arrVal["uraian"]; ?></th>
                <td width="15%" class="text-center"><?= floatval($arrVal["bongkar"]) ?></td>
                <td width="10%" class="text-center"><?= $arrVal["satuan"] ?></td>
                <td width="15%" class="text-center"><?= floatval($arrVal["muat"]) ?></td>
                <td width="10%" class="text-center"><?= $arrVal["satuan"] ?></td>
              </tr>
              <?php
              $totalBongkar += $arrVal["bongkar"];
              $totalMuat += $arrVal["muat"];
              ?>
            <?php } ?>
            <?php if (count($arrDataBarang["barang"]) > 0) { ?>
              <tr>
                <th colspan="2" class="text-center">Jumlah</th>
                <th width="15%" class="text-center"> <?= $totalBongkar ?> </th>
                <th width="5%" class="text-center">T/M3</th>
                <th width="15%" class="text-center"> <?= $totalMuat ?></th>
                <th width="5%" class="text-center">T/M3</th>
                <th width="10%"></th>
              </tr>
            <?php } ?>
            <?php foreach ($arrDataBarang["nonbarang"] as $key => $arrVal) { ?>
              <tr>
                <td width="10%" class="text-center"><?= $key + 1 ?></td>
                <td width="40%"><?= $arrVal["uraian"]; ?></th>
                <td width="15%" class="text-center"><?= floatval($arrVal["bongkar"]) ?></td>
                <td width="10%" class="text-center"><?= $arrVal["satuan"] ?></td>
                <td width="15%" class="text-center"><?= floatval($arrVal["muat"]) ?></td>
                <td width="10%" class="text-center"><?= $arrVal["satuan"] ?></td>
              </tr>
            <?php } ?>
          </table>

          <table class="table table-sm table-bordered">
            <tr>
              <th width="10%" class="text-center"> No. </th>
              <th width="55%">Nama Dokumen</th>
              <th width="20%" class="text-center">Dokumen</th>
              <th width="15%" class="text-center">Status</th>
            </tr>
            <?php foreach ($arrFile as $key => $arrVal) { ?>
              <tr>
                <td class="text-center"><?= $key + 1 ?></td>
                <td><?= $arrVal["keterangan"]; ?></td>
                <td class="text-center">
                  <?php if ($arrVal["filename"]) { ?>
                    <a target="_blank" href="<?= base_url("/admin/file-lampiran/" . $arrVal["id_file"]); ?>" class="btn btn-outline-info btn-sm">
                      Lihat Dokumen
                    </a>
                  <?php } else { ?>
                    <span> - </span>
                  <?php } ?>
                </td>
                <td class="text-center">
                  <?php if ($arrVal["filename"]) { ?>
                    <?php if ($arrValidasi) { ?>
                      <?= $arrVal["status"] == 1 ? "Disetujui" : "Ditolak"; ?>
                    <?php } else { ?>
                      <span> - </span>
                    <?php } ?>
                  <?php } else { ?>
                    <span> - </span>
                  <?php } ?>
                </td>
              </tr>
            <?php } ?>
          </table>


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


</div>

<?= $this->endSection() ?>