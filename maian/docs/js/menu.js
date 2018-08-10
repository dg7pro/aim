/***********************************************
* AnyLink Drop Down Menu- © Dynamic Drive (www.dynamicdrive.com)
* This notice MUST stay intact for legal use
* Visit http://www.dynamicdrive.com/ for full source code
***********************************************/

var install=new Array()
install[0]='<a href="install_1.html" title="ionCube Help">- IonCube Help<\/a>'
install[1]='<a href="install_2.html" title="Installation">- Installation<\/a>'
install[2]='<a href="install_7.html" title="E-Mail Digest">- E-Mail Digest<\/a>'
install[3]='<a href="google.html" title="reCaptcha Service">- ReCaptcha Service<\/a>'
install[4]='<a href="install_3.html" title="Template Integration">- Template Integration<\/a>'
install[5]='<a href="install_4.html" title="Language &amp; Text">- Language &amp; Text<\/a>'
install[6]='<a href="install_5.html" title="User Defined Options">- User Defined Options<\/a>'
install[7]='<a href="install_6.html" title="XML Data Posts" style="border-bottom:0">- XML-RPC (API)<\/a>'

var portal=new Array()
portal[0]='<a href="portal_1.html" title="Portal Overview">- Portal Overview<\/a>'
portal[1]='<a href="portal_2.html" title="Creating Ticket">- Creating Ticket<\/a>'
portal[2]='<a href="portal_3.html" title="F.A.Q Pages">- F.A.Q Pages<\/a>'
portal[3]='<a href="portal_4.html" title="Viewing Ticket">- Viewing Ticket<\/a>'
portal[4]='<a href="portal_5.html" title="Viewing Dispute">- Viewing Dispute<\/a>'
portal[5]='<a href="portal_6.html" title="Search Tickets" style="border-bottom:0">- Search Tickets<\/a>'

var settings=new Array()
settings[0]='<a href="settings_1.html" title="General Settings">- General Settings<\/a>'
settings[1]='<a href="settings_2.html" title="Imap Accounts">- Imap Accounts<\/a>'
settings[2]='<a href="settings_3.html" title="Custom Fields">- Custom Fields<\/a>'
settings[3]='<a href="settings_4.html" title="Priority Levels" style="border-bottom:0">- Priority Levels<\/a>'

var tickets=new Array()
tickets[0]='<a href="tickets_9.html" title="Assign Tickets">- Assign Tickets<\/a>'
tickets[1]='<a href="tickets_1.html" title="Open Tickets">- Open Tickets<\/a>'
tickets[2]='<a href="tickets_2.html" title="Closed Tickets">- Closed Tickets<\/a>'
tickets[3]='<a href="tickets_7.html" title="Viewing Tickets">- Viewing Tickets<\/a>'
tickets[4]='<a href="tickets_3.html" title="Open Disputes">- Open Disputes<\/a>'
tickets[5]='<a href="tickets_4.html" title="Closed Disputes">- Closed Disputes<\/a>'
tickets[6]='<a href="tickets_8.html" title="Viewing Disputes">- Viewing Disputes<\/a>'
tickets[7]='<a href="tickets_5.html" title="Search Tickets">- Search Tickets<\/a>'
tickets[8]='<a href="tickets_6.html" title="Standard Responses" style="border-bottom:0">- Standard Responses<\/a>'

var faq=new Array()
faq[0]='<a href="faq_1.html" title="Categories">- Categories<\/a>'
faq[1]='<a href="faq_2.html" title="Questions &amp; Answers">- Questions &amp; Answers<\/a>'
faq[2]='<a href="faq_3.html" title="Attachments" style="border-bottom:0">- Attachments<\/a>'

var tools=new Array()
tools[0]='<a href="tools_1.html" title="System Tools">- System Tools<\/a>'
tools[1]='<a href="tools_2.html" title="Import Options">- Import Options<\/a>'
tools[2]='<a href="tools_3.html" title="Portal Options">- Portal Options<\/a>'
tools[3]='<a href="tools_6.html" title="Reports">- Reports<\/a>'
tools[4]='<a href="tools_4.html" title="Entry Log">- Entry Log<\/a>'
tools[5]='<a href="tools_5.html" title="Database Backup" style="border-bottom:0">- Database Backup<\/a>'

var other=new Array()
other[0]='<a href="faq.html" title="Software F.A.Q">- Software F.A.Q<\/a>'
other[1]='<a href="other_1.html" title="Support">- Support<\/a>'
other[2]='<a href="http://www.maiansupport.com/licence.html" title="Licences" onclick="window.open(this);return false">- Licences<\/a>'
other[3]='<a href="http://www.maiansupport.com" title="Maian Support Website" onclick="window.open(this);return false">- Maian Support Website<\/a>'
other[4]='<a href="other_2.html" title="Changelog">- Changelog<\/a>'
other[5]='<a href="other_3.html" title="Script Credits">- Script Credits<\/a>'
other[6]='<a href="other_4.html" title="Bug Report" style="border-bottom:0">- Bug Report<\/a>'

