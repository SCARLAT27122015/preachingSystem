function properCase(str) {
	str = str.toLowerCase();
	var lcStr = str.toLowerCase();
    	return lcStr.replace(/(?:^|\s)\w/g, function(match) {
       	 	return match.toUpperCase();
    });	
}

function lowerCase(str){
	return str.toLowerCase();
}

function numericOnly(str){
    // Filter non-digits from input value.
    str = str.replace(/\D/g, '');
    return str;
}

function showMessage(){
	setTimeout(()=>{$(".alert").fadeOut(1000);},4000);
}

function extractIDs(str){
    length_id = str.length;
    divider = str.indexOf('_');
    theId = str.substring(divider + 1, length_id);
    return theId;
}

function capitalized(str) {
    lower = str.toLowerCase();
    Capitalized = lower.charAt(0).toUpperCase() + lower.slice(1);
    return Capitalized;
}
