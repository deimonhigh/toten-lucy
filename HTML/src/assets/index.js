var app = {
  initialize: function () {
    this.bind();
  },
  bind: function () {
    document.addEventListener('deviceready', this.deviceready, false);
  },
  deviceready: function () {
    app.report('deviceready');
    
    angular.bootstrap(document, ['appGoPharma']);

    document.addEventListener('resume', app.resume, false);
  },

  resume: function () {
    app.report('resume');
    //location.reload();
  },
  report: function (id) {
    console.log("report:" + id);
  }
};