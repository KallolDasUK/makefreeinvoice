<?php


namespace Enam\Acc\Utils;


abstract class MyApp
{

    const CASH_IN_HAND = "Cash";
    const CREDIT = "Credit";
    const DEBIT = "Debit";
    const JOURNAL = "Journal";
    const KISTI_COLLECTION = "Kisti Collection";
    const KISTI_PAID = "Kisti Paid";
    const SAVINGS = "Savings";
    const DEPOSIT = "Deposit";
    const WITHDRAW = "Withdraw";
    const SAVINGS_FROM_KISTI = "Savings From Kisti";
    const FORM_SALES = "Form Sales";
    const MEMBER = "member";
    const COMPANY = "company";
    const LOAN_IN_MARKET = "Loan In Market";
    const GOT_LOAN = "Got Loan";
    public static $bn = array("১", "২", "৩", "৪", "৫", "৬", "৭", "৮", "৯", "০");
    public static $en = array("1", "2", "3", "4", "5", "6", "7", "8", "9", "0");

    public static function bn2en($number)
    {
        return str_replace(self::$bn, self::$en, $number);
    }

    public static function en2bn($number)
    {
        return str_replace(self::$en, self::$bn, $number);
    }
}
