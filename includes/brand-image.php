<?php

/**
 * Plugin class
 **/
if ( ! class_exists( 'my_portfolio_brand_tax_meta' ) ) {

class my_portfolio_brand_tax_meta {

  public function __construct() {
    //
  }

 /*
  * Initialize the class and start calling our hooks and filters
  * @since 1.0.0
 */
 public function init() {
   add_action( 'brand_add_form_fields', array ( $this, 'add_brand_image' ), 10, 2 );
   add_action( 'created_brand', array ( $this, 'save_brand_image' ), 10, 2 );
   add_action( 'brand_edit_form_fields', array ( $this, 'update_brand_image' ), 10, 2 );
   add_action( 'edited_brand', array ( $this, 'updated_brand_image' ), 10, 2 );
   add_action( 'admin_enqueue_scripts', array( $this, 'load_media' ) );
   add_action( 'admin_footer', array ( $this, 'add_script' ) );
 }

public function load_media() {
 wp_enqueue_media();
}

 /*
  * Add a form field in the new brand page
  * @since 1.0.0
 */
 public function add_brand_image ( $taxonomy ) { ?>
   <div class="form-field term-group">
     <label for="brand-image-id"><?php _e('Image', 'my-portfolio'); ?></label>
     <input type="hidden" id="brand-image-id" name="brand-image-id" class="custom_media_url" value="">
     <div id="brand-image-wrapper"></div>
     <p>
       <input type="button" class="button button-secondary br_tax_media_button" id="br_tax_media_button" name="br_tax_media_button" value="<?php _e( 'Add Image', 'my-portfolio' ); ?>" />
       <input type="button" class="button button-secondary br_tax_media_remove" id="br_tax_media_remove" name="br_tax_media_remove" value="<?php _e( 'Remove Image', 'my-portfolio' ); ?>" />
    </p>
   </div>
 <?php
 }

 /*
  * Save the form field
  * @since 1.0.0
 */
 public function save_brand_image ( $term_id, $tt_id ) {
   if( isset( $_POST['brand-image-id'] ) && '' !== $_POST['brand-image-id'] ){
     $image = sanitize_text_field($_POST['brand-image-id']);
     add_term_meta( $term_id, 'brand-image-id', $image, true );
   }
 }

 /*
  * Edit the form field
  * @since 1.0.0
 */
 public function update_brand_image ( $term, $taxonomy ) { ?>
   <tr class="form-field term-group-wrap">
     <th scope="row">
       <label for="brand-image-id"><?php _e( 'Image', 'my-portfolio' ); ?></label>
     </th>
     <td>
       <?php $image_id = get_term_meta ( $term -> term_id, 'brand-image-id', true ); ?>
       <input type="hidden" id="brand-image-id" name="brand-image-id" value="<?php echo $image_id; ?>">
       <div id="brand-image-wrapper">
         <?php if ( $image_id ) { ?>
           <?php echo wp_get_attachment_image ( $image_id, 'thumbnail' ); ?>
         <?php } ?>
       </div>
       <p>
         <input type="button" class="button button-secondary br_tax_media_button" id="br_tax_media_button" name="br_tax_media_button" value="<?php _e( 'Add Image', 'my-portfolio' ); ?>" />
         <input type="button" class="button button-secondary br_tax_media_remove" id="br_tax_media_remove" name="br_tax_media_remove" value="<?php _e( 'Remove Image', 'my-portfolio' ); ?>" />
       </p>
     </td>
   </tr>
 <?php
 }

/*
 * Update the form field value
 * @since 1.0.0
 */
 public function updated_brand_image ( $term_id, $tt_id ) {
   if( isset( $_POST['brand-image-id'] ) && '' !== $_POST['brand-image-id'] ){
     $image = sanitize_text_field($_POST['brand-image-id']);
     update_term_meta ( $term_id, 'brand-image-id', $image );
   } else {
     update_term_meta ( $term_id, 'brand-image-id', '' );
   }
 }

/*
 * Add script
 * @since 1.0.0
 */
 public function add_script() { ?>
   <script>
     jQuery(document).ready( function($) {
       function br_media_upload(button_class) {
         var _custom_media = true,
         _orig_send_attachment = wp.media.editor.send.attachment;
         $('body').on('click', button_class, function(e) {
           var button_id = '#'+$(this).attr('id');
           var send_attachment_bkp = wp.media.editor.send.attachment;
           var button = $(button_id);
           _custom_media = true;
           wp.media.editor.send.attachment = function(props, attachment){
             if ( _custom_media ) {
               $('#brand-image-id').val(attachment.id);
               $('#brand-image-wrapper').html('<img class="custom_media_image" src="" style="margin:0;padding:0;max-height:100px;float:none;" />');
               $('#brand-image-wrapper .custom_media_image').attr('src',attachment.url).css('display','block');
             } else {
               return _orig_send_attachment.apply( button_id, [props, attachment] );
             }
            }
         wp.media.editor.open(button);
         return false;
       });
     }
     br_media_upload('.br_tax_media_button.button');
     $('body').on('click','.br_tax_media_remove',function(){
       $('#brand-image-id').val('');
       $('#brand-image-wrapper').html('<img class="custom_media_image" src="" style="margin:0;padding:0;max-height:100px;float:none;" />');
     });
     // Thanks: http://stackoverflow.com/questions/15281995/wordpress-create-brand-ajax-response
     $(document).ajaxComplete(function(event, xhr, settings) {
       var queryStringArr = settings.data.split('&');
       if( $.inArray('action=add-tag', queryStringArr) !== -1 ){
         var xml = xhr.responseXML;
         $response = $(xml).find('term_id').text();
         if($response!=""){
           // Clear the thumb image
           $('#brand-image-wrapper').html('');
         }
       }
     });
   });
 </script>
 <?php }

  }

$my_portfolio_brand_tax_meta = new my_portfolio_brand_tax_meta();
$my_portfolio_brand_tax_meta -> init();

}
