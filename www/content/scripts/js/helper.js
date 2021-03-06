/* 
 * Helper class
 * Created by Mihael Isaev
 */

helper = {}

helper.getRandomInt = function(min, max) {
    return Math.floor(Math.random() * (max - min + 1)) + min;
}

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

function print_r(arr, level) {
    var print_red_text = "";
    if(!level) level = 0;
    var level_padding = "";
    for(var j=0; j<level+1; j++) level_padding += "    ";
    if(typeof(arr) == 'object') {
        for(var item in arr) {
            var value = arr[item];
            if(typeof(value) == 'object') {
                print_red_text += level_padding + "'" + item + "' :\n";
                print_red_text += print_r(value,level+1);
		} 
            else 
                print_red_text += level_padding + "'" + item + "' => \"" + value + "\"\n";
        }
    } 

    else  print_red_text = "===>"+arr+"<===("+typeof(arr)+")";
    return print_red_text;
}