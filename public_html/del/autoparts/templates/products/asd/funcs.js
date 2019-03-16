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
	
	jQuery('.box.related-box a').click(function (e) {
		if(!products||!Array.isArray(products))
			products=[];
		category=jQuery('.ProductCategories a').eq(0).text();
		e.preventDefault();
		var productBlock=jQuery(this).closest('.bx-viewport');
		products.push = {
			  "name":productBlock.find('.name>a').text(),
			  "id":jQuery(this).attr('id'),
			  "price":productBlock.find('.priceVal>.value').text()/1,
			  "brand":productBlock.find('input[name="productBrand"]').val(),
			  "category":category,
			  "list":"car/list",
			  "position":productBlock.index()+1
		}
		product.list = "product/analogs"; 
		var url = $(this).attr('href');
		EeProcessor.productClick([products], url);
	});
});
