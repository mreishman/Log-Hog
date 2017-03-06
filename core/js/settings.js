var offsetHeight = document.getElementById('menu').offsetHeight;
var heightOfMain = window.innerHeight - offsetHeight - 10;
var heightOfMainStyle = 'height:';
heightOfMainStyle += heightOfMain;
heightOfMainStyle += 'px';
document.getElementById("main").setAttribute("style",heightOfMainStyle);