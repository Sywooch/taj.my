/*cookie*/!function(a){"function"==typeof define&&define.amd?define(["jquery"],a):"object"==typeof exports?a(require("jquery")):a(jQuery)}(function(a){function b(a){return h.raw?a:encodeURIComponent(a)}function c(a){return h.raw?a:decodeURIComponent(a)}function d(a){return b(h.json?JSON.stringify(a):String(a))}function e(a){0===a.indexOf('"')&&(a=a.slice(1,-1).replace(/\\"/g,'"').replace(/\\\\/g,"\\"));try{return a=decodeURIComponent(a.replace(g," ")),h.json?JSON.parse(a):a}catch(b){}}function f(b,c){var d=h.raw?b:e(b);return a.isFunction(c)?c(d):d}var g=/\+/g,h=a.cookie=function(e,g,i){if(void 0!==g&&!a.isFunction(g)){if(i=a.extend({},h.defaults,i),"number"==typeof i.expires){var j=i.expires,k=i.expires=new Date;k.setTime(+k+864e5*j)}return document.cookie=[b(e),"=",d(g),i.expires?"; expires="+i.expires.toUTCString():"",i.path?"; path="+i.path:"",i.domain?"; domain="+i.domain:"",i.secure?"; secure":""].join("")}for(var l=e?void 0:{},m=document.cookie?document.cookie.split("; "):[],n=0,o=m.length;o>n;n++){var p=m[n].split("="),q=c(p.shift()),r=p.join("=");if(e&&e===q){l=f(r,g);break}e||void 0===(r=f(r))||(l[q]=r)}return l};h.defaults={},a.removeCookie=function(b,c){return void 0===a.cookie(b)?!1:(a.cookie(b,"",a.extend({},c,{expires:-1})),!a.cookie(b))}});
// jQuery Mask Plugin v1.14.10
// github.com/igorescobar/jQuery-Mask-Plugin
var $jscomp={scope:{},findInternal:function(a,f,c){a instanceof String&&(a=String(a));for(var l=a.length,g=0;g<l;g++){var b=a[g];if(f.call(c,b,g,a))return{i:g,v:b}}return{i:-1,v:void 0}}};$jscomp.defineProperty="function"==typeof Object.defineProperties?Object.defineProperty:function(a,f,c){if(c.get||c.set)throw new TypeError("ES3 does not support getters and setters.");a!=Array.prototype&&a!=Object.prototype&&(a[f]=c.value)};
$jscomp.getGlobal=function(a){return"undefined"!=typeof window&&window===a?a:"undefined"!=typeof global&&null!=global?global:a};$jscomp.global=$jscomp.getGlobal(this);$jscomp.polyfill=function(a,f,c,l){if(f){c=$jscomp.global;a=a.split(".");for(l=0;l<a.length-1;l++){var g=a[l];g in c||(c[g]={});c=c[g]}a=a[a.length-1];l=c[a];f=f(l);f!=l&&null!=f&&$jscomp.defineProperty(c,a,{configurable:!0,writable:!0,value:f})}};
$jscomp.polyfill("Array.prototype.find",function(a){return a?a:function(a,c){return $jscomp.findInternal(this,a,c).v}},"es6-impl","es3");
(function(a,f,c){"function"===typeof define&&define.amd?define(["jquery"],a):"object"===typeof exports?module.exports=a(require("jquery")):a(f||c)})(function(a){var f=function(b,h,e){var d={invalid:[],getCaret:function(){try{var a,n=0,h=b.get(0),e=document.selection,k=h.selectionStart;if(e&&-1===navigator.appVersion.indexOf("MSIE 10"))a=e.createRange(),a.moveStart("character",-d.val().length),n=a.text.length;else if(k||"0"===k)n=k;return n}catch(A){}},setCaret:function(a){try{if(b.is(":focus")){var p,
d=b.get(0);d.setSelectionRange?d.setSelectionRange(a,a):(p=d.createTextRange(),p.collapse(!0),p.moveEnd("character",a),p.moveStart("character",a),p.select())}}catch(z){}},events:function(){b.on("keydown.mask",function(a){b.data("mask-keycode",a.keyCode||a.which);b.data("mask-previus-value",b.val())}).on(a.jMaskGlobals.useInput?"input.mask":"keyup.mask",d.behaviour).on("paste.mask drop.mask",function(){setTimeout(function(){b.keydown().keyup()},100)}).on("change.mask",function(){b.data("changed",!0)}).on("blur.mask",
function(){c===d.val()||b.data("changed")||b.trigger("change");b.data("changed",!1)}).on("blur.mask",function(){c=d.val()}).on("focus.mask",function(b){!0===e.selectOnFocus&&a(b.target).select()}).on("focusout.mask",function(){e.clearIfNotMatch&&!g.test(d.val())&&d.val("")})},getRegexMask:function(){for(var a=[],b,d,e,k,c=0;c<h.length;c++)(b=m.translation[h.charAt(c)])?(d=b.pattern.toString().replace(/.{1}$|^.{1}/g,""),e=b.optional,(b=b.recursive)?(a.push(h.charAt(c)),k={digit:h.charAt(c),pattern:d}):
a.push(e||b?d+"?":d)):a.push(h.charAt(c).replace(/[-\/\\^$*+?.()|[\]{}]/g,"\\$&"));a=a.join("");k&&(a=a.replace(new RegExp("("+k.digit+"(.*"+k.digit+")?)"),"($1)?").replace(new RegExp(k.digit,"g"),k.pattern));return new RegExp(a)},destroyEvents:function(){b.off("input keydown keyup paste drop blur focusout ".split(" ").join(".mask "))},val:function(a){var d=b.is("input")?"val":"text";if(0<arguments.length){if(b[d]()!==a)b[d](a);d=b}else d=b[d]();return d},calculateCaretPosition:function(a,d){var h=
d.length,e=b.data("mask-previus-value")||"",k=e.length;8===b.data("mask-keycode")&&e!==d?a-=d.slice(0,a).length-e.slice(0,a).length:e!==d&&(a=a>=k?h:a+(d.slice(0,a).length-e.slice(0,a).length));return a},behaviour:function(e){e=e||window.event;d.invalid=[];var h=b.data("mask-keycode");if(-1===a.inArray(h,m.byPassKeys)){var h=d.getMasked(),c=d.getCaret();setTimeout(function(a,b){d.setCaret(d.calculateCaretPosition(a,b))},10,c,h);d.val(h);d.setCaret(c);return d.callbacks(e)}},getMasked:function(a,b){var c=
[],p=void 0===b?d.val():b+"",k=0,g=h.length,f=0,l=p.length,n=1,v="push",w=-1,r,u;e.reverse?(v="unshift",n=-1,r=0,k=g-1,f=l-1,u=function(){return-1<k&&-1<f}):(r=g-1,u=function(){return k<g&&f<l});for(var y;u();){var x=h.charAt(k),t=p.charAt(f),q=m.translation[x];if(q)t.match(q.pattern)?(c[v](t),q.recursive&&(-1===w?w=k:k===r&&(k=w-n),r===w&&(k-=n)),k+=n):t===y?y=void 0:q.optional?(k+=n,f-=n):q.fallback?(c[v](q.fallback),k+=n,f-=n):d.invalid.push({p:f,v:t,e:q.pattern}),f+=n;else{if(!a)c[v](x);t===x?
f+=n:y=x;k+=n}}p=h.charAt(r);g!==l+1||m.translation[p]||c.push(p);return c.join("")},callbacks:function(a){var f=d.val(),p=f!==c,g=[f,a,b,e],k=function(a,b,d){"function"===typeof e[a]&&b&&e[a].apply(this,d)};k("onChange",!0===p,g);k("onKeyPress",!0===p,g);k("onComplete",f.length===h.length,g);k("onInvalid",0<d.invalid.length,[f,a,b,d.invalid,e])}};b=a(b);var m=this,c=d.val(),g;h="function"===typeof h?h(d.val(),void 0,b,e):h;m.mask=h;m.options=e;m.remove=function(){var a=d.getCaret();d.destroyEvents();
d.val(m.getCleanVal());d.setCaret(a);return b};m.getCleanVal=function(){return d.getMasked(!0)};m.getMaskedVal=function(a){return d.getMasked(!1,a)};m.init=function(c){c=c||!1;e=e||{};m.clearIfNotMatch=a.jMaskGlobals.clearIfNotMatch;m.byPassKeys=a.jMaskGlobals.byPassKeys;m.translation=a.extend({},a.jMaskGlobals.translation,e.translation);m=a.extend(!0,{},m,e);g=d.getRegexMask();if(c)d.events(),d.val(d.getMasked());else{e.placeholder&&b.attr("placeholder",e.placeholder);b.data("mask")&&b.attr("autocomplete",
"off");c=0;for(var f=!0;c<h.length;c++){var l=m.translation[h.charAt(c)];if(l&&l.recursive){f=!1;break}}f&&b.attr("maxlength",h.length);d.destroyEvents();d.events();c=d.getCaret();d.val(d.getMasked());d.setCaret(c)}};m.init(!b.is("input"))};a.maskWatchers={};var c=function(){var b=a(this),c={},e=b.attr("data-mask");b.attr("data-mask-reverse")&&(c.reverse=!0);b.attr("data-mask-clearifnotmatch")&&(c.clearIfNotMatch=!0);"true"===b.attr("data-mask-selectonfocus")&&(c.selectOnFocus=!0);if(l(b,e,c))return b.data("mask",
new f(this,e,c))},l=function(b,c,e){e=e||{};var d=a(b).data("mask"),h=JSON.stringify;b=a(b).val()||a(b).text();try{return"function"===typeof c&&(c=c(b)),"object"!==typeof d||h(d.options)!==h(e)||d.mask!==c}catch(u){}},g=function(a){var b=document.createElement("div"),c;a="on"+a;c=a in b;c||(b.setAttribute(a,"return;"),c="function"===typeof b[a]);return c};a.fn.mask=function(b,c){c=c||{};var e=this.selector,d=a.jMaskGlobals,h=d.watchInterval,d=c.watchInputs||d.watchInputs,g=function(){if(l(this,b,
c))return a(this).data("mask",new f(this,b,c))};a(this).each(g);e&&""!==e&&d&&(clearInterval(a.maskWatchers[e]),a.maskWatchers[e]=setInterval(function(){a(document).find(e).each(g)},h));return this};a.fn.masked=function(a){return this.data("mask").getMaskedVal(a)};a.fn.unmask=function(){clearInterval(a.maskWatchers[this.selector]);delete a.maskWatchers[this.selector];return this.each(function(){var b=a(this).data("mask");b&&b.remove().removeData("mask")})};a.fn.cleanVal=function(){return this.data("mask").getCleanVal()};
a.applyDataMask=function(b){b=b||a.jMaskGlobals.maskElements;(b instanceof a?b:a(b)).filter(a.jMaskGlobals.dataMaskAttr).each(c)};g={maskElements:"input,td,span,div",dataMaskAttr:"*[data-mask]",dataMask:!0,watchInterval:300,watchInputs:!0,useInput:!/Chrome\/[2-4][0-9]|SamsungBrowser/.test(window.navigator.userAgent)&&g("input"),watchDataMask:!1,byPassKeys:[9,16,17,18,36,37,38,39,40,91],translation:{0:{pattern:/\d/},9:{pattern:/\d/,optional:!0},"#":{pattern:/\d/,recursive:!0},A:{pattern:/[a-zA-Z0-9]/},
S:{pattern:/[a-zA-Z]/}}};a.jMaskGlobals=a.jMaskGlobals||{};g=a.jMaskGlobals=a.extend(!0,{},g,a.jMaskGlobals);g.dataMask&&a.applyDataMask();setInterval(function(){a.jMaskGlobals.watchDataMask&&a.applyDataMask()},g.watchInterval)},window.jQuery,window.Zepto);
/*! jQuery Editable*/
!function(a){a.extend(a.expr[":"],{nic:function(a,b,c,d){return!((a.textContent||a.innerText||"").toLowerCase().indexOf((c[3]||"").toLowerCase())>=0)}}),a.fn.editableSelect=function(b){var c={filter:!0,effect:"default",duration:"fast",onCreate:null,onShow:null,onHide:null,onSelect:null},d=this.clone(),e=a('<input type="text">'),f=a('<ul class="es-list">');switch(b=a.extend({},c,b),b.effects){case"default":case"fade":case"slide":break;default:b.effects="default"}(isNaN(b.duration)||"fast"!=b.duration||"slow"!=b.duration)&&(b.duration="fast"),this.replaceWith(e);var g={init:function(){var c=this;c.copyAttributes(d,e),e.addClass("es-input"),f.appendTo(b.appendTo||e.parent()),d.find("option").each(function(){var b=a("<li>"),d=a(this);b.data("value",d.val()),b.html(d.text()),c.copyAttributes(this,b),f.append(b),a(this).attr("selected")&&e.val(d.text())}),e.on("focus input click",c.show),a(document).on("click",function(b){a(b.target).is(e)||a(b.target).is(f)||c.hide()}),c.initializeList(),c.initializeEvents(),b.onCreate&&b.onCreate.call(this,e)},initializeList:function(){var b=this;f.find("li").each(function(){a(this).on("mousemove",function(){f.find(".selected").removeClass("selected"),a(this).addClass("selected")}),a(this).on("click",function(){b.setField.call(this,b)})}),f.mouseenter(function(){f.find("li.selected").removeClass("selected")})},initializeEvents:function(){var a=this;e.bind("input keydown",function(b){switch(b.keyCode){case 40:a.show();var c=f.find("li:visible"),d=c.filter("li.selected");f.find(".selected").removeClass("selected"),d=c.eq(d.size()>0?c.index(d)+1:0),d=(d.size()>0?d:f.find("li:visible:first")).addClass("selected"),a.scroll(d,!0);break;case 38:a.show();var c=f.find("li:visible"),d=c.filter("li.selected");f.find("li.selected").removeClass("selected"),d=c.eq(d.size()>0?c.index(d)-1:-1),(d.size()>0?d:f.find("li:visible:last")).addClass("selected"),a.scroll(d,!1);break;case 13:f.is(":visible")&&(a.setField.call(f.find("li.selected"),a),b.preventDefault());case 9:case 27:a.hide();break;default:a.show()}})},show:function(){f.find("li").show(),f.css({top:e.position().top+e.outerHeight()-1,left:e.position().left,width:e.outerWidth()});var a=b.filter?f.find("li:nic("+e.val()+")").hide().size():0;if(a==f.find("li").size())f.hide();else switch(b.effects){case"fade":f.fadeIn(b.duration);break;case"slide":f.slideDown(b.duration);break;default:f.show(b.duration)}b.onShow&&b.onShow.call(this,e)},hide:function(){switch(b.effects){case"fade":f.fadeOut(b.duration);break;case"slide":f.slideUp(b.duration);break;default:f.hide(b.duration)}b.onHide&&b.onHide.call(this,e)},scroll:function(b,c){var d=0,e=f.find("li:visible").index(b);f.find("li:visible").each(function(b,c){b<e&&(d+=a(c).outerHeight())}),(d+b.outerHeight()>=f.scrollTop()+f.outerHeight()||d<=f.scrollTop())&&(c?f.scrollTop(d+b.outerHeight()-f.outerHeight()):f.scrollTop(d))},copyAttributes:function(b,c){var d=a(b)[0].attributes;for(var e in d)a(c).attr(d[e].nodeName,d[e].nodeValue);a(c).data(a(b).data())},setField:function(c){return!!a(this).is("li:visible")&&(e.val(a(this).text()),c.hide(),void(b.onSelect&&b.onSelect.call(e,a(this))))}};return g.init(),e}}(jQuery);
jQuery('input[name="checkout_customer\[main_telephone\]"]').attr('placeholder','( ___ ) ___ - ____ )').mask('( 000 ) 000 - 0000');
function gotopage(url) {
	document.location = url;
}
EeProcessor = {
		productImpressions: function (products) {
		   dataLayer.push({
			   'ecommerce': {
				   'currencyCode': 'UAH',
				   'impressions': products
			   }
		   });
		},
		productClick: function (products, url) {
			setTimeout(function(){
				gotopage(url);
				console.log('Force changed location');
			}, 1000)
		   dataLayer.push({
			   'event': 'productClick',
			   'ecommerce': {
				   'click': {
						'actionField': {'list': products[0].list},
						'products': products
				   }
			   },
			   'eventCallback': function() {
				   gotopage(url);
			   }
		   });
		   console.log(url);
		   if (typeof google_tag_manager == "undefined") {
			 document.location = url;
		   }
		},

		productDetails: function(products){
		   dataLayer.push({
			   'ecommerce': {
				   'detail': {
					   'actionField': {'list': 'product'},
					   'products': products
				   }
			   }
		   });
		},
		
		addToCart: function (products) {
		   dataLayer.push({
			   'event': 'addToCart',
			   'ecommerce': {
				   'currencyCode': 'UAH',
				   'add': {
					'actionField': {'list': products[0].list},	
		'products': products
				   }
			   }
		   });
		},

		removeFromCart: function (products) {
		   dataLayer.push({
			   'event': 'removeFromCart',
			   'ecommerce': {
				   'remove': {
					   'products': products
				   }
			   }
		   });
		},

		promotionImpressions: function (promotions) {
		   dataLayer.push({
			   'ecommerce': {
				   'promoView': {
					   'promotions': promotions
				   }
			   }
		   });
		},
		
		promotionClicks: function (promotions, url) {
		   dataLayer.push({
			   'event': 'promotionClick',
			   'ecommerce': {
				   'promoClick': {
					   'promotions': promotions
				   }
			   },
			   'eventCallback': function () {
				   document.location = url;
			   }
		   });
		 
		   if (typeof google_tag_manager == "undefined") {
			 document.location = url;
		   }
		},
		
		cartEnter: function(products, url){
		   dataLayer.push({
			   'event': 'checkout',
			   'ecommerce': {
				   'checkout': {
					   'products': products
				   }
			   },
			   'eventCallback': function() {
				   document.location = url;
			   }
		   });
		 
		   if (typeof google_tag_manager == "undefined") {
			 document.location = url;
		   }
		},
		
		checkoutSteps: function (step, optionVal, products, url) {
		   var data = {
			   'event': 'checkout',
			   'ecommerce': {
				   'checkout': {
					   'actionField': {'step': step, 'option': optionVal},
					   'products': products
				   }
			   }
		   };
		   if (typeof url != "undefined") {
			   data.eventCallback = function () {document.location = url;};
		 
		 if (typeof google_tag_manager == "undefined") {
		   document.location = url;
		 }
		   }
		   dataLayer.push(data);
		},
		checkoutOption: function (step, optionVal, url) {
		   var data = {
			   'event': 'checkoutOption',
			   'ecommerce': {
				   'checkout_option': {
					   'actionField': {'step': step, 'option': optionVal}
				   }
			   }
		   };
		 
		   if (typeof url != "undefined") {
			   data.eventCallback = function () {
				   document.location = url;
			   };
		 
			 if (typeof google_tag_manager == "undefined") {
		   document.location = url;
		 }
		   }
		 
		   dataLayer.push(data);
		}
	};

$(document).ready(function() {
	jQuery('div#menu a').click(function(fn) {
		fn.preventDefault();
		chn=jQuery(this).parent().children('.submenu');
		
		if(chn.size()<1) {
			if(location.pathname.substr(0,11)=="/autoparts/"&&location.pathname.split("/").length - 1>=5) {
				var url=location.pathname.split("/");
				var get=location.search.substr(4).split(";");
				var nget=[];
				for(var i=0;i<get.length;i++) {
					if(get[i][0]=='m') nget[0]=get[i];
					if(get[i][0]=='t') nget[1]=get[i];
				}
				location.href="/"+url[1]+"/"+url[2]+"/"+url[3]+"/"+url[4]+"/"+jQuery(this).attr('href').substr(1)+"/?of="+nget[0]+";"+nget[1]+";s"+jQuery(this).attr('attr-section_id');
			} else if(location.pathname=="/"){ 
				$('html, body').animate({
					scrollTop: $(".home-filter-block").offset().top
				}, 500);
				location.hash=jQuery(this).attr("href");
				jQuery('.filter-item.active input, .filter-item.active select').click();
			} else
			location.href="#"+jQuery(this).attr('href');
		} else {
			if(chn.hasClass('showSub')) 
				chn.removeClass('showSub');
			else chn.addClass('showSub');
		}
	});
	/* Ajax Cart */
	$('#cart').click(function() {
		$('#cart').addClass('active');
		$('#cart').load('index.php?route=module/cart #cart > *');
	});
	$('#cart').hover(function() { }, function() {
		$(this).removeClass('active');
	});
	$('.success img, .warning img, .attention img, .information img').on('click', function() {
		$(this).parent().fadeOut('slow', function() {
			$(this).remove();
		});
	});	
	$('.menu-toggle').click(function() {
		if(jQuery('div#menu>ul:hidden').size()>0)
			jQuery('div#menu>ul').addClass('showMenu');
		else
			jQuery('div#menu>ul').removeClass('showMenu');
	});
});
function getURLVar(key) {
	var value = [];
	var query = String(document.location).split('?');
	if (query[1]) {
		var part = query[1].split('&');
		for (i = 0; i < part.length; i++) {
			var data = part[i].split('=');
			if (data[0] && data[1]) {
				value[data[0]] = data[1];
			}
		}
		if (value[key]) {
			return value[key];
		} else {
			return '';
		}
	}
} 
function addToCart(product_id, quantity) {
	quantity = typeof(quantity) != 'undefined' ? quantity : 1;
	$.ajax({
		url: 'index.php?route=checkout/cart/add',
		type: 'post',
		data: 'product_id=' + product_id + '&quantity=' + quantity,
		dataType: 'json',
		success: function(json) {
			$('.success, .warning, .attention, .information, .error').remove();
			
			if (json['redirect']) {location = json['redirect'];}
			if (json['success']) {		
				$('#notification').html('<div class="success" style="display: none;">' + json['success'] + '<img src="catalog/view/theme/default/image/close.png" alt="" class="close" /></div>');
				$('.success').fadeIn('slow');
				$('#cart-total').html(json['total']);
				$('html, body').animate({ scrollTop: 0 }, 'slow'); 
			}	
		}
	});
}

function addToWishList(product_id) {
	$.ajax({
		url: 'index.php?route=account/wishlist/add',
		type: 'post',
		data: 'product_id=' + product_id,
		dataType: 'json',
		success: function(json) {
			$('.success, .warning, .attention, .information').remove();	
			if (json['success']) {
				$('#notification').html('<div class="success" style="display: none;">' + json['success'] + '<img src="catalog/view/theme/default/image/close.png" alt="" class="close" /></div>');
				$('.success').fadeIn('slow');
				$('#wishlist-total').html(json['total']);
				$('html, body').animate({ scrollTop: 0 }, 'slow');
			}	
		}
	});
}
function addToCompare(product_id) { 
	$.ajax({
		url: 'index.php?route=product/compare/add',
		type: 'post',
		data: 'product_id=' + product_id,
		dataType: 'json',
		success: function(json) {
			$('.success, .warning, .attention, .information').remove();
			if (json['success']) {
				$('#notification').html('<div class="success" style="display: none;">' + json['success'] + '<img src="catalog/view/theme/default/image/close.png" alt="" class="close" /></div>');
				$('.success').fadeIn('slow');
				$('#compare-total').html(json['total']);
				$('html, body').animate({ scrollTop: 0 }, 'slow'); 
			}	
		}
	});
}
function ECommPrClick(ev,el,PageType) {
  ev.preventDefault();
  var name=jQuery(el).find('.name a').text();
  var price=jQuery(el).find('.priceVal').eq(0).text().split(' ')[0]/1;
  var url=jQuery(el).find('.name a').attr('href');
  dataLayer.push({
  'event': 'productClick',
  'ecommerce': {
    'click': {
   'actionField': {'list': PageType}, 
   'products': [{
     'name': name,                      
     'price': price
    }]
     }
   }, 'eventCallback': function() {
		 document.location = url
	   }
   });
}
