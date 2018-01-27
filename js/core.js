app.service('Core', function($http,$state,$timeout) {
    var that = this;
    this.errorText="";
    this.successText="";
    this.userName = "";
    this.loggedIn = false;
    this.user = null;
    this.editUser = null;
    this.editItem = null;
    this.editTask = null;
    this.logOut = function() {
        $http.get('api/rest.php?content=user&action=logOut').then(function(r){
            if(r.data && r.data.logOut === true){
                location.reload();
            }
        });
    };

    this.chkLogin = function(){
        $http.get('api/rest.php?content=user&action=chkLogin').then(function(r){
            if(r.data && r.data.logIn !== false){
                that.user = r.data;
                that.userName =  that.user.firstname + " " +  that.user.name;
                that.loggedIn = true;
            }
        });
    };

//    this.roleList = [];
    this.loadAllRoles = function(){
        $http.get('api/rest.php?content=user&action=getRoles').then(function(r){
            if(r.data){
                that.roleList = r.data;
            }
        });
    };

    this.loadAllUser = function($scope){
        $http.get('api/rest.php?content=user&action=getAll').then(function(r){
            if(r.data){
                $scope.userList = r.data;
            }
        });
    };

    if(!this.loggedIn){
        that.chkLogin();
    }


    this.chkShow = function(role){
        return (that.user != null && $.inArray(role, that.user.roles) > -1);
    };

   /* this.isCurrentUser = function(){
        return that.user != null && that.editUser!=null && that.user.id === that.editUser.id;
    };
*/
    this.changeMenu = function(state){
        $(".navbar-nav li").removeClass("active");
        $("#" + state).addClass("active");
    };


    this.validateInput = function(form){
        var valid = true;
        var inputs = form[0];
        $.each( inputs, function( i, val ) {
            var input = $(val)[0];
            $.each(input.attributes,function(index,attr){
                var elementValid = true;
                if(attr.name==="required"){
                    if(input.value===""){
                        elementValid = false;
                    }
                }
                if(attr.name==="pattern" && input.value.length>0){
                    var pattern =  attr.value;
                    var patt = new RegExp(pattern);
                    var res = patt.test(input.value);
                    if(res === false){
                        elementValid = false;
                    }
                }
                var parent = input.parentElement;
                if(elementValid===false){
                    $(parent).addClass("has-error");
                    valid = false;
                }else{
                    $(parent).removeClass("has-error");
                }
            })
        });
        return valid;
    };

    this.showSuccess = function(text){
        that.successText=text;
        $("#successBox").removeClass("hidden");
        $timeout( function(){ that.hideSuccess(); },3000);
    };
    this.hideSuccess = function(){
        $("#successBox").addClass("hidden");
        that.successText="";
    };
    this.showError = function(text){
        that.errorText=text;
        $("#errorBox").removeClass("hidden");
        $timeout( function(){ that.hideError(); },3000);
    };
    this.hideError = function(){
        console.log("hide");
        $("#errorBox").addClass("hidden");
        that.errorText="";
    };

});