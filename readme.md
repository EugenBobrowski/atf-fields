# ATF fields helper

### Text field

### Number

### Textarea

### Group
 
```php
 <?php AtfHtmlHelper::group(array(
		 'name' => 'robots_options[allows]',
		 'items' => array(
			 'path' => array(
				 'title' => __('Path', 'robotstxt-rewrite'),
				 'type' => 'text',
				 'desc' => __('Relative path of WordPress installation directory', 'robotstxt-rewrite'),
			 ),
			 'bots' => array(
				 'title' => __('Robots names', 'robotstxt-rewrite'),
				 'type' => 'checkbox',
				 'options' => array(
					 'googlebot' => 'Google',
					 'googlebot-mobile' => 'Google Mobile',
					 'googlebot-image'=> 'Google Images',
					 'Yandex' => 'Yandex',
				 ),
			 ),
			 'allowed' => array(
				 'title' => __('Allow', 'robotstxt-rewrite'),
				 'type' => 'tumbler',
				 'options' => array('plain' => 'Text', 'html' => 'HTML'),
				 'desc' => __('Allow / Disallow', 'robotstxt-rewrite'),
				 'cell_style' => 'text-align: center;',
			 ),
		 ),
		 'value' => array(
		 	'path' => array(
		 		'/',
		 		'/wp-content/'
		 	),
		 	'bots' => array(
		 		'',
		 		'google'
		 	),
		 	'allowed' => array(
		 		0,
		 		1
		 	),
		 ),
	 )
 );
 ?>
```
 
 sdf
