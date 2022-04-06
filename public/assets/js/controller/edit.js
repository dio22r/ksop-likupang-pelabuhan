var edit = new Vue({
  el: "#data-vue",

  data: {
    sendStatus: false,
    sendError: false,
    errors: [],

    msg_modal: "",
    save_status: "",
  },

  methods: {
    submit: function (e) {
      e.preventDefault();
      let self = this;
      let form = document.getElementById("form-perbaikan");

      let conf = confirm("Apakah Anda yakin akan menyimpan data ini?");
      if (!conf) {
        e.stopPropagation();
        return;
      }

      form.classList.add("was-validated");
      if (form.checkValidity() === false) {
        e.stopPropagation();
        return;
      }

      this.sendStatus = false;
      let formData = new FormData(form);

      url = "/perbaikan-data/" + this.token;
      axios
        .post(url, formData)
        .then((response) => {
          if (response.data.status) {
            self.sendError = false;
            self.msg_modal = "Data Berhasil terupload";
          } else {
            self.sendError = true;
            self.msg_modal =
              "Data gagal terupload dikarenakan : \n\n" +
              response.data.arrError.join("\n");
          }
          // console.log(response);
          self.sendStatus = true;
        })
        .catch((error) => {
          self.msg_modal = "Terjadi kesalahan pada sistem";
          self.sendStatus = false;
          self.sendError = true;
        });
    },
  },

  mounted: function () {
    this.token = jsConfig.token;
  },
});
