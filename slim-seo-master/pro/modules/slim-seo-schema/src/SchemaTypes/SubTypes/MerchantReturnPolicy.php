<?php
use SlimSEOPro\Schema\SchemaTypes\Helper;

return [
	'label'  => __( 'Has merchant return policy', 'slim-seo-schema' ),
	'id'     => 'hasMerchantReturnPolicy',
	'type'   => 'Group',
	'fields' => [
		[
			'id'       => '@type',
			'std'      => 'MerchantReturnPolicy',
			'type'     => 'Hidden',
			'required' => true,
		],
		// Option A
		[
			'id'        => 'applicableCountry',
			'label'     => __( 'Applicable country', 'slim-seo-schema' ),
			'tooltip'   => __( 'A country where a particular merchant return policy applies to, for exp the two-letter ISO 3166-1 alpha-2 country code. You can specify up to 50 countries.', 'slim-seo-schema' ),
			'cloneable' => true,
		],
		Helper::get_sub_type( 'MerchantReturnEnumeration' ),
		// Option B
		[
			'id'      => 'merchantReturnLink',
			'label'   => __( 'Merchant return link', 'slim-seo-schema' ),
			'tooltip' => __( 'The URL of a web page that describes the return policy to your customers. This can be your own return policy, or a third-party policy from a service that handles your returns.', 'slim-seo-schema' ),
			'show'    => true,
		],

		// Finite or unlimited return windows
		// The following properties are recommended when returnPolicyCategory is set to MerchantReturnFiniteReturnWindow or MerchantReturnUnlimitedWindow.
		[
			'id'      => 'merchantReturnDays',
			'label'   => __( 'Merchant return days', 'slim-seo-schema' ),
			'tooltip' => __( 'The number of days from the delivery date that an item can be returned. This property is only required if return policy category equals finite return window.', 'slim-seo-schema' ),
		],
		Helper::get_sub_type( 'ReturnFeesEnumeration', [
			'label'   => __( 'Return fees', 'slim-seo-schema' ),
			'id'      => 'returnFees',
			'tooltip' => __( 'The default type of return fee.', 'slim-seo-schema' ),
		] ),
		[
			'label'   => __( 'Return method', 'slim-seo-schema' ),
			'id'      => 'returnMethod',
			'type'    => 'DataList',
			'tooltip' => __( 'The type of return method.', 'slim-seo-schema' ),
			'std'     => 'https://schema.org/ReturnAtKiosk',
			'options' => [
				'https://schema.org/ReturnAtKiosk' => __( 'Return at kiosk', 'slim-seo-schema' ),
				'https://schema.org/ReturnByMail'  => __( 'Return by mail', 'slim-seo-schema' ),
				'https://schema.org/ReturnInStore' => __( 'Return in store', 'slim-seo-schema' ),
			],
		],
		Helper::get_sub_type( 'MonetaryAmount', [
			'id'      => 'returnShippingFeesAmount',
			'label'   => __( 'Return shipping fees amount', 'slim-seo-schema' ),
			'tooltip' => __( 'A specific type of return fee if the item is returned due to customer remorse. The cost of shipping for returning item. This property must be specified only when return fees equals "Return shipping fees".', 'slim-seo-schema' ),
		] ),

		// Finite or unlimited return windows
		// The following properties are additionally recommended if returnPolicyCategory is set to MerchantReturnFiniteReturnWindow or MerchantReturnUnlimitedWindow.
		Helper::get_sub_type( 'ReturnFeesEnumeration', [
			'id'      => 'customerRemorseReturnFees',
			'label'   => __( 'Customer remorse return fees', 'slim-seo-schema' ),
			'tooltip' => __( 'A specific type of return fee if the item is returned due to customer remorse.', 'slim-seo-schema' ),
		] ),
		[
			'id'      => 'customerRemorseReturnLabelSource',
			'label'   => __( 'Customer remorse return label source', 'slim-seo-schema' ),
			'type'    => 'DataList',
			'tooltip' => __( 'The method by which the consumer obtains a return shipping label for an item.', 'slim-seo-schema' ),
			'std'     => 'https://schema.org/ReturnLabelCustomerResponsibility',
			'options' => [
				'https://schema.org/ReturnLabelCustomerResponsibility' => __( 'Return label customer responsibility', 'slim-seo-schema' ),
				'https://schema.org/ReturnLabelDownloadAndPrint' => __( 'Return label download and print', 'slim-seo-schema' ),
				'https://schema.org/ReturnLabelInBox' => __( 'Return label inBox', 'slim-seo-schema' ),
			],
		],
		Helper::get_sub_type( 'MonetaryAmount', [
			'id'      => 'customerRemorseReturnShippingFeesAmount',
			'label'   => __( 'Customer remorse return shipping fees amount', 'slim-seo-schema' ),
			'tooltip' => __( 'The cost of shipping for returning an item due to customer remorse. This property is only required if there\'s a non-zero shipping fee to be paid by the consumer to return an item.', 'slim-seo-schema' ),
		] ),
		[
			'label'     => __( 'Item condition', 'slim-seo-schema' ),
			'id'        => 'itemCondition',
			'type'      => 'Select',
			'cloneable' => true,
			'tooltip'   => __( 'The type of return method.', 'slim-seo-schema' ),
			'options'   => [
				'https://schema.org/NewCondition'  => __( 'New', 'slim-seo-schema' ),
				'https://schema.org/DamagedCondition' => __( 'Damaged', 'slim-seo-schema' ),
				'https://schema.org/RefurbishedCondition' => __( 'Refurbished', 'slim-seo-schema' ),
				'https://schema.org/UsedCondition' => __( 'Used', 'slim-seo-schema' ),
			],
		],
		Helper::get_sub_type( 'ReturnFeesEnumeration', [
			'label'   => __( 'Item defect return fees', 'slim-seo-schema' ),
			'id'      => 'itemDefectReturnFees',
			'tooltip' => __( 'A specific type of return fee for defect items.', 'slim-seo-schema' ),
		] ),
		[
			'label'   => __( 'Item defect return label source', 'slim-seo-schema' ),
			'id'      => 'itemDefectReturnLabelSource',
			'type'    => 'DataList',
			'tooltip' => __( 'The method by which the consumer can obtain a return shipping label for an item.', 'slim-seo-schema' ),
			'std'     => 'https://schema.org/ReturnLabelCustomerResponsibility',
			'options' => [
				'https://schema.org/ReturnLabelCustomerResponsibility' => __( 'Return label customer responsibility', 'slim-seo-schema' ),
				'https://schema.org/ReturnLabelDownloadAndPrint' => __( 'Return label download and print', 'slim-seo-schema' ),
				'https://schema.org/ReturnLabelInBox' => __( 'Return label inbox', 'slim-seo-schema' ),
			],
		],
		Helper::get_sub_type( 'MonetaryAmount', [
			'id'      => 'itemDefectReturnShippingFeesAmount',
			'label'   => __( 'Item defect return shipping fees amount', 'slim-seo-schema' ),
			'tooltip' => __( 'The cost of shipping for returning a product due to defect products. This property is only required if there\'s a non-zero shipping fee to be paid by the consumer to return a product.', 'slim-seo-schema' ),
		] ),
		[
			'label'   => __( 'Refund type', 'slim-seo-schema' ),
			'id'      => 'refundType',
			'type'    => 'DataList',
			'tooltip' => __( 'The type of refund(s) available for the consumer when returning an item.', 'slim-seo-schema' ),
			'std'     => 'https://schema.org/ExchangeRefund',
			'options' => [
				'https://schema.org/ExchangeRefund' => __( 'Exchange refund', 'slim-seo-schema' ),
				'https://schema.org/FullRefund' => __( 'Full refund', 'slim-seo-schema' ),
				'https://schema.org/StoreCreditRefund' => __( 'Store credit refund', 'slim-seo-schema' ),
			],
		],
		Helper::get_sub_type( 'MonetaryAmount', [
			'id'      => 'restockingFeeAmount',
			'label'   => __( 'Restocking fee amount', 'slim-seo-schema' ),
			'tooltip' => __( 'The restocking fee charged to the consumer when returning a product.', 'slim-seo-schema' ),
		] ),
		[
			'label'   => __( 'Return label source', 'slim-seo-schema' ),
			'id'      => 'returnLabelSource',
			'type'    => 'DataList',
			'tooltip' => __( 'The method by which the consumer can obtain a return shipping label for an item.', 'slim-seo-schema' ),
			'std'     => 'https://schema.org/ReturnLabelCustomerResponsibility',
			'options' => [
				'https://schema.org/ReturnLabelCustomerResponsibility' => __( 'Return label customer responsibility', 'slim-seo-schema' ),
				'https://schema.org/ReturnLabelDownloadAndPrint'       => __( 'Return label download and print', 'slim-seo-schema' ),
				'https://schema.org/ReturnLabelInBox'                  => __( 'Return label inbox', 'slim-seo-schema' ),
			],
		],
		[
			'id'        => 'returnPolicyCountry',
			'label'     => __( 'Return policy country', 'slim-seo-schema' ),
			'tooltip'   => __( 'The country where the item has to be sent to for returns, for exp the two-letter ISO 3166-1 alpha-2 country code. You can specify up to 50 countries.', 'slim-seo-schema' ),
			'cloneable' => true,
		],

		// Seasonal override properties
		// The following properties are required when you need to define seasonal overrides for your organization-level return policies.
		[
			'id'        => 'returnPolicySeasonalOverride',
			'label'     => __( 'Return policy seasonal override', 'slim-seo-schema' ),
			'type'      => 'Group',
			'tooltip'   => __( 'A seasonal override of a return policy to specify return policies for special events, such as holidays. The usual return policy is unlimited, but is limited during the following two date ranges.', 'slim-seo-schema' ),
			'cloneable' => true,
			'fields'    => [
				[
					'id'       => '@type',
					'std'      => 'MerchantReturnPolicySeasonalOverride',
					'type'     => 'Hidden',
					'required' => true,
				],
				Helper::get_sub_type( 'MerchantReturnEnumeration', [
					'show' => true,
				] ),
				// The following properties are recommended when you need to define seasonal overrides for your organization-level return policies.
				[
					'id'      => 'endDate',
					'label'   => __( 'End date', 'slim-seo-schema' ),
					'tooltip' => __( 'The optional end date and end time of the event in ISO-8601 format', 'slim-seo-schema' ),
					'show'    => true,
				],
				[
					'id'      => 'merchantReturnDays',
					'label'   => __( 'Merchant return days' ),
					'tooltip' => __( 'The number of days from the delivery date that an item can be returned. This property is only required if returnPolicyCategory equals MerchantReturnFiniteReturnWindow.', 'slim-seo-schema' ),
					'show'    => true,
				],
				[
					'id'      => 'startDate',
					'label'   => __( 'Start date', 'slim-seo-schema' ),
					'type'    => 'Date',
					'tooltip' => __( 'The start date and start time of the event in ISO-8601 format', 'slim-seo-schema' ),
					'show'    => true,
				],
			],
		],
	],
];