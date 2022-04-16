<?= $this->extend('layout/member') ?>

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
            <button @click="click_print(<?= $operasiKapal->id; ?>, $event)" data-toggle="modal" data-target="#detail-modal" class="btn btn-success btn-sm">
              <i class="bi bi-printer"></i> print
            </button>
          </div>


          <table class="table table-sm table-borderless">
            <tr>
              <th width="20%">Status</th>
              <td width="80%">
                <?php if ($operasiKapal->deleted_at) { ?>
                  <span class="badge badge-danger">
                    <i class="bi bi-trash-fill"></i> dihapus
                  </span>
                <?php } else { ?>
                  <?php if ($operasiKapal->status == 1) { ?>
                    <span class="badge badge-success">Disetujui</span>
                  <?php } elseif ($operasiKapal->status == -1) { ?>
                    <span class="badge badge-danger">Ditolak</span>
                  <?php } elseif ($operasiKapal->status == 2) { ?>
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
                <?= ($validasi) ? $validasi->User->nama : " - "; ?> /
                <?= ($validasi) ? $validasi->created_at : " - "; ?>
              </td>
            </tr>
            <tr>
              <th>Keterangan</th>
              <td><?= ($validasi) ? nl2br($validasi->keterangan) : " - "; ?></td>
            </tr>
          </table>

          <table class="table table-sm table-bordered">

            <tr>
              <th>Tanggal Daftar</th>
              <td><?= $operasiKapal->created_at; ?></td>
            </tr>
            <tr>
              <th width="30%">Nama Kapal</th>
              <td width="70%"><?= $operasiKapal->nama_kapal; ?></td>
            </tr>
            <tr>
              <th>Bendera</th>
              <td><?= $operasiKapal->bendera; ?></td>
            </tr>
            <tr>
              <th>GT / DWT / Jenis Kapal</th>
              <td><?= $operasiKapal->gt . " / " . $operasiKapal->dwt . " / " . $operasiKapal->JenisKapal->nama; ?></td>
            </tr>
            <tr>
              <th>LOA</th>
              <td><?= $operasiKapal->loa; ?></td>
            </tr>
            <tr>
              <th>Pemilik / Principle</th>
              <td><?= $operasiKapal->pemilik; ?></td>
            </tr>
            <tr>
              <th>Nama Agen</th>
              <td><?= $operasiKapal->nama_agen; ?></td>
            </tr>
            <tr>
              <th>Nama Nahkoda</th>
              <td><?= $operasiKapal->nama_nahkoda; ?></td>
            </tr>
            <tr>
              <th>Trayek</th>
              <td><?= $operasiKapal->trayek; ?></td>
            </tr>
            <tr>
              <th>Jenis Pelayaran</th>
              <td><?= $operasiKapal->jenis_pelayaran; ?></td>
            </tr>
            <tr>
              <th>ETA / ETD</th>
              <td>
                <?= $operasiKapal->etd_date . " " . $operasiKapal->etd_time; ?> /
                <?= $operasiKapal->eta_date . " " . $operasiKapal->eta_time; ?>
              </td>
            </tr>
            <tr>
              <th>Pelabuhan Asal / Tujuan</th>
              <td><?= $operasiKapal->pelabuhan_asal . " / " . $operasiKapal->pelabuhan_tujuan; ?></td>
            </tr>
            <tr>
              <th>Labuh yang diminta</th>
              <td><?= $operasiKapal->Labuh->nama_dermaga; ?></td>
            </tr>
            <tr>
              <th>Tambat yang diminta</th>
              <td><?= ($operasiKapal->Tambat) ? $operasiKapal->Tambat->nama_dermaga : " - "; ?></td>
            </tr>
            <tr>
              <th>PBM dan JPT yang ditunjuk</th>
              <td><?= $operasiKapal->pbm; ?></td>
            </tr>
            <tr>
              <th>Rencana Kerja Bongkar / Muat</th>
              <td><?= $operasiKapal->rkbm ? "Ada" : "Tidak Ada"; ?></td>
            </tr>

            <tr>
              <th>Rencana Kegiatan Kapal</th>
              <td><?= $operasiKapal->rencana_kegiatan ? "Niaga" : "Non-Niaga"; ?></td>
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
            <?php if (count($arrBarang) == 0 && count($arrNonBarang) == 0) { ?>
              <tr>
                <td colspan="7" class="text-center">Belum Ada Data</td>
              </tr>
            <?php } ?>

            <?php
            $totalBongkar = 0;
            $totalMuat = 0;
            ?>

            <?php foreach ($arrBarang as $key => $barang) { ?>
              <tr>
                <td width="10%" class="text-center"><?= $key + 1 ?></td>
                <td width="40%"><?= $barang["uraian"]; ?></th>
                <td width="15%" class="text-center"><?= floatval($barang->pivot->bongkar) ?></td>
                <td width="10%" class="text-center"><?= $barang->satuan ?></td>
                <td width="15%" class="text-center"><?= floatval($barang->pivot->muat) ?></td>
                <td width="10%" class="text-center"><?= $barang->satuan ?></td>
              </tr>
              <?php
              $totalBongkar += $barang->pivot->bongkar;
              $totalMuat += $barang->pivot->muat;
              ?>
            <?php } ?>

            <?php if (count($arrBarang) > 0) { ?>
              <tr>
                <th colspan="2" class="text-center">Jumlah</th>
                <th width="15%" class="text-center"> <?= $totalBongkar ?> </th>
                <th width="5%" class="text-center">T/M3</th>
                <th width="15%" class="text-center"> <?= $totalMuat ?></th>
                <th width="5%" class="text-center">T/M3</th>
                <th width="10%"></th>
              </tr>
            <?php } ?>

            <?php $count = 0; ?>
            <?php foreach ($arrNonBarang as $key => $barang) { ?>
              <tr>
                <td width="10%" class="text-center"><?= $count + 1 ?></td>
                <td width="40%"><?= $barang->uraian; ?></th>
                <td width="15%" class="text-center"><?= floatval($barang->pivot->bongkar) ?></td>
                <td width="10%" class="text-center"><?= $barang->satuan ?></td>
                <td width="15%" class="text-center"><?= floatval($barang->pivot->muat) ?></td>
                <td width="10%" class="text-center"><?= $barang->satuan ?></td>
              </tr>
              <?php $count++; ?>
            <?php } ?>
          </table>

          <table class="table table-sm table-bordered">
            <tr>
              <th width="10%" class="text-center"> No. </th>
              <th width="55%">Nama Dokumen</th>
              <th width="20%" class="text-center">Dokumen</th>
              <th width="15%" class="text-center">Status</th>
            </tr>
            <?php $count = 0; ?>
            <?php foreach ($arrFile as $key => $fileKet) { ?>
              <tr>
                <td class="text-center"><?= $count + 1 ?></td>
                <td><?= $fileKet->keterangan; ?></td>
                <td class="text-center">
                  <?php if (count($fileKet->OperasiKapal) > 0) { ?>
                    <a target="_blank" href="<?= base_url("/admin/file-lampiran/" . $fileKet->OperasiKapal[0]->pivot->id); ?>" class="btn btn-outline-info btn-sm">
                      Lihat Dokumen
                    </a>
                  <?php } else { ?>
                    <span> - </span>
                  <?php } ?>
                </td>
                <td class="text-center">
                  <?php if (count($fileKet->OperasiKapal) > 0 && $validasi) { ?>
                    <?= $fileKet->OperasiKapal[0]->pivot->status == 1 ? "Disetujui" : "Ditolak"; ?>
                  <?php } else { ?>
                    <span> - </span>
                  <?php } ?>
                </td>
              </tr>
              <?php $count++; ?>
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


<?= $this->section('js') ?>

<script src="<?= base_url("/assets/js/controller-admin/pengoprasian-kapal/detail.js?v=1") ?>" defer></script>

<?= $this->endSection() ?>