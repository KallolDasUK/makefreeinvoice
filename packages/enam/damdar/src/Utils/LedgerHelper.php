<?php

namespace Enam\Acc\Utils;

abstract class LedgerHelper
{
    /* Assets */
    public static $CurrentAsset = "Current Asset";
    public static $CASH_IN_HAND = "Cash In Hand";
    public static $CASH = "Cash";
    public static $BANK_ACCOUNTS = "Bank Accounts";
    public static $ACCOUNTS_RECEIVABLE = "Accounts Receivable";
    public static $ACCOUNTS_RECEIVABLE_GROUP = "Accounts Receivable Group";
    public static $STOCK_IN_HAND = "Stock In Hand";
    public static $FixedAsset = "Fixed Asset";


    /* Liabilities */
    public static $CAPITAL_ACCOUNTS = "Capital Accounts";
    public static $LOAN_AND_LIABILITIES = "Loan & Liabilities";
    public static $CURRENT_LIABILITIES = "Current Liabilities";
    public static $ACCOUNTS_PAYABLE = "Accounts Payable";
    public static $ACCOUNTS_PAYABLE_GROUP = "Accounts Payable Group";
    public static $DUTIES_AND_TAXES = "Duties and Taxes";

    /* Income */
    public static $DIRECT_INCOME = "Direct Income";
    public static $INDIRECT_INCOME = "Indirect Income";
    public static $SALES_ACCOUNT = "Sales Account";

    /* Expense */
    public static $DIRECT_EXPENSE = "Direct Expense";
    public static $INDIRECT_EXPENSE = "Indirect Expense";
    public static $PURCHASE_ACCOUNT = "Purchase Account";
    public static $SALARY_ACCOUNT = "Salary Account";


    /* Ledger */

    public static $PURCHASE_AC = "Purchase A/C";
    public static $PURCHASE_EXPENSE_AC = "Purchase Expense A/C";
    public static $SALES_AC = "Sales A/C";
    public static $CASH_AC = "Cash A/C";

    public static $INVENTORY_AC = "Inventory A/C";
    public static $SALARY_AC = "Salary A/C";
    public static $SERVICE_REVENUE_AC = "Service Revenue A/C";

    public static $COST_OF_GOODS_SOLD = "Cost of Goods Sold";
    public static $ADVANCE_TAX = "Advance Tax";
    public static $TAX_PAYABLE = "Tax Payable";
    public static $OTHER_CHARGES = "Other Charges";


}
