function UserGroupsUser(name, initialMeal) {
    var self = this;
    self.name = name;
   
}

function UserRegModel() {
   var self = this;
   
    this.radioSelectedOptionValue = ko.observable("Tutor");
   
    self.groupNames = { 4:"Tutor",  3:"Student"};      
    

}
ko.applyBindings(new UserRegModel());