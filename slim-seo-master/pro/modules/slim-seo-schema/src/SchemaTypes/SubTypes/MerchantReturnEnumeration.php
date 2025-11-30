<?php
return [
	'label'   => __( 'Return policy category', 'slim-seo-schema' ),
	'id'      => 'returnPolicyCategory',
	'type'    => 'DataList',
	'tooltip' => __( 'The type of return policy. If you use finite return window, then the merchant return days property is required.', 'slim-seo-schema' ),
	'std'     => 'https://schema.org/MerchantReturnFiniteReturnWindow',
	'options' => [
		'https://schema.org/MerchantReturnFiniteReturnWindow' => __( 'Finite return window', 'slim-seo-schema' ),
		'https://schema.org/MerchantReturnNotPermitted'       => __( 'Not permitted', 'slim-seo-schema' ),
		'https://schema.org/MerchantReturnUnlimitedWindow'    => __( 'Unlimited Window', 'slim-seo-schema' ),
	],
];