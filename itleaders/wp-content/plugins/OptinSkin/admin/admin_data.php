<?php
include_once 'admin_functions.php';
function ois_designs_code() {
	$regular_fonts = array (
		'Arial',
		'Verdana',
		'Serif',
		'Georgia',
		'Helvetica',
	);
	$google_fonts = array (
		'Neuton',
		'Dancing Script',
		'Lobster',
		'Nobile',
		'Francois One',
		'Luckiest Guy',
		'PT Serif',
		'Open Sans',
		'Lora',
		'Ropa Sans',
		'Parisienne',
		'Asap',
		'Glegoo',
		'Droid Sans',
		'Ubuntu',
		'Arvo',
		'Coming Soon',
		'Lato',
		'The Girl Next Door',
		'Shadows Into Light',
		'Calligraffitti',
		'Crafty Girls',
		'Josefin Sans',
		'Marck Script',
		'Kaushan Script',
		'Condiment',
		'Kaushan Script',
		'Lilita One',
		'Kotta One',
		'Homenaje',
		'Cantarell',
		'Esteban',
		'Flamenco',
		'Cambo',
		'Fanwood Text',
		'Terminal Dosis',
		'Voces',
		'Shadows Into Light',
		'Patua One',
	);
	update_option('ois_google_fonts', $google_fonts);
	update_option('ois_regular_fonts', $regular_fonts);
	$social_buttons = new ois_social();
	
	$id = 1;
	$skin_1 = array(
		'title' => 'Simple Signup',
		'description' => '',
		'date_added' => date('Y-m-d H:i:s'),
		'last_modified' => date('Y-m-d H:i:s'),
		'design_preview' => OptinSkin_URL . 'admin/images/design_previews/1.png',
		'css' => '',
		'css_url' => OptinSkin_URL . 'skins/css/design_2.css',
		'id' => $id,
		'social_media' => array (),
		'custom' => 'no',
		'new_form' => 'yes',
		'optin_settings' => array (
			'enable_name' => 'no',
			'placeholders' => array (
				'email' => 'Your Email Address',
			),
			'labels' => array (
			),
			'button_value' => '\'',
			'force_break' => 'yes',
			'maintain_line' => 'no',
		),
		'html' => '
<div class="ois_box_' . $id . ' container-fluid" style="' . ois_vertical_gradient('%background-top-gradient%', '%background-bottom-gradient%') . 'width:%box-width%!important; border-radius: %border-radius% !important; -moz-border-radius: %-webkit-border-radius% !important; %border-radius% !important; border-color: %border-color% !important;">
		<div class="ois_title_' . $id . '" style="color: %title-font-color% !important; font-size: %title-font-size% !important; font-family: \'%title-font%\', Arial !important; padding-bottom: %title-padding-bottom% !important; text-align: %title-text-align% !important;">%title-text%</div>
		<div class="ois_subtitle_' . $id . '" style="color: %subtitle-font-color% !important;font-size: %subtitle-font-size% !important; font-family: \'%subtitle-font%\', Arial !important; padding-bottom: %subtitle-padding-bottom% !important;">%subtitle-text%</div>
		%optin_form%
	<div style="clear:both"></div>
</div>',
		'appearance' => array (
			'text' => array (
				'Title Font Color' => ois_color_option ( 'title-font-color', '#000' ),
				'Subtitle Font Color' => ois_color_option ( 'subtitle-font-color', '#868181' ),
				'Background Top Gradient' => ois_color_option ( 'background-top-gradient', '#fafafa' ),
				'Background Bottom Gradient' => ois_color_option ( 'background-bottom-gradient', '#e0e0e0'),
				'Button Top Gradient' => ois_color_option( 'button-top-gradient', '#62ABD8' ),
				'Button Bottom Gradient' => ois_color_option( 'button-bottom-gradient', '#62ABD8' ),
				'Button Text Color' => ois_color_option( 'button-text-color', '#eee' ),
				'Border Color' => ois_color_option( 'border-color', '#D6D6D6' ),
				'Button Border Color' => ois_color_option( 'button-border-color', '#10A0AE' ),
				'Title Font' => ois_font_option('title-font', 'Glegoo'),
				'Subtitle Font' => ois_font_option('subtitle-font', 'Glegoo'),
				'Title Text' => ois_title_text('&quot;Get our updates, free!&quot;'),
				'Subtitle Text' => ois_subtitle_text('Never miss a blog post again'),
				'Title Font Size' => ois_general_option( 'title-font-size', '18px' ),
				'Subtitle Font Size' => ois_general_option( 'subtitle-font-size', '14px' ),
				'Padding Beneath Subtitle' => ois_general_option( 'subtitle-padding-bottom', '10px' ),
				'Button Text' => ois_button_text('Subscribe Now'),
				'Title Text Align' => array (
					'attr' => 'title-text-align',
					'default' => 'center',
					'values' => array (
						'Left' => 'left',
						'Center' => 'center',
						'Right' => 'right',
					),
					'type' => 'dropdown',
				),
				'Width' => ois_general_option( 'box-width', '200px' ),
				'Rounded Corners (Border Radius)' => ois_general_option( 'border-radius', '4px' ),
				'Email Placeholder' => ois_email_placeholder('Your Email Address'),
			),
		),
	);
	$id = 2;
	$skin_15 = array (
		'html' => '<div class="ois_box_' . $id . '" style="%background-style%">
			<div class="ois_title_' . $id . '">%title-text%</div>
			<div class="ois_subtext_' . $id . '">%subtext%</div>
			%optin_form%
		</div>',
		'title' => 'Prestyled',
		'description' => '',
		'date_added' => date('Y-m-d H:i:s'),
		'last_modified' => date('Y-m-d H:i:s'),
		'css' => '',
		'css_url' => OptinSkin_URL . 'skins/css/design_15.css',
		'design_preview' => OptinSkin_URL . 'admin/images/design_previews/2.png',
		'id' => $id,
		'custom' => 'no',
		'optin_settings' => array (
			'enable_name' => 'yes',
			'placeholders' => array (
				'name' => 'enter your name',
				'email' => 'enter your email',
			),
			'labels' => array (
				//'email' => 'Your Email',
			),
			'button_value' => '\'',
			'force_break' => 'yes',
			'maintain_line' => 'no',
		),
		'enable_name' => 'yes',
		'appearance' => array (
			'text' => array (
				'Style' => array (
					'attr' => 'background-style',
					'default' => ois_vertical_gradient('rgb(102, 131, 179)', 'rgb(80, 110, 160)'),
					'values' => array (
						'Blue' => ois_vertical_gradient('rgb(102, 131, 179)', 'rgb(80, 110, 160)'),
						'Purple' => ois_vertical_gradient('rgb(118, 102, 179)', 'rgb(96, 80, 160)'),
						'Green' => ois_vertical_gradient('rgb(102, 179, 108)', '#50a056'),
						'Red' => ois_vertical_gradient('rgb(196, 114, 112)', 'rgb(178, 91, 89)'),
						'Pink' => ois_vertical_gradient('rgb(184, 105, 146)', 'rgb(165, 83, 126)'),
						'Orange' => ois_vertical_gradient('rgb(224, 138, 37)', 'rgb(224, 138, 37)'),
					),
					'type' => 'dropdown',
				),
				'Title Text' => ois_title_text('Sign up to my newsletter'),
				'Subtext Content' => array (
					'attr' => 'subtext',
					'default' => 'All that glitters is not gold; not all who wander are lost.',
					'type' => 'textarea',
					'height' => '50px',
					'width' => '350px',
				),
				'Button Text' => ois_button_text('Sign Up'),
				'Email Placeholder' => ois_email_placeholder('enter your email'),
				'Name Placeholder' => ois_name_placeholder('enter your name'),
			),
		),
	);
	$id = 3;
	$skin_3 = array(
		'title' => 'Elegant Signup Form 1',
		'description' => '',
		'date_added' => date('Y-m-d H:i:s'),
		'last_modified' => date('Y-m-d H:i:s'),
		'id' => $id,
		'custom' => 'no',
		'optin_settings' => array (
			'enable_name' => 'yes',
			'placeholders' => array (
				'name' => 'Your Name',
				'email' => 'Your Email',
			),
			'labels' => array (
			),
			'button_value' => 'Subscribe Now',
			'force_break' => 'yes',
			'maintain_line' => 'no',
		),
		
		'design_preview' => OptinSkin_URL . 'admin/images/design_previews/3.png',
		'html' => '<div class="ois_inner_wrap_' . $id . ' container-fluid" style="max-width:220px;width: expression(this.width > 220 ? 220: true);' . ois_vertical_gradient('%background-top-gradient%', '%background-bottom-gradient%') . '<div class="ois_' . $id . '" class="container-fluid">
		<div class="ois_inner_' . $id . '">
    <div class="ois_title_' . $id . '" style="color:%title-color% !important; text-shadow: %title-text-shadow-color% 0 1px 0 !important;">%title-text%</div>
    <div class="ois_subtitle_' . $id . '" style="color:%subtitle-color% !important; text-shadow: %subtitle-text-shadow-color% 0 1px 0 !important;">%subtitle%</div>
    %optin_form%
  </div>
 </div>',
		'css' => '',
		'css_url' => OptinSkin_URL . 'skins/css/design_3.css',
		'appearance' => array (
			'text' => array (
				'Background Top Gradient' => ois_color_option ( 'background-top-gradient', '#f8f8f8' ),
				'Background Bottom Gradient' => ois_color_option ( 'background-bottom-gradient', '#f8f8f8'),
				'Title Color' => ois_color_option( 'title-color', '#333' ),
				'Subtitle Color' => ois_color_option( 'subtitle-color', '#ffc600' ),
				'Title' => ois_title_text('Stay in touch'),
				'Subtitle' => array(
					'attr' => 'subtitle',
					'default' => 'Sign up for free updates',
					'text-width' => '250px',
				),
				'Title Text Shadow' => ois_color_option( 'title-text-shadow-color', '#fff' ),
				'Subtitle Text Shadow' => ois_color_option( 'subtitle-text-shadow-color', '#fff' ),
				'Button Text' => ois_button_text('Subscribe Now'),
				'Name Placeholder' => ois_name_placeholder('Your Name'),
				'Email Placeholder' => ois_email_placeholder('Your Email'),
			),
		),
	);
	$id = 4;
	$skin_4 = array(
		'title' => 'Elegant Signup Form 2',
		'description' => '',
		'date_added' => date('Y-m-d H:i:s'),
		'last_modified' => date('Y-m-d H:i:s'),
		'id' => $id,
		'custom' => 'no',
		'design_preview' => OptinSkin_URL . 'admin/images/design_previews/4.png',
		'optin_settings' => array (
			'enable_name' => 'yes',
			'placeholders' => array (
				'name' => 'Your Name',
				'email' => 'Email Address',
			),
			'labels' => array (
			),
			'button_value' => 'Sign Up Now',
			'force_break' => 'yes',
			'maintain_line' => 'no',
		),
		
		'html' => '<div class="ois_inner_wrap_' . $id . ' container-fluid" style="max-width:300px;width: expression(this.width > 300 ? 300: true);' . ois_vertical_gradient('%background-top-gradient%', '%background-bottom-gradient%') . 'text-align:left !important; background-color:%background-color% !important; width: %box-width% !important;"><div class="ois_title_' . $id . '" style="line-height: %title-font-size% !important; font-size: %title-font-size% !important;color:%title-color% !important;font-family: \'%title-font%\', Lucida Grande, sans-serif !important;">%title%</div><div class="ois_subtitle_' . $id . '" style="line-height: %subtitle-font-size% !important;font-size: %subtitle-font-size% !important;font-family: \'%subtitle-font%\', Lucida Grande, sans-serif !important;color:%subtitle-color% !important;">%subtitle%</div>%optin_form%</div>',
		'css' => '',
		'css_url' => OptinSkin_URL . 'skins/css/design_4.css',
		'appearance' => array (
			'text' => array (
				'Background Top Gradient' => ois_color_option ( 'background-top-gradient', '#acc7df' ),
				'Background Bottom Gradient' => ois_color_option ( 'background-bottom-gradient', '#7e97ad'),
				'Title Color' => ois_color_option( 'title-color', '#fff' ),
				'Subtitle Color' => ois_color_option( 'subtitle-color', '#f8e082' ),
				'Title Font' => array (
					'attr' => 'title-font',
					'default' => 'Droid Sans',
					'type' => 'google_font'
				),
				'Subtitle Font' => array (
					'attr' => 'subtitle-font',
					'default' => 'Droid Sans',
					'type' => 'google_font'
				),
				'Title Font Size' => array (
					'attr' => 'title-font-size',
					'default' => '20px',
				),
				'Subtitle Font Size' => array (
					'attr' => 'subtitle-font-size',
					'default' => '16px',
				),
				'Title Text' => ois_general_option( 'title', 'Get Our Free eBook' ),
				'Subtitle Text' => ois_general_option( 'subtitle', 'Easy Weight Loss in 7 Steps' ),
				'Button Text' => ois_button_text('Sign Up Now'),
				'Name Placeholder' => ois_name_placeholder('Your Name'),
				'Email Placeholder' => ois_email_placeholder('Email Address'),
			),
		),
	);

	$id = 5;
	$skin_5 = array (
		'title' => 'Horizontal Social and Signup 1',
		'description' => '',
		'date_added' => date('Y-m-d H:i:s'),
		'last_modified' => date('Y-m-d H:i:s'),
		'id' => $id,
		'custom' => 'no',
		'design_preview' => OptinSkin_URL . 'admin/images/design_previews/5.png',
		'optin_settings' => array (
			'button_value' => 'Sign Up Now'
		),
		'social_media' => array (
			'facebook', 'twitter', 'gplus', 'stumbleupon', 'linkedin', 'reddit',
		),
		'force_break' => 'yes',
		'css_url' => OptinSkin_URL . 'skins/css/design_5.css',
		'html' => '<div class="ois_box_' . $id . ' container-fluid" style="max-width:600px;width: expression(this.width > 600 ? 600: true);border: 1px solid %outer-border-color% !important;background-color: %background-color% !important;">
	<div class="ois_wrap_' . $id . '" >
		<div class="row-fluid">
			<div class="span7">
				<div class="ois_title_' . $id . '" style="font-size: %title-font-size% !important; color:%title-color% !important; font-family: \'%google-font%\', Arial !important; margin-bottom:10px !important;">%left-title%</div>
				<div class="row-fluid">
					<div class="span4">
						' . $social_buttons->ois_fbLike() . '
					</div>
					<div class="span4">
						' . $social_buttons->ois_retweet() . '
					</div>
					<div class="span4">
						' . $social_buttons->ois_gplus() . '
					</div>
				</div>
				<div class="row-fluid">
					<div class="span4">
						' . $social_buttons->ois_stumbleupon() . '
					</div>
					<div class="span4">
						' . $social_buttons->ois_linkedin() . '
					</div>
					<div class="span4">
						' . $social_buttons->ois_reddit() . '
					</div>
				</div>
			</div>
			<div class="span5">
				<div class="ois_title_' . $id . '" style="font-size: %title-font-size% !important; font-family: \'%google-font%\', Arial !important; color:%title-color% !important">%right-title%</div>
				%optin_form%
			</div>
		</div>
	</div>
	<div style="clear:both;"></div>
</div>',
		'css' => '',
		'optin_settings' => array (
			'enable_name' => 'yes',
			'placeholders' => array (
				'name' => 'Your Name',
				'email' => 'Email Address',
			),
			'labels' => array (
			),
			'button_value' => 'Sign Up Now',
			'force_break' => 'yes',
		),
		'appearance' => array (
			'text' => array (
				'Background Color' => ois_color_option ( 'background-color', '#f3f3f3' ),
				'Title Color' => ois_color_option( 'title-color', '#0e4a66' ),
				
				'Left Title Text' => array(
					'attr' => 'left-title',
					'default' => 'Share the Love',
					'text-width' => '250px',
				),
				'Right Title Text' => array(
					'attr' => 'right-title',
					'default' => 'Get Free Updates',
					'text-width' => '250px',
				),
				'Button Text' => ois_button_text('Sign Up Now'),
				
				'Title Font' => array (
					'attr' => 'google-font',
					'default' => 'PT Serif',
					'type' => 'google_font',
				),
				'Title Font-Size' => array (
					'attr' => 'title-font-size',
					'default' => '23px',
				),
				'Separator Color' => array(
					'attr' => 'separator-color',
					'default' => '#ccc',
					'type' => 'color',
				),
				'Outer-Border Color' => array(
					'attr' => 'outer-border-color',
					'default' => '#e7e7e7',
					'type' => 'color',
				),
				'Name Placeholder' => ois_name_placeholder('Your Name'),
				'Email Placeholder' => ois_email_placeholder('Email Address'),
			),
		),
	);

	$id = 6;
	$skin_6 = array(
		'title' => 'Horizontal Social and Signup 2',
		'description' => '',
		'date_added' => date('Y-m-d H:i:s'),
		'last_modified' => date('Y-m-d H:i:s'),
		'id' => $id,
		'custom' => 'no',
		'design_preview' => OptinSkin_URL . 'admin/images/design_previews/6.png',
		'optin_settings' => array (
			'button_value' => 'Sign Up Now'
		),
		'css' => '',
		'optin_settings' => array (
			'enable_name' => 'yes',
			'placeholders' => array (
				'name' => 'Your Name',
				'email' => 'Email Address',
			),
			'labels' => array (
			),
			'button_value' => 'Sign Up Now',
			'force_break' => 'yes',
		),
		'social_media' => array (
			'facebook', 'twitter', 'gplus', 'stumbleupon',
		),
		'css_url' => OptinSkin_URL . 'skins/css/design_6.css',
		'html' => '
<div class="ois_box_' . $id . ' container-fluid" style="max-width:520px;width: expression(this.width > 520 ? 520: true);border-radius: %border-radius% !important; -moz-border-radius:%border-radius% !important; -webkit-border-radius: %border-radius% !important;' . ois_vertical_gradient('%background-top-gradient%', '%background-bottom-gradient%') . '">
	<div class="row-fluid">
		<div class="span7">
			<div class="ois_title_' . $id . '" style="font-size: %title-font-size% !important; color:%title-color% !important; font-family: \'%google-font%\', Arial !important;">%title-left%</div>
			<div class="ois_underscore" style="margin-top: %underscore-margin-top% !important;">
				<img src="%underscore-image%" />
			</div>
			<div class="row-fluid" >
				<div class="span3">' . $social_buttons->ois_fb_box() . '</div>
				<div class="span3">' . $social_buttons->ois_gplus_box() . '</div>
				<div class="span3">' . $social_buttons->ois_twitter_box() . '</div>
				<div class="span3">' . $social_buttons->ois_stumbleupon_box() . '</div>
			</div>
		</div>
		<div class="span5">
			<div class="ois_title_' . $id . '" style="font-size: %title-font-size% !important; color:%title-color% !important; font-family: \'%google-font%\', Arial !important;">%title-right%</div>
			<div class="ois_underscore" style="margin-top: %underscore-margin-top% !important;">
				<img src="%underscore-image%" />
			</div>
			<div class="row-fluid">
				<div class="span12" style="padding-top: 5px;">%optin_form%</div>
			</div>
		</div>
	</div>
</div>',
		'appearance' => array (
			'text' => array (
				'Left Title Text' => array(
					'attr' => 'title-left',
					'default' => 'Share the Love',
					'text-width' => '250px',
				),
				'Right Title Text' => array(
					'attr' => 'title-right',
					'default' => 'Get Free Updates',
					'text-width' => '250px',
				),
				'Background Gradient Top Color' => array(
					'attr' => 'background-top-gradient',
					'default' => '#545554',
					'type' => 'color'
				),
				'Background Gradient Bottom Color' => array(
					'attr' => 'background-bottom-gradient',
					'default' => '#000',
					'type' => 'color'
				),
				'Title Color' => array(
					'attr' => 'title-color',
					'default' => '#ffd21f',
					'type' => 'color'
				),
				'Title Font' => array (
					'attr' => 'google-font',
					'default' => 'Lobster',
					'type' => 'google_font',
				),
				'Title Font-Size' => array (
					'attr' => 'title-font-size',
					'default' => '23px',
				),
				'Button Text' => ois_button_text('Sign Up Now'),
				'Border Radius (rounded corners)' => array (
					'attr' => 'border-radius',
					'default' => '3px',
				),
				'Space Above Underscore' => array (
					'attr' => 'underscore-margin-top',
					'default' => '0px',
				),
				'Underscore Image (url or blank)' => array(
					'attr' => 'underscore-image',
					'default' =>  OptinSkin_URL . 'front/images/underscore.png',
					'text-width' => '380px',
				),
				'Email Placeholder' => ois_email_placeholder('Email Address'),
				'Name Placeholder' => ois_name_placeholder('Your Name'),
			),
		),
	);
	$id = 7;
	$skin_7 = array(
		'title' => 'Longer Subtext Signup',
		'description' => '',
		'design_preview' => OptinSkin_URL . 'admin/images/design_previews/7.png',
		'date_added' => date('Y-m-d H:i:s'),
		'last_modified' => date('Y-m-d H:i:s'),
		'html' => '<div class="ois_box_' . $id . ' container-fluid" style="max-width:230px;width: expression(this.width > 230 ? 230: true);background-color: %background-color% !important; border: 1px solid %border-color% !important;">
	    	<div class="ois_title_' . $id . '" style="font-size: %title-font-size% !important; color: %title-color% !important;font-family: \'%title-font%\', Lucida Grande, sans-serif !important;">%title-text%</div>
	    	<div class="ois_subtitle_' . $id . '" style="font-size: %subtitle-font-size% !important; color: %subtitle-color% !important; font-family: \'%subtitle-font%\', Lucida Grande, sans-serif !important;">%subtitle-text%</div>
			    %optin_form%
			<div class="ois_subtext_' . $id . '" style="font-size: %subtext-font-size% !important;color: %subtext-color% !important;font-family: \'%subtext-font%\', Lucida Grande, sans-serif !important;">%subtext-text%</div>
	    </div>',
		'css' => '',
		'css_url' => OptinSkin_URL . 'skins/css/design_7.css',
		'id' => $id,
		'custom' => 'no',
		'optin_settings' => array (
			'enable_name' => 'yes',
			'placeholders' => array (
				'name' => 'Your Name',
				'email' => 'Your Email',
			),
			'labels' => array (
			),
			'button_value' => 'Subscribe Now',
			'force_break' => 'yes',
		),
		'enable_name' => 'yes',
		'appearance' => array (
			'text' => array (
				'Background Color' => array (
					'attr' => 'background-color',
					'default' => '#fbfafa',
					'type' => 'color',
				),
				'Border Color' => array (
					'attr' => 'border-color',
					'default' => '#e0e0e0',
					'type' => 'color',
				),
				'Title Color' => array (
					'attr' => 'title-color',
					'default' => '#0c7904',
					'type' => 'color',
				),
				'Subtitle Color' => array (
					'attr' => 'subtitle-color',
					'default' => '#666',
					'type' => 'color',
				),
				'Subtext Color Color' => array (
					'attr' => 'subtext-color',
					'default' => '#666',
					'type' => 'color',
				),
				'Title Font' => array (
					'attr' => 'title-font',
					'default' => 'Homenaje',
					'type' => 'google_font',
				),
				'Title Font Size' => array (
					'attr' => 'title-font-size',
					'default' => '26px',
				),
				'Subtitle Font' => array (
					'attr' => 'subtitle-font',
					'default' => 'Homenaje',
					'type' => 'google_font',
				),
				'Subtitle Font Size' => array (
					'attr' => 'subtitle-font-size',
					'default' => '14px',
				),
				'Subtext Font' => array (
					'attr' => 'subtext-font',
					'default' => 'Open Sans',
					'type' => 'google_font',
				),
				'Subtext Font Size' => array (
					'attr' => 'subtext-font-size',
					'default' => '13px',
				),
				'Title Text' => ois_title_text('Get our Free "Golf" eBook'),
				'Subtitle Text' => ois_subtitle_text('Enter your details below for instant download'),
				'Subtext Content' => array (
					'attr' => 'subtext-text',
					'default' => 'You\'ll receive no more than two emails per week, and we hate spam just as much as you',
					'type' => 'textarea',
					'height' => '50px',
					'width' => '350px',
				),
				'Button Text' => ois_button_text('Subscribe Now'),
				'Email Placeholder' => ois_email_placeholder('Email Address'),
				'Name Placeholder' => ois_name_placeholder('Your Name'),
			),
		),
	);
	$id = 8;
	$skin_8 = array(
		'title' => 'Horizontal Share',
		'description' => '',
		'date_added' => date('Y-m-d H:i:s'),
		'last_modified' => date('Y-m-d H:i:s'),
		'design_preview' => OptinSkin_URL . 'admin/images/design_previews/8.png',
		'social_media' => array (
			'facebook', 'twitter', 'gplus', 'stumbleupon', 'linkedin', 'reddit',
		),
		'html' => '
<div class="ois_box_' . $id . ' container-fluid" style="max-width:600px;width: expression(this.width > 600 ? 600: true); background-color: %background-color% !important; border-radius: %border-radius% !important; -moz-border-radius: %border-radius% !important; -webkit-border-radius: %border-radius% !important; border-width: %border-width% !important; border-style: %border-style% !important; border-color: %border-color% !important;">
	<div class="row-fluid">
		<div class="span7">
			<div class="ois_title_' . $id . '" style="text-shadow: %text-shadow-color% 0px 1px 0px !important; font-size: %title-font-size% !important; font-family: \'%google-font%\', Arial !important; color:%title-color% !important">%left-title-text%</div>
			<div class="row-fluid">
				<div class="span4">' . $social_buttons->ois_fbLike() . '</div>
				<div class="span4">' . $social_buttons->ois_retweet() . '</div>
				<div class="span4">' . $social_buttons->ois_gplus() . '</div>
			</div>
			<div class="row-fluid">
				<div class="span4">' . $social_buttons->ois_stumbleupon() . '</div>
				<div class="span4">' . $social_buttons->ois_linkedin() . '</div>
				<div class="span4">' . $social_buttons->ois_reddit() . '</div>
			</div>
		</div>
		<div class="span5">
			<div class="ois_title_' . $id . '" style="text-shadow: %text-shadow-color% 0px 1px 0px !important; font-size: %title-font-size% !important; font-family: \'%google-font%\', Arial !important; color:%title-color% !important">%right-title-text%</div>
			%optin_form%
		</div>
	</div>
</div>',
		'css' => '',
		'css_url' => OptinSkin_URL . 'skins/css/design_8.css',
		'id' => $id,
		'custom' => 'no',
		'optin_settings' => array (
			'enable_name' => 'no',
			'placeholders' => array (
				'email' => 'Your Email',
			),
			'labels' => array (
				//'email' => 'Your Email',
			),
			'button_value' => 'Subscribe Now',
			'force_break' => 'yes',
			'maintain_line' => 'no',
		),
		'enable_name' => 'yes',
		'appearance' => array (
			'text' => array (
				'Background Color' => array (
					'attr' => 'background-color',
					'default' => '#fff',
					'type' => 'color',
				),
				'Border Color' => array (
					'attr' => 'border-color',
					'default' => '#e5e5e5',
					'type' => 'color',
				),
				'Border Width' => array (
					'attr' => 'border-width',
					'default' => '2px',
				),
				'Border Style' => array (
					'attr' => 'border-style',
					'default' => 'dashed',
					'values' => array (
						'Solid' => 'solid',
						'Dashed' => 'dashed',
						'Dotted' => 'dotted',
						'No Border' => 'none',
					),
					'type' => 'dropdown',
				),
				'Title Color' => array(
					'attr' => 'title-color',
					'default' => '#9f1e1e',
					'type' => 'color',
				),
				'Title Font' => array (
					'attr' => 'google-font',
					'default' => 'Cambo',
					'type' => 'google_font',
				),
				'Title Font-Size' => array (
					'attr' => 'title-font-size',
					'default' => '23px',
				),
				'Border Radius' => array (
					'attr' => 'border-radius',
					'default' => '3px',
				),
				'Text-Shadow Color' => array(
					'attr' => 'text-shadow-color',
					'default' => '#e5e1e1',
					'type' => 'color',
				),
				'Left Title Text' => array (
					'attr' => 'left-title-text',
					'default' => 'Share This Content',
					'text-width' => '250px',
				),
				'Right Title Text' => array (
					'attr' => 'right-title-text',
					'default' => 'Subscribe to Updates',
					'text-width' => '250px',
				),
				'Button Text' => ois_button_text('Sign Up Now'),
				'Email Placeholder' => ois_email_placeholder('Your Email Address'),
			),
		),
	);
	$id = 9;
	$skin_9 = array (
		'title' => 'Banner 200',
		'description' => '',
		'design_preview' => OptinSkin_URL . 'admin/images/design_previews/9.png',
		'date_added' => date('Y-m-d H:i:s'),
		'last_modified' => date('Y-m-d H:i:s'),
		'html' => '<div class="ois_box_' . $id . '" style="background-image: url(\'' . OptinSkin_URL . 'front/images/banner_200_bg.png\') !important;background-repeat:none;">
			<div class="ois_title_' . $id . '" style="padding-top: %title-padding-top% !important; text-transform: uppercase !important; color: #fff !important; font-size: %title-font-size% !important; font-family: \'%title-font%\', Arial !important;">%title-text%</div>
			<div style="padding-top: 25px !important; text-align: center !important;">
				%optin_form%
			</div>
		</div>',
		'css' => '',
		'css_url' => OptinSkin_URL . 'skins/css/design_9.css',
		'id' => $id,
		'custom' => 'no',
		'optin_settings' => array (
			'enable_name' => 'yes',
			'placeholders' => array (
				'name' => 'Your Name',
				'email' => 'Email Address',
			),
			'labels' => array (
				//'email' => 'Your Email',
			),
			'button_value' => 'Subscribe Now',
			'force_break' => 'yes',
			'maintain_line' => 'no',
		),
		'enable_name' => 'yes',
		'appearance' => array (
			'text' => array (
				'Button Text' => ois_button_text('Get Updates'),
				'Title Font' => array (
					'attr' => 'title-font',
					'default' => 'Ubuntu',
					'type' => 'google_font'
				),
				'Title Font Size' => array (
					'attr' => 'title-font-size',
					'default' => '24px',
				),
				'Space Above Title' => array (
					'attr' => 'title-padding-top',
					'default' => '20px',
				),
				'Title Text' => ois_title_text('Subscribe'),
				'Name Placeholder' => ois_name_placeholder('Your Name'),
				'Email Placeholder' => ois_email_placeholder('Email Address'),
			),
		),
	);

	$id = 10;
	$skin_10 = array (
		'title' => 'Responsive Design',
		'design_preview' => OptinSkin_URL . 'admin/images/design_previews/21.png',
		'description' => '',
		'date_added' => date('Y-m-d H:i:s'),
		'last_modified' => date('Y-m-d H:i:s'),
		'css' => '',
		'css_url' => OptinSkin_URL . 'skins/css/design_10.css',
		'id' => $id,
		'social_media' => array (),
		'custom' => 'no',
		'new_form' => 'yes',
		'optin_settings' => array (
			'enable_name' => 'yes',
			'placeholders' => array (
				'name' => 'enter your name',
				'email' => 'Email Address',
			),
			'labels' => array (
			),
			'button_value' => '\'',
			'force_break' => 'yes',
			'maintain_line' => 'yes',
		),
		'html' => '
		<div class="ois_' . $id . '" class="container-fluid" style="max-width:350px;width: expression(this.width > 350 ? 350: true);' . ois_vertical_gradient('%background-top-gradient%', '%background-bottom-gradient%') . '">
<div class="ois_'.$id.'_title" style="color:%title-color%!important;font-size:%title-size%!important;font-family:%title-font%!important;">%title-text%</div>
<div class="ois_'.$id.'_main_text" style="color:%text-color%!important;font-size:%text-size%!important;font-family:%text-font%!important;">%main-text%</div>
%optin_form%
<div class="pull-left" style="padding: 10px 0 0 0;"><i class="icon-ok"></i>%bottom-guarantee%</div>
<div style="clear:both;"></div>
</div>',
		'appearance' => array (
			'text' => array (
				'Button Top Gradient' => ois_color_option( 'button-top-gradient', '#dde752' ),
				'Button Bottom Gradient' => ois_color_option( 'button-bottom-gradient', '#dde752' ),
				'Button Text Color' => ois_color_option( 'button-text-color', '#333' ),
				'Background Top Gradient' => ois_color_option ( 'background-top-gradient', '#fefefe' ),
				'Background Bottom Gradient' => ois_color_option ( 'background-bottom-gradient', '#f3f3f3'),
				'Title Color' => ois_color_option ( 'title-color', '#333' ),
				'Main Text Color' => ois_color_option ( 'text-color', '#333' ),
				'Title Font' => ois_font_option('title-font', 'Verdana'),
				'Text Font' => ois_font_option('text-font', 'Verdana'),
				'Title Size' => ois_general_option( 'title-size', '24px' ),
				'Text Size' => ois_general_option( 'text-size', '18px' ),
				'Title Text' => ois_general_option( 'title-text', 'Get free weekly email tips from the blog' ),
				'Main Text' => ois_general_option( 'main-text', 'Add more text here to describe what your giveaway is about, while reminding people that you will not spam or sell their email addresses.' ),
				'Bottom Guarantee Text' => ois_general_option( 'bottom-guarantee', 'NO SPAM GUARANTEE' ),
				'Button Text' => ois_button_text('Subscribe'),
				'Name Placeholder' => ois_name_placeholder('Your name'),
				'Email Placeholder' => ois_email_placeholder('Your email address'),
			),
		),
	);

	$id = 11;
	$skin_11 = array (
		'title' => 'Subscribe to this blog',
		'design_preview' => OptinSkin_URL . 'admin/images/design_previews/11.png',
		'description' => '',
		'date_added' => date('Y-m-d H:i:s'),
		'last_modified' => date('Y-m-d H:i:s'),
		'css' => '',
		'css_url' => OptinSkin_URL . 'skins/css/design_11.css',
		'id' => $id,
		'custom' => 'no',
		'optin_settings' => array (
			'enable_name' => 'no',
			'placeholders' => array (
				//'name' => 'Your Name',
				'email' => 'Your Email Address',
			),
			'labels' => array (
				//'email' => 'Your Email',
			),
			'button_value' => '\'',
			'force_break' => 'no',
			'maintain_line' => 'yes',
		),
		'html' => '<div class="ois_box_' . $id . '" style="max-width:600px;width: expression(this.width > 600 ? 600: true);">
	<div class="ois_title_' . $id . ' container-fluid" style="font-family: \'%title-font%\', Arial !important; background-color:transparent !important;color:%title-font-color% !important;font-size: %title-font-size% !important; line-height:%title-font-size% !important;margin-bottom:%title-margin-bottom% !important;margin-top:10px;">%title-text%</div>
	<div class="ois_inner_' . $id . '" style="margin: 0 auto !important; border-radius: %border-radius% !important; -webkit-border-radius: %border-radius% !important; -moz-border-radius: %border-radius% !important;background-color: %inner-background-color% !important; text-align: center !important;">
		<div class="ois_subtitle_' . $id . '" style="font-family: \'%subtitle-font%\', Arial !important;padding-top:15px !important;color:%subtitle-font-color% !important;font-size: %subtitle-font-size% !important;">%subtitle-text%</div>
		<div class="row-fluid" style="margin-top:10px;padding-bottom:5px;">
			<div class="span2 offset1 visible-desktop">
				<img src="%arrow-url%" class="ois_arrow_' . $id . '" />
			</div>
			<div class="span9">
				%optin_form%
			</div>
		</div>
	</div>
</div>',
		'appearance' => array (
			'text' => array (
				'Title Font' => array (
					'attr' => 'title-font',
					'default' => 'Luckiest Guy',
					'type' => 'google_font'
				),
				'Subtitle Font' => array (
					'attr' => 'subtitle-font',
					'default' => 'Dancing Script',
					'type' => 'google_font'
				),
				'Inner Box Background Color' => array (
					'attr' => 'inner-background-color',
					'default' => '#fffad2',
					'type' => 'color',
				),
				'Title Font Color' => ois_color_option('title-font-color', '#525251'),
				'Subtitle Font Color' => ois_color_option('subtitle-font-color', '#83837d'),
				'Space Below Title' => ois_general_option('title-margin-bottom', '-10px'),
				'Title Font Size' => ois_general_option('title-font-size', '38px'),
				'Subtitle Font Size' => ois_general_option('subtitle-font-size', '19px'),
				'Arrow Type' => array (
					'attr' => 'arrow-url',
					'default' => OptinSkin_URL . 'front/images/arrows/arrow_3.png',
					'values' => array (
						'Arrow 1' => OptinSkin_URL . 'front/images/arrows/arrow_1.png',
						'Arrow 2' => OptinSkin_URL . 'front/images/arrows/arrow_2.png',
						'Arrow 3' => OptinSkin_URL . 'front/images/arrows/arrow_3.png',
						'Arrow 4' => OptinSkin_URL . 'front/images/arrows/arrow_4.png',
						'Arrow 5' => OptinSkin_URL . 'front/images/arrows/arrow_5.png',
					),
					'type' => 'dropdown',
				),
				'Title Text' => ois_title_text('&quot;Subscribe to the blog&quot;'),
				'Subtitle Text' => ois_subtitle_text('Receive an update straight to your inbox every time I publish a new article. Your email address will never be shared'),				
				'Border radius (rounded corners)' => ois_general_option('border-radius', '2px'),
				'Button Text' => ois_button_text('Subscribe'),
				'Email Placeholder' => ois_email_placeholder('Your Email'),
			),
		),
	);
	$id = 12;
	$skin_12 = array (
		'title' => 'Simple Spread the Word',
		'design_preview' => OptinSkin_URL . 'admin/images/design_previews/12.png',
		'description' => '',
		'date_added' => date('Y-m-d H:i:s'),
		'last_modified' => date('Y-m-d H:i:s'),
		'social_media' => array (
			'facebook', 'twitter', 'gplus', 'stumbleupon', 'linkedin',
		),
		'html' => '
<div class="container-fluid" style="max-width:600px;width: expression(this.width > 600 ? 600: true);">
	<div class="ois_title_' . $id . '" style="color: %title-font-color% !important; font-size: %title-font-size% !important; line-height: %title-font-size% !important; font-family: \'%title-font%\', Arial !important;margin: 0 0 %title-margin% 0 !important; text-align: %title-align% !important;">%title-text%</div>
	<div class="row-fluid" style="background-color: %background-color% !important;padding:15px 10px 10px 0 !important;border: 1px solid %border-color% !important;-webkit-box-shadow: rgba(0, 0, 0, 0.199219) 1px 2px 2px 1px; box-shadow: rgba(0, 0, 0, 0.1) 1px 2px 2px 1px;">
		<div class="span11 offset1">
			<div class="span2">' . $social_buttons->ois_fbLike() . '</div>
			<div class="span2">' . $social_buttons->ois_retweet() . '</div>
			<div class="span2">' . $social_buttons->ois_gplus() . '</div>
			<div class="span2">' . $social_buttons->ois_stumbleupon() . '</div>
			<div class="span3">' . $social_buttons->ois_linkedin() . '</div>
		</div>
	</div>
</div>',
		'css' => '',
		'css_url' => OptinSkin_URL . 'skins/css/design_12.css',
		'id' => $id,
		'custom' => 'no',
		'optin_settings' => array (
			'enable_name' => 'no',
			'placeholders' => array (
				//'name' => 'Your Name',
				'email' => 'Your Email Address',
			),
			'labels' => array (
				//'email' => 'Your Email',
			),
			'button_value' => '\'',
			'force_break' => 'no',
			'maintain_line' => 'yes',
		),
		'appearance' => array (
			'text' => array (
				'Title Font' => array (
					'attr' => 'title-font',
					'default' => 'Cambo',
					'type' => 'google_font'
				),
				'Title Font Size' => array (
					'attr' => 'title-font-size',
					'default' => '24px',
				),
				'Title Font Color' => array(
					'attr' => 'title-font-color',
					'default' => '#a9a9a9',
					'type' => 'color',
				),
				'Background Color' => array (
					'attr' => 'background-color',
					'default' => '#f7f7f7',
					'type' => 'color',
				),
				'Border Color' => array (
					'attr' => 'border-color',
					'default' => '#fff',
					'type' => 'color',
				),
				'Title Text' => ois_title_text('Enjoy this post? Please share the love...'),
				'Space Below Title' => array (
					'attr' => 'title-margin',
					'default' => '5px'
				),
				'Title Align' => array (
					'attr' => 'title-align',
					'default' => 'center',
					'values' => array (
						'Left' => 'left',
						'Center' => 'center',
						'Right' => 'right',
					),
					'type' => 'dropdown',
				),
			),
		),
	);
	$id = 13;
	$skin_13 = array (
		'title' => 'Like What You See?',
		'description' => '',
		'design_preview' => OptinSkin_URL . 'admin/images/design_previews/13.png',
		'date_added' => date('Y-m-d H:i:s'),
		'last_modified' => date('Y-m-d H:i:s'),
		'social_media' => array (
			'facebook', 'twitter', 'gplus',
		),
		'html' => '
		<div class="ois_box_' . $id . ' container-fluid" style="max-width:600px;width: expression(this.width > 600 ? 600: true);">
			<div class="ois_main_title_' . $id . '" style="line-height: %main-title-size% !important;font-family: \'%main-title-font%\', Arial !important; text-align:center !important; margin-bottom: %space-below-main% !important; font-size: %main-title-size% !important; color: %title-color% !important;">%main-title-text%</div>
			<div class="ois_inner_' . $id . '" style="background-color: %background-color% !important; padding-top: %space-above-subtitles% !important;padding-bottom: %space-below% !important;">
				<div class="row-fluid" style="max-width: 100% !important; margin: 0 auto !important; ">
					<div class="span5 offset1">
						<div class="ois_title_' . $id . '" style="color: %subtitle-color% !important;font-family: \'%subtitle-font%\', Arial !important;padding-bottom: %space-below-subtitles% !important; font-size: %subtitle-size% !important;line-height: %subtitle-size% !important;">%left-subtitle-text%</div>
						<div class="row-fluid">
							<div class="span4">' . $social_buttons->ois_fb_box() . '</div>
							<div class="span4">' . $social_buttons->ois_twitter_box() . '</div>
							<div class="span4">' . $social_buttons->ois_gplus_box() . '</div>
						</div>
					</div>
					<div class="span4 offset1" style="text-align:center;">
						<div class="ois_title_' . $id . '" style="color: %subtitle-color% !important;font-family: \'%subtitle-font%\', Arial !important;padding-bottom: %space-below-subtitles% !important; font-size: %subtitle-size% !important;">%right-subtitle-text%</div>
						%optin_form%
					</div>
				</div>
			</div>
		</div>',
		'css' => '',
		'css_url' => OptinSkin_URL . 'skins/css/design_13.css',
		'id' => $id,
		'custom' => 'no',
		'optin_settings' => array (
			'enable_name' => 'no',
			'placeholders' => array (
				//'name' => 'Your Name',
				'email' => 'Your Email Address',
			),
			'labels' => array (
				//'email' => 'Your Email',
			),
			'button_value' => '\'',
			'force_break' => 'yes',
		),
		'enable_name' => 'yes',
		'appearance' => array (
			'text' => array (
				'Background Color' => array (
					'attr' => 'background-color',
					'default' => '#e4d2c9',
					'type' => 'color',
				),
				'Main Title Font Color' => array (
					'attr' => 'title-color',
					'default' => '#552d01',
					'type' => 'color',
				),
				'Subtitle Font Color' => array (
					'attr' => 'subtitle-color',
					'default' => '#943c08',
					'type' => 'color',
				),
				'Button Top Gradient' => array (
					'attr' => 'button-top-gradient',
					'default' => '#188ABD',
					'type' => 'color',
				),
				'Button Bottom Gradient' => array (
					'attr' => 'button-bottom-gradient',
					'default' => '#188ABD',
					'type' => 'color',
				),
				'Button Text Color' => array (
					'attr' => 'button-text-color',
					'default' => '#fff',
					'type' => 'color',
				),
				'Button Border Color' => array(
					'attr' => 'button-border-color',
					'default' => '#BBB',
					'type' => 'color',
				),
				'Main Title Font' => array (
					'attr' => 'main-title-font',
					'default' => 'PT Serif',
					'type' => 'google_font'
				),
				'Subtitle Font' => array (
					'attr' => 'subtitle-font',
					'default' => 'Kaushan Script',
					'type' => 'google_font'
				),
				'Main Title Font Size' => array(
					'attr' => 'main-title-size',
					'default' => '26px',
				),
				'Subtitle Font Size' => array(
					'attr' => 'subtitle-size',
					'default' => '20px',
				),
				'Space Below Main Title Size' => array(
					'attr' => 'space-below-main',
					'default' => '0px',
				),
				'Space Above Subtitles' => array (
					'attr' => 'space-above-subtitles',
					'default' => '10px',
				),
				'Space Below Subtitles' => array (
					'attr' => 'space-below-subtitles',
					'default' => '10px',
				),
				'Main Title Text' => array (
					'attr' => 'main-title-text',
					'default' => 'Did you enjoy this article?',
					'text-width' => '300px',
				),
				'Left Subtitle Text' => array (
					'attr' => 'left-subtitle-text',
					'default' => 'Share the love',
					'text-width' => '300px',
				),
				'Right Subtitle Text' => array (
					'attr' => 'right-subtitle-text',
					'default' => 'Get free updates',
					'text-width' => '275px',
				),
				'Button Text' => ois_button_text('Subscribe'),
				'Email Placeholder' => ois_email_placeholder('Your Email Address'),
			),
		),
	);
	$id = 14;
	$skin_14 = array (
		'title' => 'eBook',
		'description' => '',
		'design_preview' => OptinSkin_URL . 'admin/images/design_previews/14.png',
		'date_added' => date('Y-m-d H:i:s'),
		'last_modified' => date('Y-m-d H:i:s'),
		'css' => '',
		'css_url' => OptinSkin_URL . 'skins/css/design_14.css',
		'id' => $id,
		'custom' => 'no',
		'optin_settings' => array (
			'enable_name' => 'no',
			'placeholders' => array (
				//'name' => 'Your Name',
				'email' => 'enter your email',
			),
			'labels' => array (
				//'email' => 'Your Email',
			),
			'button_value' => '\'',
			'force_break' => 'yes',
		),
		'enable_name' => 'yes',
		'html' => '
<div class="ois_box_' . $id . ' container-fluid" style="max-width:650px;width: expression(this.width > 650 ? 650: true);">
	<div class="ois_title_' . $id . '" style="font-family: \'%main-title-font%\', Helvetica, Arial, sans-serif !important; color: %title-color% !important;text-align:center !important;font-size: %main-title-size% !important;line-height: %main-title-size% !important;margin-bottom: %below-main-title% !important;">%title-text%</div>
	<div class="ois_inner_' . $id . '" style="padding-bottom: 10px !important; border-radius: %border-radius% !important; -moz-border-radius: %border-radius% !important; -webkit-border-radius: %border-radius% !important; overflow: visible !important;' . ois_vertical_gradient('%background-top-gradient%', '%background-bottom-gradient%') . '">
	
		<div class="row-fluid">
			<div class="span6">
				<div class="spanois_subtitle_' . $id . '" style="font-family: \'%subtitle-font%\', Helvetica, Arial, sans-serif !important;color: %subtitle-color% !important;padding: 15px 0 5px 5px; text-align:center !important;font-size: %subtitle-size% !important;line-height: %subtitle-size% !important;">%subtitle-text%</div>
				<div class="ois_subtext_' . $id . '" style="font-family: \'%subtext-font%\', Helvetica, Arial, sans-serif !important;color: %subtext-color% !important;padding: %above-subtext% 15px 0 15px !important; font-size: %subtext-size% !important;line-height:normal !important;text-align:%subtext-align% !important;">%subtext-content%</div>
			</div>
			<div class="span2" style="margin-top:10%!important;">
				<img class="visible-desktop" src="%arrow-url%" class="ois_arrow_' . $id . '" />
			</div>
			<div class="span4" style="text-align:center!important;">
				<div style="text-align:center!important;">
					<img src="%product-image%" style="height: %product-image-height% !important; margin-top: -20px !important;z-index:200 !important;"/>
				</div>
				%optin_form%
			</div>
		</div>
	</div>
</div>',
		'appearance' => array (
			'text' => array (
				'Background Top Gradient' => array (
					'attr' => 'background-top-gradient',
					'default' => '#fffdda',
					'type' => 'color',
				),
				'Background Bottom Gradient' => array (
					'attr' => 'background-bottom-gradient',
					'default' => '#fdf69b',
					'type' => 'color',
				),
				'Button Top Gradient' => array (
					'attr' => 'button-top-gradient',
					'default' => '#33a6ef',
					'type' => 'color',
				),
				'Button Bottom Gradient' => array (
					'attr' => 'button-bottom-gradient',
					'default' => '#176fb9',
					'type' => 'color',
				),
				'Button Text Color' => array (
					'attr' => 'button-text-color',
					'default' => '#ffe557',
					'type' => 'color',
				),
				'Main Title Font' => array (
					'attr' => 'main-title-font',
					'default' => 'Lobster',
					'type' => 'google_font'
				),
				'Subtitle Font' => array (
					'attr' => 'subtitle-font',
					'default' => 'Lobster',
					'type' => 'google_font'
				),
				'Subtext Font' => array (
					'attr' => 'subtext-font',
					'default' => 'Lora',
					'type' => 'google_font'
				),
				'Main Title Font Size' => array(
					'attr' => 'main-title-size',
					'default' => '36px',
				),
				'Subtitle Font Size' => array(
					'attr' => 'subtitle-size',
					'default' => '23px',
				),
				'Subtext Font Size' => array(
					'attr' => 'subtext-size',
					'default' => '13px',
				),
				'Main Title Color' => array (
					'attr' => 'title-color',
					'default' => '#717171',
					'type' => 'color',
				),
				'Subtitle Color' => array (
					'attr' => 'subtitle-color',
					'default' => '#a09d9d',
					'type' => 'color',
				),
				'Subtext Color' => array (
					'attr' => 'subtext-color',
					'default' => '#a09d9d',
					'type' => 'color',
				),
				'Title Text' => ois_title_text('Did you enjoy this article?'),
				'Subtitle Text' => ois_subtitle_text('&quot;Get my free profitable niche ideas eBook&quot;'),
				'Subtext Content' => array (
					'attr' => 'subtext-content',
					'default' => 'Add more text here to describe what your giveaway is about, while reminding people you won\'t spam or sell their email address',
					'type' => 'textarea',
					'height' => '50px',
					'width' => '350px',
				),
				'Subtext Alignment' => array (
					'attr' => 'subtext-align',
					'default' => 'left',
					'values' => array (
						'Left' => 'left',
						'Center' => 'center',
						'Right' => 'right',
					),
					'type' => 'dropdown',
				),
				'Space Above Subtext' => array (
					'attr' => 'above-subtext',
					'default' => '20px',
				),
				'Space Below Main Title' => array (
					'attr' => 'below-main-title',
					'default' => '20px',
				),
				'Product/Ebook Image' => array (
					'attr' => 'product-image',
					'default' => OptinSkin_URL . 'front/images/ebook.png',
					'text-width' => '350px',
				),
				'Product/Ebook Image Height' => array (
					'attr' => 'product-image-height',
					'default' => '90px'
				),
				'Arrow Type' => array (
					'attr' => 'arrow-url',
					'default' => OptinSkin_URL . 'front/images/arrows/arrow_3.png',
					'values' => array (
						'Arrow 1' => OptinSkin_URL . 'front/images/arrows/arrow_1.png',
						'Arrow 2' => OptinSkin_URL . 'front/images/arrows/arrow_2.png',
						'Arrow 3' => OptinSkin_URL . 'front/images/arrows/arrow_3.png',
						'Arrow 4' => OptinSkin_URL . 'front/images/arrows/arrow_4.png',
						'Arrow 5' => OptinSkin_URL . 'front/images/arrows/arrow_5.png',
					),
					'type' => 'dropdown',
				),
				'Button Text' => ois_button_text('FREE INSTANT ACCESS'),
				'Rounded Corners (border-radius)' => array (
					'attr' => 'border-radius',
					'default' => '2px',
				),
				'Email Placeholder' => ois_email_placeholder('Email Address'),
			),
		),
	);

	$id = 15;
	$skin_2 = array (
		'title' => 'Horizontal Bar Signup',
		'design_preview' => OptinSkin_URL . 'admin/images/design_previews/15.png',
		'description' => 'Very simple sign up, should integrate easily into the your design.',
		'date_added' => date('Y-m-d H:i:s'),
		'last_modified' => date('Y-m-d H:i:s'),
		'css' => '',
		'css_url' => OptinSkin_URL . 'skins/css/design_1.css',
		'id' => $id,
		'custom' => 'no',
		'optin_settings' => array (
			'enable_name' => 'no',
			'maintain_line' => 'yes',
			'force_break' => 'no',
			'placeholders' => array (
				'name' => '',
				'email' => 'Your Email Address',
			),
			'labels' => array (
				'name' => '',
				'email' => '',
			),
			'button_value' => 'Subscribe Now'
		),
		'html' => '
		<div class="container-fluid" style="border-radius: %border-radius% !important; -moz-border-radius: %-webkit-border-radius% !important;' . ois_vertical_gradient('%background-top-gradient%', '%background-bottom-gradient%') . ' border: 2px %border-style% %border-color% !important; padding-left: 10px !important; font-family: \'%text-font%\', Helvetica, Arial, sans-serif !important;">
		<div class="row-fluid" style="text-align:center;padding-top:8px!important;">
			<div class="span3" style="font-size:%font-size%!important;color:%text-color%!important;padding-top:8px!important;">%pre-form%</div>
			<div class="span6">%optin_form%</div>
			<div class="span3" style="font-size:%font-size%!important;color:%text-color%!important;padding-top:8px!important;">%post-form%</div>
		</div>
	</div>',
		
		'appearance' => array (
			'text' => array (
				'Background Top Gradient' => array (
					'attr' => 'background-top-gradient',
					'default' => '#F9F3D9',
					'type' => 'color',
				),
				'Background Bottom Gradient' => array (
					'attr' => 'background-bottom-gradient',
					'default' => '#F9F3D9',
					'type' => 'color',
				),
				'Border Color' => array(
					'attr' => 'border-color',
					'default' => '#FFCC02',
					'type' => 'color',
				),
				'Button Top Gradient' => array (
					'attr' => 'button-top-gradient',
					'default' => '#ffffff',
					'type' => 'color',
				),
				'Button Bottom Gradient' => array (
					'attr' => 'button-bottom-gradient',
					'default' => '#ececec',
					'type' => 'color',
				),
				'Text Color' => array(
					'attr' => 'text-color',
					'default' => '#000',
					'type' => 'color',
				),
				'Text Font' => array (
					'attr' => 'text-font',
					'default' => 'Lora',
					'type' => 'google_font',
				),
				'Font Size' => array (
					'attr' => 'font-size',
					'default' => '13px',
				),
				'Border Style' => array (
					'attr' => 'border-style',
					'default' => 'dashed',
					'values' => array (
						'Solid' => 'solid',
						'Dashed' => 'dashed',
						'Dotted' => 'dotted',
						'No Border' => 'none',
					),
					'type' => 'dropdown',
				),
				'Text before form' => array(
					'attr' => 'pre-form',
					'default' => 'Sign up for free updates',
					'text-width' => '250px',
				),
				'Text after form' => array(
					'attr' => 'post-form',
					'default' => 'No Spam Guarantee',
					'text-width' => '250px',
				),
				'Button Text' => ois_button_text('Subscribe Now'),
				'Email Placeholder' => ois_email_placeholder('Your Email Address'),
			),
		),
	);
	$id = 16;
	$skin_16 = array (
		'title' => 'Ribbon Banner',
		'description' => '',
		'design_preview' => OptinSkin_URL . 'admin/images/design_previews/16.png',
		'date_added' => date('Y-m-d H:i:s'),
		'last_modified' => date('Y-m-d H:i:s'),
		'css' => '',
		'css_url' => OptinSkin_URL . 'skins/css/design_17.css',
		'id' => $id,
		'custom' => 'no',
		'optin_settings' => array (
			'enable_name' => 'yes',
			'placeholders' => array (
				'name' => 'enter your name',
				'email' => 'enter your email',
			),
			'labels' => array (
				//'email' => 'Your Email',
			),
			'button_value' => '\'',
			'force_break' => 'no',
			'maintain_line' => 'yes',
		),
		'html' => '
<div class="ois_outer_' . $id . '" style="max-width:600px;width: expression(this.width > 600 ? 600: true);">
	<div class="ois_border_' . $id . '" style="border:1px solid #b1b1b1 !important;">
	<div class="ois_inner_wrap_' . $id . '">
		<div class="row-fluid">
			<div class="span7">
				<div class="ois_title_' . $id . '" style="font-family: \'%title-font%\', Arial !important; color: %title-color% !important;font-size:%title-size%;padding: %title-pos-top% 0 %beneath-title% %title-pos-left%;">
						%title-text%
				</div>
				<div class="ois_subtext_' . $id . '" style="font-family: \'%subtext-font%\', Arial !important; color: %subtext-color% !important;font-size:%subtext-size%;padding-left:%subtext-pos-left%;">
					%subtext-content%
				</div>	
			</div>
			<div class="span5">
				<img class="visible-desktop" style="margin-top:-20px!important;height:%product-height% !important;" src="%product-url%" />
			</div>
		</div>
		<div class="row-fluid ois_banner_wrap_' . $id . ' span12" style="margin-top:10px!important;text-align:center!important;">
			<img src="%ribbon-url%" class="visible-desktop" style="width:116%!important;left:-12%!important;height:53px !important;position:absolute !important; z-index:2 !important;"/>
			
			<div class="span10 offset1 ois_form_wrap_'.$id.'">
				%optin_form%
			</div>
		</div>
		<div class="container-fluid" style="margin-top:65px !important;">
			<div class="row-fluid">
				<div class="span9 offset3">
					<div class="span1">
						<img src="' . OptinSkin_URL . 'front/images/lock.png"/>
					</div>
					<div class="span11">
						<div class="ois_protected_text_'.$id.'" style="color:#6e6e6e!important;padding-top:5px;">We hate spam just as much as you</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
</div>',
		'appearance' => array (
			'text' => array (
				'Title Font' => array (
					'attr' => 'title-font',
					'default' => 'Lora',
					'type' => 'google_font',
				),
				'Subtext Font' => array (
					'attr' => 'subtext-font',
					'default' => 'Ropa Sans',
					'type' => 'google_font',
				),
				'Title Color' => array (
					'attr' => 'title-color',
					'default' => '#2a6ab0',
					'type' => 'color',
				),
				'Subtext Color' => array (
					'attr' => 'subtext-color',
					'default' => '#4f5050',
					'type' => 'color',
				),
				'Ribbon Color' => array (
					'attr' => 'ribbon-url',
					'default' => OptinSkin_URL . 'front/images/ribbon_blue.png',
					'values' => array (
						'Blue' => OptinSkin_URL . 'front/images/ribbon_blue.png',
						'Red' => OptinSkin_URL . 'front/images/ribbon_red.png',
						'Black' => OptinSkin_URL . 'front/images/ribbon_black.png',
						'Green' => OptinSkin_URL . 'front/images/ribbon_green.png',
					),
					'type' => 'dropdown',
				),
				'Title Text' => ois_title_text('Learning about marketing?'),
				'Subtext Content' => array(
					'attr' => 'subtext-content',
					'default' => 'Your may be interested in my compelling eBook all about how to make sales fast',
					'type' => 'textarea',
					'height' => '50px',
					'width' => '350px',
				),
				'Title Size' => array (
					'attr' => 'title-size',
					'default' => '20px',
				),
				'Subtext Size' => array (
					'attr' => 'subtext-size',
					'default' => '17px',
				),
				'Title Position Left' => array(
					'attr' => 'title-pos-left',
					'default' => '35px',
				),
				'Title Position Top' => array(
					'attr' => 'title-pos-top',
					'default' => '20px',
				),
				'Space Beneath Title' => array (
					'attr' => 'beneath-title',
					'default' => '18px',
				),
				'Subtext Position Left' => array(
					'attr' => 'subtext-pos-left',
					'default' => '35px',
				),
				'Product Image URL' => array (
					'attr' => 'product-url',
					'default' => OptinSkin_URL . 'front/images/ribbon_book.png',
					'text-width' => '350px',
				),
				'Product Image Height' => array (
					'attr' => 'product-height',
					'default' => '139px',
				),
				'Form Position' => array(
					'attr' => 'form-position',
					'default' => '65px',
				),
				'Button Text' => ois_button_text('INSTANT ACCESS'),
				'Name Placeholder' => ois_name_placeholder('enter your name'),
				'Email Placeholder' => ois_email_placeholder('enter your email'),
			),
		),
	);
	$id = 17;
	$skin_17 = array (
		'title' => 'Clean Share and Optin',
		'design_preview' => OptinSkin_URL . 'admin/images/design_previews/17.png',
		'description' => '',
		'date_added' => date('Y-m-d H:i:s'),
		'last_modified' => date('Y-m-d H:i:s'),
		'css' => '',
		'css_url' => OptinSkin_URL . 'skins/css/design_18.css',
		'id' => $id,
		'custom' => 'no',
		'optin_settings' => array (
			'enable_name' => 'no',
			'placeholders' => array (
				//'name' => 'enter your name',
				'email' => 'enter your email',
			),
			'labels' => array (
				//'email' => 'Your Email',
			),
			'button_value' => '\'',
			'force_break' => 'no',
			'maintain_line' => 'yes',
		),
		'social_media' => array (
			'facebook', 'twitter', 'gplus',
		),
		'html' => '<div style="display:%browser-bar% !important; -webkit-box-shadow: 0px 2px 0px 0px rgba(0, 0, 0, 0.4);
-moz-box-shadow: 0px 2px 0px 0px rgba(0, 0, 0, 0.4);
box-shadow: 0px 2px 0px 0px rgba(0, 0, 0, 0.4);padding-left:%padding-left% !important;height:18px !important;display:block;' . ois_vertical_gradient('#eee', '#d6d6d6') . ' border:1px solid #b3b3b3 !important;border-top-right-radius:3px;border-top-left-radius:3px;border-bottom:none !important;"></div>
<div style="width:%box-width% !important;border-radius: %border-radius% !important; -moz-border-radius: %-webkit-border-radius% !important; %border-radius% !important;' . ois_vertical_gradient('%background-top-gradient%', '%background-bottom-gradient%') . ' border: 1px %border-style% %border-color% !important; padding: %padding-top% 0 %padding-top% %padding-left% !important;">
	<div class="row-fluid">
		<div class="span2">
			<div style="position:relative;height:59px;width:81px;text-align:center;background-image:url(\'%circle%\') !important;background-repeat:no-repeat !important;">
				<span style="font-family: \'%number-font%\', Arial !important; font-size:%number-size% !important;!important;top:%number-top% !important;left:%number-left% !important;color: %number-color% !important;line-height:%number-size% !important;" class="ois_number_' . $id . '">1</span>
			</div>
		</div>
		<div class="span5" style="padding-top:5px!important;">
			<div style="font-size:%text-size% !important;font-family:%text-font% !important;line-height:normal !important;color: %heading-color% !important;padding-left: %heading-space-left% !important;">Share the Love</div>
		</div>
		<div class="span5">
			<div class="span4">
				<div class="ois_sb_' . $id . '">' . $social_buttons->ois_fbLike() . '</div>
			</div>
			<div class="span4">
				<div class="ois_sb_' . $id . '">' . $social_buttons->ois_retweet() . '</div>
			</div>
			<div class="span4">
				<div class="ois_sb_' . $id . '">' . $social_buttons->ois_gplus() . '</div>
			</div>
		</div>
	</div>
	<div class="row-fluid">
		<div class="span2">
			<div style="position:relative;height:59px;width:81px;text-align:center;background-image:url(\'%circle%\') !important;background-repeat:no-repeat !important;">
				<span style="font-family: \'%number-font%\', Arial !important; font-size:%number-size% !important;position:absolute !important;top:%number-top% !important;left:%number-left% !important;color: %number-color% !important;line-height:%number-size% !important;">2</span>
			</div>
		</div>
		<div class="span5" style="padding-top:5px!important;">
			<div style="font-size:%text-size% !important;font-family:%text-font% !important;line-height:normal !important;color: %heading-color% !important;padding-left: %heading-space-left% !important;">Get Free Updates</div>
		</div>
		<div class="span5">
			%optin_form%
		</div>
	</div>
	</div>
</div>',
		'appearance' => array (
			'text' => array (
				'Background Top Gradient' => array (
					'attr' => 'background-top-gradient',
					'default' => '#fff',
					'type' => 'color',
				),
				'Background Bottom Gradient' => array (
					'attr' => 'background-bottom-gradient',
					'default' => '#fff',
					'type' => 'color',
				),
				'Border Color' => array(
					'attr' => 'border-color',
					'default' => '#b3b3b3',
					'type' => 'color',
				),
				'Heading Color' => array (
					'attr' => 'heading-color',
					'default' => '#777',
					'type' => 'color',
				),
				'Numbers Color' => array (
					'attr' => 'number-color',
					'default' => '#777',
					'type' => 'color',
				),
				'Border Style' => array (
					'attr' => 'border-style',
					'default' => 'solid',
					'values' => array (
						'Solid' => 'solid',
						'Dashed' => 'dashed',
						'Dotted' => 'dotted',
						'No Border' => 'none',
					),
					'type' => 'dropdown',
				),
				'Browser Bar at Top' => array (
					'attr' => 'browser-bar',
					'default' => 'block',
					'values' => array (
						'Show' => 'block',
						'Hide' => 'none',
					),
					'type' => 'dropdown',
				),
				'Bullet Circle Style' => array (
					'attr' => 'circle',
					'default' => OptinSkin_URL . 'front/images/circle_1.png',
					'values' => array (
						'Simple Circle' => OptinSkin_URL . 'front/images/circle_1.png',
						'Emphasized Cirlce' => OptinSkin_URL . 'front/images/circle_2.png',
						'No Circle' => '',
					),
					'type' => 'dropdown',
				),
				'Heading Font Type' => array (
					'attr' => 'text-font',
					'default' => 'Dancing Script',
					'type' => 'google_font',
				),
				'Heading Size' => array (
					'attr' => 'text-size',
					'default' => '28px',
				),
				'Number Font Type' => array (
					'attr' => 'number-font',
					'default' => 'Lora',
					'type' => 'google_font',
				),
				'Number Font Size' => array (
					'attr' => 'number-size',
					'default' => '28px',
				),
				'Number Position from Top' => array (
					'attr' => 'number-top',
					'default' => '20px'
				),
				'Number Position from Left' => array (
					'attr' => 'number-left',
					'default' => '25px'
				),
				'Extra Space Left of Headings' => array (
					'attr' => 'heading-space-left',
					'default' => '15px',
				),
				'Button Text' => ois_button_text('Submit'),
				'Extra Space Above and Below' => array (
					'attr' => 'padding-top',
					'default' => '5px',
				),
				'Extra Space on Left' => array (
					'attr' => 'padding-left',
					'default' => '8px',
				),
				'Border Radius (rounded corners)' => array (
					'attr' => 'border-radius',
					'default' => '0px',
				),
				'Email Placeholder' => ois_email_placeholder('enter your email'),
			),
		),
	);

	$id = 18;
	$skin_18 = array (
		'title' => 'Clean Download Optin',
		'design_preview' => OptinSkin_URL . 'admin/images/design_previews/18.png',
		'description' => '',
		'date_added' => date('Y-m-d H:i:s'),
		'last_modified' => date('Y-m-d H:i:s'),
		'css' => '',
		'css_url' => OptinSkin_URL . 'skins/css/design_19.css',
		'id' => $id,
		'custom' => 'no',
		'optin_settings' => array (
			'enable_name' => 'no',
			'placeholders' => array (
				//'name' => 'enter your name',
				'email' => 'Email Address',
			),
			'labels' => array (
				//'email' => 'Your Email',
			),
			'button_value' => '\'',
			'force_break' => 'no',
			'maintain_line' => 'yes',
		),

		'html' => '
<div class="ois_outer_18 container-fluid" style="max-width:450px;width: expression(this.width > 450 ? 450: true); border:1px solid %border-color% !important;' . ois_vertical_gradient('%background-top-gradient%', '%background-bottom-gradient%') . '">
	<div class="ois_title_18" style="color:%title-color% !important;font-size: %title-size% !important;font-family: \'%title-font%\', Arial !important;">%title-text%</div>
	<div class="ois_subtext_18" style="color:%subtext-color% !important;font-size: %subtext-size% !important;font-family: \'%subtext-font%\', Arial !important;">%subtext%</div>
	%optin_form%
</div>',
		'appearance' => array (
			'text' => array (
				'Background Top Gradient' => array (
					'attr' => 'background-top-gradient',
					'default' => '#fff',
					'type' => 'color',
				),
				'Background Bottom Gradient' => array (
					'attr' => 'background-bottom-gradient',
					'default' => '#fff',
					'type' => 'color',
				),
				'Border Color' => array (
					'attr' => 'border-color',
					'default' => '#bbb',
					'type' => 'color',
				),
				'Button Style' => array (
					'attr' => 'button-style',
					'default' => 'background: rgb(255,215,114) !important; background: -moz-linear-gradient(top, rgba(255,215,114,1) 0%, rgba(255,187,76,1) 100%) !important; background: -webkit-gradient(linear, left top, left bottom, color-stop(0%,rgba(255,215,114,1)), color-stop(100%,rgba(255,187,76,1))) !important; background: -webkit-linear-gradient(top, rgba(255,215,114,1) 0%,rgba(255,187,76,1) 100%) !important; background: -o-linear-gradient(top, rgba(255,215,114,1) 0%,rgba(255,187,76,1) 100%) !important; background: -ms-linear-gradient(top, rgba(255,215,114,1) 0%,rgba(255,187,76,1) 100%) !important; background: linear-gradient(top, rgba(255,215,114,1) 0%,rgba(255,187,76,1) 100%) !important; filter: progid:DXImageTransform.Microsoft.gradient( startColorstr=\'#ffd772\',endColorstr=\'#ffbb4c\',GradientType=0 ) !important; color: #a26533 !important; border: 1px solid #e5a53e !important;',
					'values' => array (
						'Orange' => 'background: rgb(255,215,114) !important; background: -moz-linear-gradient(top, rgba(255,215,114,1) 0%, rgba(255,187,76,1) 100%) !important; background: -webkit-gradient(linear, left top, left bottom, color-stop(0%,rgba(255,215,114,1)), color-stop(100%,rgba(255,187,76,1))) !important; background: -webkit-linear-gradient(top, rgba(255,215,114,1) 0%,rgba(255,187,76,1) 100%) !important; background: -o-linear-gradient(top, rgba(255,215,114,1) 0%,rgba(255,187,76,1) 100%) !important; background: -ms-linear-gradient(top, rgba(255,215,114,1) 0%,rgba(255,187,76,1) 100%) !important; background: linear-gradient(top, rgba(255,215,114,1) 0%,rgba(255,187,76,1) 100%) !important; filter: progid:DXImageTransform.Microsoft.gradient( startColorstr=\'#ffd772\',endColorstr=\'#ffbb4c\',GradientType=0 ) !important; color: #a26533 !important; border: 1px solid #e5a53e !important;',
						'Deep Red' => 'background: rgb(169,3,41) !important; background: -moz-linear-gradient(top, rgba(169,3,41,1) 0%, rgba(143,2,34,1) 44%, rgba(109,0,25,1) 100%) !important; background: -webkit-gradient(linear, left top, left bottom, color-stop(0%,rgba(169,3,41,1)), color-stop(44%,rgba(143,2,34,1)), color-stop(100%,rgba(109,0,25,1))) !important; background: -webkit-linear-gradient(top, rgba(169,3,41,1) 0%,rgba(143,2,34,1) 44%,rgba(109,0,25,1) 100%) !important; background: -o-linear-gradient(top, rgba(169,3,41,1) 0%,rgba(143,2,34,1) 44%,rgba(109,0,25,1) 100%) !important; background: -ms-linear-gradient(top, rgba(169,3,41,1) 0%,rgba(143,2,34,1) 44%,rgba(109,0,25,1) 100%) !important; background: linear-gradient(top, rgba(169,3,41,1) 0%,rgba(143,2,34,1) 44%,rgba(109,0,25,1) 100%) !important;filter: progid:DXImageTransform.Microsoft.gradient( startColorstr=\'#a90329\', endColorstr=\'#6d0019\',GradientType=0 ) !important; color: #f9f5f6 !important; border: 1px solid #6d0019 !important;',
						'Sky Blue' => 'background: rgb(254,255,255) !important; background: -moz-linear-gradient(top, rgba(254,255,255,1) 0%, rgba(221,241,249,1) 35%, rgba(160,216,239,1) 100%) !important; background: -webkit-gradient(linear, left top, left bottom, color-stop(0%,rgba(254,255,255,1)), color-stop(35%,rgba(221,241,249,1)), color-stop(100%,rgba(160,216,239,1))) !important; background: -webkit-linear-gradient(top, rgba(254,255,255,1) 0%,rgba(221,241,249,1) 35%,rgba(160,216,239,1) 100%) !important; background: -o-linear-gradient(top, rgba(254,255,255,1) 0%,rgba(221,241,249,1) 35%,rgba(160,216,239,1) 100%) !important; background: -ms-linear-gradient(top, rgba(254,255,255,1) 0%,rgba(221,241,249,1) 35%,rgba(160,216,239,1) 100%) !important; background: linear-gradient(top, rgba(254,255,255,1) 0%,rgba(221,241,249,1) 35%,rgba(160,216,239,1) 100%) !important; filter: progid:DXImageTransform.Microsoft.gradient( startColorstr=\'#feffff\', endColorstr=\'#a0d8ef\',GradientType=0 ) !important; color: #444 !important; border: 1px solid #c3e6f5 !important;',
						'Silver' => 'background: rgb(246,248,249) !important; background: -moz-linear-gradient(top, rgba(246,248,249,1) 0%, rgba(229,235,238,1) 50%, rgba(215,222,227,1) 51%, rgba(245,247,249,1) 100%) !important; background: -webkit-gradient(linear, left top, left bottom, color-stop(0%,rgba(246,248,249,1)), color-stop(50%,rgba(229,235,238,1)), color-stop(51%,rgba(215,222,227,1)), color-stop(100%,rgba(245,247,249,1))) !important; background: -webkit-linear-gradient(top, rgba(246,248,249,1) 0%,rgba(229,235,238,1) 50%,rgba(215,222,227,1) 51%,rgba(245,247,249,1) 100%) !important; background: -o-linear-gradient(top, rgba(246,248,249,1) 0%,rgba(229,235,238,1) 50%,rgba(215,222,227,1) 51%,rgba(245,247,249,1) 100%) !important; background: -ms-linear-gradient(top, rgba(246,248,249,1) 0%,rgba(229,235,238,1) 50%,rgba(215,222,227,1) 51%,rgba(245,247,249,1) 100%) !important; background: linear-gradient(top, rgba(246,248,249,1) 0%,rgba(229,235,238,1) 50%,rgba(215,222,227,1) 51%,rgba(245,247,249,1) 100%) !important; filter: progid:DXImageTransform.Microsoft.gradient( startColorstr=\'#f6f8f9\', endColorstr=\'#f5f7f9\',GradientType=0 ) !important; color: #444 !important; border: 1px solid #f5f7f9 !important;',
						'Pink' => 'background: rgb(252,236,252) !important; background: -moz-linear-gradient(top, rgba(252,236,252,1) 0%, rgba(251,166,225,1) 50%, rgba(253,137,215,1) 51%, rgba(255,124,216,1) 100%) !important; background: -webkit-gradient(linear, left top, left bottom, color-stop(0%,rgba(252,236,252,1)), color-stop(50%,rgba(251,166,225,1)), color-stop(51%,rgba(253,137,215,1)), color-stop(100%,rgba(255,124,216,1))) !important; background: -webkit-linear-gradient(top, rgba(252,236,252,1) 0%,rgba(251,166,225,1) 50%,rgba(253,137,215,1) 51%,rgba(255,124,216,1) 100%) !important; background: -o-linear-gradient(top, rgba(252,236,252,1) 0%,rgba(251,166,225,1) 50%,rgba(253,137,215,1) 51%,rgba(255,124,216,1) 100%) !important; background: -ms-linear-gradient(top, rgba(252,236,252,1) 0%,rgba(251,166,225,1) 50%,rgba(253,137,215,1) 51%,rgba(255,124,216,1) 100%) !important; background: linear-gradient(top, rgba(252,236,252,1) 0%,rgba(251,166,225,1) 50%,rgba(253,137,215,1) 51%,rgba(255,124,216,1) 100%) !important; filter: progid:DXImageTransform.Microsoft.gradient( startColorstr=\'#fcecfc\', endColorstr=\'#ff7cd8\',GradientType=0 ) !important; color: #9b086f !important; border: 1px solid #ffb9ea !important;',
						'Beige' => 'background: -moz-linear-gradient(top, rgba(252,255,244,1) 0%, rgba(233,233,206,1) 100%) !important; background: -webkit-gradient(linear, left top, left bottom, color-stop(0%,rgba(252,255,244,1)), color-stop(100%,rgba(233,233,206,1))) !important; background: -webkit-linear-gradient(top, rgba(252,255,244,1) 0%,rgba(233,233,206,1) 100%) !important; background: -o-linear-gradient(top, rgba(252,255,244,1) 0%,rgba(233,233,206,1) 100%) !important; background: -ms-linear-gradient(top, rgba(252,255,244,1) 0%,rgba(233,233,206,1) 100%) !important; background: linear-gradient(top, rgba(252,255,244,1) 0%,rgba(233,233,206,1) 100%) !important; filter: progid:DXImageTransform.Microsoft.gradient( startColorstr=\'#fcfff4\', endColorstr=\'#e9e9ce\',GradientType=0 ) !important; color: #754f4f !important; border: 1px solid #e9e9ce !important;',
						'Yellow' => 'background: rgb(254,252,234) !important; background: -moz-linear-gradient(top, rgba(254,252,234,1) 0%, rgba(241,218,54,1) 100%) !important; background: -webkit-gradient(linear, left top, left bottom, color-stop(0%,rgba(254,252,234,1)), color-stop(100%,rgba(241,218,54,1))) !important; background: -webkit-linear-gradient(top, rgba(254,252,234,1) 0%,rgba(241,218,54,1) 100%) !important; background: -o-linear-gradient(top, rgba(254,252,234,1) 0%,rgba(241,218,54,1) 100%) !important; background: -ms-linear-gradient(top, rgba(254,252,234,1) 0%,rgba(241,218,54,1) 100%) !important; background: linear-gradient(top, rgba(254,252,234,1) 0%,rgba(241,218,54,1) 100%) !important; filter: progid:DXImageTransform.Microsoft.gradient( startColorstr=\'#fefcea\', endColorstr=\'#f1da36\',GradientType=0 ) !important; color: #a59100 !important; border: 1px solid #f1da36 !important;',
					),
					'type' => 'dropdown',
				),
				'Title Font' => array (
					'attr' => 'title-font',
					'default' => 'Lora',
					'type' => 'google_font',
				),
				'Subtext Font' => array (
					'attr' => 'subtext-font',
					'default' => 'Lora',
					'type' => 'google_font',
				),
				'Title Color' => array (
					'attr' => 'title-color',
					'default' => '#000',
					'type' => 'color',
				),
				'Subtext Color' => array (
					'attr' => 'subtext-color',
					'default' => '#555',
					'type' => 'color',
				),
				'Title Size' => array (
					'attr' => 'title-size',
					'default' => '16px',
				),
				'Subtext Size' => array (
					'attr' => 'subtext-size',
					'default' => '13px',
				),
				'Title Text' => ois_title_text('Want our free eBook? Keep reading...'),
				'Subtext Content' => array (
					'attr' => 'subtext',
					'default' => 'We\'ve written an amazing eBook about knitting that we think you\'ll love. Enter your email address below for instant access',
					'type' => 'textarea',
					'height' => '50px',
					'width' => '350px',
				),
				'Button Text' => ois_button_text('Download'),
				'Email Placeholder' => ois_email_placeholder('Email Address'),
			),
		),
	);

	$id = 19;
	$skin_19 = array (
		'title' => 'Sidebar Optin with Product Image',
		'design_preview' => OptinSkin_URL . 'admin/images/design_previews/19.png',
		'description' => '',
		'date_added' => date('Y-m-d H:i:s'),
		'last_modified' => date('Y-m-d H:i:s'),
		'css' => '',
		'css_url' => OptinSkin_URL . 'skins/css/design_20.css',
		'id' => $id,
		'custom' => 'no',
		'optin_settings' => array (
			'enable_name' => 'no',
			'placeholders' => array (
				//'name' => 'enter your name',
				'email' => 'Email Address',
			),
			'labels' => array (
			),
			'button_value' => '\'',
			'force_break' => 'yes',
			'maintain_line' => 'no',
		),
		'html' => '<div class="ois_box_19 container-fluid" style="max-width:240px;width: expression(this.width > 240 ? 240: true);' . ois_vertical_gradient('%background-top-gradient%', '%background-bottom-gradient%') . 'border: 1px solid %border-color% !important;">
            	<div class="row-fluid">
            		<div class="span8">
            			<div class="ois_title_19" style="line-height: %title-height% !important;font-size: %title-size% !important;color:%title-color% !important; text-shadow: %title-text-shadow-color% 0 1px 0!important;font-family:\'%title-font%\',serif!important;">%title-text%</div>
            		</div>
            		<div class="span4">
            				<img src="%product-url%" style="margin-top:-20px!important" class="visible-desktop ois_product_19" />
            		</div>
            	</div>
            	%optin_form%
            	<div class="ois_outer_text_19" style="font-family:\'%subtext-font%\',serif!important;color:%subtext-color%!important;">%subtext-content%</div>
            </div>
            <style type="text/css">
            	.ois_textbox_19, .ois_box_19 input[type="text"] {
            		border: 1px solid %title-text-shadow-color%  !important;
					background-color: #FAFAFA  !important;
					background-image: url(\'' . OptinSkin_URL . 'front/images/email 2.png\')  !important;
					-webkit-box-shadow: none !important;
					-moz-box-shadow: none !important;
					box-shadow: none !important;
				}
            </style>',
		'appearance' => array (
			'text' => array (
				'Background Top Gradient' => array (
					'attr' => 'background-top-gradient',
					'default' => '#93ccf1',
					'type' => 'color',
				),
				'Background Bottom Gradient' => array (
					'attr' => 'background-bottom-gradient',
					'default' => '#0e79be',
					'type' => 'color',
				),
				'Title Font' => array(
					'attr' => 'title-font',
					'default' => 'Lobster',
					'type' => 'google_font',
				),
				'Subtext Font' => array(
					'attr' => 'subtext-font',
					'default' => 'Voces',
					'type' => 'google_font',
				),
				'Title Font Size' => array (
					'attr' => 'title-size',
					'default' => '24px',
				),
				'Title Line Height' => array (
					'attr' => 'title-height',
					'default' => '28px',
				),
				'Title Color' => array(
					'attr' => 'title-color',
					'default' => '#fff',
					'type' => 'color',
				),
				'Title Text Shadow' => array(
					'attr' => 'title-text-shadow-color',
					'default' => '#0e79be',
					'type' => 'color',
				),
				'Subtext Color' => array(
					'attr' => 'subtext-color',
					'default' => '#ffffff',
					'type' => 'color',
				),
				'Button Top Gradient' => array (
					'attr' => 'button-top-gradient',
					'default' => '#f9f6e8',
					'type' => 'color',
				),
				'Button Bottom Gradient' => array (
					'attr' => 'button-bottom-gradient',
					'default' => '#f9f6e8',
					'type' => 'color',
				),
				'Button Text Color' => array (
					'attr' => 'button-text-color',
					'default' => '#333',
					'type' => 'color',
				),
				'Button Border Color' => array(
					'attr' => 'button-border-color',
					'default' => '#fff',
					'type' => 'color',
				),
				'Button Shadow Color' => array(
					'attr' => 'button-shadow-color',
					'default' => '#e1d7a8',
					'type' => 'color',
				),
				'Textbox Shadow Color' => array(
					'attr' => 'title-text-shadow-color',
					'default' => '#85b4de',
					'type' => 'color',
				),
				'Border Color' => array (
					'attr' => 'border-color',
					'default' => '#0e79be',
					'type' => 'color',
				),
				'Product Image Url (Height: 80px)' => array (
					'attr' => 'product-url',
					'default' => OptinSkin_URL . 'front/images/ebook_2.png',
					'text-width' => '375px',
				),
				'Title Text' => ois_title_text('Get Free Profitable Niche Ideas'),
				'Button Text' => ois_button_text('Free Instant Access'),
				'Subtext Content' => array (
					'attr' => 'subtext-content',
					'default' => 'No Spam. We Promise.',
					'text-width' => '350px',
				),
				'Email Placeholder' => ois_email_placeholder('Email Address'),
			),
		),
	);

	$id = 20;
	$skin_20 = array (
		'title' => 'Alfon\'s Design',
		'design_preview' => OptinSkin_URL . 'admin/images/design_previews/20.png',
		'description' => '',
		'date_added' => date('Y-m-d H:i:s'),
		'last_modified' => date('Y-m-d H:i:s'),
		'css' => '',
		'css_url' => OptinSkin_URL . 'skins/css/design_21.css',
		'id' => $id,
		'social_media' => array ( 'facebook', 'twitter', 'gplus', 'pinterest', ),
		'custom' => 'no',
		'optin_settings' => array (
			'enable_name' => 'yes',
			'placeholders' => array (
				'name' => 'enter your name',
				'email' => 'Email Address',
			),
			'labels' => array (
			),
			'button_value' => '\'',
			'force_break' => 'yes',
			'maintain_line' => 'no',
		),
		'html' => '
		<div class="ois_' . $id . '" style="max-width:660px;width: expression(this.width > 660 ? 660: true);">
			<div class="row-fluid">
				<div class="span7">
					<div style="margin-top: 25px;">
						<div class="ois_title_' . $id . '" style="margin-bottom:-20px!important;">
							<img src="' . OptinSkin_URL . 'front/images/alfons_arrow.png" style="margin-bottom:-15px!important;" /><span style="font-family:\'%call-to-action-font%\'!important;font-size:%call-to-action-size% !important;">Did you enjoy this article?</span>
						</div>
					</div>
				<div class="ois_social_' . $id . ' visible-desktop">
					<div class="ois_vorm_' . $id . '">
						<div class="row-fluid">
							<div class="span4">' . $social_buttons->ois_fb_box() . '</div>
							<div class="span4">' . $social_buttons->ois_gplus_box() . '</div>
							<div class="span4">' . $social_buttons->ois_twitter_box() . '</div>
						</div>
					</div>
					<div style="position: relative;">
						<img src="' . OptinSkin_URL . 'front/images/alfons_badge.png" style="position:absolute;top:30px;z-index:2;" />
						<div class="ois_badge_text_' . $id . '" style="position:absolute;z-index: 3;font-family:\'%badge-button-font%\'!important;">
							<div>Share</div>
							<div>the</div>
							<div>Love</div>
						</div>
					</div>
				</div>
			</div>
			<div class="span4">
				<div class="ois_subtitle_' . $id . '" style="font-family:\'%form-title-font%\' !important;font-size: %form-title-size% !important;">Get Free Updates</div>
				<div class="ois_form_' . $id . '">
					%optin_form%
				</div>
			</div>
		</div>
	</div>',
		'appearance' => array (
			'text' => array (
				'Button Top Gradient' => array (
					'attr' => 'button-top-gradient',
					'default' => '#feda71',
					'type' => 'color',
				),
				'Button Bottom Gradient' => array (
					'attr' => 'button-bottom-gradient',
					'default' => '#febf4f',
					'type' => 'color',
				),
				'Button Text Color' => array (
					'attr' => 'button-text-color',
					'default' => '#963',
					'type' => 'color',
				),
				'Button Border Color' => array(
					'attr' => 'button-border-color',
					'default' => '#EEB047',
					'type' => 'color',
				),
				'Call to Action Font' => array (
					'attr' => 'call-to-action-font',
					'default' => 'Shadows Into Light',
					'type' => 'google_font',
				),
				'Form Title Font' => array (
					'attr' => 'form-title-font',
					'default' => 'Patua One',
					'type' => 'google_font',
				),
				'Button Text Font' => array (
					'attr' => 'button-text-font',
					'default' => 'Patua One',
					'type' => 'google_font',
				),
				'Call to Action Size' => array (
					'attr' => 'form-title-size',
					'default' => '24px',
				),
				'Form Title Size' => array (
					'attr' => 'form-title-size',
					'default' => '26px',
				),
				'Second Social Button' => array(
					'attr' => 'second_social',
					'default' => $social_buttons->ois_gplus_box(),
					'values' => array (
						'Facebook' => htmlentities($social_buttons->ois_fb_box()),
						'Google Plus' => htmlentities($social_buttons->ois_gplus_box()),
						'Twitter' => htmlentities($social_buttons->ois_twitter_box()),
						'Pinterest' => htmlentities($social_buttons->ois_pinterest_box()),
					),
					'type' => 'dropdown',
				),
				'Third Social Button' => array(
					'attr' => 'third_social',
					'default' => $social_buttons->ois_twitter_box(),
					'values' => array (
						'Facebook' => htmlentities($social_buttons->ois_fb_box()),
						'Google Plus' => htmlentities($social_buttons->ois_gplus_box()),
						'Twitter' => htmlentities($social_buttons->ois_twitter_box()),
						'Pinterest' => htmlentities($social_buttons->ois_pinterest_box()),
					),
					'type' => 'dropdown',
				),
				'Button Text' => ois_button_text('Subscribe'),
				'Name Placeholder' => ois_name_placeholder('Your name'),
				'Email Placeholder' => ois_email_placeholder('Your email address'),
			),
		),
	);






	$designs = array( '1' => $skin_1, '2' => $skin_15, '3' => $skin_3, '4' => $skin_4, '5' => $skin_5, '6' => $skin_6, '7' => $skin_7, '8' => $skin_8, '9' => $skin_9, '10' => $skin_10, '11' => $skin_11, '12' => $skin_12, '13' => $skin_13, '14' => $skin_14, '15' => $skin_2, '16' => $skin_16, '17' => $skin_17, '18' => $skin_18, '19' => $skin_19, '20' => $skin_20, );

	// which ones get added to the actual set?
	$included_designs = array( 
	 '1' => $skin_20, '2' => $skin_1, '3' => $skin_3, '4' => $skin_4, '5' => $skin_5, '6' => $skin_13, '7' => $skin_14, '8' => $skin_16, );
	update_option('ois_designs', $included_designs);

	return $designs;
}
function ois_general_option($attr, $default) {
	return array ( 'attr' => $attr,
		'default' => $default );
}
function ois_font_option($attr, $default) {
	return array ( 'attr' => $attr,
		'default' => $default,
		'type' => 'google_font' );
}
function ois_color_option( $attr, $default) {
	return array ( 'attr' => $attr, 'default' => $default, 'type' => 'color' );
}
function ois_update_designs_code() {

	update_option('ois_all_designs', ois_designs_code());
}
function ois_box_width($default) {
	return array ( 'attr' => 'box-width', 'default' => $default );
}
function ois_title_text($default) {
	return array ( 'attr' => 'title-text', 'default' => $default, 'text-width' => '275px');
}
function ois_subtitle_text($default) {
	return array ( 'attr' => 'subtitle-text', 'default' => $default, 'text-width' => '320px');
}
function ois_button_text($default) {
	return array ( 'attr' => 'button-text', 'default' => $default);
}
function ois_email_placeholder($default) {
	return array ( 'attr' => 'email-placeholder', 'default' => $default, 'text-width' => '250px', );
}
function ois_name_placeholder($default) {
	return array ( 'attr' => 'name-placeholder', 'default' => $default, 'text-width' => '250px', );
}
function ois_name_width($default) {
	return array ( 'attr' => 'name-width', 'default' => $default, );
}
function ois_email_width($default) {
	return array ( 'attr' => 'email-width', 'default' => $default, );
}
?>