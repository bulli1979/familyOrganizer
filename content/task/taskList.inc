<div ng-controller="TaskController as tc">
    <div class="searchableList" ng-init="tc.init()" ng-show="Core.chkShow('1')">
        <div class="form-group"><input type="text" ng-model="search" placeholder="Suchen">
            <button class="btn btn-success" ng-click="tc.newTask()">Aufgabe hinzufügen</button>
        </div>
        <table class="table table-striped">
            <thead>
            <tr>
                <th>Titel</th>
                <th>zuletzt am</th>
                <th>Ersteller</th>
                <th>Beschreibung</th>
                <th>Bonus</th>
                <th>ist aktiv</th>
                <th>ist standard</th>
                <th>Aktion</th>
            </tr>
            </thead>
            <tbody>
            <tr ng-repeat="item in tc.itemList | filter:{title:search}">
                <td>{{item.title}}</td>
                <th>{{item.lastdo}}</th>
                <th>{{item.ufirstname}} {{item.uname}}</th>
                <th>{{item.description}}</th>
                <th>{{item.price}}</th>
                <th>
                    <span ng-show="item.active=='1'">ja</span><span ng-show="item.active=='0'">nein</span>
                </th>
                <th>
                    <span ng-show="item.standard=='1'">ja</span><span ng-show="item.standard=='0'">nein</span>
                </th>
                <td>
                    <span class="glyphicon glyphicon-edit" aria-hidden="true" ng-click="tc.openTask(item)" title="bearbeiten"></span>
                    <span class="glyphicon glyphicon-repeat" aria-hidden="true" ng-click="tc.activateTask(item)" title="Aktiv setzen" ng-show="item.active=='0'"></span>
                    <span class="glyphicon glyphicon-remove" aria-hidden="true" ng-click="tc.deleteItem(item.id)" title="löschen"></span>
                </td>
            </tr>
            </tbody>
        </table>
    </div>
</div>