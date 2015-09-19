require.config({
  baseUrl: './static',
  paths: {
    ractive : 'node_modules/ractive/ractive',
    rvc: 'node_modules/rvc/rvc',
    leaflet: 'node_modules/leaflet/dist/leaflet',
    easyButton: 'node_modules/leaflet-easybutton/src/easy-button',
    validate: 'node_modules/validate.js/validate',
    eventemitter : 'node_modules/wolfy87-eventemitter/EventEmitter',
  },
  waitSeconds: 60,
});

require([
  'rvc!components/app',
  'rvc!components/badge-filter',
  'stores/badges-filtered'
],function(TreeApp, BadgeFilter, FilteredBadges){

  var FilteredBadges = require('stores/badges-filtered');

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

  $('#badge-filter').on('click', function(event){
    event.preventDefault();
    badgeFilter.open();
  });

  $('#view-pending-badges').on('click', function(event){
    event.preventDefault();
    FilteredBadges.filter(['unapproved']);
  });

  function filterByHash(hash){
    var filters = location.hash.slice(1);
    var filterArray = filters.split(',');
    var defaultFilter = ['abundant','average','scarce','unapproved'];
    var filterToUse = !!filters ? filterArray : defaultFilter;
    FilteredBadges.filter(filterToUse);    
  }

  $(window).on('hashchange', filterByHash);
  filterByHash();

});
