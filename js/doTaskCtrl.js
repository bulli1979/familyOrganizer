(function() {
    "use strict";
    angular.module('FamilyOrganizer').controller('DoTaskController',
        [ '$scope','$http','Core', function($scope,$http, Core) {
            var dtc = this;
            dtc.itemList = [];
            dtc.init = function(){
                $http.get('api/rest.php?content=doTask&action=getTaskList').then(function(r){
                    if(r.data){
                        dtc.itemList = r.data;
                    }
                });
            };

            dtc.doTask = function(id){
                var data = JSON.stringify({
                    content:"doTask",
                    action:"doTask",
                    id: id
                });
                $http({
                    method: 'POST',
                    url: 'api/rest.php',
                    data: data,
                    headers: {'Content-Type': 'application/json'}
                }).then(function(r){
                    if (r.data && r.data.update) {
                        dtc.removeItem(id);
                    }
                });
            };

            dtc.removeItem = function(id){
                var removeIndex=-1;
                $.each(dtc.itemList,function(index,val){
                    if(val.id === id){
                        removeIndex = index;
                    }
                });
                dtc.itemList.splice(removeIndex, 1);
            };

        } ]);
})();