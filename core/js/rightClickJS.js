(function() {

  "use strict";

  document.getElementById('gear').addEventListener( "contextmenu", function(e) {
    e.preventDefault();
    console.log(e);
  });

  document.getElementById('deleteImage').addEventListener( "contextmenu", function(e) {
    e.preventDefault();
    console.log(e);
  });




})();