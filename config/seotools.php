<?php
/**
 * @see https://github.com/artesaos/seotools
 */

return [
    'meta' => [
        /*
         * The default configurations to be used by the meta generator.
         */
        'defaults' => [
            'title' => "InvoicePedia - Free Online Invoice Generator, Billing & Accounting", // set false to total remove
            'titleBefore' => false, // Put defaults.title before page title, like 'It's Over 9000! - Dashboard'
            'description' => 'Create Free Online Invoice Generator, Billing, QuickBooks, Freshbooks, Zoho Books, Xero,
            Sage 50c, Wave, Invoice2go, OneUp, SliQ Invoicing, BillQuick Online,
             FinancialForce Billing', // set false to total remove
            'separator' => ' - ',
            'keywords' => ['Online Invoices', 'Estimate', 'Billing', 'Online Payment', 'Online Accounting Software', 'Zoho Books', 'Freshbooks',
                'Expense Entry', 'Pos Sale', 'Purchase Online', 'POS', 'Balance Sheet', 'Profit Loss', 'Online Sales Software', 'Quickbooks'],
            'canonical' => null, // Set null for using Url::current(), set false to total remove
            'robots' => 'all', // Set to 'all', 'none' or any combination of index/noindex and follow/nofollow
        ],
        /*
         * Webmaster tags are always added.
         */
        'webmaster_tags' => [
            'google' => null,
            'bing' => null,
            'alexa' => null,
            'pinterest' => null,
            'yandex' => null,
            'norton' => null,
        ],

        'add_notranslate_class' => false,
    ],
    'opengraph' => [
        /*
         * The default configurations to be used by the opengraph generator.
         */
        'defaults' => [
            'title' => "InvoicePedia - Free Online Invoice Generator, Billing & Accounting", // set false to total remove
            'description' => 'Create Free Online Invoice Generator, Billing, QuickBooks, Freshbooks, Zoho Books, Xero,
            Sage 50c, Wave, Invoice2go, OneUp, SliQ Invoicing, BillQuick Online,
             FinancialForce Billing', 'url' => null, // Set null for using Url::current(), set false to total remove
            'type' => false,
            'site_name' => false,
            'images' => [],
        ],
    ],
    'twitter' => [
        /*
         * The default values to be used by the twitter cards generator.
         */
        'defaults' => [
            //'card'        => 'summary',
            //'site'        => '@LuizVinicius73',
        ],
    ],
    'json-ld' => [
        /*
         * The default configurations to be used by the json-ld generator.
         */
        'defaults' => [
            'title' => "InvoicePedia - Free Online Invoice Generator, Billing & Accounting", // set false to total remove
            'description' => 'Create Free Online Invoice Generator, Billing, QuickBooks, Freshbooks, Zoho Books, Xero,
            Sage 50c, Wave, Invoice2go, OneUp, SliQ Invoicing, BillQuick Online,
             FinancialForce Billing',
            'url' => null, // Set null for using Url::current(), set false to total remove
            'type' => 'WebPage',
            'images' => [],
        ],
    ],
];
