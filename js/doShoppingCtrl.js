(function() {
    "use strict";
    angular.module('FamilyOrganizer').controller('DoShoppingController',
        [ '$scope','$http','Core', function($scope,$http, Core) {
            var sc = this;
            sc.itemList = [];
            sc.init = function(){
                if(!Core.chkShow("2")){
                    return;
                }
                $http.get('api/rest.php?content=doShopping&action=getShoppingListToBuy').then(function(r){
                    if(r.data){
                        sc.itemList = r.data;
                    }
                });
            };

            sc.buyItem = function(item){
                var data = JSON.stringify({
                    content:"doShopping",
                    action:"buyItem",
                    item:item
                });
                $http({
                    method: 'POST',
                    url: 'api/rest.php',
                    data: data,
                    headers: {'Content-Type': 'application/json'}
                }).then(function(r){
                    if (r.data) {
                        item.shoppingdate=new Date();
                        $("#item_"+item.id).addClass("buyed");
                    }
                });
            }

        }]);
})();