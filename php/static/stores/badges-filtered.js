define(function(require){

  var EventEmitter = require('eventemitter');
  var Badges = require('stores/badges');

  function Store() {
    EventEmitter.call(this);
    var store = this;
    this.badges = [];
    this.data = [];
    this.filters = [
      'abundant',
      'average',
      'scarce',
      'unapproved',
    ];

    Badges.on('change', function(badges){
      store.badges = badges;
      store.filter(store.filters);
    });

    this.filter(this.filters);
  }

  Store.prototype = $.extend(Object.create(EventEmitter.prototype), {
    filter: function(filters){
      this.filters = filters;
      this.data = this.badges.filter(function(badge){
        var isBadgeFiltered = (badge.approved && ~filters.indexOf(badge.abundance));
        var isUnapproved = (!badge.approved && ~filters.indexOf('unapproved'));
        return isUnapproved || isBadgeFiltered;
      });
      this.trigger('change', [this.data]);
    },
    getState: function() {
      return this.data;
    },
  });

  return new Store();

});