<?php
/**
 * @package   WooCommerce Stock Manager
 * @author    Vladislav Musílek
 * @license   GPL-2.0+
 * @link      http:/toret.cz
 * @copyright 2015 Toret.cz
 */

class WCM_Stock {

  /**
	 * Instance of this class.
	 *
	 * @since    1.0.0
	 *
	 * @var      object
	 */
	protected static $instance = null;
  
  /**
	 * Constructor for the stock class.
	 *
	 * @since     1.0.0
	 */
  public $limit = 100; 
   

	/**
	 * Constructor for the stock class.
	 *
	 * @since     1.0.0
	 */
	private function __construct() {

		
    
	}
  
  /**
	 * Return an instance of this class.
	 *
	 * @since     1.0.0
	 *
	 * @return    object    A single instance of this class.
	 */
	public static function get_instance() {

		// If the single instance hasn't been set, set it now.
		if ( null == self::$instance ) {
			self::$instance = new self;
		}

		return self::$instance;
	}
  
  
  /**
   * Return products
   *
   *   
   * @since 1.0.0  
   */        
  public function get_products($data = array()){
  
    $args = array();
    
    if(isset($_GET['product-type'])){
      if($_GET['product-type'] == 'variable'){
        $args['post_type'] = 'product';
        
        $args['tax_query'] = array(
									array(
										'taxonomy' 	=> 'product_type',
										'terms' 	  => 'variable',
										'field' 	  => 'slug'
									)
								);
        
      }else{
        $args['post_type'] = 'product';
        $args['tax_query'] = array(
									array(
										'taxonomy' 	=> 'product_type',
										'terms' 	  => 'simple',
										'field' 	  => 'slug'
									)
								);
      }
    }else{
        $args['post_type'] = 'product';
    }

    /**
     * Product category filter
     */         
    if(isset($_GET['product-category'])){
      if($_GET['product-category'] != 'all'){
      
      $category = $_GET['product-category'];
      
      $args['tax_query'] = array(
									array(
										'taxonomy' 	=> 'product_cat',
										'terms' 	  => $category,
										'field' 	  => 'term_id'
									)
								);   
      }
    }
   
   if(isset($_GET['stock-status'])){ 
      $status = $_GET['stock-status'];
   
      $args['meta_key']   = '_stock_status';
      $args['meta_value'] = $status;
   }
   
   if(isset($_GET['manage-stock'])){ 
      $manage = $_GET['manage-stock'];
      
      $args['meta_key']   = '_manage_stock';
      $args['meta_value'] = $manage;
   }


    $args['posts_per_page'] = $this->limit;


    if(!empty($_GET['offset'])){
      $offset = $_GET['offset'] - 1;
      $offset = $offset * $this->limit;
      $args['offset'] = $offset;

    }
  
  
    $the_query = new WP_Query( $args );
    
    return $the_query->posts;
  } 
  
  /**
   * Return all products
   *
   *   
   * @since 1.0.0  
   */        
  public function get_all_products(){
  
    
    
    
    $args = array();
    
    if(isset($_GET['product-type'])){
      if($_GET['product-type'] == 'variable'){
        $args['post_type'] = 'product';
        
        $args['tax_query'] = array(
									array(
										'taxonomy' 	=> 'product_type',
										'terms' 	  => 'variable',
										'field' 	  => 'slug'
									)
								);
        
      }else{
        $args['post_type'] = 'product';
        $args['tax_query'] = array(
									array(
										'taxonomy' 	=> 'product_type',
										'terms' 	  => 'simple',
										'field' 	  => 'slug'
									)
								);
      }
    }else{
        $args['post_type'] = 'product';
    }
    
    
    /**
     * Product category filter
     */         
    if(isset($_GET['product-category'])){
      if($_GET['product-category'] != 'all'){
      
      $category = $_GET['product-category'];
      
      $args['tax_query'] = array(
									array(
										'taxonomy' 	=> 'product_cat',
										'terms' 	  => $category,
										'field' 	  => 'term_id'
									)
								);   
      }
    }
   
   if(isset($_GET['stock-status'])){ 
      $status = $_GET['stock-status'];
   
      $args['meta_key']   = '_stock_status';
      $args['meta_value'] = $status;
   }
   
   if(isset($_GET['manage-stock'])){ 
      $manage = $_GET['manage-stock'];
      
      $args['meta_key']   = '_manage_stock';
      $args['meta_value'] = $manage;
   }
    
    
    
    
    
    $args['posts_per_page'] = -1;
    
    $the_query = new WP_Query( $args );
    
    return $the_query->posts;
  }   
  
  /**
   * Return all products
   *
   *   
   * @since 1.0.0  
   */        
  public function get_products_for_export(){
  
    $args = array();
    $args['post_type'] = 'product';
    $args['posts_per_page'] = -1;
    
    $the_query = new WP_Query( $args );
    
    return $the_query->posts;
  }   
  
  /**
   * Return pagination
   *
   */        
  public function pagination(){
     
     $all = count($this->get_all_products());
     $pages = ceil($all / $this->limit);
     if(!empty($_GET['offset'])){
       $current = $_GET['offset'];
     }else{
       $current = 1;
     }
     
     $html = '';
     $html .= '<div class="stock-manager-pagination">';
     $query_string = $_SERVER['QUERY_STRING'];
     if($pages != 1){
     
      for ($i=1; $i <= $pages; $i++){
        if($current == $i){
            $html .= '<span class="btn btn-default">'.$i.'</span>';
        }else{
            $html .= '<a class="btn btn-primary" href="'.admin_url().'admin.php?'.$query_string.'&offset='.$i.'">'.$i.'</a>';
        }
      }
     
     }
     
     $html .= '</div>';
     
     return $html;
  }  
  
  /**
   * Save all meta data
   *
   */        
  public function save_all($data){
    foreach($data['product_id'] as $key => $item){
  
     $manage_stock = sanitize_text_field($data['manage_stock'][$item]);
     $stock_status = sanitize_text_field($data['stock_status'][$item]);
     $backorders   = sanitize_text_field($data['backorders'][$item]);
     $stock        = sanitize_text_field($data['stock'][$item]);
  
     update_post_meta($item, '_manage_stock', $manage_stock);
     update_post_meta($item, '_stock_status', $stock_status);
     update_post_meta($item, '_backorders', $backorders);
     update_post_meta($item, '_stock', $stock);
     
    }   
  }
  
  /**
   *
   * Get prduct categories 
   *
   */   
  public function products_categories($selected = null){
    $out = '';
    
    $terms = get_terms(
                      'product_cat', 
                      array(
                            'hide_empty' => 0, 
                            'orderby' => 'ASC'
                      )
    );
    if(count($terms) > 0)
    {
        foreach ($terms as $term)
        {
            if(!empty($selected) && $selected == $term->term_id){ $sel = 'selected="selected"'; }else{ $sel = ''; }
            $out .= '<option value="'.$term->term_id.'" '.$sel.'>'.$term->name.'</option>';
        }
        return $out;
    }
    return;
  }
  
  
  
}//End class  