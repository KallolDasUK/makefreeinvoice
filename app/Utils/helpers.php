<?php

use App\Models\MetaSetting;
use Enam\Acc\Models\Ledger;
use Enam\Acc\Models\TransactionDetail;
use Enam\Acc\Utils\EntryType;

if (!function_exists('decent_format')) {
    function decent_format($number): string
    {
        $number = number_format($number, 2);
        $number = str_replace('.00', '', $number);
        return $number;
    }
}
if (!function_exists('decent_format_dash_if_zero')) {
    function decent_format_dash_if_zero($number): string
    {
        if (floatval($number) == 0) {
            return '-';
        }
        $number = number_format($number, 2);
        $number = str_replace('.00', '', $number);
        return (settings()->currency ?? '$') . '' . $number;
    }
}
if (!function_exists('decent_format_dash')) {
    function decent_format_dash($number): string
    {
        if (floatval($number) == 0) {
            return '-';
        }
        $number = number_format($number, 2);
        $number = str_replace('.00', '', $number);
        return '' . $number;
    }
}
if (!function_exists('settings')) {
    function settings()
    {
        $settings = json_decode(MetaSetting::query()->pluck('value', 'key')->toJson());
        return $settings;
    }
}


if (!function_exists('openingBalance')) {
    function openingBalance($ledger): int
    {
        return TransactionDetail::query()->where('ledger_id', $ledger->id)->where('note', "OpeningBalance")->sum('amount');
    }
}
if (!function_exists('openingDrBalance')) {
    function openingDrBalance($ledger, $start, $end)
    {
        return TransactionDetail::query()
            ->where('ledger_id', $ledger->id)
            ->where('entry_type', EntryType::$DR)
            ->where('note', 'OpeningBalance')
            ->sum('amount');

    }
}
if (!function_exists('openingCrBalance')) {
    function openingCrBalance($ledger, $start, $end)
    {

    }
}
if (!function_exists('is_home')) {
    function is_home($url, $routeName)
    {
        if ($routeName == 'acc.home') {
            return 'active';
        } else return '';


    }
}
if (!function_exists('is_settings')) {
    function is_settings($url, $routeName)
    {
        if ($routeName == 'accounting.settings.edit') {
            return 'active';
        } else return '';


    }
}
if (!function_exists('countries')) {
    function countries()
    {
        return array("Afghanistan", "Albania", "Algeria", "American Samoa", "Andorra", "Angola", "Anguilla", "Antarctica", "Antigua and Barbuda", "Argentina", "Armenia", "Aruba", "Australia", "Austria", "Azerbaijan", "Bahamas", "Bahrain", "Bangladesh", "Barbados", "Belarus", "Belgium", "Belize", "Benin", "Bermuda", "Bhutan", "Bolivia", "Bosnia and Herzegowina", "Botswana", "Bouvet Island", "Brazil", "British Indian Ocean Territory", "Brunei Darussalam", "Bulgaria", "Burkina Faso", "Burundi", "Cambodia", "Cameroon", "Canada", "Cape Verde", "Cayman Islands", "Central African Republic", "Chad", "Chile", "China", "Christmas Island", "Cocos (Keeling) Islands", "Colombia", "Comoros", "Congo", "Congo, the Democratic Republic of the", "Cook Islands", "Costa Rica", "Cote d'Ivoire", "Croatia (Hrvatska)", "Cuba", "Cyprus", "Czech Republic", "Denmark", "Djibouti", "Dominica", "Dominican Republic", "East Timor", "Ecuador", "Egypt", "El Salvador", "Equatorial Guinea", "Eritrea", "Estonia", "Ethiopia", "Falkland Islands (Malvinas)", "Faroe Islands", "Fiji", "Finland", "France", "France Metropolitan", "French Guiana", "French Polynesia", "French Southern Territories", "Gabon", "Gambia", "Georgia", "Germany", "Ghana", "Gibraltar", "Greece", "Greenland", "Grenada", "Guadeloupe", "Guam", "Guatemala", "Guinea", "Guinea-Bissau", "Guyana", "Haiti", "Heard and Mc Donald Islands", "Holy See (Vatican City State)", "Honduras", "Hong Kong", "Hungary", "Iceland", "India", "Indonesia", "Iran (Islamic Republic of)", "Iraq", "Ireland", "Israel", "Italy", "Jamaica", "Japan", "Jordan", "Kazakhstan", "Kenya", "Kiribati", "Korea, Democratic People's Republic of", "Korea, Republic of", "Kuwait", "Kyrgyzstan", "Lao, People's Democratic Republic", "Latvia", "Lebanon", "Lesotho", "Liberia", "Libyan Arab Jamahiriya", "Liechtenstein", "Lithuania", "Luxembourg", "Macau", "Macedonia, The Former Yugoslav Republic of", "Madagascar", "Malawi", "Malaysia", "Maldives", "Mali", "Malta", "Marshall Islands", "Martinique", "Mauritania", "Mauritius", "Mayotte", "Mexico", "Micronesia, Federated States of", "Moldova, Republic of", "Monaco", "Mongolia", "Montserrat", "Morocco", "Mozambique", "Myanmar", "Namibia", "Nauru", "Nepal", "Netherlands", "Netherlands Antilles", "New Caledonia", "New Zealand", "Nicaragua", "Niger", "Nigeria", "Niue", "Norfolk Island", "Northern Mariana Islands", "Norway", "Oman", "Pakistan", "Palau", "Panama", "Papua New Guinea", "Paraguay", "Peru", "Philippines", "Pitcairn", "Poland", "Portugal", "Puerto Rico", "Qatar", "Reunion", "Romania", "Russian Federation", "Rwanda", "Saint Kitts and Nevis", "Saint Lucia", "Saint Vincent and the Grenadines", "Samoa", "San Marino", "Sao Tome and Principe", "Saudi Arabia", "Senegal", "Seychelles", "Sierra Leone", "Singapore", "Slovakia (Slovak Republic)", "Slovenia", "Solomon Islands", "Somalia", "South Africa", "South Georgia and the South Sandwich Islands", "Spain", "Sri Lanka", "St. Helena", "St. Pierre and Miquelon", "Sudan", "Suriname", "Svalbard and Jan Mayen Islands", "Swaziland", "Sweden", "Switzerland", "Syrian Arab Republic", "Taiwan, Province of China", "Tajikistan", "Tanzania, United Republic of", "Thailand", "Togo", "Tokelau", "Tonga", "Trinidad and Tobago", "Tunisia", "Turkey", "Turkmenistan", "Turks and Caicos Islands", "Tuvalu", "Uganda", "Ukraine", "United Arab Emirates", "United Kingdom", "United States", "United States Minor Outlying Islands", "Uruguay", "Uzbekistan", "Vanuatu", "Venezuela", "Vietnam", "Virgin Islands (British)", "Virgin Islands (U.S.)", "Wallis and Futuna Islands", "Western Sahara", "Yemen", "Yugoslavia", "Zambia", "Zimbabwe");
    }
}


