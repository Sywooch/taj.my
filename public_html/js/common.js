function logout() {
    $.post('/user/security/logout/');
}

function searchAll() {
    $('.top__search .search_result').remove();
    $.ajax({
        url: "/ajax/product-search",
        type: 'POST',
        // Form data
        data: {
            'search' : $('input#search').val()
        },
        dataType: 'json',
        success: function (data) {
            $('.top__search').append('<div class="search_result"></div>');
            if(data['products'].length>0) {
                data['products'].forEach(function(el) {
                    cat = '<div class="bread">';
                    el['category'].forEach(function(c) {
                        cat+= '<span>'+c['name']+'</span>';
                    });
                    cat +='</div>';
                    $('.search_result').append('<div class="row"><div class="col-md-4"><img src="'+el['image']+'"></div><div class="col-md-8"><a href="'+el['url']+'">'+el['name']+'</a>'+cat+'</div></div>');
                });
            } else {
                $('.search_result').append('<div class="no-result">No results</div>');
            }
        }
    });
}

jQuery(document).ready(function () {
    let title;
    $('input.fancy[type="file"]:not(.nolabel)').each(function () {
        title = $(this).attr('attr-title');
        if(!title) title = 'Select File';
        $(this).inputfile({
            uploadText: '<div class="select_file"><span class="glyphicon glyphicon-upload"></span>'+title+'</div>',
            removeText: '<span class="glyphicon glyphicon-trash"></span>',
            restoreText: '<span class="glyphicon glyphicon-remove"></span>',

            uploadButtonClass: 'btn btn-primary',
            removeButtonClass: 'btn btn-default'
        });
    });
	
	$('.pageReport').on('click',function(e) {
		e.preventDefault();
		var form = $(this).closest('form');
		if(form.find('#comment').val()=='') {
			form.find('#comment').parent().addClass('has-error');
			return false;
		} else {
			form.find('#comment').parent().removeClass('has-error');
		}
		$.ajax({
			url: form.attr('action'),
			method: "POST",
			data: form.serialize(),
			dataType: "json",
			success: function(data) {
				if(data.result) {
					$('#comment').val('').hide(200);
					$('#commentResult').show(200);
				} else {
					alert('Some errors while sending. Please, try later.');
				}
			}
		});
	});

    $('input.fancy.nolabel[type="file"]').each(function () {
        title = $(this).attr('attr-title');
        if(!title) title = 'Select File';
        $(this).inputfile({
            uploadText: '<div class="select_file"><span class="glyphicon glyphicon-upload"></span>'+title+'</div>',
            removeText: '',
            restoreText: '',

            uploadButtonClass: 'btn btn-primary',
            removeButtonClass: 'btn btn-default',
        });
    });

    $('.product__social .like').on('click',function() {
        var ico = $(this).find('i');
        var t   = $(this).find('.count__like');
        jQuery.post({
            url:'/ajax/like-review',
            dataType: 'json',
            data: {'review_id': $(this).attr('attr-id') },
            success: function (data) {
                if(data.result) {
                    if(data.action == 'added') {
                            ico.addClass('fas');
                            ico.removeClass('far');
                            t.text(parseInt(t.text())+1);
                    } else {
                        ico.addClass('far');
                        ico.removeClass('fas');
                        t.text(parseInt(t.text())-1);
                    }
                } else {
					if(!data.logged) {
						$('#loginFirstModal').modal()
					} else 
						console.log('error')
                }
            }
        });
    });
	
	$('.like__comment, .like__diss').on('click',function() {
		var el = $(this);
		var count = el.find('.count');
		var remove = false;
		var like = false;
		var block = el.closest('.like_comment_block');
		
		if(el.hasClass('active')) {
		 remove = true;
		} 
		if(el.hasClass('like__comment')) {
		 like = true;
		} 
		
		$.ajax({ 
			url:'/ajax/like-comment', 
			method:'POST', 
			dataType: 'json',
			data: {
				'like':like,
				'comment_id':parseInt(el.closest('.review__list__item').attr('attr-id')),
				'remove': remove
			},
			success: function(data) {
				if(data.result) {
					block.find('.like__comment, .like__diss').removeClass('active');
					
					if(data.action == 'added') {
						el.addClass('active');
					} 
					
					block.find('.like__comment .count').text(data.countLike);
					block.find('.like__diss .count').text(data.countDislike);
				} else {
					if(data.logged==false) $('#loginFirstModal').modal();
				}
			}
		})
	});

    $('.review__compare').on('click',function() {
        var t   = $(this).find('span');
		var e 	= $(this);
        jQuery.post({
            url:'/ajax/add-compare',
            dataType: 'json',
            data: {'product_id': e.attr('attr-id') },
            success: function (data) {
                if(data.result) {
                    if(data.action == 'added') {
                        t.text( e.attr('attr-removed') );
                    } else {
                        t.text( e.attr('attr-added') );
                    }
					
					$('#compare_count').text( data.count );
					if(data.count>0) {
						$('#compare_count').show();
					} else {
						$('#compare_count').hide();
					}
                } else {
                    console.log('error')
                }
            }
        });
    });
    

    $('#search').keypress(function() {
        if (typeof timerSearchProduct !== 'undefined') {
            clearTimeout(timerSearchProduct);
        }

        timerSearchProduct = setTimeout(searchAll, 500);
    });

    $('.dialog__content').animate({ scrollTop: 999999 }, 100);
    $('div#send_msg').on('click',function() {
        if($('textarea#dialogform-content').val()!=='') {
            jQuery.ajax({
                url: $('form#dialog-form').attr('action'),
                type: 'POST',
                dataType: 'json',
                data: $('form#dialog-form').serialize(),
                success: function(data) {
                    if(data.result) {
                        location.reload();
					} else {	
						alert('Error. Please,contact to webmaster');
					}
                }
            });
        } else {
            $('textarea#dialog_footer-content').focus();
        }
    });
	$('#dialog_footer-title').val($('h1').text());
	$('#dialog_footer-user_to').val($('[data-target="#writeNewMsg"]').attr('attr-id'));
    $('#writeNewMsgSend').on('click',function() {
		var error = false; 
        if($('#dialog_footer-content').val()=='') {
            $('#dialog_footer-content').focus();
			error=true;
        }
        if($('#dialog_footer-title').val()=='') {
            $('#dialog_footer-title').focus();
			error=true;
        }
		if(!error) {
            jQuery.ajax({
                url: $('form#dialog_footer-form').attr('action'),
                type: 'POST',
                dataType: 'json',
                data: $('form#dialog_footer-form').serialize(),
                success: function(data) {
                    if(data.result) {
                        location.href=data.redirect;
					} else {
						alert('Error. Please,contact to webmaster');
					}
                }
            });
        } else {
            $('textarea#dialog_footer-content').focus();
		}
    });
	
	jQuery('.invite-code-create').on('click',function() {
		jQuery.ajax({
			url: '/ajax/create-invite-code',
			success: function() { 
				document.location.hash = '#codeCreated';
				document.location.reload();
			}
		});
	});

	jQuery('input[name="searchProductCompare"]').change(function() {
		let block = $(this).parent();
		jQuery.ajax({
			url: "/ajax/product-search",
			type: 'POST',
			data: {
				'search' : jQuery(this).val()
			},
			dataType: 'json',
			success: function (data) {
				jQuery('.search_result_compare').remove();
				block.append('<div class="search_result_compare"></div>');
				if(data['products'].length>0) {
					data['products'].forEach(function(el) {
						cat = '<div class="bread">';
						el['category'].forEach(function(c) {
							cat+= '<span>'+c['name']+'</span>';
						});
						cat +='</div>';
						block.find('.search_result_compare').append('<div attr-addcompare-id="'+el['id']+'" class="row"><div class="col-md-4"><img src="'+el['image']+'"></div><div class="col-md-8"><a>'+el['name']+'</a>'+cat+'</div></div>');
					});
					
					jQuery('div[attr-addcompare-id]').on('click',function() {
						let e = jQuery(this);
						jQuery.post({
							url:'/ajax/add-compare',
							dataType: 'json',
							data: {'product_id': e.attr('attr-addcompare-id') },
							success: function (data) {
								document.location.reload();
							}
						});
					});
					
				} else {
					block.find('.search_result_compare').append('<div class="no-result">No results</div>');
				}
			}
		});
	});
	
	jQuery('.copy-action').on('click',function() {
		  var copyText = jQuery(this).closest(".copyGroup").find('input');
		  copyText.attr('disabled',false);
		  copyText.select();
		  document.execCommand("copy");
		  copyText.attr('disabled',true);
		  let st = $(this).find('.tooltiptext').text();
		  let b = $(this);
		  b.find('.tooltiptext').text('Copied!')
		  setTimeout(function() {
			b.find('.tooltiptext').text(st);
		  },2000);
	});

});
/*
* Обработка клика в мобильном меню
* */
var openMenu = false;
function mainMenu () {
   var menu = document.querySelector(".main-menu");


   /*
   * обрабатываем клик по элементу
   * */
   menu.onclick = function () {
	   var lis = document.querySelectorAll(".main-menu li");
	   if (/*если закрыто*/!openMenu){
	   		for(var i = 0; i<lis.length;i++){
	   			lis[i].style.display = "unset";
	   		}
           openMenu = true;
	   }else{
           for(var i = 0; i<lis.length;i++){
               lis[i].style.display = "none";
           }

           openMenu = false;
	   }
   }
}

if( /Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent) ) {
	mainMenu();
}