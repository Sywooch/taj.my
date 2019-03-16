		/*	if(location.origin=="http://ibexshop.com.ua")
				location.href="https://ibexshop.com.ua"*/
			MarkSelected = YearSelected = false;

			function GetModelTDC() {
				var url=jQuery('ul.es-list li:contains('+jQuery('.filter-select[name="filter-mark"]').eq(0).val()+')').attr('value');
				var years= jQuery('input[name="filter-year"]').val();
						if(url!=''&&(jQuery('input#filter-model').val()!=''&&jQuery('input#filter-year').val()>=1989)) {
							jQuery('select[name="filter-model"]').removeProp('disabled').addClass('active');
							var t=Date.now();
							var w= parseInt(jQuery('.filter-item').width()*2+22);
							var m= parseInt(jQuery('.filters').width()-w)/2;
							var h= parseInt(jQuery('.filter-content').height()+20);
							var b= parseInt(jQuery('.filter-botton').height());
							jQuery('div#ajax-preloader').show().css({'margin-top': -h+b+10, 'margin-left': m, width: w, height: h});
							
							$.ajax({
								type: "POST",
								url: "/autoparts/"+url+"/",
								data: {key:'model', years:years},
								dataType: "json"
							}).done(function(models) {
								var options='<option>Выбирете модель</option>';
								var options2='<option>Выбирете подмодель</option>';
								for(var k in models) {
									if(options.indexOf('>'+models[k]['model_name']+'</')<0)
									options+='<option>'+models[k]['model_name']+'</option>';
									options2+='<option value="'+models[k]['url']+'" attr-subModel="'+models[k]['model_name']+'">'+models[k]['name']+'</option>';
								}
								jQuery('select[name="filter-model"]').html(options);
								jQuery('select[name="filter-model"]').removeProp('disabled').addClass('active');
								jQuery('select[name="filter-submodel"]').html(options2);
								jQuery('select[name="filter-submodel"]').removeProp('disabled').addClass('active');
								
								jQuery('select#filter-motorv option').eq(0).attr("selected", "selected").parent().prop('disabled', true);
								jQuery('select[name="filter-motor"] option').eq(0).attr("selected", "selected").parent().prop('disabled', true);
								
								if(Date.now()<t+1000)
									setTimeout(jQuery('div#ajax-preloader').hide(), t-Date.now()+1000);
								else
									jQuery('div#ajax-preloader').hide();
								
							});
						} 
						
				
				if(jQuery('.helparrow:visible').size()>0) setArrows();
			}
			function GetSubModelTDC() {
				jQuery('select[name="filter-submodel"] option').hide();
				jQuery('select[name="filter-submodel"] option[attr-subModel="'+jQuery('select[name="filter-model"]').val()+'"]').show();
					jQuery('.helparrow').fadeOut();
					jQuery('select#filter-submodel').eq(0).parent().find('.helparrow').finish().fadeIn(500);
			  
				if(jQuery('select[name="filter-submodel"] option[attr-subModel="'+jQuery('select[name="filter-model"]').val()+'"]').size()==1) {
					jQuery('select[name="filter-submodel"] option[attr-subModel="'+jQuery('select[name="filter-model"]').val()+'"]').attr("selected", "selected");
					GetSubModelInfoTDC();
						jQuery('.helparrow').fadeOut();
						jQuery('#filter-motorv').eq(0).parent().find('.helparrow').finish().fadeIn(500);
				}
			}					
			function GetSubModelInfoTDC() {
				var url=jQuery('[name="filter-submodel"]').val();
				var years= jQuery('input[name="filter-year"]').val();
						if(url!='') {
							t=Date.now();
							var w= parseInt(jQuery('.filter-item').width()*2+22);
							var m= parseInt(jQuery('.filters').width()-w)/2;
							var h= parseInt(jQuery('.filter-content').height()+20);
							var b= parseInt(jQuery('.filter-botton').height());
							jQuery('div#ajax-preloader').show().css({'margin-top': -h+b+10, 'margin-left': m, width: w, height: h});
							
							$.ajax({
								type: "POST",
								timeout:30000,
								url: url+"/",
								data: {key:'model', years:years},
								dataType: "json",
								error: function(x, t, m) {
									if(t==="timeout") {
										alert("Время ожидание превышено. Пожалуйста, обновите страницу и попробуйте еще раз или свяжитесь с нашим оператором для констультации");
									} else {
										alert("Произошла ошибка. Пожалуйста, обновите страницу и попробуйте еще раз или свяжитесь с нашим оператором для констультации");
										console.log(t);
									}
								}
							}).done(function(motor) {
								var options='<option>Выбирете объем двигателя</option>';
								var options2='<option>Выбирете двигатель</option>';
								for(var k in motor) {
									if(options.indexOf('>'+motor[k]['v']+' л</')<0)
									options+='<option attr-motor="V'+motor[k]['v']+'">'+motor[k]['v']+' л</option>';
									options2+='<option value="'+motor[k]['url']+'" attr-motor="V'+motor[k]['v']+'filter">'+motor[k]['name']+' ('+motor[k]['engine']+')</option>';
								}
								if(Date.now()<t+1000) {
									setTimeout(jQuery('div#ajax-preloader').hide(), 500);
								} else {
									jQuery('div#ajax-preloader').hide();
								}
								jQuery('.helparrow').stop().fadeOut();
								jQuery('select[name="filter-motorV"]').removeProp('disabled').addClass('active');
								jQuery('select[name="filter-motorV"]').html(options).parent().find('.helparrow').stop().fadeIn(500);
								jQuery('select[name="filter-motor"]').html(options2);
								
								
							});
						} else alert('Error');
			}
			function MotorSelectedTDC() {
				var SFM=jQuery('select[name="filter-motor"]').val();
				var SFMv=jQuery('select[name="filter-motorV"]').val();
				if(		SFM	!="Выберите двигатель"
					&&	SFM	!=""
					&&	SFMv!="Выберите объем двигатель"
					&&	SFMv!=""
				)  {
					car=GetFilterVars();
					saveCar(car);
					window.location=GetUrlIfCategory();
				}
			}
			function GetUrlIfCategory() {
				url = jQuery('select[name="filter-motor"]').val();
					if(document.location.hash[0]=="#") {
						var category =document.location.hash.replace(/\#/g, "")
						var turl=jQuery('select[name="filter-motor"]').val().split("?");
						var s = jQuery('#menu li a[href="#'+category+'"]').attr("attr-section_id");
						if(turl[0]!=undefined&&turl[1]!=undefined&&s!=undefined)
						url = turl[0]+category+"/?"+turl[1]+";s"+s;
					}
				return url;
			}
			function RefreshSelect(element) {
				if(!jQuery(element).find('option:selected').is(':visible'))
					jQuery(element).find('option').eq(0).attr("selected", "selected");
			};
			function GetFilterVars() {
				var temp_car={
						'brand':	jQuery('[name="filter-mark"]')						.val(),
						'year':		jQuery('[name="filter-year"]')						.val(),
						'model':	jQuery('[name="filter-model"] option:checked')		.text(),
						'submodel':	jQuery('[name="filter-submodel"] option:checked')	.text(),	
						'motorV':	jQuery('[name="filter-motorV"] option:checked')		.text(),
						'motor': 	jQuery('[name="filter-motor"] option:checked')		.text(),
						'url':		jQuery('[name="filter-motor"]')						.val()
					}
				return temp_car;
			}
			function MoveToFilter() {
				var SFM=jQuery('select[name="filter-motor"]').val();
				var SFMv=jQuery('select[name="filter-motorV"]').val();
				if(		SFM	!="Выберите двигатель"
					&&	SFM	!=""
					&&	SFMv!="Выберите объем двигатель"
					&&	SFMv!=""
				) {
					car=GetFilterVars();
					saveCar(car);
					location.href=GetUrlIfCategory();
				}
			}
			function setArrows() {
				jQuery('.helparrow').fadeOut();
				if(jQuery('.filter-content input:enabled').eq(0).val()=='')
				  jQuery('.filter-content input:enabled').eq(0).parent().find('.helparrow').finish().fadeIn(500);
				else 
				if(jQuery('.filter-content input:enabled').eq(1).val()=='')
					jQuery('.filter-content input:enabled').eq(1).parent().find('.helparrow').finish().fadeIn(500);
				else {
					var n = jQuery('.filter-item select:enabled').size();
					var stop=false;
					if(n==1) for(var i=0;i<n;i++) {
						if(jQuery('.filter-item select:enabled').eq(i).val()==jQuery('.filter-item select:enabled').eq(i).attr('placeholder')||!stop) {
							jQuery('.filter-item select:enabled').eq(i).parent().find('.helparrow').finish().fadeIn(500);
							stop=true;
						}
					}
				}
			}
			function saveCar(car) {
				jQuery.cookie('cars',null);
				car={
						'brand':	car.brand,
						'year':		car.year,
						'model':	car.model,
						'submodel':	car.submodel,
						'motorV':	car.motorV,
						'motor':	car.motor,
						'url': 		car.url
					};
					jQuery.cookie('cars',JSON.stringify(car));
			}
			function skipCar() {
				jQuery('.selectedBlock').removeClass('selectedBlock ');
				jQuery('input[name="filter-mark"]').attr('disabled',false)
				jQuery('.filters input').val('');
				jQuery('li.HistoryCar, option.HistoryCar').remove();
				jQuery('.filter-botton2').addClass('hidden')
				jQuery('.filter-botton.double').removeClass('double');
			}
			
			$('.filters .filter-select[name="filter-mark"]').editableSelect({ 
				effects: 'slide',
				onSelect: function (element) {
					jQuery('#filter-year').removeAttr("disabled");
					MarkSelected = true;
					if(YearSelected) GetModelTDC(); 
					setArrows();
				}
			});
			$('.filters .filter-select[name="filter-year"]').editableSelect({ 
				effects: 'slide',
				onSelect: function (element) {
					YearSelected = true;
					if(MarkSelected) GetModelTDC(); 
					setArrows();
				}
			});
			jQuery('select[name="filter-model"]').change(function() {
				GetSubModelTDC();
			});
			jQuery('select[name="filter-submodel"]').change(function() {
				GetSubModelInfoTDC();
			});
			jQuery('select[name="filter-motor"]').change(function() {
				MotorSelectedTDC();
				jQuery('.filter-botton').animate({'background-color':'#3e8a57'},1000);
			});
			jQuery('select[name="filter-motorV"]').change(function() {
				jQuery('.helparrow').fadeOut();
				jQuery('select[name="filter-motor"]').removeProp('disabled').addClass('active');
				
			
				var mt=jQuery('select[name="filter-motor"] option[attr-motor="'+jQuery('select[name="filter-motorV"] option:selected').attr('attr-motor')+'filter"]');
				if(mt.attr('attr-motor')!=undefined) {
					jQuery('select[name="filter-motor"] option').hide();
					mt.show();
					if(mt.size()==1) {
						jQuery('.filter-botton').addClass('active').animate({'background-color':'#3e8a57'},1000);
						mt.prop('selected', true);
					} else { 
						RefreshSelect(jQuery('select[name="filter-motor"]'));
						jQuery('select[name="filter-motor"]').parent().find('.helparrow').finish().fadeIn(500);
					}
				} else 
					jQuery('select[name="filter-motor"] option').show();
			});
			jQuery('.filter-botton').click(function() {
					MoveToFilter();
			});
			jQuery('.es-input').focusin(function() {
				jQuery(this).val("");
			});
			jQuery('.helparrow.right').css('margin-left',jQuery('.filter-item').eq(0).width());
			scrolltosearchbtn=true;
			jQuery(window).scroll(function() {
				if(scrolltosearchbtn&&$(window).scrollTop()+$(window).height() > $('.filter-botton').offset().top) {
					scrolltosearchbtn=false;
					setArrows();
				}
			});
			jQuery('.filter-botton').click( function(e){
				jQuery('.helparrow.left:visible').finish().animate({'margin':'-5px -55px','width':'60px'},500).delay(500).animate({'margin':'0px -50px','width':'50px'},500);
				jQuery('.helparrow.right:visible').finish().animate({'margin':'-35px 245px','width':'60px'},500).delay(500).animate({'margin':'-30px 250px','width':'50px'},500);
			});
			jQuery('.filter-botton2').click(function(e) {
				skipCar();
			});