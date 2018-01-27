<div ng-controller="DoShoppingController as sc">
    <div class="panel-group" ng-init="sc.init()">
        <div class="panel panel-success" ng-repeat="catArr in sc.itemList">
            <a style="display:block;" data-toggle="collapse" href="#cat{{catArr.category}}" class="panel-heading">
                <h4 class="panel-title">
                    {{catArr.category}}
                </h4>
            </a>
            <div id="cat{{catArr.category}}" class="panel-collapse collapse">
                <div class="panel-body">
                    <div class="panel panel-default" id="item_{{item.id}}" ng-repeat="item in catArr.items">
                      <div class="panel-body">
                      <div class="row">
                          <div class="col-md-11">
                              {{item.amount}} {{item.unittitle}} {{item.article}}
                          </div>
                          <div class="col-md-1 shoppingAdd" ng-click="sc.buyItem(item)" ng-show="item.shoppingdate==null">
                              <span class="glyphicon glyphicon-shopping-cart" aria-hidden="true"></span>
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