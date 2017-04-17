var offsetHeight = 0;
if(document.getElementById('menu'))
{
	offsetHeight = document.getElementById('menu').offsetHeight;
}
var heightOfMain = window.innerHeight - offsetHeight;
var heightOfMainStyle = 'height:';
heightOfMainStyle += heightOfMain;
heightOfMainStyle += 'px';
document.getElementById("main").setAttribute("style",heightOfMainStyle);