if (!function_exists('currencies')) {
    function currencies()
    {
        $co = array(
            array('code' => 'ALL',
                'countryname' => 'Albania',
                'name' => 'Albanian lek',
                'symbol' => '&#76;'),

            array('code' => 'AFN',
                'countryname' => 'Afghanistan',
                'name' => 'Afghanistan Afghani',
                'symbol' => '&#1547;'),

            array('code' => 'ARS',
                'countryname' => 'Argentina',
                'name' => 'Argentine Peso',
                'symbol' => '&#36;'),

            array('code' => 'AWG',
                'countryname' => 'Aruba',
                'name' => 'Aruban florin',
                'symbol' => '&#402;'),

            array('code' => 'AUD',
                'countryname' => 'Australia',
                'name' => 'Australian Dollar',
                'symbol' => '&#65;&#36;'),

            array('code' => 'AZN',
                'countryname' => 'Azerbaijan',
                'name' => 'Azerbaijani Manat',
                'symbol' => '&#8380;'),

            array('code' => 'BSD',
                'countryname' => 'The Bahamas',
                'name' => 'Bahamas Dollar',
                'symbol' => '&#66;&#36;'),

            array('code' => 'BBD',
                'countryname' => 'Barbados',
                'name' => 'Barbados Dollar',
                'symbol' => '&#66;&#100;&#115;&#36;'),

            array('code' => 'BDT',
                'countryname' => 'People\'s Republic of Bangladesh',
                'name' => 'Bangladeshi taka',
                'symbol' => '&#2547;'),

            array('code' => 'BYN',
                'countryname' => 'Belarus',
                'name' => 'Belarus Ruble',
                'symbol' => '&#66;&#114;'),

            array('code' => 'BZD',
                'countryname' => 'Belize',
                'name' => 'Belize Dollar',
                'symbol' => '&#66;&#90;&#36;'),

            array('code' => 'BMD',
                'countryname' => 'British Overseas Territory of Bermuda',
                'name' => 'Bermudian Dollar',
                'symbol' => '&#66;&#68;&#36;'),

            array('code' => 'BOP',
                'countryname' => 'Bolivia',
                'name' => 'Boliviano',
                'symbol' => '&#66;&#115;'),

            array('code' => 'BAM',
                'countryname' => 'Bosnia and Herzegovina',
                'name' => 'Bosnia-Herzegovina Convertible Marka',
                'symbol' => '&#75;&#77;'),

            array('code' => 'BWP',
                'countryname' => 'Botswana',
                'name' => 'Botswana pula',
                'symbol' => '&#80;'),

            array('code' => 'BGN',
                'countryname' => 'Bulgaria',
                'name' => 'Bulgarian lev',
                'symbol' => '&#1083;&#1074;'),

            array('code' => 'BRL',
                'countryname' => 'Brazil',
                'name' => 'Brazilian real',
                'symbol' => '&#82;&#36;'),

            array('code' => 'BND',
                'countryname' => 'Sultanate of Brunei',
                'name' => 'Brunei dollar',
                'symbol' => '&#66;&#36;'),

            array('code' => 'KHR',
                'countryname' => 'Cambodia',
                'name' => 'Cambodian riel',
                'symbol' => '&#6107;'),

            array('code' => 'CAD',
                'countryname' => 'Canada',
                'name' => 'Canadian dollar',
                'symbol' => '&#67;&#36;'),

            array('code' => 'KYD',
                'countryname' => 'Cayman Islands',
                'name' => 'Cayman Islands dollar',
                'symbol' => '&#36;'),

            array('code' => 'CLP',
                'countryname' => 'Chile',
                'name' => 'Chilean peso',
                'symbol' => '&#36;'),

            array('code' => 'CNY',
                'countryname' => 'China',
                'name' => 'Chinese Yuan Renminbi',
                'symbol' => '&#165;'),

            array('code' => 'COP',
                'countryname' => 'Colombia',
                'name' => 'Colombian peso',
                'symbol' => '&#36;'),

            array('code' => 'CRC',
                'countryname' => 'Costa Rica',
                'name' => 'Costa Rican colón',
                'symbol' => '&#8353;'),

            array('code' => 'HRK',
                'countryname' => 'Croatia',
                'name' => 'Croatian kuna',
                'symbol' => '&#107;&#110;'),

            array('code' => 'CUP',
                'countryname' => 'Cuba',
                'name' => 'Cuban peso',
                'symbol' => '&#8369;'),

            array('code' => 'CZK',
                'countryname' => 'Czech Republic',
                'name' => 'Czech koruna',
                'symbol' => '&#75;&#269;'),

            array('code' => 'DKK',
                'countryname' => 'Denmark, Greenland, and the Faroe Islands',
                'name' => 'Danish krone',
                'symbol' => '&#107;&#114;'),

            array('code' => 'DOP',
                'countryname' => 'Dominican Republic',
                'name' => 'Dominican peso',
                'symbol' => '&#82;&#68;&#36;'),

            array('code' => 'XCD',
                'countryname' => 'Antigua and Barbuda, Commonwealth of Dominica, Grenada, Montserrat, St. Kitts and Nevis, Saint Lucia and St. Vincent and the Grenadines',
                'name' => 'Eastern Caribbean dollar',
                'symbol' => '&#36;'),

            array('code' => 'EGP',
                'countryname' => 'Egypt',
                'name' => 'Egyptian pound',
                'symbol' => '&#163;'),

            array('code' => 'SVC',
                'countryname' => 'El Salvador',
                'name' => 'Salvadoran colón',
                'symbol' => '&#36;'),

            array('code' => 'EEK',
                'countryname' => 'Estonia',
                'name' => 'Estonian kroon',
                'symbol' => '&#75;&#114;'),

            array('code' => 'EUR',
                'countryname' => 'European Union, Italy, Belgium, Bulgaria, Croatia, Cyprus, Czechia, Denmark, Estonia, Finland, France, Germany,
                        Greece, Hungary, Ireland, Latvia, Lithuania, Luxembourg, Malta, Netherlands, Poland,
                        Portugal, Romania, Slovakia, Slovenia, Spain, Sweden',
                'name' => 'Euro',
                'symbol' => '&#8364;'),

            array('code' => 'FKP',
                'countryname' => 'Falkland Islands',
                'name' => 'Falkland Islands (Malvinas) Pound',
                'symbol' => '&#70;&#75;&#163;'),

            array('code' => 'FJD',
                'countryname' => 'Fiji',
                'name' => 'Fijian dollar',
                'symbol' => '&#70;&#74;&#36;'),

            array('code' => 'GHC',
                'countryname' => 'Ghana',
                'name' => 'Ghanaian cedi',
                'symbol' => '&#71;&#72;&#162;'),

            array('code' => 'GIP',
                'countryname' => 'Gibraltar',
                'name' => 'Gibraltar pound',
                'symbol' => '&#163;'),

            array('code' => 'GTQ',
                'countryname' => 'Guatemala',
                'name' => 'Guatemalan quetzal',
                'symbol' => '&#81;'),

            array('code' => 'GGP',
                'countryname' => 'Guernsey',
                'name' => 'Guernsey pound',
                'symbol' => '&#81;'),

            array('code' => 'GYD',
                'countryname' => 'Guyana',
                'name' => 'Guyanese dollar',
                'symbol' => '&#71;&#89;&#36;'),

            array('code' => 'HNL',
                'countryname' => 'Honduras',
                'name' => 'Honduran lempira',
                'symbol' => '&#76;'),

            array('code' => 'HKD',
                'countryname' => 'Hong Kong',
                'name' => 'Hong Kong dollar',
                'symbol' => '&#72;&#75;&#36;'),

            array('code' => 'HUF',
                'countryname' => 'Hungary',
                'name' => 'Hungarian forint',
                'symbol' => '&#70;&#116;'),

            array('code' => 'ISK',
                'countryname' => 'Iceland',
                'name' => 'Icelandic króna',
                'symbol' => '&#237;&#107;&#114;'),

            array('code' => 'INR',
                'countryname' => 'India',
                'name' => 'Indian rupee',
                'symbol' => '&#8377;'),

            array('code' => 'IDR',
                'countryname' => 'Indonesia',
                'name' => 'Indonesian rupiah',
                'symbol' => '&#82;&#112;'),

            array('code' => 'IRR',
                'countryname' => 'Iran',
                'name' => 'Iranian rial',
                'symbol' => '&#65020;'),

            array('code' => 'IMP',
                'countryname' => 'Isle of Man',
                'name' => 'Manx pound',
                'symbol' => '&#163;'),

            array('code' => 'ILS',
                'countryname' => 'Israel, Palestinian territories of the West Bank and the Gaza Strip',
                'name' => 'Israeli Shekel',
                'symbol' => '&#8362;'),

            array('code' => 'JMD',
                'countryname' => 'Jamaica',
                'name' => 'Jamaican dollar',
                'symbol' => '&#74;&#36;'),

            array('code' => 'JPY',
                'countryname' => 'Japan',
                'name' => 'Japanese yen',
                'symbol' => '&#165;'),

            array('code' => 'JEP',
                'countryname' => 'Jersey',
                'name' => 'Jersey pound',
                'symbol' => '&#163;'),

            array('code' => 'KZT',
                'countryname' => 'Kazakhstan',
                'name' => 'Kazakhstani tenge',
                'symbol' => '&#8376;'),

            array('code' => 'KPW',
                'countryname' => 'North Korea',
                'name' => 'North Korean won',
                'symbol' => '&#8361;'),

            array('code' => 'KPW',
                'countryname' => 'South Korea',
                'name' => 'South Korean won',
                'symbol' => '&#8361;'),

            array('code' => 'KGS',
                'countryname' => 'Kyrgyz Republic',
                'name' => 'Kyrgyzstani som',
                'symbol' => '&#1083;&#1074;'),

            array('code' => 'LAK',
                'countryname' => 'Laos',
                'name' => 'Lao kip',
                'symbol' => '&#8365;'),

            array('code' => 'LAK',
                'countryname' => 'Laos',
                'name' => 'Latvian lats',
                'symbol' => '&#8364;'),

            array('code' => 'LVL',
                'countryname' => 'Laos',
                'name' => 'Latvian lats',
                'symbol' => '&#8364;'),

            array('code' => 'LBP',
                'countryname' => 'Lebanon',
                'name' => 'Lebanese pound',
                'symbol' => '&#76;&#163;'),

            array('code' => 'LRD',
                'countryname' => 'Liberia',
                'name' => 'Liberian dollar',
                'symbol' => '&#76;&#68;&#36;'),

            array('code' => 'LTL',
                'countryname' => 'Lithuania',
                'name' => 'Lithuanian litas',
                'symbol' => '&#8364;'),

            array('code' => 'MKD',
                'countryname' => 'North Macedonia',
                'name' => 'Macedonian denar',
                'symbol' => '&#1076;&#1077;&#1085;'),

            array('code' => 'MYR',
                'countryname' => 'Malaysia',
                'name' => 'Malaysian ringgit',
                'symbol' => '&#82;&#77;'),

            array('code' => 'MUR',
                'countryname' => 'Mauritius',
                'name' => 'Mauritian rupee',
                'symbol' => '&#82;&#115;'),

            array('code' => 'MXN',
                'countryname' => 'Mexico',
                'name' => 'Mexican peso',
                'symbol' => '&#77;&#101;&#120;&#36;'),

            array('code' => 'MNT',
                'countryname' => 'Mongolia',
                'name' => 'Mongolian tögrög',
                'symbol' => '&#8366;'),


            array('code' => 'MZN',
                'countryname' => 'Mozambique',
                'name' => 'Mozambican metical',
                'symbol' => '&#77;&#84;'),

            array('code' => 'NAD',
                'countryname' => 'Namibia',
                'name' => 'Namibian dollar',
                'symbol' => '&#78;&#36;'),

            array('code' => 'NPR',
                'countryname' => 'Federal Democratic Republic of Nepal',
                'name' => 'Nepalese rupee',
                'symbol' => '&#82;&#115;&#46;'),

            array('code' => 'ANG',
                'countryname' => 'Curaçao and Sint Maarten',
                'name' => 'Netherlands Antillean guilder',
                'symbol' => '&#402;'),

            array('code' => 'NZD',
                'countryname' => 'New Zealand, the Cook Islands, Niue, the Ross Dependency, Tokelau, the Pitcairn Islands',
                'name' => 'New Zealand dollar',
                'symbol' => '&#36;'),


            array('code' => 'NIO',
                'countryname' => 'Nicaragua',
                'name' => 'Nicaraguan córdoba',
                'symbol' => '&#67;&#36;'),

            array('code' => 'NGN',
                'countryname' => 'Nigeria',
                'name' => 'Nigerian naira',
                'symbol' => '&#8358;'),

            array('code' => 'NOK',
                'countryname' => 'Norway and its dependent territories',
                'name' => 'Norwegian krone',
                'symbol' => '&#107;&#114;'),

            array('code' => 'OMR',
                'countryname' => 'Oman',
                'name' => 'Omani rial',
                'symbol' => '&#65020;'),

            array('code' => 'PKR',
                'countryname' => 'Pakistan',
                'name' => 'Pakistani rupee',
                'symbol' => '&#82;&#115;'),

            array('code' => 'PAB',
                'countryname' => 'Panama',
                'name' => 'Panamanian balboa',
                'symbol' => '&#66;&#47;&#46;'),

            array('code' => 'PYG',
                'countryname' => 'Paraguay',
                'name' => 'Paraguayan Guaraní',
                'symbol' => '&#8370;'),

            array('code' => 'PEN',
                'countryname' => 'Peru',
                'name' => 'Sol',
                'symbol' => '&#83;&#47;&#46;'),

            array('code' => 'PHP',
                'countryname' => 'Philippines',
                'name' => 'Philippine peso',
                'symbol' => '&#8369;'),

            array('code' => 'PLN',
                'countryname' => 'Poland',
                'name' => 'Polish złoty',
                'symbol' => '&#122;&#322;'),

            array('code' => 'QAR',
                'countryname' => 'State of Qatar',
                'name' => 'Qatari Riyal',
                'symbol' => '&#65020;'),

            array('code' => 'RON',
                'countryname' => 'Romania',
                'name' => 'Romanian leu (Leu românesc)',
                'symbol' => '&#76;'),

            array('code' => 'RUB',
                'countryname' => 'Russian Federation, Abkhazia and South Ossetia, Donetsk and Luhansk',
                'name' => 'Russian ruble',
                'symbol' => '&#8381;'),


            array('code' => 'SHP',
                'countryname' => 'Saint Helena, Ascension and Tristan da Cunha',
                'name' => 'Saint Helena pound',
                'symbol' => '&#163;'),

            array('code' => 'SAR',
                'countryname' => 'Saudi Arabia',
                'name' => 'Saudi riyal',
                'symbol' => '&#65020;'),

            array('code' => 'RSD',
                'countryname' => 'Serbia',
                'name' => 'Serbian dinar',
                'symbol' => '&#100;&#105;&#110;'),

            array('code' => 'SCR',
                'countryname' => 'Seychelles',
                'name' => 'Seychellois rupee',
                'symbol' => '&#82;&#115;'),

            array('code' => 'SGD',
                'countryname' => 'Singapore',
                'name' => 'Singapore dollar',
                'symbol' => '&#83;&#36;'),

            array('code' => 'SBD',
                'countryname' => 'Solomon Islands',
                'name' => 'Solomon Islands dollar',
                'symbol' => '&#83;&#73;&#36;'),

            array('code' => 'SOS',
                'countryname' => 'Somalia',
                'name' => 'Somali shilling',
                'symbol' => '&#83;&#104;&#46;&#83;&#111;'),

            array('code' => 'ZAR',
                'countryname' => 'South Africa',
                'name' => 'South African rand',
                'symbol' => '&#82;'),

            array('code' => 'LKR',
                'countryname' => 'Sri Lanka',
                'name' => 'Sri Lankan rupee',
                'symbol' => '&#82;&#115;'),


            array('code' => 'SEK',
                'countryname' => 'Sweden',
                'name' => 'Swedish krona',
                'symbol' => '&#107;&#114;'),


            array('code' => 'CHF',
                'countryname' => 'Switzerland',
                'name' => 'Swiss franc',
                'symbol' => '&#67;&#72;&#102;'),

            array('code' => 'SRD',
                'countryname' => 'Suriname',
                'name' => 'Suriname Dollar',
                'symbol' => '&#83;&#114;&#36;'),

            array('code' => 'SYP',
                'countryname' => 'Syria',
                'name' => 'Syrian pound',
                'symbol' => '&#163;&#83;'),

            array('code' => 'TWD',
                'countryname' => 'Taiwan',
                'name' => 'New Taiwan dollar',
                'symbol' => '&#78;&#84;&#36;'),


            array('code' => 'THB',
                'countryname' => 'Thailand',
                'name' => 'Thai baht',
                'symbol' => '&#3647;'),


            array('code' => 'TTD',
                'countryname' => 'Trinidad and Tobago',
                'name' => 'Trinidad and Tobago dollar',
                'symbol' => '&#84;&#84;&#36;'),


            array('code' => 'TRY',
                'countryname' => 'Turkey, Turkish Republic of Northern Cyprus',
                'name' => 'Turkey Lira',
                'symbol' => '&#8378;'),

            array('code' => 'TVD',
                'countryname' => 'Tuvalu',
                'name' => 'Tuvaluan dollar',
                'symbol' => '&#84;&#86;&#36;'),

            array('code' => 'UAH',
                'countryname' => 'Ukraine',
                'name' => 'Ukrainian hryvnia',
                'symbol' => '&#8372;'),


            array('code' => 'GBP',
                'countryname' => 'United Kingdom, Jersey, Guernsey, the Isle of Man, Gibraltar, South Georgia and the South Sandwich Islands, the British Antarctic Territory, and Tristan da Cunha',
                'name' => 'Pound sterling',
                'symbol' => '&#163;'),


            array('code' => 'UGX',
                'countryname' => 'Uganda',
                'name' => 'Ugandan shilling',
                'symbol' => '&#85;&#83;&#104;'),


            array('code' => 'USD',
                'countryname' => 'United States',
                'name' => 'United States dollar',
                'symbol' => '&#36;'),

            array('code' => 'UYU',
                'countryname' => 'Uruguayan',
                'name' => 'Peso Uruguayolar',
                'symbol' => '&#36;&#85;'),

            array('code' => 'UZS',
                'countryname' => 'Uzbekistan',
                'name' => 'Uzbekistani soʻm',
                'symbol' => '&#1083;&#1074;'),


            array('code' => 'VEF',
                'countryname' => 'Venezuela',
                'name' => 'Venezuelan bolívar',
                'symbol' => '&#66;&#115;'),


            array('code' => 'VND',
                'countryname' => 'Vietnam',
                'name' => 'Vietnamese dong (Đồng)',
                'symbol' => '&#8363;'),

            array('code' => 'VND',
                'countryname' => 'Yemen',
                'name' => 'Yemeni rial',
                'symbol' => '&#65020;'),

            array('code' => 'ZWD',
                'countryname' => 'Zimbabwe',
                'name' => 'Zimbabwean dollar',
                'symbol' => '&#90;&#36;'),


        );

        foreach ($co as $index => $c) {
            $co[$index]['symbol'] = html_entity_decode($c['symbol']);
        }
        return collect($co);
    }


}

