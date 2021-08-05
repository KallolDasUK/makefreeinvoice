<?php

// @formatter:off
/**
 * A helper file for your Eloquent Models
 * Copy the phpDocs from this file to the correct Model,
 * And remove them from this file, to prevent double declarations.
 *
 * @author Barry vd. Heuvel <barryvdh@gmail.com>
 */


namespace App\Models{
/**
 * App\Models\AppMail
 *
 * @method static \Illuminate\Database\Eloquent\Builder|AppMail newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|AppMail newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|AppMail query()
 */
	class AppMail extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Bill
 *
 * @property int $id
 * @property int|null $vendor_id
 * @property string|null $bill_number
 * @property string|null $order_number
 * @property string|null $bill_date
 * @property string|null $due_date
 * @property string|null $sub_total
 * @property string|null $total
 * @property string|null $discount_type
 * @property string|null $discount_value
 * @property string|null $discount
 * @property string|null $shipping_charge
 * @property string|null $notes
 * @property string|null $bill_status
 * @property string|null $attachment
 * @property string|null $secret
 * @property int|null $user_id
 * @property int|null $client_id
 * @property string $currency
 * @property int|null $bill_payment_id
 * @property int|null $is_payment
 * @property string|null $payment_amount
 * @property int|null $payment_method_id
 * @property int|null $deposit_to
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\BillExtraField[] $bill_extra
 * @property-read int|null $bill_extra_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\BillItem[] $bill_items
 * @property-read int|null $bill_items_count
 * @property-read mixed $due
 * @property-read mixed $extra_fields
 * @property-read mixed $taxable_amount
 * @property-read mixed $taxes
 * @property-read \App\Models\Vendor|null $vendor
 * @method static \Illuminate\Database\Eloquent\Builder|Bill newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Bill newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Bill query()
 * @method static \Illuminate\Database\Eloquent\Builder|Bill whereAttachment($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Bill whereBillDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Bill whereBillNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Bill whereBillPaymentId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Bill whereBillStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Bill whereClientId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Bill whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Bill whereCurrency($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Bill whereDepositTo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Bill whereDiscount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Bill whereDiscountType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Bill whereDiscountValue($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Bill whereDueDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Bill whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Bill whereIsPayment($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Bill whereNotes($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Bill whereOrderNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Bill wherePaymentAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Bill wherePaymentMethodId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Bill whereSecret($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Bill whereShippingCharge($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Bill whereSubTotal($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Bill whereTotal($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Bill whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Bill whereUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Bill whereVendorId($value)
 */
	class Bill extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\BillExtraField
 *
 * @property int $id
 * @property string|null $bill_id
 * @property string|null $name
 * @property string|null $value
 * @property int|null $user_id
 * @property int|null $client_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|BillExtraField newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|BillExtraField newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|BillExtraField query()
 * @method static \Illuminate\Database\Eloquent\Builder|BillExtraField whereBillId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BillExtraField whereClientId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BillExtraField whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BillExtraField whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BillExtraField whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BillExtraField whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BillExtraField whereUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BillExtraField whereValue($value)
 */
	class BillExtraField extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\BillItem
 *
 * @property int $id
 * @property int $bill_id
 * @property int $product_id
 * @property string|null $description
 * @property string $qnt
 * @property string|null $unit
 * @property string $price
 * @property string $amount
 * @property int|null $tax_id
 * @property int|null $user_id
 * @property int|null $client_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Product $product
 * @method static \Illuminate\Database\Eloquent\Builder|BillItem newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|BillItem newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|BillItem query()
 * @method static \Illuminate\Database\Eloquent\Builder|BillItem whereAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BillItem whereBillId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BillItem whereClientId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BillItem whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BillItem whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BillItem whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BillItem wherePrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BillItem whereProductId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BillItem whereQnt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BillItem whereTaxId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BillItem whereUnit($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BillItem whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BillItem whereUserId($value)
 */
	class BillItem extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\BillPayment
 *
 * @property int $id
 * @property int|null $vendor_id
 * @property string|null $bill
 * @property string|null $payment_date
 * @property string|null $payment_sl
 * @property int|null $payment_method_id
 * @property string|null $ledger_id
 * @property string|null $note
 * @property int|null $user_id
 * @property int|null $client_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|BillPayment newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|BillPayment newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|BillPayment query()
 * @method static \Illuminate\Database\Eloquent\Builder|BillPayment whereBill($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BillPayment whereClientId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BillPayment whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BillPayment whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BillPayment whereLedgerId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BillPayment whereNote($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BillPayment wherePaymentDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BillPayment wherePaymentMethodId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BillPayment wherePaymentSl($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BillPayment whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BillPayment whereUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BillPayment whereVendorId($value)
 */
	class BillPayment extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\BillPaymentItem
 *
 * @property int $id
 * @property int|null $bill_payment_id
 * @property int|null $bill_id
 * @property string|null $amount
 * @property int|null $user_id
 * @property int|null $client_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|BillPaymentItem newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|BillPaymentItem newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|BillPaymentItem query()
 * @method static \Illuminate\Database\Eloquent\Builder|BillPaymentItem whereAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BillPaymentItem whereBillId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BillPaymentItem whereBillPaymentId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BillPaymentItem whereClientId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BillPaymentItem whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BillPaymentItem whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BillPaymentItem whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BillPaymentItem whereUserId($value)
 */
	class BillPaymentItem extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Blog
 *
 * @property int $id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $title
 * @property string|null $slug
 * @property string|null $body
 * @property int|null $user_id
 * @property int|null $client_id
 * @method static \Illuminate\Database\Eloquent\Builder|Blog newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Blog newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Blog query()
 * @method static \Illuminate\Database\Eloquent\Builder|Blog whereBody($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Blog whereClientId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Blog whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Blog whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Blog whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Blog whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Blog whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Blog whereUserId($value)
 */
	class Blog extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Category
 *
 * @property int $id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $name
 * @property int|null $category_id
 * @property int|null $user_id
 * @property int|null $client_id
 * @property-read Category|null $category
 * @method static \Illuminate\Database\Eloquent\Builder|Category newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Category newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Category query()
 * @method static \Illuminate\Database\Eloquent\Builder|Category whereCategoryId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Category whereClientId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Category whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Category whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Category whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Category whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Category whereUserId($value)
 */
	class Category extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Customer
 *
 * @property int $id
 * @property string|null $name
 * @property string|null $photo
 * @property string|null $company_name
 * @property string|null $phone
 * @property string|null $email
 * @property string|null $address
 * @property string|null $website
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $country
 * @property string|null $street_1
 * @property string|null $street_2
 * @property string|null $city
 * @property string|null $state
 * @property string|null $zip_post
 * @property int|null $user_id
 * @property int|null $client_id
 * @method static \Illuminate\Database\Eloquent\Builder|Customer newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Customer newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Customer query()
 * @method static \Illuminate\Database\Eloquent\Builder|Customer whereAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Customer whereCity($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Customer whereClientId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Customer whereCompanyName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Customer whereCountry($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Customer whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Customer whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Customer whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Customer whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Customer wherePhone($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Customer wherePhoto($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Customer whereState($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Customer whereStreet1($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Customer whereStreet2($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Customer whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Customer whereUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Customer whereWebsite($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Customer whereZipPost($value)
 */
	class Customer extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Estimate
 *
 * @property int $id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property int|null $customer_id
 * @property string|null $estimate_number
 * @property string|null $order_number
 * @property string|null $estimate_date
 * @property string|null $payment_terms
 * @property string|null $due_date
 * @property string|null $sub_total
 * @property string|null $total
 * @property string|null $discount_type
 * @property string|null $discount_value
 * @property string|null $discount
 * @property string|null $shipping_charge
 * @property string|null $terms_condition
 * @property string|null $notes
 * @property string|null $attachment
 * @property string $currency
 * @property string|null $shipping_date
 * @property string|null $secret
 * @property int|null $user_id
 * @property int|null $client_id
 * @property string|null $estimate_status
 * @property-read \App\Models\Customer|null $customer
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\EstimateExtraField[] $estimate_extra
 * @property-read int|null $estimate_extra_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\EstimateItem[] $estimate_items
 * @property-read int|null $estimate_items_count
 * @property-read mixed $extra_fields
 * @property-read mixed $taxable_amount
 * @property-read mixed $taxes
 * @method static \Illuminate\Database\Eloquent\Builder|Estimate newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Estimate newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Estimate query()
 * @method static \Illuminate\Database\Eloquent\Builder|Estimate whereAttachment($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Estimate whereClientId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Estimate whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Estimate whereCurrency($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Estimate whereCustomerId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Estimate whereDiscount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Estimate whereDiscountType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Estimate whereDiscountValue($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Estimate whereDueDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Estimate whereEstimateDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Estimate whereEstimateNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Estimate whereEstimateStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Estimate whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Estimate whereNotes($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Estimate whereOrderNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Estimate wherePaymentTerms($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Estimate whereSecret($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Estimate whereShippingCharge($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Estimate whereShippingDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Estimate whereSubTotal($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Estimate whereTermsCondition($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Estimate whereTotal($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Estimate whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Estimate whereUserId($value)
 */
	class Estimate extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\EstimateExtraField
 *
 * @property int $id
 * @property string|null $estimate_id
 * @property string|null $name
 * @property string|null $value
 * @property int|null $user_id
 * @property int|null $client_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|EstimateExtraField newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|EstimateExtraField newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|EstimateExtraField query()
 * @method static \Illuminate\Database\Eloquent\Builder|EstimateExtraField whereClientId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EstimateExtraField whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EstimateExtraField whereEstimateId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EstimateExtraField whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EstimateExtraField whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EstimateExtraField whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EstimateExtraField whereUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EstimateExtraField whereValue($value)
 */
	class EstimateExtraField extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\EstimateItem
 *
 * @property int $id
 * @property int $estimate_id
 * @property int $product_id
 * @property string|null $description
 * @property string $qnt
 * @property string|null $unit
 * @property string $price
 * @property string $amount
 * @property int|null $tax_id
 * @property int|null $user_id
 * @property int|null $client_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Product $product
 * @method static \Illuminate\Database\Eloquent\Builder|EstimateItem newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|EstimateItem newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|EstimateItem query()
 * @method static \Illuminate\Database\Eloquent\Builder|EstimateItem whereAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EstimateItem whereClientId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EstimateItem whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EstimateItem whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EstimateItem whereEstimateId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EstimateItem whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EstimateItem wherePrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EstimateItem whereProductId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EstimateItem whereQnt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EstimateItem whereTaxId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EstimateItem whereUnit($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EstimateItem whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EstimateItem whereUserId($value)
 */
	class EstimateItem extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Expense
 *
 * @property int $id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $date
 * @property int|null $ledger_id
 * @property int|null $vendor_id
 * @property int|null $customer_id
 * @property string|null $ref
 * @property int|null $is_billable
 * @property string|null $file
 * @property int|null $user_id
 * @property int|null $client_id
 * @property-read \App\Models\Customer|null $customer
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\ExpenseItem[] $expense_items
 * @property-read int|null $expense_items_count
 * @property-read mixed $amount
 * @property-read mixed $taxable_amount
 * @property-read mixed $taxes
 * @property-read \Enam\Acc\Models\Ledger|null $ledger
 * @property-read \App\Models\Vendor|null $vendor
 * @method static \Illuminate\Database\Eloquent\Builder|Expense newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Expense newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Expense query()
 * @method static \Illuminate\Database\Eloquent\Builder|Expense whereClientId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Expense whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Expense whereCustomerId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Expense whereDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Expense whereFile($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Expense whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Expense whereIsBillable($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Expense whereLedgerId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Expense whereRef($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Expense whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Expense whereUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Expense whereVendorId($value)
 */
	class Expense extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\ExpenseItem
 *
 * @property int $id
 * @property int $expense_id
 * @property int|null $ledger_id
 * @property string|null $notes
 * @property string|null $tax_id
 * @property string $amount
 * @property int|null $user_id
 * @property int|null $client_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Enam\Acc\Models\Ledger|null $ledger
 * @method static \Illuminate\Database\Eloquent\Builder|ExpenseItem newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ExpenseItem newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ExpenseItem query()
 * @method static \Illuminate\Database\Eloquent\Builder|ExpenseItem whereAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ExpenseItem whereClientId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ExpenseItem whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ExpenseItem whereExpenseId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ExpenseItem whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ExpenseItem whereLedgerId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ExpenseItem whereNotes($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ExpenseItem whereTaxId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ExpenseItem whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ExpenseItem whereUserId($value)
 */
	class ExpenseItem extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\ExtraField
 *
 * @property int $id
 * @property string|null $name
 * @property string|null $value
 * @property string|null $type
 * @property int|null $type_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property int|null $user_id
 * @property int|null $client_id
 * @method static \Illuminate\Database\Eloquent\Builder|ExtraField newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ExtraField newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ExtraField query()
 * @method static \Illuminate\Database\Eloquent\Builder|ExtraField whereClientId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ExtraField whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ExtraField whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ExtraField whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ExtraField whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ExtraField whereTypeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ExtraField whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ExtraField whereUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ExtraField whereValue($value)
 */
	class ExtraField extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Invoice
 *
 * @property int $id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property int|null $customer_id
 * @property string|null $invoice_number
 * @property string|null $order_number
 * @property string|null $invoice_date
 * @property string|null $payment_terms
 * @property string|null $due_date
 * @property string|null $sub_total
 * @property string|null $total
 * @property string|null $discount_type
 * @property string|null $discount_value
 * @property string|null $discount
 * @property string|null $shipping_charge
 * @property string|null $terms_condition
 * @property string|null $notes
 * @property string|null $attachment
 * @property string $currency
 * @property string|null $shipping_date
 * @property int $is_payment
 * @property string|null $payment_amount
 * @property int|null $payment_method_id
 * @property int|null $deposit_to
 * @property int|null $receive_payment_id
 * @property string $invoice_status
 * @property string|null $secret
 * @property int|null $user_id
 * @property int|null $client_id
 * @property-read \App\Models\Customer|null $customer
 * @property-read mixed $due
 * @property-read mixed $extra_fields
 * @property-read mixed $payment_status
 * @property-read mixed $taxable_amount
 * @property-read mixed $taxes
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\InvoiceExtraField[] $invoice_extra
 * @property-read int|null $invoice_extra_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\InvoiceItem[] $invoice_items
 * @property-read int|null $invoice_items_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\ReceivePaymentItem[] $payments
 * @property-read int|null $payments_count
 * @method static \Illuminate\Database\Eloquent\Builder|Invoice newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Invoice newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Invoice query()
 * @method static \Illuminate\Database\Eloquent\Builder|Invoice whereAttachment($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Invoice whereClientId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Invoice whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Invoice whereCurrency($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Invoice whereCustomerId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Invoice whereDepositTo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Invoice whereDiscount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Invoice whereDiscountType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Invoice whereDiscountValue($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Invoice whereDueDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Invoice whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Invoice whereInvoiceDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Invoice whereInvoiceNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Invoice whereInvoiceStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Invoice whereIsPayment($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Invoice whereNotes($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Invoice whereOrderNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Invoice wherePaymentAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Invoice wherePaymentMethodId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Invoice wherePaymentTerms($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Invoice whereReceivePaymentId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Invoice whereSecret($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Invoice whereShippingCharge($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Invoice whereShippingDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Invoice whereSubTotal($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Invoice whereTermsCondition($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Invoice whereTotal($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Invoice whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Invoice whereUserId($value)
 */
	class Invoice extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\InvoiceExtraField
 *
 * @property int $id
 * @property string|null $invoice_id
 * @property string|null $name
 * @property string|null $value
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property int|null $user_id
 * @property int|null $client_id
 * @method static \Illuminate\Database\Eloquent\Builder|InvoiceExtraField newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|InvoiceExtraField newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|InvoiceExtraField query()
 * @method static \Illuminate\Database\Eloquent\Builder|InvoiceExtraField whereClientId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|InvoiceExtraField whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|InvoiceExtraField whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|InvoiceExtraField whereInvoiceId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|InvoiceExtraField whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|InvoiceExtraField whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|InvoiceExtraField whereUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|InvoiceExtraField whereValue($value)
 */
	class InvoiceExtraField extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\InvoiceItem
 *
 * @property int $id
 * @property int $invoice_id
 * @property int $product_id
 * @property string|null $description
 * @property string $qnt
 * @property string|null $unit
 * @property string $price
 * @property string $amount
 * @property int|null $tax_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property int|null $user_id
 * @property int|null $client_id
 * @property-read \App\Models\Product $product
 * @method static \Illuminate\Database\Eloquent\Builder|InvoiceItem newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|InvoiceItem newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|InvoiceItem query()
 * @method static \Illuminate\Database\Eloquent\Builder|InvoiceItem whereAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|InvoiceItem whereClientId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|InvoiceItem whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|InvoiceItem whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|InvoiceItem whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|InvoiceItem whereInvoiceId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|InvoiceItem wherePrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|InvoiceItem whereProductId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|InvoiceItem whereQnt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|InvoiceItem whereTaxId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|InvoiceItem whereUnit($value)
 * @method static \Illuminate\Database\Eloquent\Builder|InvoiceItem whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|InvoiceItem whereUserId($value)
 */
	class InvoiceItem extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\MetaSetting
 *
 * @property int $id
 * @property string|null $key
 * @property string|null $value
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property int|null $user_id
 * @property int|null $client_id
 * @method static \Illuminate\Database\Eloquent\Builder|MetaSetting newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|MetaSetting newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|MetaSetting query()
 * @method static \Illuminate\Database\Eloquent\Builder|MetaSetting whereClientId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MetaSetting whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MetaSetting whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MetaSetting whereKey($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MetaSetting whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MetaSetting whereUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MetaSetting whereValue($value)
 */
	class MetaSetting extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\PaymentMethod
 *
 * @property int $id
 * @property string $name
 * @property string|null $description
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property int $is_default
 * @property int|null $user_id
 * @property int|null $client_id
 * @method static \Illuminate\Database\Eloquent\Builder|PaymentMethod newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|PaymentMethod newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|PaymentMethod query()
 * @method static \Illuminate\Database\Eloquent\Builder|PaymentMethod whereClientId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PaymentMethod whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PaymentMethod whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PaymentMethod whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PaymentMethod whereIsDefault($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PaymentMethod whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PaymentMethod whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PaymentMethod whereUserId($value)
 */
	class PaymentMethod extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Product
 *
 * @property int $id
 * @property string|null $product_type
 * @property string|null $name
 * @property string|null $sku
 * @property string|null $photo
 * @property int|null $category_id
 * @property string|null $sell_price
 * @property string|null $sell_unit
 * @property string|null $purchase_price
 * @property string|null $purchase_unit
 * @property string|null $description
 * @property int|null $is_track
 * @property string|null $opening_stock
 * @property string|null $opening_stock_price
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property int|null $user_id
 * @property int|null $client_id
 * @property-read \App\Models\Category|null $category
 * @method static \Illuminate\Database\Eloquent\Builder|Product newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Product newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Product query()
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereCategoryId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereClientId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereIsTrack($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereOpeningStock($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereOpeningStockPrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product wherePhoto($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereProductType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product wherePurchasePrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product wherePurchaseUnit($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereSellPrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereSellUnit($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereSku($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereUserId($value)
 */
	class Product extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\ReceivePayment
 *
 * @property int $id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property int|null $customer_id
 * @property string|null $invoice
 * @property string|null $payment_date
 * @property string|null $payment_sl
 * @property int|null $payment_method_id
 * @property string|null $deposit_to
 * @property string|null $note
 * @property int|null $user_id
 * @property int|null $client_id
 * @property-read \App\Models\Customer|null $customer
 * @property-read mixed $amount
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\ReceivePaymentItem[] $items
 * @property-read int|null $items_count
 * @property-read \App\Models\PaymentMethod|null $paymentMethod
 * @method static \Illuminate\Database\Eloquent\Builder|ReceivePayment newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ReceivePayment newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ReceivePayment query()
 * @method static \Illuminate\Database\Eloquent\Builder|ReceivePayment whereClientId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ReceivePayment whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ReceivePayment whereCustomerId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ReceivePayment whereDepositTo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ReceivePayment whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ReceivePayment whereInvoice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ReceivePayment whereNote($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ReceivePayment wherePaymentDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ReceivePayment wherePaymentMethodId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ReceivePayment wherePaymentSl($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ReceivePayment whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ReceivePayment whereUserId($value)
 */
	class ReceivePayment extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\ReceivePaymentItem
 *
 * @property int $id
 * @property int|null $receive_payment_id
 * @property int|null $invoice_id
 * @property string|null $amount
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property int|null $user_id
 * @property int|null $client_id
 * @property-read \App\Models\Estimate|null $invoice
 * @method static \Illuminate\Database\Eloquent\Builder|ReceivePaymentItem newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ReceivePaymentItem newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ReceivePaymentItem query()
 * @method static \Illuminate\Database\Eloquent\Builder|ReceivePaymentItem whereAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ReceivePaymentItem whereClientId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ReceivePaymentItem whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ReceivePaymentItem whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ReceivePaymentItem whereInvoiceId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ReceivePaymentItem whereReceivePaymentId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ReceivePaymentItem whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ReceivePaymentItem whereUserId($value)
 */
	class ReceivePaymentItem extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Tax
 *
 * @property int $id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $name
 * @property string|null $value
 * @property string|null $tax_type
 * @property int|null $user_id
 * @property int|null $client_id
 * @method static \Illuminate\Database\Eloquent\Builder|Tax newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Tax newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Tax query()
 * @method static \Illuminate\Database\Eloquent\Builder|Tax whereClientId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Tax whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Tax whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Tax whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Tax whereTaxType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Tax whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Tax whereUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Tax whereValue($value)
 */
	class Tax extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\User
 *
 * @property int $id
 * @property string $name
 * @property string $email
 * @property \Illuminate\Support\Carbon|null $email_verified_at
 * @property string $password
 * @property string|null $remember_token
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property int|null $client_id
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection|\Illuminate\Notifications\DatabaseNotification[] $notifications
 * @property-read int|null $notifications_count
 * @method static \Database\Factories\UserFactory factory(...$parameters)
 * @method static \Illuminate\Database\Eloquent\Builder|User newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|User newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|User query()
 * @method static \Illuminate\Database\Eloquent\Builder|User whereClientId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereEmailVerifiedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereRememberToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereUpdatedAt($value)
 */
	class User extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Vendor
 *
 * @property int $id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $name
 * @property string|null $photo
 * @property string|null $company_name
 * @property string|null $phone
 * @property string|null $email
 * @property string|null $country
 * @property string|null $street_1
 * @property string|null $street_2
 * @property string|null $city
 * @property string|null $state
 * @property string|null $zip_post
 * @property string|null $address
 * @property string|null $website
 * @property int|null $user_id
 * @property int|null $client_id
 * @method static \Illuminate\Database\Eloquent\Builder|Vendor newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Vendor newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Vendor query()
 * @method static \Illuminate\Database\Eloquent\Builder|Vendor whereAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Vendor whereCity($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Vendor whereClientId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Vendor whereCompanyName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Vendor whereCountry($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Vendor whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Vendor whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Vendor whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Vendor whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Vendor wherePhone($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Vendor wherePhoto($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Vendor whereState($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Vendor whereStreet1($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Vendor whereStreet2($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Vendor whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Vendor whereUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Vendor whereWebsite($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Vendor whereZipPost($value)
 */
	class Vendor extends \Eloquent {}
}

