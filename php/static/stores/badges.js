define(function(require) {

  var EventEmitter = require('eventemitter');

  function Store() {
    EventEmitter.call(this);
    this.data = [];
    this.read();
  }

  Store.prototype = $.extend(Object.create(EventEmitter.prototype), {
    create: function(badgeData) {
      var store = this;
      return $.post('/badges', badgeData)
        .then(function(response) {
          store.data.push(response);
          store.trigger('change', [store.data]);
        }, function(error) {

        });
    },
    read: function() {
      var store = this;
      return $.get('/badges')
        .then(function(response) {
          store.data = response;
          store.trigger('change', [store.data]);
        }, function(error) {

        });
    },
    update: function(badgeData) {
      var store = this;

      return $.ajax({
        type: 'put',
        url: '/badges/' + badgeData.id,
        data: badgeData,
      }).then(function(response) {
        
        var existingBadge = store.data.filter(function(badge){
          return badge.id === response.id;
        })[0];

        $.extend(existingBadge, response);
        store.trigger('change', [store.data]);

      }, function() {

      });

    },
    delete: function(badgeData) {
      var store = this;
      return $.ajax({
        type: 'delete',
        url: '/badges/' + badgeData.id,
      }).then(function() {
        var dataLength = store.data.length;
        while(dataLength--)
          if(store.data[dataLength].id === badgeData.id)
            store.data.splice(dataLength, 1);
        store.trigger('change', [store.data]);
      }, function() {

      });

    },
    accept: function(data){
      var store = this;

      var badgeToUpdate = store.data.filter(function(badge){
        return badge.id === data.id;
      })[0];

      badgeToUpdate.approved = 1;
      badgeToUpdate.approvalRequest = 1;

      return $.ajax({
        type: 'put',
        url: '/badges/' + data.id,
        data: badgeToUpdate
      }).then(function(badgeData){
        $.extend(badgeToUpdate, badgeData);
        store.trigger('change', [store.data]);
      },function(){

      });
    },
    getState: function() {
      return this.data;
    },
  });

  return new Store();

});
