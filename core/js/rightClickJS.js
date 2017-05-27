(function() {

  "use strict";

  var Rightclick_ID_list = ['gear','deleteImage'];


  var menuPosition;
  var menuPositionX;
  var menuPositionY;


  var menuState = 0;
  var active = "context-menu--active";
  function contextListener() {

    document.addEventListener( "contextmenu", function(e) {
      var elementClicked = clickInsideElement(e);
      var Rightclick_ID_list_Length = Rightclick_ID_list.length;
      var hideMenu = true;

      for (var i =  Rightclick_ID_list_Length - 1; i >= 0; i--) {
          if(document.getElementById(Rightclick_ID_list[i]) == elementClicked)
          {
            hideMenu = false;
            e.preventDefault();
            console.log(e);
            toggleMenuOn(Rightclick_ID_list[i], "ID");
            positionMenu(e);
          }
      }

      if(hideMenu)
      {
        toggleMenuOff();
      }

    });
  }

  function toggleMenuOn(elementClicked, typeOfEitherClassORID) {
    if ( menuState !== 1 ) {
      menuState = 1;
      document.getElementById("context-menu").classList.add(active);
    }
  }

  function toggleMenuOff() {
    if ( menuState !== 0 ) {
      menuState = 0;
      document.getElementById("context-menu").classList.remove(active);
    }
  }

  function clickInsideElement( e, className, boolVar = true ) {
    var el = e.srcElement || e.target;
    return el;
  }

  function getPosition(e) {
    var posx = 0;
    var posy = 0;

    if (!e) var e = window.event;

    if (e.pageX || e.pageY) {
      posx = e.pageX;
      posy = e.pageY;
    } else if (e.clientX || e.clientY) {
      posx = e.clientX + document.body.scrollLeft + 
                         document.documentElement.scrollLeft;
      posy = e.clientY + document.body.scrollTop + 
                         document.documentElement.scrollTop;
    }

    return {
      x: posx,
      y: posy
    }
  }

  function positionMenu(e) {
     menuPosition = getPosition(e);
    menuPositionX = menuPosition.x + "px";
    menuPositionY = menuPosition.y + "px";

    document.getElementById("context-menu").style.left = menuPositionX;
    document.getElementById("context-menu").style.top = menuPositionY;
  }

  function clickListener() {
    document.addEventListener( "click", function(e) {
      var button = e.which || e.button;
      if ( button === 1 ) {
        toggleMenuOff();
      }
    });
  }

  function keyupListener() {
    window.onkeyup = function(e) {
      if ( e.keyCode === 27 ) {
        toggleMenuOff();
      }
    }
  }

  contextListener();
  clickListener();
  keyupListener();



})();