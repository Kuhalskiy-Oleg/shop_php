

<?php foreach ($open_product as $value):?>

<section class="content">
	<div class="contetn_img">
		<img  src="assets/images/<?= $value['name_img']; ?>" alt="">
	</div>
	<div class="content_description">
		<h1 class="name_telephone"><?= $value['brand']; ?></h1>
		<span class="description_telephone"><?php echo $value['description']; ?></span>
		<span class="color_telephone">Model:<?= $value['model']; ?></span>
		<span class="color_telephone">Color:<?= $value['color']; ?></span>
		<span class="price_telephone">Price:<?= $value['price']; ?></span>
	</div>
</section>


<?php endforeach ?>







