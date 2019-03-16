<?php 
	include_once('config.php');
	// підключення головного контроллеру 
	include_once('controller/ControllerModel.php'); 
	include('header.php');
?>
		<div class="container first">
			<div class="breadcrumbs">
				<a href="/" title="Ремонт техніки у Львові">Головна</a>
				<a href="/remont/<?=$_GET['c']?>" title="<?=$model['category_name']?>"><?=$model['category_name']?></a>
				<a href="/remont/<?=$_GET['c']?>/<?=$_GET['p']?>" title="Ремонт <?=$model['brand']?>"><?=$model['brand']?></a>
				<span href="/remont/<?=$_GET['c']?>/<?=$_GET['sp']?>"><?=$model['name']?></span>
			</div>
			<div class="row">
				<div class="left-part">
                    <div class="pr_image">
                        <img src="<?=$model['image']?>" alt="<?=$model['name']?>">
                    </div>
					<h1>Професійний ремонт <?=$model['name']?></h1>
                    <div class="slug">Професійний ремонт за 20-40 хвилин.</div>
					<div class="filter_list">
						<?php foreach($filters as $filter) { ?>
							<a attr-filter-id="[<?=implode(',',$filter['links'])?>]" title="<?=$filter['name']?>" style="background: url(<?=$filter['img']?>) no-repeat;background-size:contain;">
								<img src="<?=$filter['tag']?>">
								<span><?=$filter['name']?></span>
							</a>
						<?php }?>
					</div>
					<div class="filter_list_show" style="display:none;">
						Показити всі фільтри
					</div>
                    <div class="service_list">
						<?php foreach($serv as $s) { ?>
							<div attr-filter="<?=$s['id']?>" class="service_p<?php if($s['url']) echo ' linked'?>" attr-price="<?=$s['price']?>" attr-parts="<?=$s['datapart']?>">
								<div class="title">
									<span class="checkbox"></span><?php 
									if($s['url']) {
										echo '<a href="/remont/content/'.$s['url'].'" title="'.$s['label'].'" target="_blank">'.$s['label'].'</a>';
									} else { 
										echo $s['label'];
									} ?>
								</div>
								<div class="price"><?=number_format ($s['price'], 0, "", " ")?> <span>грн.</span></div>
							</div>
						<?php } ?>
                    </div>
				</div>
				<div class="right-part">
					<div class="prices" id="prices">
                        <div class="summary">
                            <div class="label">Ціна: <span id="full_price">0</span> <span>грн.</span></div>
                            <div class="selectors">
                                <div>
                                    <div class="input_block">
                                        <select id="original-copy">
                                            <option value="<?=$model['price_copy']?>">Деталі: Копія</option>
                                            <option value="-1" attr-value1="<?=$model['price_original1']?>" attr-value2="<?=$model['price_original2']?>">Деталі: Оригінал</option>
                                        </select>
                                    </div>
                                    <div class="sub_price"> + 0 грн</div>
                                </div>
                                <div>
                                    <div class="input_block">
                                        <select id="express">
                                            <option value="0">Тип ремонту: Стандарт</option>
                                            <option value="<?=$model['price_express']?>">Тип ремонту: експрес</option>
                                        </select>
                                    </div>
                                    <div class="sub_price"> + 0 грн</div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="sub_info_labels">
                        <div>
                            <img src="data:image/svg+xml;utf8;base64,PD94bWwgdmVyc2lvbj0iMS4wIiBlbmNvZGluZz0iaXNvLTg4NTktMSI/Pgo8IS0tIEdlbmVyYXRvcjogQWRvYmUgSWxsdXN0cmF0b3IgMTkuMC4wLCBTVkcgRXhwb3J0IFBsdWctSW4gLiBTVkcgVmVyc2lvbjogNi4wMCBCdWlsZCAwKSAgLS0+CjxzdmcgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIiB4bWxuczp4bGluaz0iaHR0cDovL3d3dy53My5vcmcvMTk5OS94bGluayIgdmVyc2lvbj0iMS4xIiBpZD0iTGF5ZXJfMSIgeD0iMHB4IiB5PSIwcHgiIHZpZXdCb3g9IjAgMCA1MTIgNTEyIiBzdHlsZT0iZW5hYmxlLWJhY2tncm91bmQ6bmV3IDAgMCA1MTIgNTEyOyIgeG1sOnNwYWNlPSJwcmVzZXJ2ZSIgd2lkdGg9IjI0cHgiIGhlaWdodD0iMjRweCI+CjxnPgoJPGc+CgkJPHBhdGggZD0iTTI1NiwwQzE1My43NTUsMCw3MC41NzMsODMuMTgyLDcwLjU3MywxODUuNDI2YzAsMTI2Ljg4OCwxNjUuOTM5LDMxMy4xNjcsMTczLjAwNCwzMjEuMDM1ICAgIGM2LjYzNiw3LjM5MSwxOC4yMjIsNy4zNzgsMjQuODQ2LDBjNy4wNjUtNy44NjgsMTczLjAwNC0xOTQuMTQ3LDE3My4wMDQtMzIxLjAzNUM0NDEuNDI1LDgzLjE4MiwzNTguMjQ0LDAsMjU2LDB6IE0yNTYsMjc4LjcxOSAgICBjLTUxLjQ0MiwwLTkzLjI5Mi00MS44NTEtOTMuMjkyLTkzLjI5M1MyMDQuNTU5LDkyLjEzNCwyNTYsOTIuMTM0czkzLjI5MSw0MS44NTEsOTMuMjkxLDkzLjI5M1MzMDcuNDQxLDI3OC43MTksMjU2LDI3OC43MTl6IiBmaWxsPSIjMzBiMmU3Ii8+Cgk8L2c+CjwvZz4KPGc+CjwvZz4KPGc+CjwvZz4KPGc+CjwvZz4KPGc+CjwvZz4KPGc+CjwvZz4KPGc+CjwvZz4KPGc+CjwvZz4KPGc+CjwvZz4KPGc+CjwvZz4KPGc+CjwvZz4KPGc+CjwvZz4KPGc+CjwvZz4KPGc+CjwvZz4KPGc+CjwvZz4KPGc+CjwvZz4KPC9zdmc+Cg==" />
                            Знаходимось поруч
                        </div>
                        <div>
                            <img src="data:image/svg+xml;utf8;base64,PD94bWwgdmVyc2lvbj0iMS4wIiBlbmNvZGluZz0iaXNvLTg4NTktMSI/Pgo8IS0tIEdlbmVyYXRvcjogQWRvYmUgSWxsdXN0cmF0b3IgMTkuMC4wLCBTVkcgRXhwb3J0IFBsdWctSW4gLiBTVkcgVmVyc2lvbjogNi4wMCBCdWlsZCAwKSAgLS0+CjxzdmcgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIiB4bWxuczp4bGluaz0iaHR0cDovL3d3dy53My5vcmcvMTk5OS94bGluayIgdmVyc2lvbj0iMS4xIiBpZD0iQ2FwYV8xIiB4PSIwcHgiIHk9IjBweCIgdmlld0JveD0iMCAwIDYwIDYwIiBzdHlsZT0iZW5hYmxlLWJhY2tncm91bmQ6bmV3IDAgMCA2MCA2MDsiIHhtbDpzcGFjZT0icHJlc2VydmUiIHdpZHRoPSIyNHB4IiBoZWlnaHQ9IjI0cHgiPgo8Zz4KCTxwYXRoIGQ9Ik0zMS42MzQsMzcuOTg5YzEuMDQxLTAuMDgxLDEuOTktMC42MTIsMi42MDYtMS40NTlsOS4zNjMtMTIuOTQ0YzAuMjg3LTAuMzk3LDAuMjQ0LTAuOTQ1LTAuMTA0LTEuMjkzICAgYy0wLjM0OC0wLjM0Ny0wLjg5Ni0wLjM5LTEuMjkzLTAuMTA0TDI5LjI2LDMxLjU1NWMtMC44NDQsMC42MTQtMS4zNzUsMS41NjMtMS40NTYsMi42MDRzMC4yOTYsMi4wNiwxLjAzMywyLjc5NyAgIEMyOS41MDgsMzcuNjI4LDMwLjQxMywzOCwzMS4zNTQsMzhDMzEuNDQ3LDM4LDMxLjU0LDM3Ljk5NiwzMS42MzQsMzcuOTg5eiBNMjkuNzk4LDM0LjMxNWMwLjAzNS0wLjQ1NywwLjI2OS0wLjg3NCwwLjYzNy0xLjE0MiAgIGw3Ljg5Ny01LjcxM2wtNS43MTEsNy44OTVjLTAuMjcsMC4zNzEtMC42ODcsMC42MDQtMS4xNDQsMC42NGMtMC40NTUsMC4wMy0wLjkwMi0wLjEyOC0xLjIyNy0wLjQ1MyAgIEMyOS45MjgsMzUuMjE5LDI5Ljc2MiwzNC43NzEsMjkuNzk4LDM0LjMxNXoiIGZpbGw9IiMzMjg5YzciLz4KCTxwYXRoIGQ9Ik01NC4wMzQsMTkuNTY0Yy0wLjAxLTAuMDIxLTAuMDEtMC4wNDMtMC4wMjEtMC4wNjRjLTAuMDEyLTAuMDItMC4wMzEtMC4wMzEtMC4wNDQtMC4wNSAgIGMtMS4wMTEtMS43MzQtMi4yMDctMy4zNDctMy41NjUtNC44MDlsMi4xNDgtMi4xNDdsMS40MTQsMS40MTRsNC4yNDItNC4yNDNsLTQuMjQyLTQuMjQybC00LjI0Myw0LjI0MmwxLjQxNSwxLjQxNWwtMi4xNDgsMi4xNDcgICBjLTEuNDYyLTEuMzU4LTMuMDc0LTIuNTU1LTQuODA5LTMuNTY2Yy0wLjAxOS0wLjAxMy0wLjAzLTAuMDMyLTAuMDUtMC4wNDRjLTAuMDIxLTAuMDEyLTAuMDQzLTAuMDExLTAuMDY0LTAuMDIyICAgYy0zLjA5My0xLjc4Mi02LjU2OC0yLjk2OS0xMC4yNzMtMy40MDRWNWgxLjVjMS4zNzksMCwyLjUtMS4xMjEsMi41LTIuNVMzNi42NzIsMCwzNS4yOTMsMGgtOWMtMS4zNzksMC0yLjUsMS4xMjEtMi41LDIuNSAgIHMxLjEyMSwyLjUsMi41LDIuNWgxLjV2MS4xNTZjLTEuMDgsMC4xMTUtMi4xNTgsMC4yOTEtMy4yMjQsMC41MzVjLTAuNTM4LDAuMTIzLTAuODc1LDAuNjYtMC43NTEsMS4xOTggICBjMC4xMjMsMC41MzgsMC42NiwwLjg3NiwxLjE5OCwwLjc1MWMwLjkyLTAuMjExLDEuODQ5LTAuMzcsMi43OC0wLjQ3N2wxLjA3My0wLjA4M2MwLjMyOC0wLjAyNSwwLjYzLTAuMDQzLDAuOTI0LTAuMDU3VjEwICAgYzAsMC41NTMsMC40NDcsMSwxLDFzMS0wLjQ0NywxLTFWOC4wM2MzLjc2MSwwLjE3Myw3LjMwNSwxLjE4MywxMC40NTYsMi44NDVsLTAuOTg2LDEuNzA3Yy0wLjI3NiwwLjQ3OS0wLjExMiwxLjA5LDAuMzY2LDEuMzY2ICAgYzAuMTU3LDAuMDkxLDAuMzI5LDAuMTM0LDAuNDk5LDAuMTM0YzAuMzQ2LDAsMC42ODItMC4xNzksMC44NjctMC41bDAuOTgzLTEuNzAzYzMuMTI5LDEuOTg1LDUuNzg3LDQuNjQzLDcuNzcyLDcuNzcyICAgbC0xLjcwMywwLjk4M0M0OS41NywyMC45MSw0OS40MDYsMjEuNTIxLDQ5LjY4MywyMmMwLjE4NiwwLjMyMSwwLjUyMSwwLjUsMC44NjcsMC41YzAuMTcsMCwwLjM0Mi0wLjA0MywwLjQ5OS0wLjEzNGwxLjcwNy0wLjk4NiAgIGMxLjY4NSwzLjE5NiwyLjY5OCw2Ljc5OCwyLjg0OSwxMC42MTlINTMuNjNjLTAuNTUzLDAtMSwwLjQ0Ny0xLDFzMC40NDcsMSwxLDFoMS45NzVjLTAuMTUxLDMuODIxLTEuMTY0LDcuNDIzLTIuODQ5LDEwLjYxOSAgIGwtMS43MDctMC45ODZjLTAuNDc4LTAuMjc2LTEuMDktMC4xMTQtMS4zNjYsMC4zNjZjLTAuMjc2LDAuNDc5LTAuMTEyLDEuMDksMC4zNjYsMS4zNjZsMS43MDMsMC45ODMgICBjLTEuOTg1LDMuMTI5LTQuNjQzLDUuNzg3LTcuNzcyLDcuNzcybC0wLjk4My0xLjcwM2MtMC4yNzctMC40OC0wLjg5LTAuNjQzLTEuMzY2LTAuMzY2Yy0wLjQ3OSwwLjI3Ni0wLjY0MywwLjg4OC0wLjM2NiwxLjM2NiAgIGwwLjk4NiwxLjcwN2MtMy4xNTEsMS42NjItNi42OTUsMi42NzItMTAuNDU2LDIuODQ1VjU2YzAtMC41NTMtMC40NDctMS0xLTFzLTEsMC40NDctMSwxdjEuOTc2ICAgYy0xLjU5Ny0wLjA1NS0zLjE5OS0wLjI1NS00Ljc3Ni0wLjYxN2MtMC41MzgtMC4xMjktMS4wNzUsMC4yMTMtMS4xOTgsMC43NTFjLTAuMTI0LDAuNTM4LDAuMjEzLDEuMDc1LDAuNzUxLDEuMTk4ICAgQzI2LjU2OCw1OS43NjgsMjguNjA3LDYwLDMwLjYzLDYwYzAuMDQ5LDAsMC4wOTYtMC4wMDMsMC4xNDUtMC4wMDRjMC4wMDcsMCwwLjAxMiwwLjAwNCwwLjAxOCwwLjAwNCAgIGMwLjAwOCwwLDAuMDE1LTAuMDA1LDAuMDIzLTAuMDA1YzQuODA3LTAuMDMzLDkuMzE3LTEuMzMxLDEzLjIxOS0zLjU3M2MwLjAzMS0wLjAxNCwwLjA2NC0wLjAyMSwwLjA5NC0wLjAzOSAgIGMwLjAyLTAuMDEyLDAuMDMxLTAuMDMxLDAuMDUtMC4wNDRjNC4wMzktMi4zNTQsNy40MTQtNS43MjUsOS43NzMtOS43NjFjMC4wMTktMC4wMjcsMC4wNDMtMC4wNDgsMC4wNi0wLjA3OCAgIGMwLjAxMi0wLjAyMSwwLjAxMS0wLjA0MywwLjAyMS0wLjA2NEM1Ni4zMTcsNDIuNDc2LDU3LjYzLDM3Ljg5LDU3LjYzLDMzUzU2LjMxNywyMy41MjQsNTQuMDM0LDE5LjU2NHogTTUzLjk2NSw4LjI1MWwxLjQxNCwxLjQxNCAgIGwtMS40MTQsMS40MTVMNTIuNTUsOS42NjVMNTMuOTY1LDguMjUxeiBNMjkuNzkzLDYuMDIxVjNoLTMuNWMtMC4yNzUsMC0wLjUtMC4yMjUtMC41LTAuNXMwLjIyNS0wLjUsMC41LTAuNWg5ICAgYzAuMjc1LDAsMC41LDAuMjI1LDAuNSwwLjVTMzUuNTY4LDMsMzUuMjkzLDNoLTMuNXYzLjAyMUMzMS40NDUsNi4wMDcsMzEuMTEzLDYsMzAuNzkzLDZjLTAuMDI4LDAtMC4wNiwwLjAwMi0wLjA4OCwwLjAwMiAgIEMzMC42OCw2LjAwMiwzMC42NTUsNiwzMC42Myw2Yy0wLjE2NCwwLTAuMzI4LDAuMDExLTAuNDkyLDAuMDE0QzMwLjAyMiw2LjAxNywyOS45MTMsNi4wMTYsMjkuNzkzLDYuMDIxeiIgZmlsbD0iIzMyODljNyIvPgoJPHBhdGggZD0iTTIxLjc5MywxNGgtNWMtMC41NTMsMC0xLDAuNDQ3LTEsMXMwLjQ0NywxLDEsMWg1YzAuNTUzLDAsMS0wLjQ0NywxLTFTMjIuMzQ2LDE0LDIxLjc5MywxNHoiIGZpbGw9IiMzMjg5YzciLz4KCTxwYXRoIGQ9Ik0yMS43OTMsMjFoLTEwYy0wLjU1MywwLTEsMC40NDctMSwxczAuNDQ3LDEsMSwxaDEwYzAuNTUzLDAsMS0wLjQ0NywxLTFTMjIuMzQ2LDIxLDIxLjc5MywyMXoiIGZpbGw9IiMzMjg5YzciLz4KCTxwYXRoIGQ9Ik0yMS43OTMsMjhoLTE1Yy0wLjU1MywwLTEsMC40NDctMSwxczAuNDQ3LDEsMSwxaDE1YzAuNTUzLDAsMS0wLjQ0NywxLTFTMjIuMzQ2LDI4LDIxLjc5MywyOHoiIGZpbGw9IiMzMjg5YzciLz4KCTxwYXRoIGQ9Ik0yMS43OTMsMzVoLTE5Yy0wLjU1MywwLTEsMC40NDctMSwxczAuNDQ3LDEsMSwxaDE5YzAuNTUzLDAsMS0wLjQ0NywxLTFTMjIuMzQ2LDM1LDIxLjc5MywzNXoiIGZpbGw9IiMzMjg5YzciLz4KCTxwYXRoIGQ9Ik0yMS43OTMsNDJoLTEzYy0wLjU1MywwLTEsMC40NDctMSwxczAuNDQ3LDEsMSwxaDEzYzAuNTUzLDAsMS0wLjQ0NywxLTFTMjIuMzQ2LDQyLDIxLjc5Myw0MnoiIGZpbGw9IiMzMjg5YzciLz4KCTxwYXRoIGQ9Ik0yMS43OTMsNDloLTdjLTAuNTUzLDAtMSwwLjQ0Ny0xLDFzMC40NDcsMSwxLDFoN2MwLjU1MywwLDEtMC40NDcsMS0xUzIyLjM0Niw0OSwyMS43OTMsNDl6IiBmaWxsPSIjMzI4OWM3Ii8+CjwvZz4KPGc+CjwvZz4KPGc+CjwvZz4KPGc+CjwvZz4KPGc+CjwvZz4KPGc+CjwvZz4KPGc+CjwvZz4KPGc+CjwvZz4KPGc+CjwvZz4KPGc+CjwvZz4KPGc+CjwvZz4KPGc+CjwvZz4KPGc+CjwvZz4KPGc+CjwvZz4KPGc+CjwvZz4KPGc+CjwvZz4KPC9zdmc+Cg==" />
                            Ремонтуємо за 20-40 хвилин
                        </div>
                        <div>
                            <img src="data:image/svg+xml;utf8;base64,PD94bWwgdmVyc2lvbj0iMS4wIj8+CjxzdmcgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIiBoZWlnaHQ9IjI0cHgiIHZlcnNpb249IjEuMSIgdmlld0JveD0iLTM4IDAgNTEyIDUxMi4wMDE0MiIgd2lkdGg9IjI0cHgiPgo8ZyBpZD0ic3VyZmFjZTEiPgo8cGF0aCBkPSJNIDQzNS40ODgyODEgMTM4LjkxNzk2OSBMIDQzNS40NzI2NTYgMTM4LjUxOTUzMSBDIDQzNS4yNSAxMzMuNjAxNTYyIDQzNS4xMDE1NjIgMTI4LjM5ODQzOCA0MzUuMDExNzE5IDEyMi42MDkzNzUgQyA0MzQuNTkzNzUgOTQuMzc4OTA2IDQxMi4xNTIzNDQgNzEuMDI3MzQ0IDM4My45MTc5NjkgNjkuNDQ5MjE5IEMgMzI1LjA1MDc4MSA2Ni4xNjQwNjIgMjc5LjUxMTcxOSA0Ni45Njg3NSAyNDAuNjAxNTYyIDkuMDQyOTY5IEwgMjQwLjI2OTUzMSA4LjcyNjU2MiBDIDIyNy41NzgxMjUgLTIuOTEwMTU2IDIwOC40MzM1OTQgLTIuOTEwMTU2IDE5NS43MzgyODEgOC43MjY1NjIgTCAxOTUuNDA2MjUgOS4wNDI5NjkgQyAxNTYuNDk2MDk0IDQ2Ljk2ODc1IDExMC45NTcwMzEgNjYuMTY0MDYyIDUyLjA4OTg0NCA2OS40NTMxMjUgQyAyMy44NTkzNzUgNzEuMDI3MzQ0IDEuNDE0MDYyIDk0LjM3ODkwNiAwLjk5NjA5NCAxMjIuNjEzMjgxIEMgMC45MTAxNTYgMTI4LjM2MzI4MSAwLjc1NzgxMiAxMzMuNTY2NDA2IDAuNTM1MTU2IDEzOC41MTk1MzEgTCAwLjUxMTcxOSAxMzkuNDQ1MzEyIEMgLTAuNjMyODEyIDE5OS40NzI2NTYgLTIuMDU0Njg4IDI3NC4xNzk2ODggMjIuOTM3NSAzNDEuOTg4MjgxIEMgMzYuNjc5Njg4IDM3OS4yNzczNDQgNTcuNDkyMTg4IDQxMS42OTE0MDYgODQuNzkyOTY5IDQzOC4zMzU5MzggQyAxMTUuODg2NzE5IDQ2OC42Nzk2ODggMTU2LjYxMzI4MSA0OTIuNzY5NTMxIDIwNS44Mzk4NDQgNTA5LjkzMzU5NCBDIDIwNy40NDE0MDYgNTEwLjQ5MjE4OCAyMDkuMTA1NDY5IDUxMC45NDUzMTIgMjEwLjgwMDc4MSA1MTEuMjg1MTU2IEMgMjEzLjE5MTQwNiA1MTEuNzYxNzE5IDIxNS41OTc2NTYgNTEyIDIxOC4wMDM5MDYgNTEyIEMgMjIwLjQxMDE1NiA1MTIgMjIyLjgyMDMxMiA1MTEuNzYxNzE5IDIyNS4yMDcwMzEgNTExLjI4NTE1NiBDIDIyNi45MDIzNDQgNTEwLjk0NTMxMiAyMjguNTc4MTI1IDUxMC40ODgyODEgMjMwLjE4NzUgNTA5LjkyNTc4MSBDIDI3OS4zNTU0NjkgNDkyLjczMDQ2OSAzMjAuMDM5MDYyIDQ2OC42Mjg5MDYgMzUxLjEwNTQ2OSA0MzguMjg5MDYyIEMgMzc4LjM5NDUzMSA0MTEuNjM2NzE5IDM5OS4yMDcwMzEgMzc5LjIxNDg0NCA0MTIuOTYwOTM4IDM0MS45MTc5NjkgQyA0MzguMDQ2ODc1IDI3My45MDYyNSA0MzYuNjI4OTA2IDE5OS4wNTg1OTQgNDM1LjQ4ODI4MSAxMzguOTE3OTY5IFogTSAzODQuNzczNDM4IDMzMS41MjM0MzggQyAzNTguNDE0MDYyIDQwMi45OTIxODggMzA0LjYwNTQ2OSA0NTIuMDc0MjE5IDIyMC4yNzM0MzggNDgxLjU2NjQwNiBDIDIxOS45NzI2NTYgNDgxLjY2Nzk2OSAyMTkuNjUyMzQ0IDQ4MS43NTc4MTIgMjE5LjMyMDMxMiA0ODEuODI0MjE5IEMgMjE4LjQ0OTIxOSA0ODEuOTk2MDk0IDIxNy41NjI1IDQ4MS45OTYwOTQgMjE2LjY3OTY4OCA0ODEuODIwMzEyIEMgMjE2LjM1MTU2MiA0ODEuNzUzOTA2IDIxNi4wMzEyNSA0ODEuNjY3OTY5IDIxNS43MzQzNzUgNDgxLjU2NjQwNiBDIDEzMS4zMTI1IDQ1Mi4xMjg5MDYgNzcuNDY4NzUgNDAzLjA3NDIxOSA1MS4xMjg5MDYgMzMxLjYwMTU2MiBDIDI4LjA5Mzc1IDI2OS4wOTc2NTYgMjkuMzk4NDM4IDIwMC41MTk1MzEgMzAuNTUwNzgxIDE0MC4wMTk1MzEgTCAzMC41NTg1OTQgMTM5LjY4MzU5NCBDIDMwLjc5Mjk2OSAxMzQuNDg0Mzc1IDMwLjk0OTIxOSAxMjkuMDM5MDYyIDMxLjAzNTE1NiAxMjMuMDU0Njg4IEMgMzEuMjIyNjU2IDExMC41MTk1MzEgNDEuMjA3MDMxIDEwMC4xNDg0MzggNTMuNzY1NjI1IDk5LjQ0OTIxOSBDIDg3LjA3ODEyNSA5Ny41ODk4NDQgMTE2LjM0Mzc1IDkxLjE1MjM0NCAxNDMuMjM0Mzc1IDc5Ljc2OTUzMSBDIDE3MC4wODk4NDQgNjguNDAyMzQ0IDE5My45NDE0MDYgNTIuMzc4OTA2IDIxNi4xNDQ1MzEgMzAuNzg1MTU2IEMgMjE3LjI3MzQzOCAyOS44MzIwMzEgMjE4LjczODI4MSAyOS44MjgxMjUgMjE5Ljg2MzI4MSAzMC43ODUxNTYgQyAyNDIuMDcwMzEyIDUyLjM3ODkwNiAyNjUuOTIxODc1IDY4LjQwMjM0NCAyOTIuNzczNDM4IDc5Ljc2OTUzMSBDIDMxOS42NjQwNjIgOTEuMTUyMzQ0IDM0OC45Mjk2ODggOTcuNTg5ODQ0IDM4Mi4yNDYwOTQgOTkuNDQ5MjE5IEMgMzk0LjgwNDY4OCAxMDAuMTQ4NDM4IDQwNC43ODkwNjIgMTEwLjUxOTUzMSA0MDQuOTcyNjU2IDEyMy4wNTg1OTQgQyA0MDUuMDYyNSAxMjkuMDc0MjE5IDQwNS4yMTg3NSAxMzQuNTE5NTMxIDQwNS40NTMxMjUgMTM5LjY4MzU5NCBDIDQwNi42MDE1NjIgMjAwLjI1MzkwNiA0MDcuODc1IDI2OC44ODY3MTkgMzg0Ljc3MzQzOCAzMzEuNTIzNDM4IFogTSAzODQuNzczNDM4IDMzMS41MjM0MzggIiBzdHlsZT0iIGZpbGwtcnVsZTpub256ZXJvO2ZpbGwtb3BhY2l0eToxOyIgc3Ryb2tlPSIjMzI4OWM3IiBmaWxsPSIjMzI4OWM3Ii8+CjxwYXRoIGQ9Ik0gMjE3Ljk5NjA5NCAxMjguNDEwMTU2IEMgMTQ3LjYzNjcxOSAxMjguNDEwMTU2IDkwLjM5ODQzOCAxODUuNjUyMzQ0IDkwLjM5ODQzOCAyNTYuMDA3ODEyIEMgOTAuMzk4NDM4IDMyNi4zNjcxODggMTQ3LjYzNjcxOSAzODMuNjA5Mzc1IDIxNy45OTYwOTQgMzgzLjYwOTM3NSBDIDI4OC4zNTE1NjIgMzgzLjYwOTM3NSAzNDUuNTkzNzUgMzI2LjM2NzE4OCAzNDUuNTkzNzUgMjU2LjAwNzgxMiBDIDM0NS41OTM3NSAxODUuNjUyMzQ0IDI4OC4zNTE1NjIgMTI4LjQxMDE1NiAyMTcuOTk2MDk0IDEyOC40MTAxNTYgWiBNIDIxNy45OTYwOTQgMzUzLjU2MjUgQyAxNjQuMjAzMTI1IDM1My41NjI1IDEyMC40NDE0MDYgMzA5LjgwMDc4MSAxMjAuNDQxNDA2IDI1Ni4wMDc4MTIgQyAxMjAuNDQxNDA2IDIwMi4yMTQ4NDQgMTY0LjIwMzEyNSAxNTguNDUzMTI1IDIxNy45OTYwOTQgMTU4LjQ1MzEyNSBDIDI3MS43ODUxNTYgMTU4LjQ1MzEyNSAzMTUuNTQ2ODc1IDIwMi4yMTQ4NDQgMzE1LjU0Njg3NSAyNTYuMDA3ODEyIEMgMzE1LjU0Njg3NSAzMDkuODAwNzgxIDI3MS43ODUxNTYgMzUzLjU2MjUgMjE3Ljk5NjA5NCAzNTMuNTYyNSBaIE0gMjE3Ljk5NjA5NCAzNTMuNTYyNSAiIHN0eWxlPSIgZmlsbC1ydWxlOm5vbnplcm87ZmlsbC1vcGFjaXR5OjE7IiBzdHJva2U9IiMzMjg5YzciIGZpbGw9IiMzMjg5YzciLz4KPHBhdGggZD0iTSAyNTQuNjY3OTY5IDIxNi4zOTQ1MzEgTCAxOTUuNDAyMzQ0IDI3NS42NjAxNTYgTCAxNzkuMzE2NDA2IDI1OS41NzQyMTkgQyAxNzMuNDQ5MjE5IDI1My43MDcwMzEgMTYzLjkzNzUgMjUzLjcwNzAzMSAxNTguMDcwMzEyIDI1OS41NzQyMTkgQyAxNTIuMjA3MDMxIDI2NS40NDE0MDYgMTUyLjIwNzAzMSAyNzQuOTUzMTI1IDE1OC4wNzAzMTIgMjgwLjgxNjQwNiBMIDE4NC43ODEyNSAzMDcuNTI3MzQ0IEMgMTg3LjcxNDg0NCAzMTAuNDYwOTM4IDE5MS41NTg1OTQgMzExLjkyNTc4MSAxOTUuNDAyMzQ0IDMxMS45MjU3ODEgQyAxOTkuMjQ2MDk0IDMxMS45MjU3ODEgMjAzLjA4OTg0NCAzMTAuNDYwOTM4IDIwNi4wMjM0MzggMzA3LjUyNzM0NCBMIDI3NS45MTQwNjIgMjM3LjYzNjcxOSBDIDI4MS43NzczNDQgMjMxLjc2OTUzMSAyODEuNzc3MzQ0IDIyMi4yNTc4MTIgMjc1LjkxNDA2MiAyMTYuMzk0NTMxIEMgMjcwLjA0Njg3NSAyMTAuNTIzNDM4IDI2MC41MzUxNTYgMjEwLjUyMzQzOCAyNTQuNjY3OTY5IDIxNi4zOTQ1MzEgWiBNIDI1NC42Njc5NjkgMjE2LjM5NDUzMSAiIHN0eWxlPSIgZmlsbC1ydWxlOm5vbnplcm87ZmlsbC1vcGFjaXR5OjE7IiBzdHJva2U9IiMzMjg5YzciIGZpbGw9IiMzMjg5YzciLz4KPC9nPgo8L3N2Zz4K" />
                            Даємо гарантію 1 рік
                        </div>
                    </div>
					<div class="b-play right_block active" onclick="$('.b-play-button').click();">
						<p>Все про компанію за 25 сек</p>
					</div>
						<a href="#" onclick="playY('2C56RGUzcck')" style="display:none;" class="b-play-button transition-1"><img src="/images/icon-play-1.png" alt=""></a>
				</div>
				<div class="sub_row">
					<a href="#prices">
						<div class="label">Ціна: <span id="full_price">0</span> <span>грн.</span></div>
					</a>
				</div>
				<div class="clear"></div>
            </div>
		</div>
<?php include('footer.php');?>