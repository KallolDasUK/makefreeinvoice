<?php


namespace App\Utils;


abstract class MyApp
{

    const CASH_IN_HAND = "Cash";
    const SALES = "Sales";
    const SUPP_PREFIX = "SUP-";
    const  HEAD = 'head';

    const LIABILITIES = "Liabilities";
    const CURRENT_LIABILITIES = "Current Liabilities";
    const PURCHASE = "Purchase";
    const PURCHASE_RETURN = "Purchase Return";
    const CREDIT = "Credit";
    const DEBIT = "Debit";
    const SERVICE_CHARGE = "Service Charge";
    const JOURNAL = "Journal";
    const KISTI_COLLECTION = "Kisti Collection";
    const DPS_KISTI_COLLECTION = "DPS Kisti Collection";
    const KISTI_PAID = "Kisti Paid";
    const DPS_KISTI_PAID = "DPS Kisti Paid";
    const FDR_PROFIT_RECEIVED = "FDR Profit Received";
    const FDR_PROFIT_PAID = "FDR Profit Paid";
    const FDR_DEPOSIT_RECEIVED = "FDR Deposit Received";
    const FDR_DEPOSIT_PAID = "FDR Deposit Paid";
    const FDR_PROFIT_BACK = "FDR Profit Back";
    const FDR_PROFIT_RETURN = "FDR Profit Return";
    const FDR_DEPOSIT = "FDR Deposit";
    const DPS_PROFIT_PAID = "DPS Profit Paid";
    const DPS_PROFIT_RECEIVED = "DPS Profit Received";
    const DPS_DEPOSIT_PAID = "DPS Deposit Paid";
    const DPS_DEPOSIT_RECEIVED = "DPS Deposit Received";
    const LOAN_FINE = "Loan Fine";
    const LOAN_FINE_RECEIVED = "Loan Fine Received";
    const LOAN_FINE_PAID = "Loan Fine Paid";
    const LOAN_DISCOUNT = "Loan Discount";
    const LOAN_DISCOUNT_PAID = "Loan Discount Paid";
    const LOAN_DISCOUNT_RECEIVED = "Loan Discount Received";
    const LOAN_DUE_RECEIVED = "Loan Due Received";
    const LOAN_DUE_PAID = "Loan Due Paid";
    const PAYMENT_FROM_DEPOSIT = "Payment From Deposit";
    const PAYMENT_FROM_DEPOSIT_RECEIVED = "Payment From Deposit Received";
    const PAYMENT_FROM_DEPOSIT_PAID = "Payment From Deposit Paid";
    const DEPOSIT_TO_LOAN_ADJUSTMENT = "Deposit To Loan Adjustment";
    const SAVINGS = "Savings";
    const DEPOSIT = "Deposit";
    const WITHDRAW = "Withdraw";
    const SAVINGS_FROM_KISTI = "Savings From Kisti";
    const FORM_SALES = "Form Sales";
    const MEMBER = "member";
    const COMPANY = "company";
    const LOAN_IN_MARKET = "Loan In Market";
    const GOT_LOAN = "Got Loan";
    const Insurance = "Insurance";
    const LOAN_INSURANCE = "Loan Insurance";
    const DPS = "DPS";
    const FDR = "FDR";
    const ACCOUNTS_PAYABLE = "Accounts Payable";
    const ACCOUNTS_RECEIVABLE = "Accounts Receivable";
    const MEMBER_LOAN = "Member Loan";
    const REVENUE = "Revenue";
    const LOAN_INTEREST = "Loan Interest";
    const DPS_INTEREST = "DPS Interest";
    const FDR_INTEREST = "FDR Interest";
    const LOAN_FORM = "Loan Form Fees";
    const BANK = "Bank";


    /* SUB HEADS */
    const INTEREST = "Interest";


    public static $bn = array("১", "২", "৩", "৪", "৫", "৬", "৭", "৮", "৯", "০");
    public static $en = array("1", "2", "3", "4", "5", "6", "7", "8", "9", "0");

    public static function bn2en($number)
    {
        return str_replace(self::$bn, self::$en, $number);
    }

    public static function redundantColumn()
    {
        return ['created_at', 'updated_at', 'user_id', 'client_id'];
    }

    public static function ignorableWhileShowing()
    {
        return ['id', 'member_id', 'created_at', 'updated_at', 'user_id', 'client_id'];
    }

    public static function en2bn($number)
    {
        return str_replace(self::$en, self::$bn, $number);
    }
}
