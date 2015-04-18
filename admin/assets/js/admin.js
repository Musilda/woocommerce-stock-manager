(function ( $ ) {
	"use strict";

	$(function () {

		/**
		 * Save single product line in stock table
		 *
		 */              
    jQuery('.save-product').on('click', function(){
       jQuery('.lineloader').css('display','block');
       var product = jQuery(this).data('product');
       
       
       var manage_stock = jQuery('.manage_stock_' + product).val();
       var stock_status = jQuery('.stock_status_' + product).val();
       var backorders   = jQuery('.backorders_' + product).val();
       var stock        = jQuery('.stock_' + product).val();
       
       var data = {
            action      : 'save_one_product',
            product     : product,
            manage_stock: manage_stock,
            stock_status: stock_status,
            backorders  :backorders,
            stock       : stock
       };
        jQuery.post(ajaxurl, data, function(response){
           
          jQuery('.lineloader').css('display','none'); 
        
        });
       
    });
    
    
    /**
     * Show variations of selected product
     *
     */ 
    jQuery('.show-variable').on('click', function(){
       var variable = jQuery(this).data('variable');
       jQuery('.variation-item-' + variable).css('display','table-row');       
    });                 

	});

}(jQuery));