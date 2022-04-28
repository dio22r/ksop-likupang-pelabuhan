var login = new Vue({
  el: "#data-vue",

  data: {
    sendStatus: false,
    sendError: false,

    jenis_barang_id: "",
    bongkar: 0,
    muat: 0,

    detailBarang: {
      id: "",
      uraian: "",
      satuan: " - ",
    },

    arrDataBarang: [],
    arrDataNotBarang: [],
    jumlahBongkar: 0,
    jumlahMuat: 0,

    qrcodeimg: "#",
    qrcodeurl: "#",
  },

  methods: {
    submit: function (e) {
      e.preventDefault();
      let self = this;
      let form = document.getElementById("form-daftar");

      let conf = confirm("Apakah Anda yakin akan mengajukan data ini?");
      if (!conf) {
        e.stopPropagation();
        return;
      }

      form.classList.add("was-validated");
      if (form.checkValidity() === false) {
        alert("Periksa Kembali Form Isian");
        window.scrollTo(0, 0);
        e.stopPropagation();
        return;
      }

      this.sendStatus = true;
      let formData = new FormData(form);
      let arrBarang = this.arrDataBarang.concat(this.arrDataNotBarang);

      arrBarang.forEach((item, index) => {
        formData.append("jenis_barang_id[]", item.id);
        formData.append("bongkar[]", item.bongkar);
        formData.append("muat[]", item.muat);
      });

      let config = {
        headers: { "Content-Type": "multipart/form-data" },
      };

      url = form.action;
      axios
        .post(url, formData, config)
        .then((response) => {
          if (response.data.status) {
            self.sendError = false;
            self.qrcodeimg = response.data.qrcodeimg;
            self.qrcodeurl = response.data.qrcodeurl;
            form.reset();
          } else {
            self.sendError = true;
            self.errors = response.data.arrErr;
          }
          // console.log(response);
          self.sendStatus = false;
        })
        .catch((error) => {
          self.errors = { fail: "Terjadi kesalahan pada sistem" };
          self.sendStatus = false;
          self.sendError = true;
        });
    },

    search_jenis_barang: function () {
      this.detailBarang = this.arrJenisBarang.find((element) => {
        return element.id == this.jenis_barang_id;
      });
    },

    tambahkan_jenis_barang: function () {
      let check = this.arrDataBarang.filter((element) => {
        return element.id == this.detailBarang.id;
      });

      let check2 = this.arrDataNotBarang.filter((element) => {
        return element.id == this.detailBarang.id;
      });

      if (check.length < 1 && check2.length < 1) {
        if (!isNaN(parseFloat(this.bongkar))) {
          this.detailBarang.bongkar = parseFloat(this.bongkar);
        } else {
          this.detailBarang.bongkar = 0;
        }
        if (!isNaN(parseFloat(this.muat))) {
          this.detailBarang.muat = parseFloat(this.muat);
        } else {
          this.detailBarang.muat = 0;
        }

        if (
          (this.detailBarang.bongkar > 0 || this.detailBarang.muat > 0) &&
          this.detailBarang.bongkar >= 0 &&
          this.detailBarang.muat >= 0
        ) {
          if (this.detailBarang.type == 1) {
            this.arrDataBarang.push(this.detailBarang);
          } else {
            this.arrDataNotBarang.push(this.detailBarang);
          }

          this.count_jumlah();
        }
      } else {
        alert("Jenis barang sudah ada");
      }
    },

    delete_item: function (id) {
      this.arrDataBarang = this.arrDataBarang.filter((element) => {
        return element.id != id;
      });
      this.arrDataNotBarang = this.arrDataNotBarang.filter((element) => {
        return element.id != id;
      });
      this.count_jumlah();
    },

    count_jumlah: function () {
      this.jumlahBongkar = 0;
      this.jumlahMuat = 0;
      this.arrDataBarang.forEach((element) => {
        if (element.type == 1) {
          this.jumlahBongkar += element.bongkar;
          this.jumlahMuat += element.muat;
        }
      });
    },
  },

  mounted: function () {
    $(".datepicker").datepicker({
      orientation: "bottom auto",
      autoclose: true,
    });

    this.arrJenisBarang = formconfig.arrJenisBarang;
  },
});
