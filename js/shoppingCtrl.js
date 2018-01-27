(function() {
    "use strict";
    angular.module('FamilyOrganizer').controller('ShoppingController',
        [ '$scope','$http','Core', function($scope,$http, Core) {
            var sc = this;
            sc.categories = [];
            sc.itemList = [];
            sc.init = function(){
                $http.get('api/rest.php?content=shopping&action=getCategories').then(function(r){
                    if(r.data){
                        sc.categories = r.data;
                    }
                });

                $http.get('api/rest.php?content=shopping&action=getShoppingList').then(function(r){
                    if(r.data){
                        sc.itemList = r.data;
                    }
                });
            };

            sc.deleteItem = function(id){
                var data = JSON.stringify({
                    content:"shopping",
                    action:"deleteItem",
                    id: id
                });
                $http({
                    method: 'POST',
                    url: 'api/rest.php',
                    data: data,
                    headers: {'Content-Type': 'application/json'}
                }).then(function(r){
                    if (r.data && r.data.delete) {
                        sc.removeItem(id);
                    }
                });
            };

            sc.removeItem = function(id){
                $.each(sc.itemList,function(index,val){
                    if(val.id === id){
                        sc.itemList.splice(index, 1);
                    }
                })
            };

            sc.newShoppingItem = function(){
                Core.editItem = new ShoppingItem();
                $scope.changeNav("shoppingEdit");
            };


        } ]);
})();