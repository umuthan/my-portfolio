<?php

/**
 * Plugin class
 **/
if ( ! class_exists( 'my_portfolio_category_tax_meta' ) ) {

class my_portfolio_category_tax_meta {

  public function __construct() {
    //
  }

 /*
  * Initialize the class and start calling our hooks and filters
  * @since 1.0.0
 */
 public function init() {
   add_action( 'portfolio_category_add_form_fields', array ( $this, 'add_portfolio_category_image' ), 10, 2 );
   add_action( 'created_portfolio_category', array ( $this, 'save_portfolio_category_image' ), 10, 2 );
   add_action( 'portfolio_category_edit_form_fields', array ( $this, 'update_portfolio_category_image' ), 10, 2 );
   add_action( 'edited_portfolio_category', array ( $this, 'updated_portfolio_category_image' ), 10, 2 );
   add_action( 'admin_enqueue_scripts', array( $this, 'load_media' ) );
   add_action( 'admin_footer', array ( $this, 'add_script' ) );
 }

public function load_media() {
 wp_enqueue_media();
}

 /*
  * Add a form field in the new portfolio_category page
  * @since 1.0.0
 */
 public function add_portfolio_category_image ( $taxonomy ) { ?>
   <div class="form-field term-group">
     <label for="portfolio_category-image-id"><?php _e('Image', 'my-portfolio'); ?></label>
     <input type="hidden" id="portfolio_category-image-id" name="portfolio_category-image-id" class="custom_media_url" value="">
     <div id="portfolio_category-image-wrapper"></div>
     <p>
       <input type="button" class="button button-secondary ct_tax_media_button" id="ct_tax_media_button" name="ct_tax_media_button" value="<?php _e( 'Add Image', 'my-portfolio' ); ?>" />
       <input type="button" class="button button-secondary ct_tax_media_remove" id="ct_tax_media_remove" name="ct_tax_media_remove" value="<?php _e( 'Remove Image', 'my-portfolio' ); ?>" />
    </p>
   </div>
 <?php
 }

 /*
  * Save the form field
  * @since 1.0.0
 */
 public function save_portfolio_category_image ( $term_id, $tt_id ) {
   if( isset( $_POST['portfolio_category-image-id'] ) && '' !== $_POST['portfolio_category-image-id'] ){
     $image = sanitize_text_field($_POST['portfolio_category-image-id']);
     add_term_meta( $term_id, 'portfolio_category-image-id', $image, true );
   }
 }

 /*
  * Edit the form field
  * @since 1.0.0
 */
 public function update_portfolio_category_image ( $term, $taxonomy ) { ?>
   <tr class="form-field term-group-wrap">
     <th scope="row">
       <label for="portfolio_category-image-id"><?php _e( 'Image', 'my-portfolio' ); ?></label>
     </th>
     <td>
       <?php $image_id = get_term_meta ( $term -> term_id, 'portfolio_category-image-id', true ); ?>
       <input type="hidden" id="portfolio_category-image-id" name="portfolio_category-image-id" value="<?php echo $image_id; ?>">
       <div id="portfolio_category-image-wrapper">
         <?php if ( $image_id ) { ?>
           <?php echo wp_get_attachment_image ( $image_id, 'thumbnail' ); ?>
         <?php } ?>
       </div>
       <p>
         <input type="button" class="button button-secondary ct_tax_media_button" id="ct_tax_media_button" name="ct_tax_media_button" value="<?php _e( 'Add Image', 'my-portfolio' ); ?>" />
         <input type="button" class="button button-secondary ct_tax_media_remove" id="ct_tax_media_remove" name="ct_tax_media_remove" value="<?php _e( 'Remove Image', 'my-portfolio' ); ?>" />
       </p>
     </td>
   </tr>
 <?php
 }

/*
 * Update the form field value
 * @since 1.0.0
 */
 public function updated_portfolio_category_image ( $term_id, $tt_id ) {
   if( isset( $_POST['portfolio_category-image-id'] ) && '' !== $_POST['portfolio_category-image-id'] ){
     $image = sanitize_text_field($_POST['portfolio_category-image-id']);
     update_term_meta ( $term_id, 'portfolio_category-image-id', $image );
   } else {
     update_term_meta ( $term_id, 'portfolio_category-image-id', '' );
   }
 }

/*
 * Add script
 * @since 1.0.0
 */
 public function add_script() { ?>
   <script>
     jQuery(document).ready( function($) {
       function ct_media_upload(button_class) {
         var _custom_media = true,
         _orig_send_attachment = wp.media.editor.send.attachment;
         $('body').on('click', button_class, function(e) {
           var button_id = '#'+$(this).attr('id');
           var send_attachment_bkp = wp.media.editor.send.attachment;
           var button = $(button_id);
           _custom_media = true;
           wp.media.editor.send.attachment = function(props, attachment){
             if ( _custom_media ) {
               $('#portfolio_category-image-id').val(attachment.id);
               $('#portfolio_category-image-wrapper').html('<img class="custom_media_image" src="" style="margin:0;padding:0;max-height:100px;float:none;" />');
               $('#portfolio_category-image-wrapper .custom_media_image').attr('src',attachment.url).css('display','block');
             } else {
               return _orig_send_attachment.apply( button_id, [props, attachment] );
             }
            }
         wp.media.editor.open(button);
         return false;
       });
     }
     ct_media_upload('.ct_tax_media_button.button');
     $('body').on('click','.ct_tax_media_remove',function(){
       $('#portfolio_category-image-id').val('');
       $('#portfolio_category-image-wrapper').html('<img class="custom_media_image" src="" style="margin:0;padding:0;max-height:100px;float:none;" />');
     });
     // Thanks: http://stackoverflow.com/questions/15281995/wordpress-create-portfolio_category-ajax-response
     $(document).ajaxComplete(function(event, xhr, settings) {
       var queryStringArr = settings.data.split('&');
       if( $.inArray('action=add-tag', queryStringArr) !== -1 ){
         var xml = xhr.responseXML;
         $response = $(xml).find('term_id').text();
         if($response!=""){
           // Clear the thumb image
           $('#portfolio_category-image-wrapper').html('');
         }
       }
     });
   });
 </script>
 <?php }

  }

$my_portfolio_category_tax_meta = new my_portfolio_category_tax_meta();
$my_portfolio_category_tax_meta -> init();

}
