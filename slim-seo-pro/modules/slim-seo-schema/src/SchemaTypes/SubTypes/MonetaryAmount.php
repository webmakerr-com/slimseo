<?php
return [
	'type'   => 'Group',
	'fields' => [
		[
			'id'       => '@type',
			'std'      => 'MonetaryAmount',
			'type'     => 'Hidden',
			'required' => true,
		],
		[
			'id'       => 'value',
			'label'    => __( 'Value', 'slim-seo-schema' ),
			'required' => true,
		],
		[
			'id'       => 'currency',
			'label'    => __( 'Currency', 'slim-seo-schema' ),
			'std'      => 'USD',
			'required' => true,
		],
	],
];
