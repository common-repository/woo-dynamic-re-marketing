<?php
		if(is_front_page()){
		?>
<script type="text/javascript">
		var google_tag_params = {
		dynx_pagetype: 'home'
		};
		</script>
<?php
		}
		
		elseif (is_product()){
		?>
<script type="text/javascript">
		var google_tag_params = {
		dynx_itemid: '<?php echo get_the_ID(); ?>',
		
		dynx_pagetype: 'offerdetail',
		dynx_totalvalue: <?php 
				
			$product = get_product( get_the_ID() );
			echo $product->get_price();
									
			?>
			
		};
		</script>
<?php
		}
		
		elseif (is_cart()){
		?>
<script type="text/javascript">
		var google_tag_params = {
dynx_itemid: <?php echo "["; global $woocommerce; $cart_items = array();  $items = $woocommerce->cart->get_cart();
  foreach((array)$items as $item => $values) { ?>
   <?php $_product = $values['data']->post; ?>
		 <?php array_push($cart_items, "'" . $_product->ID . "'"); ?>
		  <?php } echo implode(', ', $cart_items); echo "]";
			
		?>,
  
  
		dynx_pagetype: 'conversionintent',
		dynx_totalvalue: <?php  echo WC()->cart->total; ?>
		
		};
		</script>
<?php

		}
		
		elseif (is_order_received_page()){
		?>
<script type="text/javascript">
		var google_tag_params = {
		dynx_itemid: <?php
			
			echo "[";
			
			$order       = new WC_Order(wc_get_order_id_by_order_key($_GET['key']));
			$order_total = $order->get_total();
			$items = $order->get_items();
			
			$order_items = array();
			foreach((array)$items as $item){
				array_push($order_items, "'" . $item['product_id'] . "'");
			}
			echo implode(', ', $order_items);
			
			echo "]";
			
		?>,
		dynx_pagetype: 'conversion',
		dynx_totalvalue: <?php echo $order_total; ?>
		
		};
		</script>
<?php

		}
	
		else{
		?>
<script type="text/javascript">
		var google_tag_params = {
		dynx_pagetype: 'other'
		};
		</script>
<?php } ?>
<script type="text/javascript">
/* <![CDATA[ */
var google_conversion_id = <?php $idul = get_option( 'gcid_name');print_r($idul['id_number']);?>;
var google_custom_params = window.google_tag_params;
var google_remarketing_only = true;
/* ]]> */
</script>
<script type="text/javascript" src="//www.googleadservices.com/pagead/conversion.js">
</script>

<noscript>
<div style="display:inline;"> <img height="1" width="1" style="border-style:none;" alt="" src="//googleads.g.doubleclick.net/pagead/viewthroughconversion/<?php $idul = get_option( 'gcid_name'); print_r($idul['id_number']);?>/?value=0&amp;guid=ON&amp;script=0"/> </div>
</noscript>
