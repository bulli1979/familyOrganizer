(function() {
    "use strict";
    angular.module('FamilyOrganizer').controller('ShoppingEditController',
        [ '$scope','$http','Core', function($scope,$http, Core) {
            var sc = this;
            sc.categories = [];
            sc.units = [];
            sc.products = [];
            sc.showProductForm = false;
            sc.showCategoryForm = false;
            sc.catTitel = "";
            sc.prodTitel = "";
            sc.selCategory = null;
            sc.substringMatcher = function(index){
                return function findMatches(q, cb) {
                    var matches;
                    // an array that will be populated with substring matches
                    matches = [];
                    var arr;
                    switch( index){
                        case 1: arr =sc.products ;
                        break;
                        case 2: arr = sc.categories;
                        break;
                        case 3: arr = sc.units;
                        break;
                        default : arr = [];
                    }
                    var substrRegex = new RegExp(q, 'i');
                    $.each(arr, function(i, pro) {
                        if (substrRegex.test(pro.title)) {
                            matches.push(pro.title);
                        }
                    });
                    cb(matches);
                };
            };
            sc.init = function(){
                $http.get('api/rest.php?content=shopping&action=getCategories').then(function(r){
                    if(r.data){
                        sc.categories = r.data;
                    }
                });
                $http.get('api/rest.php?content=shopping&action=getProducts').then(function(r){
                    if(r.data){
                        sc.products = r.data;
                    }
                });
                $http.get('api/rest.php?content=shopping&action=getUnits').then(function(r){
                    if(r.data){
                        sc.units = r.data;
                    }
                });
                $('#unit').typeahead({
                        hint: true,
                        highlight: true,
                        minLength: 1
                    },
                    {
                        name: 'unit',
                        source: sc.substringMatcher(3)
                    });

                if(Core.editItem == null){
                    Core.editItem = new ShoppingItem();
                }
            };

            sc.productAdd = function(){
                sc.showProductForm = true;
            };
            sc.categoryAdd = function(){
                sc.showCategoryForm = true;
            };
            sc.hideCategoryAdd = function(){
                sc.showCategoryForm = false;
            };
            sc.hideProductAdd = function(){
                sc.showProductForm = false;
            };

            sc.categorySave = function(){
                if(sc.catTitel.length>3){
                    $.each(sc.categories,function(index,val){
                        if(val.title === sc.catTitel){
                            Core.showError("Fehler bei KAtegorie speichern, Kategorie existiert schon.");
                            return false;
                        }
                    });
                    var data = JSON.stringify({
                        content:"shopping",
                        action:"createCategory",
                        title:sc.catTitel
                    });
                    $http({
                        method: 'POST',
                        url: 'api/rest.php',
                        data: data,
                        headers: {'Content-Type': 'application/json'}
                    }).then(function(r){
                        if (r.data && r.data.id) {
                            var cat = new Category(r.data.id,sc.catTitel);
                            sc.categories.push(cat);
                            sc.catTitel = "";
                            sc.hideCategoryAdd();
                            Core.showSuccess("Kategorie gespeichert");
                        }else{
                            Core.showError("Fehler bei Kategorie speichern Systemadmin kontaktieren.");
                        }
                    });
                }
            };

            sc.productSave = function(){
                var form = $("#productForm");
                var found = false;
                $.each(sc.products,function(index,val){
                    if(val.title === sc.prodTitel){
                        found = true;
                        return false;
                    }
                });
                if(found){
                    Core.showError("Fehler bei Produkt speichern Produkt existiert schon.");
                    return;
                }
                if(Core.validateInput(form)){

                    var data = JSON.stringify({
                        content:"shopping",
                        action:"createProduct",
                        title:sc.prodTitel,
                        category : sc.selCategory
                    });
                    $http({
                        method: 'POST',
                        url: 'api/rest.php',
                        data: data,
                        headers: {'Content-Type': 'application/json'}
                    }).then(function(r){
                        if (r.data && r.data.id) {
                            Core.showSuccess("Produkt gespeichert");
                            var prod = new Product(r.data.id,sc.prodTitel,sc.selCategory);
                            sc.products.push(prod);
                            sc.hideProductAdd();
                            sc.hideCategoryAdd();
                        }else{
                            Core.showError("Fehler bei Produkt speichern Systemadmin kontaktieren.");
                        }
                    });
                }else{
                    Core.showError("Fehler beim speichern eines  Produktes. Alle Pflichtfelder ausfüllen!");
                }
            };

            sc.saveItem = function(){
                var form = $("#itemForm");
                if(Core.validateInput(form)){
                    var data = JSON.stringify({
                        content:"shopping",
                        action:"saveItem",
                        product: Core.editItem.product,
                        unit: $("#unit").val(),
                        amount: Core.editItem.amount,
                        id: Core.editItem.id
                    });
                    $http({
                        method: 'POST',
                        url: 'api/rest.php',
                        data: data,
                        headers: {'Content-Type': 'application/json'}
                    }).then(function(r){
                        if (r.data && r.data.id) {
                            Core.editItem.id = r.data.id;
                            Core.showSuccess("Einkaufsartikel gespeichert");
                            $scope.changeNav("shoppingList");
                        }else{
                            Core.showError("Fehler beim speichern eines Eines Artikels Systemadmin kontaktieren.");
                        }
                    });
                }else{
                    Core.showError("Fehler beim speichern eines Eines Artikels. Alle Pflichtfelder ausfüllen!");
                }
            }


        } ]);
})();