if (!function_exists('participants')) {
    function participants($txn_id, $ledger_id)
    {
        $participants = [];
        $ledger_ids = TransactionDetail::query()
            ->where('transaction_id', $txn_id)
            ->where('ledger_id', '!=', $ledger_id)
            ->pluck('ledger_id')->toArray();
        $ledgers = Ledger::find($ledger_ids);
        if ($ledgers) {
            $participants = $ledgers->pluck('ledger_name')->toArray();
        }
        return $participants;
    }
}


function ip_info($ip = NULL, $purpose = "location", $deep_detect = TRUE)
{
    $output = NULL;
    if (filter_var($ip, FILTER_VALIDATE_IP) === FALSE) {
        $ip = $_SERVER["REMOTE_ADDR"];
        if ($deep_detect) {
            if (filter_var(@$_SERVER['HTTP_X_FORWARDED_FOR'], FILTER_VALIDATE_IP))
                $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
            if (filter_var(@$_SERVER['HTTP_CLIENT_IP'], FILTER_VALIDATE_IP))
                $ip = $_SERVER['HTTP_CLIENT_IP'];
        }
    }
    $purpose = str_replace(array("name", "\n", "\t", " ", "-", "_"), NULL, strtolower(trim($purpose)));
    $support = array("country", "countrycode", "state", "region", "city", "location", "address");
    $continents = array(
        "AF" => "Africa",
        "AN" => "Antarctica",
        "AS" => "Asia",
        "EU" => "Europe",
        "OC" => "Australia (Oceania)",
        "NA" => "North America",
        "SA" => "South America"
    );
    if (filter_var($ip, FILTER_VALIDATE_IP) && in_array($purpose, $support)) {
        $ipdat = @json_decode(file_get_contents("http://www.geoplugin.net/json.gp?ip=" . $ip));
        if (@strlen(trim($ipdat->geoplugin_countryCode)) == 2) {
            switch ($purpose) {
                case "location":
                    $output = array(
                        "city" => @$ipdat->geoplugin_city,
                        "state" => @$ipdat->geoplugin_regionName,
                        "country" => @$ipdat->geoplugin_countryName,
                        "country_code" => @$ipdat->geoplugin_countryCode,
                        "continent" => @$continents[strtoupper($ipdat->geoplugin_continentCode)],
                        "continent_code" => @$ipdat->geoplugin_continentCode
                    );
                    break;
                case "address":
                    $address = array($ipdat->geoplugin_countryName);
                    if (@strlen($ipdat->geoplugin_regionName) >= 1)
                        $address[] = $ipdat->geoplugin_regionName;
                    if (@strlen($ipdat->geoplugin_city) >= 1)
                        $address[] = $ipdat->geoplugin_city;
                    $output = implode(", ", array_reverse($address));
                    break;
                case "city":
                    $output = @$ipdat->geoplugin_city;
                    break;
                case "state":
                    $output = @$ipdat->geoplugin_regionName;
                    break;
                case "region":
                    $output = @$ipdat->geoplugin_regionName;
                    break;
                case "country":
                    $output = @$ipdat->geoplugin_countryName;
                    break;
                case "countrycode":
                    $output = @$ipdat->geoplugin_countryCode;
                    break;
            }
        }
    }
    return $output;
}

