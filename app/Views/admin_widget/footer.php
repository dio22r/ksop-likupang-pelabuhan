<style>
  #footer {
    background-color: #007BFF;
    padding: 50px 0px 100px 0px;
    border-bottom: 5px solid #FB0000;
    color: white;
  }

  #footer .social-btn {
    display: inline-flex;
  }

  #footer .social-btn .btn-circle {
    width: 40px;
    height: 40px;
    display: flex;
    align-items: center;
    justify-content: center;
    border: 1px solid white;
    color: white;
    border-radius: 40px;
    text-decoration: none;
    margin: 5px;
  }

  #footer .social-btn .btn-circle:hover {
    border: 1px solid #ddd;
    color: #ddd;
  }

  #footer .box-content h5 {
    position: relative;
  }

  #footer .box-content h5::after {
    content: "";
    border-bottom: 2px solid #fff;
    width: 50px;
    position: absolute;
    bottom: -6px;
    left: 0px;
  }

  #footer ul {
    padding: 0px;
  }

  #footer li {
    list-style: none;
    margin: 0px 0px;
  }

  #footer li a {
    color: #fff;
    text-decoration: none;
  }

  #footer li a:hover {
    color: #ccc;
  }

  #copyright {
    background-color: #FB0000;
    padding: 10px 0px 10px 0px;
    border-bottom: 5px solid #FB0000;
    color: white;
    font-size: 12px;
    font-weight: 500;
  }
</style>

<div id="footer" class="mt-5">
  <div class="container">
    <div class="row">
      <div class="col-lg-6">
        <div class="row">
          <div class="col-sm-3">
            <a href="<?= base_url() ?>">
              <img class="bi me-2" style="max-width:100px" src="<?= base_url('/assets/images/Kerja-dengan-hati.png') ?>" width="100%" />
            </a>
          </div>
          <div class=" col-sm-9  box-content">
            <h5 class="mb-3">Kantor UPP Kelas III Likupang</h5>
            <h3 class="mb-3">E-SITABUH</h3>
            <ul>
              <li class="mb-2">
                <a href="#">
                  <i class="bi bi-geo-alt-fill"></i>&nbsp;
                  Desa Munte, Kec. Likupang Barat, Kabupaten Minahasa Utara, Sulawesi Utara
                </a>
              </li>
              <li class="mb-2">
                <a href="#">
                  <i class="bi bi-telephone-fill"></i>&nbsp;
                  (031) 7524149
                </a>
              </li>
              <li class="mb-2">
                <a href="#">
                  <i class="bi bi-card-text"></i>&nbsp;
                  (031) 7525486
                </a>
              </li>
              <li class="mb-2">
                <a target="_blank" href="https://api.whatsapp.com/send?phone=">
                  <i class="bi bi-whatsapp"></i>&nbsp;
                  e-Sitabuh
                </a>
              </li>
            </ul>
          </div>
        </div>
      </div>
      <div class="col-lg-6 mt-lg-0 mt-3 box-content">
        <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3988.076258323991!2d125.0109146596551!3d1.6932016366977052!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3287b95cb90c52d7%3A0xbef03f4ed8ffb99e!2sKANTOR%20UPP%20KELAS%20III%20LIKUPANG!5e0!3m2!1sen!2sid!4v1651136324292!5m2!1sen!2sid" width="100%" height="300" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
      </div>
    </div>
  </div>
</div>

<div id="copyright">
  <div class="container">
    Hak Cipta ©2022 Kantor UPP Kelas III Likupang. All Rights Reserved
  </div>
</div>