<div ng-controller="ShoppingController as sc">
    <div class="searchableList" ng-init="sc.init()" ng-show="Core.chkShow('3')">
        <div class="form-group"><input type="text" ng-model="search">
            <button class="btn btn-success" ng-click="sc.newShoppingItem()">Artikel hinzufügen</button>
        </div>
        <table class="table table-striped">
            <thead>
            <tr>
                <th>Artikel</th>
                <th>Anzahl</th>
                <th>zuletzt gekauft</th>
                <th>Aktion</th>
            </tr>
            </thead>
            <tbody>
            <tr ng-repeat="item in sc.itemList">
                <td>{{item.ptitle}}</td>
                <td>{{item.amount}} {{item.utitle}}</td>
                <td>{{item.shoppingdate}} {{item.firstname}} {{item.name}}</td>
                <td>
                    <span class="glyphicon glyphicon-remove" aria-hidden="true" ng-click="sc.deleteItem(item.id)" title="löschen"></span>
                </td>
            </tr>
            </tbody>
        </table>
    </div>
</div>