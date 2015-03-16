require.config({
  baseUrl: './static',
  paths: {
    ractive : 'node_modules/ractive/ractive',
    rvc: 'node_modules/rvc/rvc',
    leaflet: 'node_modules/leaflet/dist/leaflet',
    validate: 'node_modules/validate.js/validate',
    eventemitter : 'node_modules/wolfy87-eventemitter/EventEmitter',
  },
  waitSeconds: 60,
});

require([
  'rvc!components/app',
  'rvc!components/badge-filter',
],function(TreeApp, BadgeFilter){

  new TreeApp({
    el: '.content',
    data: {
      isLoggedIn: window.isLoggedIn,
      isAdmin: window.isAdmin,
    },
  });

  var badgeFilter = new BadgeFilter({
    el: 'body',
    append: true,
    data: {
      isLoggedIn: window.isLoggedIn
    },
  });

  $('#badge-filter').on('click', function(){
    badgeFilter.open();
  });

});
