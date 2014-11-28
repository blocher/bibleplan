var bibleServices = angular.module('bibleServices', ['ngResource']);

bibleServices.factory('Bible', ['$resource',
  function($resource){
    return $resource('/api/plan', {}, {
      query: {method:'GET', params:{num_days:'2',books:'Matt,Mark'}, isArray:false}
    });
  }]);