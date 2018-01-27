(function() {
    "use strict";
    angular.module('FamilyOrganizer').controller('EditTaskController',
        [ '$scope','$http','Core', function($scope,$http, Core) {
            var tc = this;
            tc.init = function(){
                if(Core.editTask == null){
                    Core.editTask = new Task();
                }
            };
            tc.save = function(){
                var form = $("#taskForm");
                if(Core.validateInput(form)){
                    Core.hideError();
                    var data = {
                        content: "task",
                        action: "save",
                        id: Core.editTask.id,
                        title: Core.editTask.title,
                        price: Core.editTask.price,
                        description: Core.editTask.description,
                        standard: Core.editTask.standard,
                        active: Core.editTask.active
                    };
                    $http({
                        method: 'POST',
                        url: 'api/rest.php',
                        headers: {'Content-Type': 'application/json'},
                        data: data
                    }).then(function(r){
                        if (r.data) {
                            if(r.data.id){
                                Core.editTask.id = r.data.id;
                            }
                            Core.showSuccess("Aufgabe gespeichert!");
                        }else{
                            Core.showError("Fehler beim speichern einer Aufgabe Systemadmin kontaktieren.");
                        }
                    });
                }else{
                    Core.showError("Fehler beim speichern einer Aufgabe, bitte Füllen sie alle Pflichtfelder aus.");
                }
            };
        } ]);
})();