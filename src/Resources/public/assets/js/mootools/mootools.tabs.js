var AccessibleTabs = new Class({
	Implements : [Options, Events],
	keyCodes : {
		37 : -1,
		38 : -1,
		39 : +1,
		40 : +1
	},
	debug : function debug(a) {
		if (this.options.debug && window.console && window.console.log) {
			window.console.log(a);
		}
	},
	options : {
		wrapperClass : "content",
		currentClass : "current",
		tabhead : "h4",
		tabheadClass : "tabhead",
		tabbody : ".tabbody",
		fx : "show",
		fxspeed : "normal",
		currentInfoText : "current tab: ",
		currentInfoPosition : "prepend",
		currentInfoClass : "current-info",
		tabsListClass : "tabs-list",
		syncheights : false,
		syncHeightsClassName : "SyncHeight",
		debug : true,
		clearfixClass : "block",
		responsive: true,
		responsiveToggleClass: "open"
	},
	getUniqueId : function(a) {
		return a + new Date().getTime();
	},
	initialize : function(a, b) {
		var c = this.elements = $$(a);
		var o = this.options;
		
		var data = {};
		var d = new Object();
		var prefix = "cbat-";
		$H(o).each(function(value, key){

		    var k = key.replace(/([a-z])([A-Z])/g, '$1-$2').toLowerCase();
		    var v = c.get("data-" + prefix + k);
		    if(v !== undefined && v != "") {
		    	data[key] = v.toString();
		    }
		});
	
		this.setOptions(data,b);
		switch(o.fx) {
			case"fadeIn":
				this.addEvent("showContent", function(d) {
					d.preventDefault();
					d.contentElement.setStyle("opacity", 0).show().get("tween", {
						property : "opacity",
						duration : this.options.fxspeed
					}).start(1);
				});
				break;
			case"slideDown":
				if ($defined(Fx.Slide)) {
				}
				break;
		}
		c.each(function(d) {
			this.makeElement(d);
		}, this);
		return this;
	},
	makeElement : function(m) {
		m = document.id(m);
		var l = this, a = 0, b = l.getUniqueId("accessibletabscontent"), k = l.getUniqueId("accessibletabs"), j = new Element("div", {
			"class" : this.options.wrapperClass
		}), e = [], g = new Element("span", {
			"class" : this.options.currentInfoClass,
			text : this.options.currentInfoText
		}), h = m.getChildren(), i, c;
		j.inject(m, "top");
		j.adopt(h);
		m.getElements(l.options.tabhead).each(function(o, n) {
			var p = "";
			c = o.get("tag");
			e[n] = new Element("li").adopt(new Element("a", {
				href : "#" + b,
				text : o.get("text")
			}));
			if (n === 0) {
				e[n].getFirst().set("id", k);
				i = e[n].getFirst().get("text");
			}
			o.dispose();
			a++;
		});
		var f = new Element("ul", {
			"class" : l.options.clearfixClass + " " + l.options.tabsListClass + " tabamount" + a
		}).adopt(e);
		f.inject(m, "top");
		m.getElements(l.options.tabbody).each(function(o, n) {
			if (n != 0) {
				o.hide();
			}
		});
		j.grab(new Element(c, {
			"class" : l.options.tabheadClass
		}).grab(new Element("a", {
			tabindex : "0",
			"class" : "accessibletabsanchor",
			name : b,
			id : b,
			text : i
		})), "top");
		m.getElement("ul").getChildren()[0].addClass(l.options.currentClass).getChildren("a")[0].grab(g, (l.options.currentInfoPosition == "prepend") ? "top" : "bottom");
		var d = $(b);
		if (l.options.syncheights && l.options.syncHeightsClassName) {
			new window[l.options.syncHeightsClassName](m.getElements(l.options.tabbody));
		}
		m.getElements("ul." + l.options.tabsListClass + ">li>a").each(function(o, n) {
			o.addEvent("click", function(r) {
				var s = 0;

				if(l.options.responsive == true) {
					
					if(this.getParent('li').hasClass(l.options.currentClass)) {
						m.getElement("ul." + l.options.tabsListClass).addClass(l.options.responsiveToggleClass);
					} else {
						m.getElement("ul." + l.options.tabsListClass).removeClass(l.options.responsiveToggleClass);
					}
					
				}
				s = m.getElement("ul." + l.options.tabsListClass + " li." + l.options.currentClass).removeClass(l.options.currentClass).getAllPrevious().length;
				g.dispose();
				o.blur();
				var q = {
					contentElement : m.getElements(l.options.tabbody)[s],
					tabsElement : m,
					pd : false,
					preventDefault : function() {
						this.pD = true;
					}
				};
				l.fireEvent("hideContent", q);
				if (!q.pd) {
					q.contentElement.hide();
				}
				q.pd = false;
				q.contentElement = m.getElements(l.options.tabbody)[n];
				l.fireEvent("showContent", q);
				if (!q.pd) {
					q.contentElement.show();
				}
				var t = function(u) {
					if (l.keyCodes[u.code]) {
						l.showAccessibleTab(n + l.keyCodes[u.code], m);
						d.removeEvents("keyup");
						l.debug(n);
					}
				};
				d.set({
					text : o.get("text")
				});
				d.focus();
				d.addEvent("keyup", t);
				o.grab(g, (l.options.currentInfoPosition == "prepend") ? "top" : "bottom").getParent().addClass(l.options.currentClass);
				return false;
			});
			var p = function(q) {
				$(document).addEvent("keyup", function(r) {
					if (l.keyCodes[r.code]) {
						l.showAccessibleTab(n + l.keyCodes[r.code], m);
					}
				});
			};
			o.addEvent("focus", p);
			o.addEvent("blur", function(q) {
				$(document).removeEvents("keyup");
			});
		});
		return l;
	},
	showAccessibleTab : function(a, b) {
		b = document.id(b);
		this.debug("showAccessibleTab");
		this.debug(a);
		var c = b.getElements("ul." + this.options.tabsListClass + " li a");
		if (a < 0) {
			c[0].fireEvent("click");
		} else {
			if (a >= c.length) {
				c[c.length - 1].fireEvent("click");
			} else {
				c[a].fireEvent("click");
			}
		}
		return this;
	}
}); 
