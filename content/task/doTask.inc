<div ng-controller="DoTaskController as dtc">

    <div class="panel-group" ng-init="dtc.init()">
        <div class="panel panel-success" ng-repeat="task in dtc.itemList">
            <a style="display:block;" data-toggle="collapse" href="#task{{task.id}}" class="panel-heading">
                <h4 class="panel-title">
                    {{task.title}}
                </h4>
            </a>
            <div id="task{{task.id}}" class="panel-collapse collapse">
                <div class="panel-body">
                    <div class="panel panel-default" id="item_{{task.id}}">
                        <div class="panel-body">
                            <div class="row">
                                <div class="col-md-11">
                                    {{task.description}}<br>
                                    {{task.price}} CHF<br>
                                    <span ng-show="task.lastdo != null">Zulettst erledigt am: {{task.lastdo}}</span>
                                </div>
                                <div class="col-md-1 shoppingAdd" ng-click="dtc.doTask(task.id)">
                                    <span class="glyphicon glyphicon-ok" aria-hidden="true"></span>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
                <!--<div class="panel-footer">Panel Footer</div>-->
            </div>

        </div>
    </div>
</div>