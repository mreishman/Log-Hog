//Clear Logs Menu Button

var clearAllLogs = {action: "deleteAction();", name: "Clear All Logs"};
var clearCurrentLog = {action: "clearLog(currentSelectWindow);", name: "Clear Current Log"};
var deleteAllLogs = {action: "", name: "Delete All Logs"};
var deleteCurrentLog = {action: "deleteLogPopup();", name: "Delete Current Log"};

//Pause Icon

var tmpTogglePauseOnUnfocus = {action: "switchPollType();", name: "Toggle pause on unfocus"};

//Notification Icon

var doToggleClearAllNotifications = {action: "removeAllNotifications(); ", name: "Clear All Notifications"};

var deleteMenu = [clearAllLogs,clearCurrentLog,deleteCurrentLog];
var pauseMenu = [tmpTogglePauseOnUnfocus];
var notificationMenuBadge = [doToggleClearAllNotifications];

var menuObjectRightClick = {deleteImage: deleteMenu, pauseImage: pauseMenu, notificationBadge: notificationMenuBadge};

$( document ).ready(function() {
  (function() {

    "use strict";

    var menuPosition;
    var menuPositionX;
    var menuPositionY;

    var menuWidth;
    var menuHeight;

    var windowWidth;
    var windowHeight;

    var menuState = 0;
    var active = "context-menu--active";
    function contextListener() {
      document.addEventListener( "contextmenu", function(e) {
        var elementClicked = clickInsideElement(e);
        var rightClickIDListLength = Rightclick_ID_list.length;
        var hideMenu = true;

        for (var i =  rightClickIDListLength - 1; i >= 0; i--) {
          if(document.getElementById(Rightclick_ID_list[i]) == elementClicked)
          {
            var menuIDSelected = Rightclick_ID_list[i];
            hideMenu = false;
            e.preventDefault();
            toggleMenuOn();
            var rightClickMenuArray = menuObjectRightClick[menuIDSelected];
            var rightClickMenuArrayLength = rightClickMenuArray.length;
            var rightClickMenuHTML = "";
            for (var i = rightClickMenuArrayLength - 1; i >= 0; i--) 
            {
              rightClickMenuHTML += "<li onclick='"+rightClickMenuArray[i].action+"' class=\"context-menu__item\"><a class=\"context-menu__link\"> "+rightClickMenuArray[i].name+" </a> </li>";
            }
            document.getElementById("context-menu-items").innerHTML = rightClickMenuHTML;
            positionMenu(e);
          }
        }
        if(hideMenu)
        {
          toggleMenuOff();
        }

      });
    }

    function toggleMenuOn() {
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
      if(!e)
      {
        e = window.event;
      }

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
      };
    }

    function positionMenu(e) {
       menuPosition = getPosition(e);
      menuPositionX = menuPosition.x;
      menuPositionY = menuPosition.y;

      windowWidth = window.innerWidth;
      windowHeight = window.innerHeight;

      menuWidth = document.getElementById("context-menu").offsetWidth + 4;
      menuHeight = document.getElementById("context-menu").offsetHeight + 4;

      if ( (windowWidth - menuPositionX) < menuWidth ) {
        document.getElementById("context-menu").style.left = windowWidth - menuWidth + "px";
      }else{
        document.getElementById("context-menu").style.left = menuPositionX + "px";
      }

     if ( (windowHeight - menuPositionY) < menuHeight ) {
      document.getElementById("context-menu").style.top = windowHeight - menuHeight + "px";
     }else{
      document.getElementById("context-menu").style.top = menuPositionY+ "px";
     }
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
      };
    }

    function resizeListener() {
      window.onresize = function(e) {
        toggleMenuOff();
      };
    }

    contextListener();
    clickListener();
    keyupListener();
    resizeListener();

  })();
});