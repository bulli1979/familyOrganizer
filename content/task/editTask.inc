<div ng-controller="EditTaskController as tc">
    <form id="taskForm" ng-init="tc.init()">
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="title">Titel*:</label>
                    <input type="text" class="form-control" id="title" name="title" id="title" placeholder="Titel" required ng-model="Core.editTask.title">

                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label for="description">Beschreibung*:</label>
                        <textarea class="form-control" name="description" id="description" placeholder="Beschreibung" required ng-model="Core.editTask.description"></textarea>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="price">Bonus*:</label>
                    <input type="text" class="form-control" name="price" id="price" pattern="[0-9]{1,4}.{0,1}[0-9]{0,2}" placeholder="0000.00" required ng-model="Core.editTask.price">
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group">
                    <label for="standard">ist Standard:</label>
                    <select name="standard" class="form-control" ng-model="Core.editTask.standard">
                        <option value="1">Ja</option>
                        <option value="0">Nein</option>
                    </select>
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group">
                    <label for="active">ist Aktiv:</label>
                    <select name="active" class="form-control" ng-model="Core.editTask.active">
                        <option value="1">Ja</option>
                        <option value="0">Nein</option>
                    </select>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12 right">
                <div class="form-group">
                    <button type="button" class="btn btn-success" ng-click="tc.save()">speichern</button>
                </div>
            </div>
        </div>
    </form>
</div>