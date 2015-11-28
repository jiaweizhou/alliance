<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<HTML XMLNS:ELEMENT>
<html>
<head>
<title>::move::</title>
<meta http-equiv="Content-Type" content="text/html;charset=utf-8">
<style>
body{
    padding:0px;
    background-color:white;
}
#panel{
    position:absolute;
}
#panel>div{
    border-top-left-radius:5px; 
    border-top-right-radius:5px;
    border-bottom-left-radius:5px; 
    border-bottom-right-radius:5px;
    box-shadow:3px 3px 5px #5f5f5f;
    opacity:1;
    filter:alpha(opacity=100);
}
#recycle{
    position:absolute;
    top:600px;
    left:20px;
    width:200px;
    height:200px;
}
</style>
</head>
<body>
<div id="panel"></div>
<div id="recycle">
<button onclick="doMove(this,document.getElementById('panel'))">删除</button></div>
</body>
</html>


<script type="text/javascript">
var color = "darkcyan";
var color_ = "tomato";
var height = 130;
var width = 160;
var xDivs = 7;
var yDivs = 4;
var aSelected = new Array();
var aTempObj = new Array();
var tempLen = 0;
//初始化 
s=document.getElementsByName("pic[]");
console.log(s.length);
for (var i = 0;i < s.length;i++)
{
	for(var j=0;j<kind2array.length;j++){
	    if (s[i].value == kind2array[j])
	    { 
	        s[i].checked = true;
	        break;
	    }
    }
}
(function(){
    for(var i = 0;i < yDivs;i++) {
        for(var j = 0;j < xDivs;j++) {
            var oD = new divFactory(i + "_" + j,i * (height + 10),j * (width + 10),width,height);
            oD.setText("<img width='" + width + "' src='" + aImg[(Math.ceil(Math.random() * 2) > 1)?i:j] + "'>");
            oD.draw();
            aTempObj.push(oD);
        }
    }
})();

//select
function doSelect(o,p){
    o.remove();
    if(o.getSld()){
        o.setSld(false);
        o.setBgcolor(color);
        o.draw();
    } else {
        o.setSld(true);
        o.setBgcolor(color_);
        o.draw();
    }
}

//move
function doMove(o,p){
        //获取选中项
        for(var i = 0;i < aTempObj.length;i++){
            if(aTempObj[i].getSld()){
                aSelected.push(aTempObj[i]); 
            }
        }
        tempLen = aSelected.length;
        //移动
        for(var i = 0;i < aSelected.length;i++){
            moveByStep(aSelected[i],600,20,p,i);
        }

        setTimeout(function(){
            var len = aTempObj.length - tempLen;
            var c = 0;
            for(var i = 0;i < yDivs;i++){
                for(var j = 0;j < xDivs;j++){
                    if(!document.getElementById(aTempObj[c].getId())) {
                        aTempObj.splice(c,1);
                        j--;
                        continue;
                    }
                    aTempObj[c].remove();
                    aTempObj[c].setTop(i * (height + 10));
                    aTempObj[c].setLeft(j * (width + 10));
                    aTempObj[c].setSld(false);
                    aTempObj[c].setBgcolor(color);
                    aTempObj[c].draw();    
                    c++;
                }
            }
            c = 0;
            aSelected = new Array();
        },tempLen * 30 + 300); 
}

//doMove
function moveByStep(o,t,l,p,i){
    var top = o.getTop();
    var left = o.getLeft();
    var dt = parseInt((t - top) / 10);
    var dl = parseInt((l - left) / 10);
    var index = 0;
    var timer = window.setInterval(function(){
        o.remove();
        o.setTop(o.getTop() + dt);
        o.setLeft(o.getLeft() + dl);
        o.draw();
        index++;
        if(index == 10){
            window.clearInterval(timer);
            o.remove();
            o.setZIndex(-1 * (i + 1));
            o.setTop(t + (i + 1));
            o.setLeft(l + (i + 1));
        }
    },10);
}

//div factory
function divFactory(id,t,l,w,h) {
    //private
    var id = id;
    var top = t + "px";
    var left = l + "px";
    var width = w + "px";
    var height = h + "px";
    var sld = false;
    var bgcolor = color;
    var self = this;
    var _parent = document.getElementById("panel");
    var zIndex = 0;
    var text = "";
    //public
    this.getId = function() {
        return id;
    }
    this.setTop = function(t) {
        top = t + "px";
    }
    this.getTop = function() {
        return parseInt(top.substring(0,top.indexOf("p")));
    }
    this.setLeft = function(l) {
        left = l + "px";
    }
    this.getLeft = function() {
        return parseInt(left.substring(0,left.indexOf("p")));
    }
    this.setBgcolor = function(c) {
        bgcolor = c;
    }
    this.setSld = function(b){
        sld = b;
    }
    this.getSld = function() {
        return sld;
    }
    this.setZIndex = function(z) {
        zIndex = z;
    }
    this.setText = function(t){
        text = t;
    }
    this.remove = function() {
        _parent.removeChild(document.getElementById(id));
    }
    this.draw = function() {
        var oDiv = document.createElement("div");
        oDiv.id = id;
        oDiv.style.position = "absolute";
        oDiv.style.top = top;
        oDiv.style.left = left;
        oDiv.style.width = width;
        oDiv.style.height = height;
        oDiv.style.lineHeight = height;
        oDiv.style.backgroundColor = bgcolor;
        oDiv.style.border = "solid 1px #7f9fcf";
        oDiv.style.cursor = "pointer";
        oDiv.style.zIndex = zIndex;
        oDiv.title = id;
        oDiv.innerHTML = text;
        oDiv.onclick = function(){
            doSelect(self,_parent);
        }
        _parent.appendChild(oDiv);
    }
}
</script>