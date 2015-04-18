=== WooCommerce Stock Manager ===
Contributors: Musilda
Donate link: 
Tags: WooCommerce, stock manager
Requires at least: 3.5.1
Tested up to: 4.0
Stable tag: 1.0.1
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

== Description ==

WooCommerce Stock Manager allows you manage stock for products and their variables from one screen. 

Plugin is compatible with WooCommerce 2.1+ and is tested on 2.3 version. 

A few notes about the plugin:

*   You can set "Manage stock" for each product and variation
*   You can set "Stock status" for each product and variation
*   You can set "Backorders" for each product and variation
*   You can set "Stock" for each product and variation

Stock field is green, when stock is more than 5 pieces.
Stock field is yellow, when stock is low than 5 pieces.
Stock field is red, when stock is 0 pieces.

You can filter products by type, category, stock manage or stock status.

Variants for variable product is posible edit after click on "Show variables" button.
Each product or variation, can be save separatelly, or you can save all displayed data.

Import/Export

With plugin is possible export all stock data from your eshop, edit them and import back with csv file.

Export file structure:

SKU - product unique identificator, required.
Manage stock - values: "yes", "notify", "no". If is empty "no" will be save.
Stock status - values: "instock", "outofstock". If is empty "outofstock" will be save.
Backorders - values: "yes", "notify", "no". If is empty "no" will be save.
Stock - quantity value.
Product type - type of product.
Parent SKU - if product is variant, parent product SKU is displayed for better filtering csv file.     


== Installation ==

= Using The WordPress Dashboard =

1. Navigate to the 'Add New' in the plugins dashboard
2. Search for 'WooCommerce Stock Manager'
3. Click 'Install Now'
4. Activate the plugin on the Plugin dashboard

= Uploading in WordPress Dashboard =

1. Navigate to the 'Add New' in the plugins dashboard
2. Navigate to the 'Upload' area
3. Select `woocommerce-stock-manager.zip` from your computer
4. Click 'Install Now'
5. Activate the plugin in the Plugin dashboard

= Using FTP =

1. Download `woocommerce-stock-manager.zip`
2. Extract the `woocommerce-stock-manager` directory to your computer
3. Upload the `woocommerce-stock-manager` directory to the `/wp-content/plugins/` directory
4. Activate the plugin in the Plugin dashboard


== Frequently Asked Questions ==


== Screenshots ==

1. Edit stock product data
2. Edit stock variations data
3. Import/export
4. Show product variations

== Changelog ==

= 1.0.0 =
Startup version


== Upgrade Notice ==

= 1.0.0 =
Startup version