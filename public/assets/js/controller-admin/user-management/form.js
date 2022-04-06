var form = new Vue({
  el: "#data-vue",

  data: {
    retrieve_process: false,

    is_new: true,
    error: [],

    detail: {
      nama: "",
      username: "",
      password: "",
      role: "",
      status: "",
    },
  },

  methods: {
    submit: function (e) {
      e.preventDefault();
      let self = this;

      let conf = confirm("Apakah Anda yakin akan menyimpan data?");
      if (!conf) {
        e.stopPropagation();
        return;
      }

      let form = document.getElementById("form-validasi");
      form.classList.add("was-validated");
      if (form.checkValidity() === false) {
        e.stopPropagation();
        return;
      }

      if (this.is_new) {
        this.send_create();
      } else {
        this.send_edit();
      }
    },

    send_edit: function () {
      let url = "/admin/user-management/" + this.detail.id;
      axios
        .put(url, this.detail)
        .then((response) => {
          if (response.data.status) {
            alert("Data Berhasil Diubah");
            window.location = "/admin/user-management";
          } else {
            self.error = response.data.arrError;
          }
        })
        .catch((error) => {
          alert("Terjadi Kesalahan Coba lagi!");
        });
    },

    send_create: function () {
      let self = this;
      let form = document.getElementById("form-validasi");
      let formData = new FormData(form);
      let url = "/admin/user-management";
      axios
        .post(url, formData)
        .then((response) => {
          if (response.data.status) {
            alert("Data Berhasil Disimpan");
            window.location = "/admin/user-management";
          } else {
            self.error = response.data.arrError;
          }
        })
        .catch((error) => {
          alert("Terjadi Kesalahan Coba lagi!");
        });
    },
  },

  mounted: function () {
    if (jsConfig.detail) {
      this.is_new = false;
      this.detail = jsConfig.detail;
    } else {
      this.is_new = true;
    }
  },
});
