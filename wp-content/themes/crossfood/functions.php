<?php 

	function crossfood_setup() {
		function nav($content) {
			$pattern = "<a ";
			$replacement = '<a itemprop="url" ';
			$content = str_replace($pattern, $replacement, $content);
			return $content;
		}

		add_filter('wp_nav_menu', 'nav');


		add_filter( 'post_thumbnail_html', 'remove_wps_width_attribute', 10 );
		add_filter( 'image_send_to_editor', 'remove_wps_width_attribute', 10 );

		function remove_wps_width_attribute( $html ) {
			$html = preg_replace( '/(width|height)=\"\d*\"\s/', "", $html );
			return $html;
		}

		add_theme_support('post-thumbnails');
		add_filter( 'post_thumbnail_html', 'remove_wps_width_attribute', 10 );

		add_theme_support('html5', array(
			'search_form',
			'comment_form',
			'comment_list',
			'gallery',
			'caption'
		));

		add_theme_support('post-formats', array(
			'aside',
			'image',
			'video',
			'gallery'
		));

		add_theme_support('pageparentdiv');

		function new_excerpt_length($length) {
			return 55;
		}
		
		add_filter('excerpt_more', function($more) {
			return '...';
		});

		add_filter('excerpt_length', 'new_excerpt_length');
	}

	add_action('after_setup_theme', 'crossfood_setup');

	// TEL MASK

    add_action('wp_enqueue_scripts', 'wpmidia_enqueue_masked_input');
        function wpmidia_enqueue_masked_input(){
        wp_enqueue_script('masked-input', get_template_directory_uri().'/src/js/jquery.maskedinput.min.js', array('jquery'));
    }

    add_action('wp_footer', 'wpmidia_activate_masked_input');
        function wpmidia_activate_masked_input(){
        ?>
            <script type="text/javascript">
                jQuery( function($){
                    $(".data").mask("99/99/9999");
                    $(".tel").mask("+38 (099) 999 99 99");
                    $(".cpf").mask("999.999.999-99");
                    $(".cnpj").mask("99.999.999/9999-99");
                });
            </script>
        <?php
    }





// подключаем функцию активации мета блока (my_extra_fields)
add_action('add_meta_boxes', 'my_extra_fields', 1);

function my_extra_fields() {
	add_meta_box( 'extra_fields', 'Дополнительные поля', 'extra_fields_box_func', 'post', 'normal', 'high'  );
}

// код блока
function extra_fields_box_func( $post ){
	?>

	<p><label>Цена<br> <input type="text" name="extra[desserts_price]" value="<?php echo get_post_meta($post->ID, 'desserts_price', 1); ?>" style="width:50%" /></label></p>

	<input type="hidden" name="extra_fields_nonce" value="<?php echo wp_create_nonce(__FILE__); ?>" />




	<p><label>Калории<br> <input type="text" name="extra[desserts_cal]" value="<?php echo get_post_meta($post->ID, 'desserts_cal', 1); ?>" style="width:50%;" /></label></p>

	<input type="hidden" name="extra_fields_nonce" value="<?php echo wp_create_nonce(__FILE__); ?>" />
	
	<p><label>Белки<br> <input type="text" name="extra[desserts_prot]" value="<?php echo get_post_meta($post->ID, 'desserts_prot', 1); ?>" style="width:50%;" /></label></p>

	<input type="hidden" name="extra_fields_nonce" value="<?php echo wp_create_nonce(__FILE__); ?>" />
	
	<p><label>Жиры<br> <input type="text" name="extra[desserts_fat]" value="<?php echo get_post_meta($post->ID, 'desserts_fat', 1); ?>" style="width:50%;" /></label></p>

	<input type="hidden" name="extra_fields_nonce" value="<?php echo wp_create_nonce(__FILE__); ?>" />

	<p><label>Углеводы<br> <input type="text" name="extra[desserts_car]" value="<?php echo get_post_meta($post->ID, 'desserts_car', 1); ?>" style="width:50%;" /></label></p>

	<input type="hidden" name="extra_fields_nonce" value="<?php echo wp_create_nonce(__FILE__); ?>" />





	<?php
}



// включаем обновление полей при сохранении
add_action('save_post', 'my_extra_fields_update', 0);

/* Сохраняем данные, при сохранении поста */
function my_extra_fields_update( $post_id ){
	if ( !isset($_POST['extra_fields_nonce']) || !wp_verify_nonce($_POST['extra_fields_nonce'], __FILE__) ) return false; // проверка
	if ( defined('DOING_AUTOSAVE') && DOING_AUTOSAVE  ) return false; // если это автосохранение
	if ( !current_user_can('edit_post', $post_id) ) return false; // если юзер не имеет право редактировать запись

	if( !isset($_POST['extra']) ) return false; 

	// Все ОК! Теперь, нужно сохранить/удалить данные
	$_POST['extra'] = array_map('trim', $_POST['extra']);
	foreach( $_POST['extra'] as $key=>$value ){
		if( empty($value) ){
			delete_post_meta($post_id, $key); // удаляем поле если значение пустое
			continue;
		}

		update_post_meta($post_id, $key, $value); // add_post_meta() работает автоматически
	}
	return $post_id;
}



	function crossfood_scripts() {

		wp_enqueue_script( 'jquery' );
		wp_enqueue_script( 'bootstrap', get_template_directory_uri() . '/src/js/bootstrap.js',"","1.0");
		wp_enqueue_script( 'main', get_template_directory_uri() . '/src/js/main.js',"","1.2");

	}




	add_action( 'wp_enqueue_scripts', 'crossfood_scripts' );