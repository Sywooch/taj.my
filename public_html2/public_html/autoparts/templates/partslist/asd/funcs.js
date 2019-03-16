function ShowMPrices(pkey){$('.ip'+pkey).show('fast'); $('.sb'+pkey).hide(); $('.hb'+pkey).show();}
function HideMPrices(pkey){$('.ip'+pkey).hide('fast'); $('.sb'+pkey).show(); $('.hb'+pkey).hide();}

function ShowMoreListPrices(pkey){
	$('.pr'+pkey).show('fast'); $('.sb'+pkey).hide(); $('.op'+pkey).show('fast');
}

var ShowLettersFilter=0;
$(document).ready(function () {
    if(ShowLettersFilter==1){
		var ABrandsDiv=$('.bfname');
		ABrandsDiv.hide();
		var LetsDiv = $('.letfilter > a');
		LetsDiv.click(
			function (){
				FstLet=$(this).text();
				LetsDiv.removeClass("active");
				$(this).addClass("active");
				ABrandsDiv.hide();
				ABrandsDiv.each(function(i){
					var AText = $(this).eq(0).text().toUpperCase();
					if(RegExp('^' + FstLet).test(AText)) {
						$(this).fadeIn(400);
					}
				});
		});
	}
});

var FIRST_PAGE_LINK='';
function AddBrandFilter(BKEY){
	$("<form action='"+FIRST_PAGE_LINK+"' id='bfilterform' method='post'><input type='hidden' name='BRAND_FILTER' value='"+BKEY+"'/></form>").appendTo('body');
	$("#bfilterform").submit();
}

function RemoveBrandFilter(BKEY){
	$("<form action='"+FIRST_PAGE_LINK+"' id='bfilterform' method='post'><input type='hidden' name='BRAND_REMOVE' value='"+BKEY+"'/></form>").appendTo('body');
	$("#bfilterform").submit();
}


function ViewSwitch(VIEW){
	$("<form action='"+FIRST_PAGE_LINK+"' id='viewform' method='post'><input type='hidden' name='VIEW' value='"+VIEW+"'/></form>").appendTo('body');
	$("#viewform").submit();
}

function ShowMoreProps(But,TDItem){
	var curHeight = $('#'+TDItem).height();
	autoHeight = $('#'+TDItem).css('height','auto').height();
	$('#'+TDItem).height(curHeight);
	$('#'+TDItem).stop().animate({'height':autoHeight}, 500, function(){deferred.resolve();});
	$(But).hide('normal');
}
jQuery(document).ready(function() {
	products = [];
	category= jQuery('h1').text();
	pr_i=1;
	
	jQuery('.product-grid>.tditem.it').each(function() {
		products.push = {
			  "name":jQuery(this).find('.name>a').text(),
			  "id":jQuery(this).attr('id'),
			  "price":jQuery(this).find('.priceVal>.value').text()/1,
			  "brand":jQuery(this).find('input[name="productBrand"]').val(),
			  "category":category,
			  "list":"car/list",
			  "position":pr_i
		}
		pr_i++;
	});
	EeProcessor.productImpressions(products);
	

	jQuery('.product-grid a:not(.addtocart)').click(function (e) {
		e.preventDefault();
		productBlock=jQuery(this).closest('.tditem.it');
		product = [];
		product.push = {
			  "name":productBlock.find('.name>a').text(),
			  "id":jQuery(this).attr('id'),
			  "price":productBlock.find('.priceVal>.value').text()/1,
			  "brand":productBlock.find('input[name="productBrand"]').val(),
			  "category":category,
			  "list":"car/list",
			  "position":productBlock.index()+1
		}
		product.list = "car/list"; 
		var url = $(this).attr('href');
		EeProcessor.productClick([product], url);
	});
});