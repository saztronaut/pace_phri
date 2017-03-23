// takes the text file and the element id as argument to load text from text file 
function loadText(elem, textfile){
   var xhr= new XMLHttpRequest();
   xhr.open("GET", textfile, true);
   xhr.onreadystatechange = function(){
     if (xhr.readyState==4 && xhr.status==200){
         mylinks=xhr.responseText;
         document.getElementById(elem).innerHTML = mylinks;}
	   }
   xhr.send();

}