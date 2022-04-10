var login = new Vue({
  el: "#data-vue",

  data: {
    alert_show: false,
    msg: "",
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
        self.msg = response.data.msg;

        location.reload();
      });
    },
  },

  mounted: function () {
    //
  },
});
