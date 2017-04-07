var Promo = {
	c: {},
	as: {},
	init: function() {
		this.c = getByID('fswitcher')
		this.as = getByTag(this.c, 'a');
		this.pc = getByID('promocontainer');
		this.p = getByTag(this.pc, 'div');
		
		asl = this.as.length;
		for(i=0;i<asl;i++)
			attachHandler(this.as[i], 'mouseover', switchPromo);
		
	},
	hideAll: function() {
		pl = this.p.length;
		for (j=0;j<pl;j++)
			this.p[j].className = 'fph';
		
	},
	hide: function(o) {
		o.className = 'fph'
	},
	show: function(o) {
		o.className = 'fps'
	},
	setActive: function(e) {
		
		var f = getTarget(e);
		var id = f.getAttribute('id').split('_')[1];
		
		pl = this.p.length;
		for (j=0;j<pl;j++) {
			this.p[j].className = 'fph';
			if (this.p[j].getAttribute('id') == id)
				this.show(this.p[j]);
			else
				this.hide(this.p[j]);
		}
		
		
		var c = f.className.split('_')[1];
		var promo = getByID('promo');
		promo.className = f.className;
	
	}
	
	
};


function switchTabs() {
	var pnl = getById("resources") || getById("infopanels");
	var t = this.id.substring(1,3);
	pnl.className = t;
	return false;
}

function activateTabs() {
		
		var numtabs;
		var func = switchTabs;
		var tabs = getById("prodtabs") || getById("itemnav");
		
		if (!tabs) return;
		
		
		
		var tabitems = tabs.getElementsByTagName('li');
		numtabs = tabitems.length;
		
		if (numtabs > 1) {
			for (i=0;i<=numtabs;i++) {
					attachEvent(tabitems[i], func);
				}
		}
}





function switchPromo(e) {
	Promo.setActive(e);
}

Promo.init();
activateTabs();