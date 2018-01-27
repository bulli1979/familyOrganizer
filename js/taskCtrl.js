(function() {
    "use strict";
    angular.module('FamilyOrganizer').controller('TaskController',
        [ '$scope','$http','Core', function($scope,$http, Core) {
            var tc = this;
            tc.itemList = [];
            tc.init = function(){
                $http.get('api/rest.php?content=task&action=getTaskList').then(function(r){
                    if(r.data){
                        tc.itemList = r.data;
                    }
                });
                Core.changeMenu("taskList");
            };

            tc.deleteItem = function(id){
                var data = JSON.stringify({
                    content:"task",
                    action:"delete",
                    id: id
                });
                $http({
                    method: 'POST',
                    url: 'api/rest.php',
                    data: data,
                    headers: {'Content-Type': 'application/json'}
                }).then(function(r){
                    if (r.data && r.data.delete) {
                        tc.removeItem(id);
                    }
                });
            };

            tc.activateTask = function(item){
                var data = JSON.stringify({
                    content:"task",
                    action:"activate",
                    id: item.id
                });
                $http({
                    method: 'POST',
                    url: 'api/rest.php',
                    data: data,
                    headers: {'Content-Type': 'application/json'}
                }).then(function(r){
                    if (r.data && r.data.update) {
                        item.active = "1";
                    }
                });
            };

            tc.removeItem = function(id){
                var remove=-1;
                $.each(tc.itemList,function(index,val){
                    if(val.id === id){
                        remove = index;
                    }
                });
                if(remove>-1){
                    tc.itemList.splice(remove, 1);
                }
            };

            tc.openTask = function(item){
                Core.editTask = item;
                $scope.changeNav("taskEdit");
            };

            tc.newTask = function(){
                Core.editTask = new Task();
                $scope.changeNav("taskEdit");
            };
        } ]);
})();