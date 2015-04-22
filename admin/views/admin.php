<?php
/**
 * @package   WooCommerce Stock Manager
 * @author    Vladislav Musílek
 * @license   GPL-2.0+
 * @link      http:/toret.cz
 * @copyright 2015 Toret.cz
 */
$stock = $this->stock();

/**
 * Save all data
 *
 */   
if(isset($_POST['save-all'])){
  $stock->save_all($_POST);
  //add redirect
  
}


?>


<div class="wrap">

	<h2><?php echo esc_html( get_admin_page_title() ); ?></h2>
  
  

  
<div class="t-col-12">
  <div class="toret-box box-info">
    <div class="box-header">
      <h3 class="box-title"><?php _e('Stock manager','stock-manager'); ?></h3>
    </div>
  <div class="box-body">
      <div class="lineloader"></div>
      
      <div class="stock-filter">
        <form method="get" action="">
          <select name="product-type">
            <option value="simple" <?php if(isset($_GET['product-type']) && $_GET['product-type'] == 'simple'){ echo 'selected="selected"'; } ?> ><?php _e('Simple products','stock-manager'); ?></option>
            <option value="variable" <?php if(isset($_GET['product-type']) && $_GET['product-type'] == 'variable'){ echo 'selected="selected"'; } ?>><?php _e('Products with variation','stock-manager'); ?></option>
          </select>
          <input type="hidden" name="page" value="stock-manager" />
          <input type="submit" name="show-product-type" value="<?php _e('Show','stock-manager'); ?>" class="btn btn-info" />
        </form>
        <form method="get" action="">
          <select name="product-category">
            <option value="all"><?php _e('All categories','stock-manager'); ?></option>
            <?php
              if(isset($_GET['product-category']) && $_GET['product-category'] != 'all' ){
                echo $stock->products_categories($_GET['product-category']);
              }else{
                echo $stock->products_categories();
              }
              
            ?>
          </select>
          <input type="hidden" name="page" value="stock-manager" />
          <input type="submit" name="show-product-category" value="<?php _e('Show','stock-manager'); ?>" class="btn btn-info" />
        </form>
        <form method="get" action="">
          <select name="manage-stock">
            <option value="no"><?php _e('No manage stock','stock-manager'); ?></option>
            <option value="yes"><?php _e('Yes manage stock','stock-manager'); ?></option>
          </select>
          <input type="hidden" name="page" value="stock-manager" />
          <input type="submit" name="show-manage-stock" value="<?php _e('Show','stock-manager'); ?>" class="btn btn-info" />
        </form>
        <form method="get" action="">
          <select name="stock-status">
            <option value="instock"><?php _e('In stock','stock-manager'); ?></option>
            <option value="outofstock"><?php _e('Out of stock','stock-manager'); ?></option>
          </select>
          <input type="hidden" name="page" value="stock-manager" />
          <input type="submit" name="show-stock-status" value="<?php _e('Show','stock-manager'); ?>" class="btn btn-info" />
        </form>
        <a href="<?php echo admin_url().'admin.php?page=stock-manager'; ?>" class="btn btn-danger"><?php _e('Clear filter','stock-manager'); ?></a>
      </div>
    <form method="post" action="">  
      <table class="table-bordered">
        <tr>
          <th><?php _e('SKU','stock-manager'); ?></th>
          <th><?php _e('ID','stock-manager'); ?></th>
          <th><?php _e('Name','stock-manager'); ?></th>
          <th><?php _e('Product type','stock-manager'); ?></th>
          <th><?php _e('Parent ID','stock-manager'); ?></th>
          <th><?php _e('Manage stock','stock-manager'); ?></th>
          <th><?php _e('Stock status','stock-manager'); ?></th>
          <th><?php _e('Backorders','stock-manager'); ?></th>
          <th style="width:50px;"><?php _e('Stock','stock-manager'); ?></th>
          <th style="width:100px;"><?php _e('Save','stock-manager'); ?></th>
        </tr>
      <?php $products = $stock->get_products($_GET); ?>
      <?php foreach( $products as $item ){ 
        $product_meta = get_post_meta($item->ID);
        $item_product = get_product($item->ID);
        $product_type = $item_product->product_type;
      ?>
        <tr>
          <input type="hidden" name="product_id[<?php echo $item->ID; ?>]" value="<?php echo $item->ID; ?>" />
          <td><?php if(!empty($product_meta['_sku'][0])){ echo $product_meta['_sku'][0]; } ?></td>
          <td class="td_center"><?php echo $item->ID; ?></td>
          <td><?php echo $item->post_title; ?></td>
          <td class="td_center">
            <?php if($product_type == 'variable'){
              echo '<span class="btn btn-info btn-sm show-variable" data-variable="'.$item->ID.'">'.__('Show wariables','stock-manager').'</span>';
            }else{ 
              echo $product_type; 
            } ?>
          </td>
          <td></td>
          <td>
            <select name="manage_stock[<?php echo $item->ID; ?>]" class="manage_stock_<?php echo $item->ID; ?>">
              <option value="yes" <?php if(!empty($product_meta['_manage_stock'][0]) && $product_meta['_manage_stock'][0] == 'yes'){ echo 'selected="selected"'; } ?>><?php _e('Yes','stock-manager'); ?></option>
              <option value="no" <?php if(!empty($product_meta['_manage_stock'][0]) && $product_meta['_manage_stock'][0] == 'no'){ echo 'selected="selected"'; } ?>><?php _e('No','stock-manager'); ?></option>
            </select>
          </td>
          <td>
            <select name="stock_status[<?php echo $item->ID; ?>]" class="stock_status_<?php echo $item->ID; ?>">
              <option value="instock" <?php if(!empty($product_meta['_stock_status'][0]) && $product_meta['_stock_status'][0] == 'instock'){ echo 'selected="selected"'; } ?>><?php _e('In stock','stock-manager'); ?></option>
              <option value="outofstock" <?php if(!empty($product_meta['_stock_status'][0]) && $product_meta['_stock_status'][0] == 'outofstock'){ echo 'selected="selected"'; } ?>><?php _e('Out of stock','stock-manager'); ?></option>
            </select>
          </td>
          <td>
            <select name="backorders[<?php echo $item->ID; ?>]" class="backorders_<?php echo $item->ID; ?>">
              <option value="no" <?php if(!empty($product_meta['_backorders'][0]) && $product_meta['_backorders'][0] == 'no'){ echo 'selected="selected"'; } ?>><?php _e('No','stock-manager'); ?></option>
              <option value="notify" <?php if(!empty($product_meta['_backorders'][0]) && $product_meta['_backorders'][0] == 'notify'){ echo 'selected="selected"'; } ?>><?php _e('Notify','stock-manager'); ?></option>
              <option value="yes" <?php if(!empty($product_meta['_backorders'][0]) && $product_meta['_backorders'][0] == 'yes'){ echo 'selected="selected"'; } ?>><?php _e('Yes','stock-manager'); ?></option>
            </select>
          </td>
          <?php 
            $class = '';
            if(!empty($product_meta['_stock'])){
            if($product_meta['_stock'][0] < 1){ 
              $stock_number = 0;
              $class = 'outofstock';
            }else{ 
              $stock_number = $product_meta['_stock'][0];
              if($product_meta['_stock'][0] < 5){ $class = 'lowstock'; }else{
                 $class = 'instock';
              } 
            } 
            }else{
               $class = '';
            }
            ?>
          <td class="td_center <?php echo $class; ?>" style="width:90px;">
            <input type="number" name="stock[<?php echo $item->ID; ?>]" value="<?php echo $stock_number; ?>" class="stock_<?php echo $item->ID; ?>" style="width:90px;" />
          </td>
          <td class="td_center"><span class="btn btn-primary btn-sm save-product" data-product="<?php echo $item->ID; ?>"><?php _e('Save','stock-manager'); ?></span></td>
        </tr>
        
        <?php 
            if($product_type == 'variable'){
                $args = array(
	               'post_parent' => $item->ID,
	               'post_type'   => 'product_variation', 
	               'numberposts' => -1,
	               'post_status' => 'publish' 
                ); 
                $variations_array = get_children( $args );
                foreach($variations_array as $vars){
             
        $product_meta = get_post_meta($vars->ID);
        $item_product = get_product($vars->ID);
        $product_type = 'product variation' ;
      ?>
        <tr class="variation-line variation-item-<?php echo $item->ID; ?>">
          <input type="hidden" name="product_id[<?php echo $vars->ID; ?>]" value="<?php echo $vars->ID; ?>" />
          <td><?php if(!empty($product_meta['_sku'][0])){ echo $product_meta['_sku'][0]; } ?></td>
          <td class="td_center"><?php echo $vars->ID; ?></td>
          <td><?php echo $vars->post_title; ?></td>
          <td><?php echo $product_type; ?></td>
          <td><?php echo $item->ID; ?></td>
          <td>
            <select name="manage_stock[<?php echo $vars->ID; ?>]" class="manage_stock_<?php echo $vars->ID; ?>">
              <option value="yes" <?php if(!empty($product_meta['_manage_stock'][0]) && $product_meta['_manage_stock'][0] == 'yes'){ echo 'selected="selected"'; } ?>><?php _e('Yes','stock-manager'); ?></option>
              <option value="no" <?php if(!empty($product_meta['_manage_stock'][0]) && $product_meta['_manage_stock'][0] == 'no'){ echo 'selected="selected"'; } ?>><?php _e('No','stock-manager'); ?></option>
            </select>
          </td>
          <td>
            <select name="stock_status[<?php echo $vars->ID; ?>]" class="stock_status_<?php echo $vars->ID; ?>">
              <option value="instock" <?php if(!empty($product_meta['_stock_status'][0]) && $product_meta['_stock_status'][0] == 'instock'){ echo 'selected="selected"'; } ?>><?php _e('In stock','stock-manager'); ?></option>
              <option value="outofstock" <?php if(!empty($product_meta['_stock_status'][0]) && $product_meta['_stock_status'][0] == 'outofstock'){ echo 'selected="selected"'; } ?>><?php _e('Out of stock','stock-manager'); ?></option>
            </select>
          </td>
          <td>
            <select name="backorders[<?php echo $vars->ID; ?>]" class="backorders_<?php echo $vars->ID; ?>">
              <option value="no" <?php if(!empty($product_meta['_backorders'][0]) && $product_meta['_backorders'][0] == 'no'){ echo 'selected="selected"'; } ?>><?php _e('No','stock-manager'); ?></option>
              <option value="notify" <?php if(!empty($product_meta['_backorders'][0]) && $product_meta['_backorders'][0] == 'notify'){ echo 'selected="selected"'; } ?>><?php _e('Notify','stock-manager'); ?></option>
              <option value="yes" <?php if(!empty($product_meta['_backorders'][0]) && $product_meta['_backorders'][0] == 'yes'){ echo 'selected="selected"'; } ?>><?php _e('Yes','stock-manager'); ?></option>
            </select>
          </td>
          <?php
          $class = '';
            if(!empty($product_meta['_stock'])){
            if($product_meta['_stock'][0] < 1){ 
              $stock_number = 0;
              $class = 'outofstock';
            }else{ 
              $stock_number = $product_meta['_stock'][0];
              if($product_meta['_stock'][0] < 5){ $class = 'lowstock'; }else{
                 $class = 'instock';
              } 
            } 
            }else{
               $class = '';
            }
            ?>
          <td class="td_center <?php echo $class; ?>" style="width:90px;">
            <?php if($product_meta['_stock'][0] < 1){ $stock_number = 0; }else{ $stock_number = $product_meta['_stock'][0]; } ?>
            <input type="number" name="stock[<?php echo $vars->ID; ?>]" value="<?php echo $stock_number; ?>" class="stock_<?php echo $vars->ID; ?>" style="width:90px;" />
          </td>
          <td class="td_center"><span class="btn btn-primary btn-sm save-product" data-product="<?php echo $vars->ID; ?>"><?php _e('Save','stock-manager'); ?></span></td>
        </tr>      
        <?php        
                }
            }
        ?>
        
      <?php } ?>
      
      </table>
      <input type="submit" name="save-all" class="btn btn-danger" value="<?php _e('Save all','stock-manager') ?>" />
      </form>
      <?php echo $stock->pagination(); ?>
  </div>
</div>  
  

</div>
