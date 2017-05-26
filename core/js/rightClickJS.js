(function() {

  "use strict";


  var menuState = 0;
  var active = "context-menu--active";

  document.getElementById('gear').addEventListener( "contextmenu", function(e) {
    e.preventDefault();
    console.log(e);
    toggleMenuOn();
  });

  document.getElementById('deleteImage').addEventListener( "contextmenu", function(e) {
    e.preventDefault();
    console.log(e);
    toggleMenuOn();
  });

  function toggleMenuOn() {
    if ( menuState !== 1 ) {
      menuState = 1;
      document.getElementById("context-menu").classList.add(active);
    }
  }


})();