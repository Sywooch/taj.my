<?
			$postdata = http_build_query(array( 'getcategorynames'=> 1,'admin'=> 1, 'getfullinfo' =>1));
			$opts = array('http' =>array( 'method'  => 'POST','header'  => 'Content-type: application/x-www-form-urlencoded','content' => $postdata));

			$context  = stream_context_create($opts);

			$data = json_decode(file_get_contents('https://ibexshop.com.ua/autoparts/products/'.$_GET['BKEY'].'/'.$_GET['AKEY'], false, $context), true);
			
			
			if(count($data)>1) {?>
			<p>Аналоги:</p>
			 <table class="show_analogs">
				 <tr>
					<td>Артикул</td>
					<td>Бренд</td>
					<td style="display:none;">Название</td>
					<td></td>
				 </tr>
				<?php foreach($data as $store)
						if($store['AKEY']!=$_GET['AKEY']||$store['BKEY']!=$_GET['BKEY']) { ?>
					<tr>
						<td><?php echo $store['AKEY']; ?></td>
						<td><?php echo $store['BKEY']; ?></td>
						<td style="display:none;"><?php echo $store['NAME']; ?></td>
						<td><a class="analog_search_btn">Поиск</a></td>
					</tr>
				<?php } ?>
			 </table>
			<?php 
			}
	  
	  
	  ?>