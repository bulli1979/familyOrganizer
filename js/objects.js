var User = function(){
    this.id = -1;
    this.firstname = "";
    this.name = "";
    this.email = "";
    this.birthday = "";
    this.roles = [];
    this.username="";
};
var ShoppingItem = function(){
  this.id = -1;
  this.product;
  this.price = 0;
  this.amount = 0;
  this.unit = "";
  this.shoppingDate = null;
};

var Product = function(id,title,category){
  this.id=id;
  this.title = title;
  this.category = category;
};
var Category = function(id,title){
  this.id = id;
  this.title = title;
};
var Task = function(){
  this.id = -1;
  this.title="";
  this.description = "";
  this.price = 0;
  this.lasdo = null;
  this.standard = '1';
  this.active='1';
};