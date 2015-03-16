define(function(require){

  var EventEmitter = require('eventemitter');
  var Badges = require('stores/badges');

  function Store() {
    EventEmitter.call(this);
    var store = this;
    this.badges = [];
    this.data = [];
    this.filters = [];

    Badges.on('change', function(badges){
      store.badges = badges;
      store.filter(store.filters);
    });

    this.filter([]);
  }

  Store.prototype = $.extend(Object.create(EventEmitter.prototype), {
    filter: function(filters){
      this.filters = filters;
      this.data = this.badges.filter(function(badge){
        return filters.length ? (~filters.indexOf(badge.abundance) && badge.approved) : true;
      });
      this.trigger('change', [this.data]);
    },
    getState: function() {
      return this.data;
    },
  });

  return new Store();

});