if (!function_exists('app_features')) {
    function app_features()
    {
        $features = [
            'invoice' => 'Invoice',
            'bill' => 'Purchase/Bill',
            'pos' => 'POS (Point Of Sale)',
            'estimate' => 'Estimate/Proforma',
            'products' => 'Products',
            'customer' => 'Customer',
            'vendor' => 'Vendor/Supplier',
            'purchase_order' => 'Purchase Order',
            'sales_return' => 'Sales Return',
            'purchase_return' => 'Purchase Return',
            'barcode' => 'Print Barcode',
            'category' => 'Category',
            'brand' => 'Brand',
            'stock_entry' => 'Stock Entry',
            'expense' => 'Expense Entry',
            'customer_advance' => 'Customer Advance Payment',
            'vendor_advance' => 'Vendor Advance Payment',
            'production' => 'Production',
            'inventory_adjustment' => 'Inventory Adjustment',
            'pay_bill' => 'Pay Bill',
            'receive_payment' => 'Receive Payment',
            'general_settings' => 'General Settings',
            'accounting' => 'Accounting Module',
            'user' => 'Users',
            'role' => 'Role',
            'reports' => 'All Reports',
        ];
        return $features;
    }
}

if (!function_exists('random_item')) {
    function random_item($items)
    {
        return $items[array_rand($items)];

    }
}
if (!function_exists('ability_class')) {
    function ability_class($ability)
    {
//        dd('test');
        if (auth()->user()->can($ability) || auth()->user()->is_admin) {
            return "";
        }

        return "protected";

    }
}
