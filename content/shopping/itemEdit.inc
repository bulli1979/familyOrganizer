<div class="shoppingContent" ng-controller="ShoppingEditController as sc">
    <form id="itemForm" class="form" ng-init="sc.init()">
        <div class="row">
            <div class="col-md-4 col-sm-4">
                <div class="form-group">
                    <label for="product">Artikel*</label> <span class="glyphicon glyphicon-plus" aria-hidden="true" title="bearbeiten" ng-click="sc.productAdd()"></span>
                    <select id="product" class="form-control" ng-model="Core.editItem.product">
                        <option value="{{product.id}}" ng-repeat="product in sc.products">{{product.title}}</option>
                    </select>
                </div>
            </div>
            <div class="col-md-2 col-sm-4">
                <div class="form-group">
                    <label>Anzahl*
                        <input type="text" id="amount" name="amount" class="form-control" ng-model="Core.editItem.amount" required>
                    </label>
                </div>

            </div>
            <div class="col-md-2 col-sm-4">
                <div class="form-group">
                    <label>Einheit*
                        <input type="text" id="unit" name="unit" class="form-control" required autocomplete="off">
                    </label>
                </div>
                <div class="form-group">
                    <button type="button" class="btn btn-success" ng-click="sc.saveItem()">speichern</button>
                </div>
            </div>
        </div>
    </form>
    <form id="productForm" class="form">
        <div class="row" ng-show="sc.showProductForm">
            <div class="col-md-4 col-sm-4">
                <div class="form-group">
                    <label>neuer Artikel Titel*
                        <input type="text" id="title" name="title" ng-model="sc.prodTitel" class="form-control" required>
                    </label>
                </div>
            </div>
            <div class="col-md-4" col-sm-4>
                <div class="form-group">
                    <label for="product">Kategorie*</label> <span class="glyphicon glyphicon-plus" aria-hidden="true" title="bearbeiten" ng-click="sc.categoryAdd()"></span>
                    <select id="category" class="form-control" ng-model="sc.selCategory">
                        <option value="{{category.id}}" ng-repeat="category in sc.categories">{{category.title}}</option>
                    </select>
                </div>
                <div class="form-group" ng-show="sc.showCategoryForm">
                    <label>
                        neue Kategorie Titel*
                        <input type="text" id="catTitle" ng-model="sc.catTitel" name="catTitle" class="form-control">
                    </label>
                </div>
                <div class="form-group" ng-show="sc.showCategoryForm">
                    <button type="button" class="btn btn-default" ng-click="sc.hideCategoryAdd()">cancel</button>
                    <button type="button" class="btn btn-success" ng-click="sc.categorySave()">hinzufügen</button>
                </div>
            </div>
            <div class="col-md-4 col-sm-4">
                <div class="form-group">
                    <button type="button" class="btn btn-default" ng-click="sc.hideProductAdd()">cancel</button>
                    <button type="button" class="btn btn-success" ng-click="sc.productSave()">hinzufügen</button>
                </div>
            </div>
        </div>
    </form>
</div>