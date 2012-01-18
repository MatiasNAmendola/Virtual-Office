/* 
 * Helper class
 * Created by Mihael Isaev
 */


/**
 * Browser checker
 * @return boolean true/false
 */
function isGoogleChrome(){
    if(navigator.userAgent.toLowerCase().indexOf('chrome') > -1)
        return true;
    else
        return false;
}

function getTopCoordinateForCenterVertical(element){
    var result = 0;
    var heightElement = $(element).outerHeight();
    var heightWindow = document.body.clientHeight;
    alert('heightElement = '+heightElement);
    alert('heightWindow = '+heightWindow);
    if(heightWindow>heightElement)
        result = (heightWindow/2)-(heightElement/100*70);
    return result;
}

function StringBuffer()
{
  this.buffer = [];
}

StringBuffer.prototype.append = function(string) 
{ 
  this.buffer.push(string); 
  return this; 
} 

StringBuffer.prototype.toString = function()
{ 
  return this.buffer.join(""); 
}