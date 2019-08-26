var SyncHeight = new Class({
	Implements : [Options],
	browser_id : 0,
	property : [["min-height", "0px"], ["height", "1%"]],
	options : {
		updateOnResize : false
	},
	initialize : function(c, a) {
		this.setOptions(a);
		this.elements = $$(c);
		//if (Browser.Engine.trident4) {
		//	this.browser_id = 1;
		//}
		this.syncNow();
		if (this.options.updateOnResize == true) {
			var b = function() {
				this.syncNow();
			};
			b = b.bind(this);
			$(window).addEvent("resize", b);
		}
		return this;
	},
	syncNow : function() {
		var a = 0;
		this.elements.each(function(b) {
			b.setStyle(this.property[this.browser_id][0], this.property[this.browser_id][1]);
			var c = b.measure(function() {
				return this.getSize().y;
			});
			if (c > a) {
				a = c;
			}
		}, this);
		this.elements.each(function(b) {
			b.setStyle(this.property[this.browser_id][0], a + "px");
		}, this);
		return this;
	}
}); 