<md-dialog aria-label="Login form">
    <form ng-cloak class="fo-loginform">
        <md-toolbar>
            <div class="md-toolbar-tools">
                <h2>Anmeldung</h2>
                <span flex></span>
                <md-button class="md-icon-button" ng-click="cancel()">
                    <i class="material-icons">close</i>
                </md-button>
            </div>
        </md-toolbar>

        <md-dialog-content>
            <div class="md-dialog-content">
                <div ng-hide="loading" layout="column">
                    <b style="margin-bottom: 20px;">{{status}}</b>
                    <br/>
                    <md-input-container>
                        <label>Benutzername</label>
                        <input ng-model="formData.user" md-autofocus ng-keypress="checkLoginSubmit(this,event)">
                    </md-input-container>
                    <md-input-container>
                        <label>Passwort</label>
                        <input ng-model="formData.password" type="password" ng-keypress="checkLoginSubmit(this,event)">
                    </md-input-container>
                </div>
                <div ng-hide="!loading" style="text-align: center;">
                    <md-progress-linear md-mode="indeterminate" class="md-primary"></md-progress-linear>
                    <p>{{status}}</p>
                </div>
            </div>
        </md-dialog-content>

        <md-dialog-actions layout="row" ng-hide="loading">
            <md-button ng-click="doLogin()">Login</md-button>
            <md-button ng-click="cancel()">Cancel</md-button>
        </md-dialog-actions>
    </form>
</md-dialog>