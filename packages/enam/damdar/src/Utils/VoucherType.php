<?php

namespace Enam\Acc\Utils;
abstract class VoucherType
{
    public static $RECEIVE = "Receive";
    public static $PAYMENT = "Payment";
    public static $JOURNAL = "Journal";
    public static $CONTRA = "Contra";
    public static $CUSTOMER_PAYMENT = "Customer Payment";
    public static $VENDOR_PAYMENT = "Vendor Payment";

}