var menuwidth        = '185px' //default menu width
var menubgcolor      = '#dbdbbe'  //menu bgcolor
var disappeardelay   = 275  //menu disappear speed onMouseout (in miliseconds)
var hidemenu_onclick = "yes" //hide menu when user clicks within menu?

/////No further editting needed

var ie4=document.all
var ns6=document.getElementById&&!document.all

if (ie4||ns6) {
}

function getposOffset(what, offsettype){
var totaloffset=(offsettype=="left")? what.offsetLeft : what.offsetTop;
var parentEl=what.offsetParent;
while (parentEl!=null){
totaloffset=(offsettype=="left")? totaloffset+parentEl.offsetLeft : totaloffset+parentEl.offsetTop;
parentEl=parentEl.offsetParent;
}
return totaloffset;
}


function showhide(obj, e, visible, hidden, menuwidth){
if (ie4||ns6)
dropmenuobj.style.left=dropmenuobj.style.top="-500px"
if (menuwidth!=""){
dropmenuobj.widthobj=dropmenuobj.style
dropmenuobj.widthobj.width=menuwidth
}
if (e.type=="click" && obj.visibility==hidden || e.type=="mouseover")
obj.visibility=visible
else if (e.type=="click")
obj.visibility=hidden
}

function iecompattest(){
return (document.compatMode && document.compatMode!="BackCompat")? document.documentElement : document.body
}

function clearbrowseredge(obj, whichedge){
var edgeoffset=0
if (whichedge=="rightedge"){
var windowedge=ie4 && !window.opera? iecompattest().scrollLeft+iecompattest().clientWidth-15 : window.pageXOffset+window.innerWidth-15
dropmenuobj.contentmeasure=dropmenuobj.offsetWidth
if (windowedge-dropmenuobj.x < dropmenuobj.contentmeasure)
edgeoffset=dropmenuobj.contentmeasure-obj.offsetWidth
}
else{
var topedge=ie4 && !window.opera? iecompattest().scrollTop : window.pageYOffset
var windowedge=ie4 && !window.opera? iecompattest().scrollTop+iecompattest().clientHeight-15 : window.pageYOffset+window.innerHeight-18
dropmenuobj.contentmeasure=dropmenuobj.offsetHeight
if (windowedge-dropmenuobj.y < dropmenuobj.contentmeasure){ //move up?
edgeoffset=dropmenuobj.contentmeasure+obj.offsetHeight
if ((dropmenuobj.y-topedge)<dropmenuobj.contentmeasure) //up no good either?
edgeoffset=dropmenuobj.y+obj.offsetHeight-topedge
}
}
return edgeoffset
}

function populatemenu(what){
if (ie4||ns6)
dropmenuobj.innerHTML=what.join("")
}


function dropdownmenu(obj, e, menucontents, menuwidth){
if (window.event) event.cancelBubble=true
else if (e.stopPropagation) e.stopPropagation()
clearhidemenu()
dropmenuobj=document.getElementById? document.getElementById("dropmenudiv") : dropmenudiv
populatemenu(menucontents)

if (ie4||ns6){
showhide(dropmenuobj.style, e, "visible", "hidden", menuwidth)
dropmenuobj.x=getposOffset(obj, "left")
dropmenuobj.y=getposOffset(obj, "top")
dropmenuobj.style.left=dropmenuobj.x-clearbrowseredge(obj, "rightedge")+"px"
dropmenuobj.style.top=dropmenuobj.y-clearbrowseredge(obj, "bottomedge")+obj.offsetHeight+"px"
}

return clickreturnvalue()
}

function clickreturnvalue(){
if (ie4||ns6) return false
else return true
}

function contains_ns6(a, b) {
while (b.parentNode)
if ((b = b.parentNode) == a)
return true;
return false;
}

function dynamichide(e){
if (ie4&&!dropmenuobj.contains(e.toElement))
delayhidemenu()
else if (ns6&&e.currentTarget!= e.relatedTarget&& !contains_ns6(e.currentTarget, e.relatedTarget))
delayhidemenu()
}

function hidemenu(e){
if (typeof dropmenuobj!="undefined"){
if (ie4||ns6)
dropmenuobj.style.visibility="hidden"
}
}

function delayhidemenu(){
if (ie4||ns6)
delayhide=setTimeout("hidemenu()",disappeardelay)
}

function clearhidemenu(){
if (typeof delayhide!="undefined")
clearTimeout(delayhide)
}

if (hidemenu_onclick=="yes")
document.onclick=hidemenu