/*
	Filename         : 
	Last modified by : jalal
	Created          : 07/21/2000 13:10:11
	Last Updated     : 07/21/2000 13:10:11
	Comments         : 
*/

function Cookie(document, name, hours, path, domain, secure) {
  // all the predefined properties of this object begin with '$'
  // to distinguish them from other properties which are the values to
  // be stored in the cookie.
  this.$document = document;
  this.$name = name;
  if( hours )
    this.$expiration = new Date( (new Date()).getTime() + hours * 3600000 );
  else  
    this.$expiration = null;
  if( path ) this.$path = path; else this.$path = null;
  if( domain ) this.$domain = domain; else this.$domain = null;
  if( secure ) this.$secure = true; else this.$secure = false;
}

function _Cookie_store() {
  // first loop through the properties of the Cookie object and
  // put together the value of the cookie. Since cookies use the 
  // equals sign and semicolons as separators, we'll use colons
  // and ampersands for the individual state variables we store
  // within a single cookie value. Note that we escape the value 
  // of each state variable, in case it contains punctuation or other 
  // illegal characters.
  var cookieval = "";
  for( var prop in this ) {
    // ignore properties with name that start with '$'
    if( (prop.charAt(0) == '$') || ((typeof this[prop]) == 'function') ) continue;
    if( cookieval != "" ) cookieval += '&';
    cookieval += prop + ':' + escape(this[prop]);
  }
  // Now that we have the value of the cookie, put together th
  // complete cookie string, which includes the name and the various
  // attributes specified when the Cookie object was created
  var cookie = this.$name + '=' + cookieval;
  if( this.$expiration )
    cookie += '; expires=' + this.$expiration.toGMTString();
  if( this.$path ) cookie += '; path=' + this.$path;
  if( this.$domain ) cookie += '; domain=' + this.$domain;
  if( this.$secure ) cookie += '; secure';
  
  // now store the cookie by setting the magic Document.cookie property
  this.$document.cookie = cookie;
}//

// the load method of the Cookie object
function _Cookie_load() {
  // first, get a list of all cookies that pertain to this document.
  // by reading the magic document.cookie property
  var allcookies = this.$document.cookie;
  if( allcookies == "" ) return false;
  
  // now extract just the named cookie from that list.
  var start = allcookies.indexOf( this.$name + '=' );
  if( start == -1 ) return false;
  start += this.$name.length + 1; // + '=' sign
  var end = allcookies.indexOf(':', start);
  if( end == -1) end = allcookies.length;
  var cookieval = allcookies.substring( start, end );
  
  // now that we have that cookie, break it down into individual variables
  // name/value pairs are seperated from each other with ampersands and
  // names are seperated from values with colons
  var a = cookieval.split( '&' );
  for( var i=0; i < a.length; i++) {
    a[i] = a[i].split( ':' );
  }
  // store the names and values into this cookie object.
  for( var i = 0; i < a.length; i++ ) {
    this[a[i][0]] = unescape( a[i][1] );
  }
  return true;
}// _Cookie_load()

function _Cookie_remove() {
  var cookie;
  cookie = this.$name + '=';
  if( this.$path ) cookie += '; path=' + this.$path;
  if( this.$domain ) cookie += '; domain=' + this.$domain;
  cookie += '; expires=Fri, 02-Jan-1970 00:00:00 GMT';
  this.$document.cookie = cookie;
}

// create a dummy cookie object so that we can use the prototype object
// to make the functions above into methods
new Cookie();
Cookie.prototype.store = _Cookie_store;
Cookie.prototype.load = _Cookie_load;
Cookie.prototype.remove = _Cookie_remove;


