var ganti_password = new Vue({
  el: "#data-vue",

  data: {
    alert_show: false,
    alert_msg: [],
  },

  methods: {
    submit: function (e) {
      e.preventDefault();
      let self = this;

      let form = document.getElementById("form");
      let formData = new FormData(form);

      let url = form.action;
      axios.post(url, formData).then((response) => {
        self.alert_show = !response.data.status;
        self.alert_msg = response.data.arrErr;

        if (response.data.status) {
          alert("Perubahan Password Berhasil!");
          window.location = "/admin";
        }
      });
    },
  },

  mounted: function () {
    //
  },
});
