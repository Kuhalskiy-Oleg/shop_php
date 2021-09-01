<!-- если корзина пуста то скрываем код для отображения  выбранных товаров -->
<?php if (!empty($row)): ?>

	<?php $i = 0; ?>
	<div class="gg">
	<form class="form_card_body_add_order" action="assets/php/order/add_items_order.php" method="post">
	<?php foreach ($row as $key => $items_products):  ?> 
	<?php $i += 1; ?>
		

	<span number="<?=$items_products['id']?>">Товар номер <?=$i?>)</span>
	<ul number="<?=$items_products['id']?>">
		<li>id продукта <?=$items_products['id']?></li>
		<li>бренд <?=$items_products['brand']?></li>
		<li>модель <?=$items_products['model']?></li>
		<li>цвет <?=$items_products['color']?></li>
		<li>цена <?=$items_products['price']?></li>
	</ul>
	<label number="<?=$items_products['id']?>" >count</label>
	<div number="<?=$items_products['id']?>" class="count_order two<?=$items_products['id']?>">
		<input id="count_order" data="input" value="1" class="value<?=$items_products['id']?>" type="text" placeholder="count" name="count_<?=$items_products['id']?>"><br>
		<span data="span" class="error<?=$items_products['id']?>" id="error_count"></span>
	</div>

	<hr number="<?=$items_products['id']?>">
	<br number="<?=$items_products['id']?>"><br number="<?=$items_products['id']?>">


	<?php endforeach; ?>
		<input id="submit_order" type="submit"  value="оформить заказ">	
	</form>


	<?php foreach ($row as $key => $items_products):  ?> 
	<form number="<?=$items_products['id']?>" class="form_delete_elem_korz" method="post" action="assets/php/order/delete_elem_korz.php" style="visibility: hidden; height: 0;">
		<input number="<?=$items_products['id']?>" type="hidden" name="items_products_id_name" value="<?=$items_products['id']?>">
		<input number="<?=$items_products['id']?>" type="submit" data="submit_items_products_id_name" class="vvvv<?=$items_products['id']?>" value="delete" style="visibility: visible;" >
	</form>

	<!-- устанавливаем кнопки (для отправки формы с удалением элемента из корзины) в форму с выбранным товаром -->
	<script>
		
	 	$.each($('.count_order.two<?=$items_products['id']?>'), function(index,value){
		    //console.log($(value).position());
		    //console.log($(value).position().top);
		    let top_<?=$items_products['id']?> = $(value).position().top;
		    let left_<?=$items_products['id']?> = $(value).position().left;
		    $('.vvvv<?=$items_products['id']?>').offset({top: top_<?=$items_products['id']?> + 28, left: left_<?=$items_products['id']?> });
		})
		
		</script>

	<?php endforeach; ?>


	</div>


<?php endif ?>