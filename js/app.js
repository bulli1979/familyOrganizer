var app = angular.module('FamilyOrganizer', ["ngSanitize","ui.router"]);
angular.module('FamilyOrganizer')
    .config(['$stateProvider', '$urlRouterProvider',
        function($stateProvider, $urlRouterProvider) {
            $urlRouterProvider.otherwise('/'); // redirect to home
            $stateProvider.
            state('home',{ url: '/home', templateUrl: 'content/home.html',controller:"navigationChangeController" }).
            state('shoppingList',{ url: '/shoppingList', templateUrl: 'content/shopping/shoppingList.inc',controller:"navigationChangeController" }).
            state('doShopping',{ url: '/shopping', templateUrl: 'content/shopping/shopping.inc',controller:"navigationChangeController" }).
            state('shoppingEdit',{ url: '/editItem', templateUrl: 'content/shopping/itemEdit.inc',controller:"navigationChangeController" }).
            state('taskList',{ url: '/taskList', templateUrl: 'content/task/taskList.inc',controller:"navigationChangeController" }).
            state('task',{ url: '/task', templateUrl: 'content/task/doTask.inc',controller:"navigationChangeController" }).
            state('taskEdit',{ url: '/taskEdit', templateUrl: 'content/task/editTask.inc',controller:"navigationChangeController" }).
            state('admin',{ url: '/admin', templateUrl: 'content/admin/adminList.html',controller:"navigationChangeController" }).
            state('userEdit',{ url: '/userEdit', templateUrl: 'content/user/userEdit.html',controller:"navigationChangeController" });
        }
    ]).controller("navigationChangeController",function($scope,$log){
        //If we need something todo on site change then here.

    }).controller('PageController', function ($scope, $log, $http, $state,$rootScope,Core) {
        $scope.$state = $state;
        $scope.Core = Core;

        $scope.initApp = function(){
            Core.loadAllRoles();
        };
        $scope.changeNav = function(state){
           Core.changeMenu(state);
           $state.go(state);
           $scope.$state = $state;
        };
        $scope.editProfile = function(){
            if(Core.user != null){
                Core.editUser = Core.user;
                $state.go('userEdit');
            }
        };
    })
    .controller("LoginController",function($scope,$http,Core){
        $scope.formData = {};
        $scope.checkLoginSubmit = function(obj, e) {
            e = e || event;
            if (e.keyCode === 13) $scope.doLogin();
        };
        $scope.doLogin = function() {
            try {
                if ($scope.formData.user ==="" || $scope.formData.password === "") return;
                $scope.status = "Bitte warten..";
                var data = JSON.stringify({content:"user",action:"logIn", username:$scope.formData.user, password:$scope.formData.password});
                $http({
                    method: 'POST',
                    url: 'api/rest.php',
                    data: data,
                    headers: {'Content-Type': 'application/json'}
                }).then(function(r){
                    if (r.data) {
                        if(r.data.logIn === false){
                            $("#loginAlert").removeClass("hidden");
                        }else{
                            Core.userName = r.data.firstname + " " + r.data.name;
                            Core.loggedIn = true;
                            Core.user = r.data;
                            $('#loginDialog').modal('hide');
                            $scope.changeNav("home");
                        }
                    }
                });
            } catch (e) {
                Core.showError("Es ist ein Fehler aufgetreten bitte Kontaktieren sie den Systemadmin!")
            }
        };
    })
    .controller("adminController", function($scope,$state,$http,Core){
        var ac = this;
        $scope.userList = [];
        $scope.loadAllUser = function(){
            Core.loadAllUser($scope);
        };
        $scope.deleteUser=function(obj){
            var delId = obj.user.id;
            var data = JSON.stringify({
                content:"user",
                action:"delete",
                id: delId
            });
            $http({
                method: 'POST',
                url: 'api/rest.php',
                data: data,
                headers: {'Content-Type': 'application/json'}
            }).then(function(){

                Core.showSuccess("User gelöscht");
                ac.removeUserFromList(obj.user.id);
            });
        };
        ac.removeUserFromList = function(id){
            var remove=-1;
            $.each($scope.userList,function(index,val){
                if(val.id === id){
                    remove = index;
                }
            });
            if(remove>-1){
                $scope.userList.splice(remove, 1);
            }
        };
        $scope.openUser = function(obj){
            Core.editUser = obj.user;
            $state.go('userEdit');
        };
        $scope.createNewUser = function(){
            Core.editUser = new User();
            $state.go('userEdit');
        }
    })
    .controller("userController", function($scope,$http,Core){
        var uc = this;

        uc.newPw1 = "";
        uc.newPw2 = "";
        uc.chkUserRoles = function(id){
            return Core.editUser !== null && $.inArray(id,Core.editUser.roles)>-1;
        };

        uc.saveUserData = function(){
            var roles = [];
            $("[name='ucRoles']:checked" ).each(function( index ) {
               roles.push($( this ).val());
            });
            var  editUser = Core.editUser;
            if(!uc.validateUserdata()){
                Core.showError("Fehler in der Validierung überprüfe bitte alle Felder.")
                return;
            }
            var data = JSON.stringify({
                content:"user",
                action:"save",
                username: editUser.username,
                password: uc.newPw1,
                firstname: editUser.firstname,
                name: editUser.name,
                email: editUser.email,
                birthday: editUser.birthday,
                id:editUser.id,
                roles: roles});
            $http({
                method: 'POST',
                url: 'api/rest.php',
                data: data,
                headers: {'Content-Type': 'application/json'}
            }).then(function(r){
                if (r.data && r.data.id) {
                    Core.editUser.id = r.data.id;
                    Core.showSuccess("User Daten erfolgreich gespeichert!");
                } else {
                    Core.showError("Fehler beim Speichern der Userdaten bitte kontaktieren sie den Systemadministrator!")
                }
            });
        };

        this.validateUserdata = function(){
            var val = Core.validateInput($("#userForm"));
            if(this.newPw1.length>0 && this.newPw1 !== this.newPw2){
                val = false;
                $("#pwRow").addClass("has-error");
            }else{
                $("#pwRow").removeClass("has-error");
            }
            return val;
        };
    })
    .directive('foNavHeader', function() {
        return {
            restrict: 'AE',
            replace: 'true',
            templateUrl: 'content/global/mainHeader.inc'
        };
    })
    .directive('file', function () {
    return {
        scope: {
            file: '='
        },
        link: function ($scope, el, attrs) {
            el.bind('change', function (event) {
                var file = event.target.files[0];
                $scope.file = file ? file : undefined;
                $scope.$apply();
            });
        }
    };
});
