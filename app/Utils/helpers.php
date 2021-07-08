<?php

use Enam\Acc\Models\TransactionDetail;
use Enam\Acc\Utils\EntryType;

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
}if (!function_exists('is_settings')) {
    function is_settings($url, $routeName)
    {
        if ($routeName == 'accounting.settings.edit') {
            return 'active';
        } else return '';


    }
}
