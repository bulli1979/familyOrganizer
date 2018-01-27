<nav class="navbar navbar-inverse">
    <div class="container-fluid">
        <div class="navbar-header">
            <a class="logo" ng-click="changeNav('home')"><img src="images/logo.png" alt="Family Organizer" height="50px"></a>
        </div>
        <ul class="nav navbar-nav">
            <li id="home" class="active"><a href="#" ng-click="changeNav('home')" ng-click="changeNav('home')">Home</a></li>
            <li id="admin"><a href="#" ng-click="changeNav('admin')" ng-show="Core.chkShow('1')">Userverwaltung</a></li>
            <li id="shoppingList"><a href="#" ng-click="changeNav('shoppingList')" ng-show="Core.chkShow('3')">Einkaufsliste</a></li>
            <li id="taskList"><a href="#" ng-click="changeNav('taskList')" ng-show="Core.chkShow('4')">Hausarbeit</a></li>
        </ul>
        <ul class="nav navbar-nav navbar-right">

            <li class="dropdown" ng-show="Core.userName!=null && Core.userName.length>0">
                <a class="dropdown-toggle" data-toggle="dropdown" href="#">{{Core.userName}}
                    <span class="caret"></span>
                </a>
                <ul class="dropdown-menu">
                    <li><a href="#" ng-click="Core.logOut()">Logout</a></li>
                    <li><a href="#" ng-click="editProfile()">Profil bearbeiten</a></li>
                </ul>
            </li>
            <li><a href="#" onclick="$('#loginDialog').modal();" ng-hide="Core.userName!=null && Core.userName.length>0"><span class="glyphicon glyphicon-log-in"></span> Login</a></li>
        </ul>
    </div>
</nav>

