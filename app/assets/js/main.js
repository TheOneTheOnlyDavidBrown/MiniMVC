
	// base "class"
var base = $.inherit(/** @lends A.prototype */{
	__constructor : function(vars) { // constructor
		var cs = this;
		$(function() {
			$.extend(cs,vars);
			cs.ready();
			cs.init();
			cs.myfn();
		});
	},
	
	init : function(){
		alert('init function needs to be in the js');
	},
	ready : function(){
		alert('ready function needs to be in the js');
	},
	eventListeners : function(){
		alert('eventListeners function needs to be in the js');
	}
});

    
// inherited "class" from base
// EXAMPLE
base.functionNameHere = $.inherit(base,/** @lends B.prototype */{
	init : function(){
		
	},
	
	ready : function(){
		
	}
});
