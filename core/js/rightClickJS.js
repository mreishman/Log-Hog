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

//check for list of addons addons to add to object
var listOfAddonsKeys = Object.keys(listOfAddons);
var listOfAddonsKeysLength = listOfAddonsKeys.length;
for(var akcount = 0; akcount < listOfAddonsKeysLength; akcount++)
{
  if(listOfAddons[listOfAddonsKeys[akcount]]["Installed"] !== false)
  {
    //add right click object
    var listOfRightClickTargets =["Span", "Div", "Image", "Text",addonRightClickIds[listOfAddonsKeys[akcount]]];
    var listOfRightClickTargetsLength = listOfRightClickTargets.length;
    for(var rct = 0; rct < listOfRightClickTargetsLength; rct++)
    {
      var innerId = listOfAddonsKeys[akcount]+listOfRightClickTargets[rct];
      if(!document.getElementById(innerId))
      {
        innerId = listOfRightClickTargets[rct];
        if(!document.getElementById(innerId))
        {
          continue;
        }
      }
      menuObjectRightClick[innerId] = [addonRightClickObject[listOfAddonsKeys[akcount]]];
      Rightclick_ID_list.push(innerId);
    }
  }
}

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
          if(Rightclick_ID_list[i] == elementClicked.id)
          {
            var menuIDSelected = Rightclick_ID_list[i];
            hideMenu = false;
            e.preventDefault();
            toggleMenuOn();
            var rightClickMenuArray = menuObjectRightClick[menuIDSelected];
            var rightClickMenuArrayLength = rightClickMenuArray.length;
            var rightClickMenuHTML = "";
            for (var j = rightClickMenuArrayLength - 1; j >= 0; j--)
            {
              rightClickMenuHTML += "<li onclick='"+rightClickMenuArray[j].action+"' class=\"context-menu__item\"><a class=\"context-menu__link\"> "+rightClickMenuArray[j].name+" </a> </li>";
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

function switchPollType()
{
  pollRateCalc = pollingRate;
  if(pollingRateType === "Seconds")
  {
    pollRateCalc *= 1000;
  }
  if(pauseOnNotFocus === "true")
  {
    clearInterval(pollTimer);
    pauseOnNotFocus = "false";
    var bgPollRateCalc = backgroundPollingRate;
    if(backgroundPollingRateType === "Seconds")
    {
      bgPollRateCalc *= 1000;
    }
    pollTimer = Visibility.every(pollRateCalc, bgPollRateCalc, function () { poll(); });
    showPopup();
    document.getElementById("popupContentInnerHTMLDiv").innerHTML = "<div class=\"settingsHeader\" >Toggled off!</div><br><div style=\"width:100%;text-align:center;padding-left:10px;padding-right:10px;\">Toggled off auto pause in background</div></div>";
  }
  else
  {
    Visibility.stop(pollTimer);
    pauseOnNotFocus = "true";
    pollTimer = setInterval(poll, pollRateCalc);
    showPopup();
    document.getElementById("popupContentInnerHTMLDiv").innerHTML = "<div class=\"settingsHeader\" >Toggled on!</div><br><div style=\"width:100%;text-align:center;padding-left:10px;padding-right:10px;\">Toggled on auto pause in background</div></div>";
  }
  setTimeout(function(){ hidePopup(); }, 500);
}

function addLogToRightClickMenu(localName, id, fullPathSearch, shortName)
{
  var rightClickObjectNew = new Array();
  if(localName.indexOf("LogHog/Backup/") !== 0)
  {
    rightClickObjectNew.push({action: "tmpHideLog(\""+id+"\");", name: "Tmp Hide Log"});
    rightClickObjectNew.push({action: "clearLogInner(titles[\""+id+"\"]);", name: "Clear Log"});
    rightClickObjectNew.push({action: "deleteLogPopupInner(titles[\""+id+"\"]);", name: "Delete Log"});
    var alertToggle = {action: "tmpToggleAlerts(\""+id+"\");" ,name: "Enable Alerts"};
    if( (!(fullPathSearch in fileData)) || fileData[fullPathSearch]["AlertEnabled"] === "true")
    {
      alertToggle = {action: "tmpToggleAlerts(\""+id+"\");" ,name: "Disable Alerts"};
    }
    rightClickObjectNew.push(alertToggle);
  }
  rightClickObjectNew.push({action: "copyToClipBoard(\""+shortName+"\");", name: "Copy File Name"});
  rightClickObjectNew.push({action: "copyToClipBoard(titles[\""+id+"\"]);", name: "Copy Filepath"});
  //add rightclick menu
  var listOfRightClickTargets =["","CurrentWindow","GroupInName","Count"];
  var listOfRightClickTargetsLength = listOfRightClickTargets.length;
  for(var rct = 0; rct < listOfRightClickTargetsLength; rct++)
  {
    var innerId = id+listOfRightClickTargets[rct];
    menuObjectRightClick[innerId] = rightClickObjectNew;
    Rightclick_ID_list.push(innerId);
  }
}

function addClearAlertToRightClickMenu(id)
{
  try
  {
    var listOfRightClickTargets =["","CurrentWindow","GroupInName","Count"];
    var listOfRightClickTargetsLength = listOfRightClickTargets.length;
    for(var rct = 0; rct < listOfRightClickTargetsLength; rct++)
    {
      var innerId = id+listOfRightClickTargets[rct];
      var menuObjectLocal = menuObjectRightClick[innerId];
      if(menuObjectLocal)
      {
        var addToMenu = true;
        var options = Object.keys(menuObjectLocal);
        var lengthOfOptions = options.length;
        for(var i = 0; i < lengthOfOptions; i++)
        {
          var currentOption = menuObjectLocal[options[i]];
          if(currentOption["name"] === "Remove Alert")
          {
            addToMenu = false;
            break;
          }
        }
        if(addToMenu)
        {
          menuObjectRightClick[innerId][lengthOfOptions] =  {action: "removeNotificationByLog(\""+id+"\");" ,name: "Remove Alert"};
        }
      }
    }
  }
  catch(e)
  {
    eventThrowException(e);
  }
}