<?php
$roket_shipping_config = [
	'kurir' => [
		'rs-jne' => [
			'slug' => 'jne',
			'title' => 'JNE',
			'desc' => 'JNE Shipping',
			'field_option' => [
	            'title' => __( 'JNE', 'roket_shipping' ),
	              'type' => 'checkbox',
	              'description' => __( 'JNE shipping', 'roket_shipping' ),
	              'default' => __( 'no', 'roket_shipping' )
	        ],
		],
		'rs-tiki' => [
			'slug' => 'tiki',
			'title' => 'TIKI',
			'desc' => 'TIKI Shipping',
			'field_option' => [
	            'title' => __( 'TIKI', 'roket_shipping' ),
	              'type' => 'checkbox',
	              'description' => __( 'TIKI shipping', 'roket_shipping' ),
	              'default' => __( 'no', 'roket_shipping' )
	        ],
		],
	]
];