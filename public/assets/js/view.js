
function ViewModel() {
  var self = this;
  
  self.k = ko.observable('');
  self.p = ko.observable('');
  // self.email = ko.observable('');
  
  self.isValidName = ko.pureComputed(function() {
    return self.k().trim().length > 0;
  });
  self.isValidName = ko.pureComputed(function() {
    return self.p().trim().length > 0;
  });
  
  // self.isValidEmail = ko.pureComputed(function() {
  //   return self.email().trim().length > 0;
  // });
  
  self.isValidForm = ko.pureComputed(function() {
    return self.p() && self.k();
  });


ko.applyBindings(new ViewModel());
  }
console.log(1);