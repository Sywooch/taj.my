<?php echo $header; ?>
<div class="home-filter-block catalog-filter clearfix">
	<div class="filter-left">
	<?php if(!isset($motor)) { ?>
	<div class="filter-title">Начните с выбора автомобиля</div>
	<div class="filter-content">
		
		<div class="filters">
				<div class="filter-item active">
					<select data-placeholder="Выберите марку" name="filter-mark" class="filter-select" style="width: 250px;">
						<option></option>
						<?php foreach($mark as $mk) { ?>
						<option value="<?php echo $mk['id_car_mark'];?>"><?php echo $mk['name'];?></option>
						<?php } ?>						
					</select>
				</div>
				<div class="filter-item" >
					<select data-placeholder="Выберите модель" name="filter-model" class="filter-select" style="width: 250px;">
					
					</select>
				</div>
				<div class="filter-item">
					<select data-placeholder="Выберите год" name="filter-year" class="filter-select" style="width: 250px;">

					</select>
				</div>

				<div class="filter-item" >
					<select data-placeholder="Выберите двигатель" name="filter-motor" class="filter-select" style="width: 250px;">
					
					</select>
				</div> 
			</div>
		<div class="filter-botton">Подобрать запчасти</div>
	</div>
		<div class="filter-text">
	Выбор автомобиля позволяет отобразить только те запчасти, которые подходят к вашему автомобилю.
	</div>
	<?php } else { ?>
	
	<div class="filter-content">
		
		<div class="selected-filter"><?php echo $mark.'<br/>'.$model.'<br/>'.$year.'<br/>'.$motor; ?></div>
		<div class="filter-botton filter-cancel">Отменить фильтр</div>
	</div>
	<?php } ?>

	<img src="/image/mini-cars.png" />
	</div>
	<div class="filter-right">
		<img src="catalog/view/theme/default/image/bigcar.png" />
	</div>
</div>
<div id="content"><?php echo $content_top; ?>
  <h1  class="entry-title-catalog"><?php echo $heading_title; ?></h1>
  <div class="breadcrumb breadcrumb-catalog">
    <?php foreach ($breadcrumbs as $breadcrumb) { ?>
    <?php echo $breadcrumb['separator']; ?><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a>
    <?php } ?>
  </div>
  

  <?php if ($categories) { ?>
  <div class="category-list catalog-list">
    <ul>
      <?php foreach ($categories as $category) { ?>
      <li class="catalog-category">
		<a  href="<?php echo $category['href']; ?>">
			<span><?php echo $category['name']; ?></span>
			<img src="<?php echo $category['thumb']; ?>">
		</a>
		
			<?php if(count($category['child'])) { ?>
			<ul>
				<?php foreach($category['child'] as $ch) { ?>
					<li><a href="<?php echo $ch['href'];?>"><?php echo $ch['name'];?></a></li>
				<?php } ?>
			</ul>
			<?php } ?>
	
		</li>
      <?php } ?>
    </ul>
  </div>
  <?php } ?>

<?php echo $content_bottom; ?></div>
<?php echo $footer; ?>