var detail = new Vue({
  el: "#data-vue",

  data: {},

  methods: {
    click_print: function (id, e) {
      e.preventDefault();
      let href = "/admin/pengoprasian-kapal/print/" + id;
      let iframe = document.getElementById("iframe-print-laporan");
      iframe.setAttribute("src", href);
    },
  },

  mounted: function () {
    let iframe = document.getElementById("iframe-print-laporan");
    iframe.addEventListener("load", () => {
      if (iframe.getAttribute("src") != "#") {
        document.getElementById("btn-close").click();
      }
    });
  },
});
