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
 * @mixin \Eloquent
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
 * @property string $payment_status
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\BillExtraField[] $bill_extra
 * @property-read int|null $bill_extra_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\BillItem[] $bill_items
 * @property-read int|null $bill_items_count
 * @property-read mixed $age
 * @property-read mixed $charges
 * @property-read mixed $due
 * @property-read mixed $extra_fields
 * @property-read mixed $paid
 * @property-read mixed $payment
 * @property-read mixed $payment_status_text
 * @property-read mixed $taxable_amount
 * @property-read mixed $taxes
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\BillPaymentItem[] $payments
 * @property-read int|null $payments_count
 * @property-read \App\Models\Vendor|null $vendor
 * @method static Builder|Bill newModelQuery()
 * @method static Builder|Bill newQuery()
 * @method static Builder|Bill query()
 * @method static Builder|Bill whereAttachment($value)
 * @method static Builder|Bill whereBillDate($value)
 * @method static Builder|Bill whereBillNumber($value)
 * @method static Builder|Bill whereBillPaymentId($value)
 * @method static Builder|Bill whereBillStatus($value)
 * @method static Builder|Bill whereClientId($value)
 * @method static Builder|Bill whereCreatedAt($value)
 * @method static Builder|Bill whereCurrency($value)
 * @method static Builder|Bill whereDepositTo($value)
 * @method static Builder|Bill whereDiscount($value)
 * @method static Builder|Bill whereDiscountType($value)
 * @method static Builder|Bill whereDiscountValue($value)
 * @method static Builder|Bill whereDueDate($value)
 * @method static Builder|Bill whereId($value)
 * @method static Builder|Bill whereIsPayment($value)
 * @method static Builder|Bill whereNotes($value)
 * @method static Builder|Bill whereOrderNumber($value)
 * @method static Builder|Bill wherePaymentAmount($value)
 * @method static Builder|Bill wherePaymentMethodId($value)
 * @method static Builder|Bill wherePaymentStatus($value)
 * @method static Builder|Bill whereSecret($value)
 * @method static Builder|Bill whereShippingCharge($value)
 * @method static Builder|Bill whereSubTotal($value)
 * @method static Builder|Bill whereTotal($value)
 * @method static Builder|Bill whereUpdatedAt($value)
 * @method static Builder|Bill whereUserId($value)
 * @method static Builder|Bill whereVendorId($value)
 * @mixin \Eloquent
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
 * @method static Builder|BillExtraField newModelQuery()
 * @method static Builder|BillExtraField newQuery()
 * @method static Builder|BillExtraField query()
 * @method static Builder|BillExtraField whereBillId($value)
 * @method static Builder|BillExtraField whereClientId($value)
 * @method static Builder|BillExtraField whereCreatedAt($value)
 * @method static Builder|BillExtraField whereId($value)
 * @method static Builder|BillExtraField whereName($value)
 * @method static Builder|BillExtraField whereUpdatedAt($value)
 * @method static Builder|BillExtraField whereUserId($value)
 * @method static Builder|BillExtraField whereValue($value)
 * @mixin \Eloquent
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
 * @property string|null $date
 * @property-read \App\Models\Bill $bill
 * @property-read mixed $tax_amount
 * @property-read \App\Models\Product $product
 * @method static Builder|BillItem newModelQuery()
 * @method static Builder|BillItem newQuery()
 * @method static Builder|BillItem query()
 * @method static Builder|BillItem whereAmount($value)
 * @method static Builder|BillItem whereBillId($value)
 * @method static Builder|BillItem whereClientId($value)
 * @method static Builder|BillItem whereCreatedAt($value)
 * @method static Builder|BillItem whereDate($value)
 * @method static Builder|BillItem whereDescription($value)
 * @method static Builder|BillItem whereId($value)
 * @method static Builder|BillItem wherePrice($value)
 * @method static Builder|BillItem whereProductId($value)
 * @method static Builder|BillItem whereQnt($value)
 * @method static Builder|BillItem whereTaxId($value)
 * @method static Builder|BillItem whereUnit($value)
 * @method static Builder|BillItem whereUpdatedAt($value)
 * @method static Builder|BillItem whereUserId($value)
 * @mixin \Eloquent
 */
	class BillItem extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\BillPayment
 *
 * @property int $id
 * @property int|null $vendor_id
 * @property string|null $bill_id
 * @property string|null $payment_date
 * @property string|null $payment_sl
 * @property int|null $payment_method_id
 * @property string|null $ledger_id
 * @property string|null $note
 * @property int|null $user_id
 * @property int|null $client_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Bill|null $bill
 * @property-read mixed $amount
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\BillPaymentItem[] $items
 * @property-read int|null $items_count
 * @property-read Ledger|null $ledger
 * @property-read \App\Models\PaymentMethod|null $paymentMethod
 * @property-read \App\Models\Vendor|null $vendor
 * @method static Builder|BillPayment newModelQuery()
 * @method static Builder|BillPayment newQuery()
 * @method static Builder|BillPayment query()
 * @method static Builder|BillPayment whereBillId($value)
 * @method static Builder|BillPayment whereClientId($value)
 * @method static Builder|BillPayment whereCreatedAt($value)
 * @method static Builder|BillPayment whereId($value)
 * @method static Builder|BillPayment whereLedgerId($value)
 * @method static Builder|BillPayment whereNote($value)
 * @method static Builder|BillPayment wherePaymentDate($value)
 * @method static Builder|BillPayment wherePaymentMethodId($value)
 * @method static Builder|BillPayment wherePaymentSl($value)
 * @method static Builder|BillPayment whereUpdatedAt($value)
 * @method static Builder|BillPayment whereUserId($value)
 * @method static Builder|BillPayment whereVendorId($value)
 * @mixin \Eloquent
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
 * @property-read \App\Models\Bill|null $bill
 * @property-read \App\Models\BillPayment|null $bill_payment
 * @method static Builder|BillPaymentItem newModelQuery()
 * @method static Builder|BillPaymentItem newQuery()
 * @method static Builder|BillPaymentItem query()
 * @method static Builder|BillPaymentItem whereAmount($value)
 * @method static Builder|BillPaymentItem whereBillId($value)
 * @method static Builder|BillPaymentItem whereBillPaymentId($value)
 * @method static Builder|BillPaymentItem whereClientId($value)
 * @method static Builder|BillPaymentItem whereCreatedAt($value)
 * @method static Builder|BillPaymentItem whereId($value)
 * @method static Builder|BillPaymentItem whereUpdatedAt($value)
 * @method static Builder|BillPaymentItem whereUserId($value)
 * @mixin \Eloquent
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
 * @property string $tags
 * @property string|null $meta
 * @property-read mixed $blog_tag_names
 * @property-read mixed $blog_tags
 * @method static \Illuminate\Database\Eloquent\Builder|Blog newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Blog newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Blog query()
 * @method static \Illuminate\Database\Eloquent\Builder|Blog whereBody($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Blog whereClientId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Blog whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Blog whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Blog whereMeta($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Blog whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Blog whereTags($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Blog whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Blog whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Blog whereUserId($value)
 * @mixin \Eloquent
 */
	class Blog extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\BlogTag
 *
 * @property int $id
 * @property string|null $name
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|BlogTag newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|BlogTag newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|BlogTag query()
 * @method static \Illuminate\Database\Eloquent\Builder|BlogTag whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BlogTag whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BlogTag whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BlogTag whereUpdatedAt($value)
 * @mixin \Eloquent
 */
	class BlogTag extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Brand
 *
 * @property int $id
 * @property string|null $name
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property int|null $user_id
 * @property int|null $client_id
 * @method static Builder|Brand newModelQuery()
 * @method static Builder|Brand newQuery()
 * @method static Builder|Brand query()
 * @method static Builder|Brand whereClientId($value)
 * @method static Builder|Brand whereCreatedAt($value)
 * @method static Builder|Brand whereId($value)
 * @method static Builder|Brand whereName($value)
 * @method static Builder|Brand whereUpdatedAt($value)
 * @method static Builder|Brand whereUserId($value)
 * @mixin \Eloquent
 */
	class Brand extends \Eloquent {}
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
 * @method static Builder|Category newModelQuery()
 * @method static Builder|Category newQuery()
 * @method static Builder|Category query()
 * @method static Builder|Category whereCategoryId($value)
 * @method static Builder|Category whereClientId($value)
 * @method static Builder|Category whereCreatedAt($value)
 * @method static Builder|Category whereId($value)
 * @method static Builder|Category whereName($value)
 * @method static Builder|Category whereUpdatedAt($value)
 * @method static Builder|Category whereUserId($value)
 * @mixin \Eloquent
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
 * @property string|null $opening
 * @property string|null $opening_type
 * @property-read mixed $previous_due
 * @property-read mixed $receivables
 * @method static Builder|Customer newModelQuery()
 * @method static Builder|Customer newQuery()
 * @method static Builder|Customer query()
 * @method static Builder|Customer whereAddress($value)
 * @method static Builder|Customer whereCity($value)
 * @method static Builder|Customer whereClientId($value)
 * @method static Builder|Customer whereCompanyName($value)
 * @method static Builder|Customer whereCountry($value)
 * @method static Builder|Customer whereCreatedAt($value)
 * @method static Builder|Customer whereEmail($value)
 * @method static Builder|Customer whereId($value)
 * @method static Builder|Customer whereName($value)
 * @method static Builder|Customer whereOpening($value)
 * @method static Builder|Customer whereOpeningType($value)
 * @method static Builder|Customer wherePhone($value)
 * @method static Builder|Customer wherePhoto($value)
 * @method static Builder|Customer whereState($value)
 * @method static Builder|Customer whereStreet1($value)
 * @method static Builder|Customer whereStreet2($value)
 * @method static Builder|Customer whereUpdatedAt($value)
 * @method static Builder|Customer whereUserId($value)
 * @method static Builder|Customer whereWebsite($value)
 * @method static Builder|Customer whereZipPost($value)
 * @mixin \Eloquent
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
 * @method static Builder|Estimate newModelQuery()
 * @method static Builder|Estimate newQuery()
 * @method static Builder|Estimate query()
 * @method static Builder|Estimate whereAttachment($value)
 * @method static Builder|Estimate whereClientId($value)
 * @method static Builder|Estimate whereCreatedAt($value)
 * @method static Builder|Estimate whereCurrency($value)
 * @method static Builder|Estimate whereCustomerId($value)
 * @method static Builder|Estimate whereDiscount($value)
 * @method static Builder|Estimate whereDiscountType($value)
 * @method static Builder|Estimate whereDiscountValue($value)
 * @method static Builder|Estimate whereDueDate($value)
 * @method static Builder|Estimate whereEstimateDate($value)
 * @method static Builder|Estimate whereEstimateNumber($value)
 * @method static Builder|Estimate whereEstimateStatus($value)
 * @method static Builder|Estimate whereId($value)
 * @method static Builder|Estimate whereNotes($value)
 * @method static Builder|Estimate whereOrderNumber($value)
 * @method static Builder|Estimate wherePaymentTerms($value)
 * @method static Builder|Estimate whereSecret($value)
 * @method static Builder|Estimate whereShippingCharge($value)
 * @method static Builder|Estimate whereShippingDate($value)
 * @method static Builder|Estimate whereSubTotal($value)
 * @method static Builder|Estimate whereTermsCondition($value)
 * @method static Builder|Estimate whereTotal($value)
 * @method static Builder|Estimate whereUpdatedAt($value)
 * @method static Builder|Estimate whereUserId($value)
 * @mixin \Eloquent
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
 * @method static Builder|EstimateExtraField newModelQuery()
 * @method static Builder|EstimateExtraField newQuery()
 * @method static Builder|EstimateExtraField query()
 * @method static Builder|EstimateExtraField whereClientId($value)
 * @method static Builder|EstimateExtraField whereCreatedAt($value)
 * @method static Builder|EstimateExtraField whereEstimateId($value)
 * @method static Builder|EstimateExtraField whereId($value)
 * @method static Builder|EstimateExtraField whereName($value)
 * @method static Builder|EstimateExtraField whereUpdatedAt($value)
 * @method static Builder|EstimateExtraField whereUserId($value)
 * @method static Builder|EstimateExtraField whereValue($value)
 * @mixin \Eloquent
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
 * @property string|null $date
 * @property-read \App\Models\Estimate $estimate
 * @property-read \App\Models\Product $product
 * @method static Builder|EstimateItem newModelQuery()
 * @method static Builder|EstimateItem newQuery()
 * @method static Builder|EstimateItem query()
 * @method static Builder|EstimateItem whereAmount($value)
 * @method static Builder|EstimateItem whereClientId($value)
 * @method static Builder|EstimateItem whereCreatedAt($value)
 * @method static Builder|EstimateItem whereDate($value)
 * @method static Builder|EstimateItem whereDescription($value)
 * @method static Builder|EstimateItem whereEstimateId($value)
 * @method static Builder|EstimateItem whereId($value)
 * @method static Builder|EstimateItem wherePrice($value)
 * @method static Builder|EstimateItem whereProductId($value)
 * @method static Builder|EstimateItem whereQnt($value)
 * @method static Builder|EstimateItem whereTaxId($value)
 * @method static Builder|EstimateItem whereUnit($value)
 * @method static Builder|EstimateItem whereUpdatedAt($value)
 * @method static Builder|EstimateItem whereUserId($value)
 * @mixin \Eloquent
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
 * @property-read Ledger|null $ledger
 * @property-read \App\Models\Vendor|null $vendor
 * @method static Builder|Expense newModelQuery()
 * @method static Builder|Expense newQuery()
 * @method static Builder|Expense query()
 * @method static Builder|Expense whereClientId($value)
 * @method static Builder|Expense whereCreatedAt($value)
 * @method static Builder|Expense whereCustomerId($value)
 * @method static Builder|Expense whereDate($value)
 * @method static Builder|Expense whereFile($value)
 * @method static Builder|Expense whereId($value)
 * @method static Builder|Expense whereIsBillable($value)
 * @method static Builder|Expense whereLedgerId($value)
 * @method static Builder|Expense whereRef($value)
 * @method static Builder|Expense whereUpdatedAt($value)
 * @method static Builder|Expense whereUserId($value)
 * @method static Builder|Expense whereVendorId($value)
 * @mixin \Eloquent
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
 * @property string|null $date
 * @property-read \App\Models\Expense $expense
 * @property-read mixed $tax_amount
 * @property-read Ledger|null $ledger
 * @method static \Illuminate\Database\Eloquent\Builder|ExpenseItem newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ExpenseItem newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ExpenseItem query()
 * @method static \Illuminate\Database\Eloquent\Builder|ExpenseItem whereAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ExpenseItem whereClientId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ExpenseItem whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ExpenseItem whereDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ExpenseItem whereExpenseId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ExpenseItem whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ExpenseItem whereLedgerId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ExpenseItem whereNotes($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ExpenseItem whereTaxId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ExpenseItem whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ExpenseItem whereUserId($value)
 * @mixin \Eloquent
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
 * @method static Builder|ExtraField newModelQuery()
 * @method static Builder|ExtraField newQuery()
 * @method static Builder|ExtraField query()
 * @method static Builder|ExtraField whereClientId($value)
 * @method static Builder|ExtraField whereCreatedAt($value)
 * @method static Builder|ExtraField whereId($value)
 * @method static Builder|ExtraField whereName($value)
 * @method static Builder|ExtraField whereType($value)
 * @method static Builder|ExtraField whereTypeId($value)
 * @method static Builder|ExtraField whereUpdatedAt($value)
 * @method static Builder|ExtraField whereUserId($value)
 * @method static Builder|ExtraField whereValue($value)
 * @mixin \Eloquent
 */
	class ExtraField extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\GlobalSetting
 *
 * @property int $id
 * @property string|null $key
 * @property string|null $value
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|GlobalSetting newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|GlobalSetting newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|GlobalSetting query()
 * @method static \Illuminate\Database\Eloquent\Builder|GlobalSetting whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|GlobalSetting whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|GlobalSetting whereKey($value)
 * @method static \Illuminate\Database\Eloquent\Builder|GlobalSetting whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|GlobalSetting whereValue($value)
 * @mixin \Eloquent
 */
	class GlobalSetting extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\InventoryAdjustment
 *
 * @property int $id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $date
 * @property string|null $ref
 * @property int|null $ledger_id
 * @property int|null $reason_id
 * @property string|null $description
 * @property int|null $user_id
 * @property int|null $client_id
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\InventoryAdjustmentItem[] $inventory_adjustment_items
 * @property-read int|null $inventory_adjustment_items_count
 * @property-read Ledger|null $ledger
 * @property-read \App\Models\Reason|null $reason
 * @method static Builder|InventoryAdjustment newModelQuery()
 * @method static Builder|InventoryAdjustment newQuery()
 * @method static Builder|InventoryAdjustment query()
 * @method static Builder|InventoryAdjustment whereClientId($value)
 * @method static Builder|InventoryAdjustment whereCreatedAt($value)
 * @method static Builder|InventoryAdjustment whereDate($value)
 * @method static Builder|InventoryAdjustment whereDescription($value)
 * @method static Builder|InventoryAdjustment whereId($value)
 * @method static Builder|InventoryAdjustment whereLedgerId($value)
 * @method static Builder|InventoryAdjustment whereReasonId($value)
 * @method static Builder|InventoryAdjustment whereRef($value)
 * @method static Builder|InventoryAdjustment whereUpdatedAt($value)
 * @method static Builder|InventoryAdjustment whereUserId($value)
 * @mixin \Eloquent
 */
	class InventoryAdjustment extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\InventoryAdjustmentItem
 *
 * @property int $id
 * @property int $inventory_adjustment_id
 * @property int $product_id
 * @property string $sub_qnt
 * @property string $add_qnt
 * @property string|null $type
 * @property int|null $user_id
 * @property int|null $client_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property int|null $reason_id
 * @property string|null $date
 * @property-read \App\Models\InventoryAdjustment $inventory_adjustment
 * @property-read \App\Models\Product $product
 * @property-read \App\Models\Reason|null $reason
 * @method static \Illuminate\Database\Eloquent\Builder|InventoryAdjustmentItem newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|InventoryAdjustmentItem newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|InventoryAdjustmentItem query()
 * @method static \Illuminate\Database\Eloquent\Builder|InventoryAdjustmentItem whereAddQnt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|InventoryAdjustmentItem whereClientId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|InventoryAdjustmentItem whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|InventoryAdjustmentItem whereDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|InventoryAdjustmentItem whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|InventoryAdjustmentItem whereInventoryAdjustmentId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|InventoryAdjustmentItem whereProductId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|InventoryAdjustmentItem whereReasonId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|InventoryAdjustmentItem whereSubQnt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|InventoryAdjustmentItem whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|InventoryAdjustmentItem whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|InventoryAdjustmentItem whereUserId($value)
 * @mixin \Eloquent
 */
	class InventoryAdjustmentItem extends \Eloquent {}
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
 * @property string $payment_status
 * @property int|null $sr_id
 * @property-read \App\Models\Customer|null $customer
 * @property-read mixed $age
 * @property-read mixed $charges
 * @property-read mixed $due
 * @property-read mixed $extra_fields
 * @property-read mixed $payment
 * @property-read mixed $payment_status_text
 * @property-read mixed $taxable_amount
 * @property-read mixed $taxes
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\InvoiceExtraField[] $invoice_extra
 * @property-read int|null $invoice_extra_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\InvoiceItem[] $invoice_items
 * @property-read int|null $invoice_items_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\ReceivePaymentItem[] $payments
 * @property-read int|null $payments_count
 * @property-read \App\Models\SR|null $sr
 * @method static Builder|Invoice newModelQuery()
 * @method static Builder|Invoice newQuery()
 * @method static Builder|Invoice query()
 * @method static Builder|Invoice whereAttachment($value)
 * @method static Builder|Invoice whereClientId($value)
 * @method static Builder|Invoice whereCreatedAt($value)
 * @method static Builder|Invoice whereCurrency($value)
 * @method static Builder|Invoice whereCustomerId($value)
 * @method static Builder|Invoice whereDepositTo($value)
 * @method static Builder|Invoice whereDiscount($value)
 * @method static Builder|Invoice whereDiscountType($value)
 * @method static Builder|Invoice whereDiscountValue($value)
 * @method static Builder|Invoice whereDueDate($value)
 * @method static Builder|Invoice whereId($value)
 * @method static Builder|Invoice whereInvoiceDate($value)
 * @method static Builder|Invoice whereInvoiceNumber($value)
 * @method static Builder|Invoice whereInvoiceStatus($value)
 * @method static Builder|Invoice whereIsPayment($value)
 * @method static Builder|Invoice whereNotes($value)
 * @method static Builder|Invoice whereOrderNumber($value)
 * @method static Builder|Invoice wherePaymentAmount($value)
 * @method static Builder|Invoice wherePaymentMethodId($value)
 * @method static Builder|Invoice wherePaymentStatus($value)
 * @method static Builder|Invoice wherePaymentTerms($value)
 * @method static Builder|Invoice whereReceivePaymentId($value)
 * @method static Builder|Invoice whereSecret($value)
 * @method static Builder|Invoice whereShippingCharge($value)
 * @method static Builder|Invoice whereShippingDate($value)
 * @method static Builder|Invoice whereSrId($value)
 * @method static Builder|Invoice whereSubTotal($value)
 * @method static Builder|Invoice whereTermsCondition($value)
 * @method static Builder|Invoice whereTotal($value)
 * @method static Builder|Invoice whereUpdatedAt($value)
 * @method static Builder|Invoice whereUserId($value)
 * @mixin \Eloquent
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
 * @method static Builder|InvoiceExtraField newModelQuery()
 * @method static Builder|InvoiceExtraField newQuery()
 * @method static Builder|InvoiceExtraField query()
 * @method static Builder|InvoiceExtraField whereClientId($value)
 * @method static Builder|InvoiceExtraField whereCreatedAt($value)
 * @method static Builder|InvoiceExtraField whereId($value)
 * @method static Builder|InvoiceExtraField whereInvoiceId($value)
 * @method static Builder|InvoiceExtraField whereName($value)
 * @method static Builder|InvoiceExtraField whereUpdatedAt($value)
 * @method static Builder|InvoiceExtraField whereUserId($value)
 * @method static Builder|InvoiceExtraField whereValue($value)
 * @mixin \Eloquent
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
 * @property string|null $date
 * @property-read mixed $tax_amount
 * @property-read \App\Models\Invoice $invoice
 * @property-read \App\Models\Product $product
 * @method static Builder|InvoiceItem newModelQuery()
 * @method static Builder|InvoiceItem newQuery()
 * @method static Builder|InvoiceItem query()
 * @method static Builder|InvoiceItem whereAmount($value)
 * @method static Builder|InvoiceItem whereClientId($value)
 * @method static Builder|InvoiceItem whereCreatedAt($value)
 * @method static Builder|InvoiceItem whereDate($value)
 * @method static Builder|InvoiceItem whereDescription($value)
 * @method static Builder|InvoiceItem whereId($value)
 * @method static Builder|InvoiceItem whereInvoiceId($value)
 * @method static Builder|InvoiceItem wherePrice($value)
 * @method static Builder|InvoiceItem whereProductId($value)
 * @method static Builder|InvoiceItem whereQnt($value)
 * @method static Builder|InvoiceItem whereTaxId($value)
 * @method static Builder|InvoiceItem whereUnit($value)
 * @method static Builder|InvoiceItem whereUpdatedAt($value)
 * @method static Builder|InvoiceItem whereUserId($value)
 * @mixin \Eloquent
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
 * @method static Builder|MetaSetting newModelQuery()
 * @method static Builder|MetaSetting newQuery()
 * @method static Builder|MetaSetting query()
 * @method static Builder|MetaSetting whereClientId($value)
 * @method static Builder|MetaSetting whereCreatedAt($value)
 * @method static Builder|MetaSetting whereId($value)
 * @method static Builder|MetaSetting whereKey($value)
 * @method static Builder|MetaSetting whereUpdatedAt($value)
 * @method static Builder|MetaSetting whereUserId($value)
 * @method static Builder|MetaSetting whereValue($value)
 * @mixin \Eloquent
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
 * @method static Builder|PaymentMethod newModelQuery()
 * @method static Builder|PaymentMethod newQuery()
 * @method static Builder|PaymentMethod query()
 * @method static Builder|PaymentMethod whereClientId($value)
 * @method static Builder|PaymentMethod whereCreatedAt($value)
 * @method static Builder|PaymentMethod whereDescription($value)
 * @method static Builder|PaymentMethod whereId($value)
 * @method static Builder|PaymentMethod whereIsDefault($value)
 * @method static Builder|PaymentMethod whereName($value)
 * @method static Builder|PaymentMethod whereUpdatedAt($value)
 * @method static Builder|PaymentMethod whereUserId($value)
 * @mixin \Eloquent
 */
	class PaymentMethod extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\PosCharge
 *
 * @property int $id
 * @property int $pos_sales_id
 * @property string|null $key
 * @property string|null $value
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $amount
 * @property int|null $user_id
 * @property int|null $client_id
 * @property-read \App\Models\PosSale $pos_sale
 * @method static \Illuminate\Database\Eloquent\Builder|PosCharge newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|PosCharge newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|PosCharge query()
 * @method static \Illuminate\Database\Eloquent\Builder|PosCharge whereAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PosCharge whereClientId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PosCharge whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PosCharge whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PosCharge whereKey($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PosCharge wherePosSalesId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PosCharge whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PosCharge whereUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PosCharge whereValue($value)
 * @mixin \Eloquent
 */
	class PosCharge extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\PosItem
 *
 * @property int $id
 * @property int $pos_sales_id
 * @property int $product_id
 * @property string|null $price
 * @property string|null $qnt
 * @property string|null $amount
 * @property int|null $tax_id
 * @property int|null $attribute_id
 * @property string|null $date
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property int|null $user_id
 * @property int|null $client_id
 * @property-read \App\Models\PosSale $pos_sale
 * @property-read \App\Models\Product $product
 * @method static Builder|PosItem newModelQuery()
 * @method static Builder|PosItem newQuery()
 * @method static Builder|PosItem query()
 * @method static Builder|PosItem whereAmount($value)
 * @method static Builder|PosItem whereAttributeId($value)
 * @method static Builder|PosItem whereClientId($value)
 * @method static Builder|PosItem whereCreatedAt($value)
 * @method static Builder|PosItem whereDate($value)
 * @method static Builder|PosItem whereId($value)
 * @method static Builder|PosItem wherePosSalesId($value)
 * @method static Builder|PosItem wherePrice($value)
 * @method static Builder|PosItem whereProductId($value)
 * @method static Builder|PosItem whereQnt($value)
 * @method static Builder|PosItem whereTaxId($value)
 * @method static Builder|PosItem whereUpdatedAt($value)
 * @method static Builder|PosItem whereUserId($value)
 * @mixin \Eloquent
 */
	class PosItem extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\PosPayment
 *
 * @property int $id
 * @property int|null $pos_sales_id
 * @property int|null $payment_method_id
 * @property string|null $amount
 * @property string|null $date
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $ledger_id
 * @property int|null $receive_payment_id
 * @property int|null $user_id
 * @property int|null $client_id
 * @property-read Ledger|null $ledger
 * @property-read \App\Models\PosSale|null $pos_sale
 * @method static Builder|PosPayment newModelQuery()
 * @method static Builder|PosPayment newQuery()
 * @method static Builder|PosPayment query()
 * @method static Builder|PosPayment whereAmount($value)
 * @method static Builder|PosPayment whereClientId($value)
 * @method static Builder|PosPayment whereCreatedAt($value)
 * @method static Builder|PosPayment whereDate($value)
 * @method static Builder|PosPayment whereId($value)
 * @method static Builder|PosPayment whereLedgerId($value)
 * @method static Builder|PosPayment wherePaymentMethodId($value)
 * @method static Builder|PosPayment wherePosSalesId($value)
 * @method static Builder|PosPayment whereReceivePaymentId($value)
 * @method static Builder|PosPayment whereUpdatedAt($value)
 * @method static Builder|PosPayment whereUserId($value)
 * @mixin \Eloquent
 */
	class PosPayment extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\PosSale
 *
 * @property int $id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $pos_number
 * @property string|null $date
 * @property int|null $customer_id
 * @property int|null $branch_id
 * @property int|null $ledger_id
 * @property string|null $discount_type
 * @property string|null $discount
 * @property string|null $vat
 * @property string|null $service_charge_type
 * @property string|null $service_charge
 * @property string|null $note
 * @property int|null $payment_method_id
 * @property string|null $sub_total
 * @property string|null $total
 * @property string|null $payment_amount
 * @property string|null $due
 * @property string|null $pos_status
 * @property string|null $change
 * @property int|null $user_id
 * @property int|null $client_id
 * @property-read Branch|null $branch
 * @property-read \App\Models\Customer|null $customer
 * @property-read mixed $charges
 * @property-read mixed $payment
 * @property-read Ledger|null $ledger
 * @property-read \App\Models\PaymentMethod|null $payment_method
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\PosPayment[] $payments
 * @property-read int|null $payments_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\PosCharge[] $pos_charges
 * @property-read int|null $pos_charges_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\PosItem[] $pos_items
 * @property-read int|null $pos_items_count
 * @method static Builder|PosSale newModelQuery()
 * @method static Builder|PosSale newQuery()
 * @method static Builder|PosSale query()
 * @method static Builder|PosSale whereBranchId($value)
 * @method static Builder|PosSale whereChange($value)
 * @method static Builder|PosSale whereClientId($value)
 * @method static Builder|PosSale whereCreatedAt($value)
 * @method static Builder|PosSale whereCustomerId($value)
 * @method static Builder|PosSale whereDate($value)
 * @method static Builder|PosSale whereDiscount($value)
 * @method static Builder|PosSale whereDiscountType($value)
 * @method static Builder|PosSale whereDue($value)
 * @method static Builder|PosSale whereId($value)
 * @method static Builder|PosSale whereLedgerId($value)
 * @method static Builder|PosSale whereNote($value)
 * @method static Builder|PosSale wherePaymentAmount($value)
 * @method static Builder|PosSale wherePaymentMethodId($value)
 * @method static Builder|PosSale wherePosNumber($value)
 * @method static Builder|PosSale wherePosStatus($value)
 * @method static Builder|PosSale whereServiceCharge($value)
 * @method static Builder|PosSale whereServiceChargeType($value)
 * @method static Builder|PosSale whereSubTotal($value)
 * @method static Builder|PosSale whereTotal($value)
 * @method static Builder|PosSale whereUpdatedAt($value)
 * @method static Builder|PosSale whereUserId($value)
 * @method static Builder|PosSale whereVat($value)
 * @mixin \Eloquent
 */
	class PosSale extends \Eloquent {}
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
 * @property int|null $brand_id
 * @property string|null $code
 * @property int $is_bookmarked
 * @property-read \App\Models\Brand|null $brand
 * @property-read \App\Models\Category|null $category
 * @property-read mixed $price
 * @property-read mixed $short_name
 * @property-read mixed $stock
 * @property-read mixed $stock_value
 * @method static Builder|Product newModelQuery()
 * @method static Builder|Product newQuery()
 * @method static Builder|Product query()
 * @method static Builder|Product whereBrandId($value)
 * @method static Builder|Product whereCategoryId($value)
 * @method static Builder|Product whereClientId($value)
 * @method static Builder|Product whereCode($value)
 * @method static Builder|Product whereCreatedAt($value)
 * @method static Builder|Product whereDescription($value)
 * @method static Builder|Product whereId($value)
 * @method static Builder|Product whereIsBookmarked($value)
 * @method static Builder|Product whereIsTrack($value)
 * @method static Builder|Product whereName($value)
 * @method static Builder|Product whereOpeningStock($value)
 * @method static Builder|Product whereOpeningStockPrice($value)
 * @method static Builder|Product wherePhoto($value)
 * @method static Builder|Product whereProductType($value)
 * @method static Builder|Product wherePurchasePrice($value)
 * @method static Builder|Product wherePurchaseUnit($value)
 * @method static Builder|Product whereSellPrice($value)
 * @method static Builder|Product whereSellUnit($value)
 * @method static Builder|Product whereSku($value)
 * @method static Builder|Product whereUpdatedAt($value)
 * @method static Builder|Product whereUserId($value)
 * @mixin \Eloquent
 */
	class Product extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\ProductUnit
 *
 * @property int $id
 * @property string|null $name
 * @property int|null $user_id
 * @property int|null $client_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static Builder|ProductUnit newModelQuery()
 * @method static Builder|ProductUnit newQuery()
 * @method static Builder|ProductUnit query()
 * @method static Builder|ProductUnit whereClientId($value)
 * @method static Builder|ProductUnit whereCreatedAt($value)
 * @method static Builder|ProductUnit whereId($value)
 * @method static Builder|ProductUnit whereName($value)
 * @method static Builder|ProductUnit whereUpdatedAt($value)
 * @method static Builder|ProductUnit whereUserId($value)
 * @mixin \Eloquent
 */
	class ProductUnit extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\PurchaseOrder
 *
 * @property int $id
 * @property int|null $vendor_id
 * @property string|null $purchase_order_number
 * @property string|null $order_number
 * @property string|null $ref
 * @property string|null $purchase_order_date
 * @property string|null $delivery_date
 * @property string|null $sub_total
 * @property string|null $total
 * @property string|null $discount_type
 * @property string|null $discount_value
 * @property string|null $discount
 * @property string|null $shipping_charge
 * @property string|null $notes
 * @property string|null $purchase_order_status
 * @property string|null $attachment
 * @property string|null $secret
 * @property int|null $user_id
 * @property int|null $client_id
 * @property string $currency
 * @property int|null $purchase_order_payment_id
 * @property int|null $is_payment
 * @property string|null $payment_amount
 * @property int|null $payment_method_id
 * @property int|null $deposit_to
 * @property int $converted
 * @property string $payment_status
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read mixed $age
 * @property-read mixed $charges
 * @property-read mixed $due
 * @property-read mixed $extra_fields
 * @property-read mixed $paid
 * @property-read mixed $payment
 * @property-read mixed $payment_status_text
 * @property-read mixed $payments
 * @property-read mixed $taxable_amount
 * @property-read mixed $taxes
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\PurchaseOrderExtraField[] $purchase_order_extra
 * @property-read int|null $purchase_order_extra_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\PurchaseOrderItem[] $purchase_order_items
 * @property-read int|null $purchase_order_items_count
 * @property-read \App\Models\Vendor|null $vendor
 * @method static \Illuminate\Database\Eloquent\Builder|PurchaseOrder newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|PurchaseOrder newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|PurchaseOrder query()
 * @method static \Illuminate\Database\Eloquent\Builder|PurchaseOrder whereAttachment($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PurchaseOrder whereClientId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PurchaseOrder whereConverted($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PurchaseOrder whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PurchaseOrder whereCurrency($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PurchaseOrder whereDeliveryDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PurchaseOrder whereDepositTo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PurchaseOrder whereDiscount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PurchaseOrder whereDiscountType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PurchaseOrder whereDiscountValue($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PurchaseOrder whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PurchaseOrder whereIsPayment($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PurchaseOrder whereNotes($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PurchaseOrder whereOrderNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PurchaseOrder wherePaymentAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PurchaseOrder wherePaymentMethodId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PurchaseOrder wherePaymentStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PurchaseOrder wherePurchaseOrderDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PurchaseOrder wherePurchaseOrderNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PurchaseOrder wherePurchaseOrderPaymentId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PurchaseOrder wherePurchaseOrderStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PurchaseOrder whereRef($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PurchaseOrder whereSecret($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PurchaseOrder whereShippingCharge($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PurchaseOrder whereSubTotal($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PurchaseOrder whereTotal($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PurchaseOrder whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PurchaseOrder whereUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PurchaseOrder whereVendorId($value)
 */
	class PurchaseOrder extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\PurchaseOrderExtraField
 *
 * @property int $id
 * @property string|null $purchase_order_id
 * @property string|null $name
 * @property string|null $value
 * @property int|null $user_id
 * @property int|null $client_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|PurchaseOrderExtraField newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|PurchaseOrderExtraField newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|PurchaseOrderExtraField query()
 * @method static \Illuminate\Database\Eloquent\Builder|PurchaseOrderExtraField whereClientId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PurchaseOrderExtraField whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PurchaseOrderExtraField whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PurchaseOrderExtraField whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PurchaseOrderExtraField wherePurchaseOrderId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PurchaseOrderExtraField whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PurchaseOrderExtraField whereUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PurchaseOrderExtraField whereValue($value)
 * @mixin \Eloquent
 */
	class PurchaseOrderExtraField extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\PurchaseOrderItem
 *
 * @property int $id
 * @property int $purchase_order_id
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
 * @property string|null $date
 * @property-read mixed $tax_amount
 * @property-read \App\Models\Product $product
 * @property-read \App\Models\PurchaseOrder $purchase_order
 * @method static Builder|PurchaseOrderItem newModelQuery()
 * @method static Builder|PurchaseOrderItem newQuery()
 * @method static Builder|PurchaseOrderItem query()
 * @method static Builder|PurchaseOrderItem whereAmount($value)
 * @method static Builder|PurchaseOrderItem whereClientId($value)
 * @method static Builder|PurchaseOrderItem whereCreatedAt($value)
 * @method static Builder|PurchaseOrderItem whereDate($value)
 * @method static Builder|PurchaseOrderItem whereDescription($value)
 * @method static Builder|PurchaseOrderItem whereId($value)
 * @method static Builder|PurchaseOrderItem wherePrice($value)
 * @method static Builder|PurchaseOrderItem whereProductId($value)
 * @method static Builder|PurchaseOrderItem wherePurchaseOrderId($value)
 * @method static Builder|PurchaseOrderItem whereQnt($value)
 * @method static Builder|PurchaseOrderItem whereTaxId($value)
 * @method static Builder|PurchaseOrderItem whereUnit($value)
 * @method static Builder|PurchaseOrderItem whereUpdatedAt($value)
 * @method static Builder|PurchaseOrderItem whereUserId($value)
 * @mixin \Eloquent
 */
	class PurchaseOrderItem extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Reason
 *
 * @property int $id
 * @property string|null $name
 * @property int|null $user_id
 * @property int|null $client_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static Builder|Reason newModelQuery()
 * @method static Builder|Reason newQuery()
 * @method static Builder|Reason query()
 * @method static Builder|Reason whereClientId($value)
 * @method static Builder|Reason whereCreatedAt($value)
 * @method static Builder|Reason whereId($value)
 * @method static Builder|Reason whereName($value)
 * @method static Builder|Reason whereUpdatedAt($value)
 * @method static Builder|Reason whereUserId($value)
 * @mixin \Eloquent
 */
	class Reason extends \Eloquent {}
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
 * @property string|null $given
 * @property-read \App\Models\Customer|null $customer
 * @property-read mixed $amount
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\ReceivePaymentItem[] $items
 * @property-read int|null $items_count
 * @property-read Ledger|null $ledger
 * @property-read \App\Models\PaymentMethod|null $paymentMethod
 * @method static Builder|ReceivePayment newModelQuery()
 * @method static Builder|ReceivePayment newQuery()
 * @method static Builder|ReceivePayment query()
 * @method static Builder|ReceivePayment whereClientId($value)
 * @method static Builder|ReceivePayment whereCreatedAt($value)
 * @method static Builder|ReceivePayment whereCustomerId($value)
 * @method static Builder|ReceivePayment whereDepositTo($value)
 * @method static Builder|ReceivePayment whereGiven($value)
 * @method static Builder|ReceivePayment whereId($value)
 * @method static Builder|ReceivePayment whereInvoice($value)
 * @method static Builder|ReceivePayment whereNote($value)
 * @method static Builder|ReceivePayment wherePaymentDate($value)
 * @method static Builder|ReceivePayment wherePaymentMethodId($value)
 * @method static Builder|ReceivePayment wherePaymentSl($value)
 * @method static Builder|ReceivePayment whereUpdatedAt($value)
 * @method static Builder|ReceivePayment whereUserId($value)
 * @mixin \Eloquent
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
 * @property-read \App\Models\Invoice|null $invoice
 * @property-read \App\Models\ReceivePayment|null $receive_payment
 * @method static Builder|ReceivePaymentItem newModelQuery()
 * @method static Builder|ReceivePaymentItem newQuery()
 * @method static Builder|ReceivePaymentItem query()
 * @method static Builder|ReceivePaymentItem whereAmount($value)
 * @method static Builder|ReceivePaymentItem whereClientId($value)
 * @method static Builder|ReceivePaymentItem whereCreatedAt($value)
 * @method static Builder|ReceivePaymentItem whereId($value)
 * @method static Builder|ReceivePaymentItem whereInvoiceId($value)
 * @method static Builder|ReceivePaymentItem whereReceivePaymentId($value)
 * @method static Builder|ReceivePaymentItem whereUpdatedAt($value)
 * @method static Builder|ReceivePaymentItem whereUserId($value)
 * @mixin \Eloquent
 */
	class ReceivePaymentItem extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Report
 *
 * @method static \Illuminate\Database\Eloquent\Builder|Report newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Report newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Report query()
 * @mixin \Eloquent
 */
	class Report extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\SR
 *
 * @property int $id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $name
 * @property string|null $photo
 * @property string|null $phone
 * @property string|null $email
 * @property string|null $address
 * @property int|null $client_id
 * @property int|null $user_id
 * @method static \Illuminate\Database\Eloquent\Builder|SR newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|SR newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|SR query()
 * @method static \Illuminate\Database\Eloquent\Builder|SR whereAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SR whereClientId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SR whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SR whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SR whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SR whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SR wherePhone($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SR wherePhoto($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SR whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SR whereUserId($value)
 * @mixin \Eloquent
 */
	class SR extends \Eloquent {}
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
 * @method static Builder|Tax newModelQuery()
 * @method static Builder|Tax newQuery()
 * @method static Builder|Tax query()
 * @method static Builder|Tax whereClientId($value)
 * @method static Builder|Tax whereCreatedAt($value)
 * @method static Builder|Tax whereId($value)
 * @method static Builder|Tax whereName($value)
 * @method static Builder|Tax whereTaxType($value)
 * @method static Builder|Tax whereUpdatedAt($value)
 * @method static Builder|Tax whereUserId($value)
 * @method static Builder|Tax whereValue($value)
 * @mixin \Eloquent
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
 * @property Carbon|null $email_verified_at
 * @property string $password
 * @property string|null $remember_token
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property string|null $stripe_id
 * @property string|null $pm_type
 * @property string|null $pm_last_four
 * @property string|null $trial_ends_at
 * @property int|null $client_id
 * @property string|null $role
 * @property string|null $last_active_at
 * @property string|null $affiliate_tag
 * @property string|null $referred_by
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Bill[] $bills
 * @property-read int|null $bills_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Customer[] $customers
 * @property-read int|null $customers_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Estimate[] $estimates
 * @property-read int|null $estimates_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Expense[] $expenses
 * @property-read int|null $expenses_count
 * @property-read mixed $invoice_count
 * @property-read mixed $login_url
 * @property-read mixed $plan
 * @property-read mixed $settings
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Invoice[] $invoices
 * @property-read int|null $invoices_count
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection|\Illuminate\Notifications\DatabaseNotification[] $notifications
 * @property-read int|null $notifications_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\PosSale[] $pos_sales
 * @property-read int|null $pos_sales_count
 * @property-read \Illuminate\Database\Eloquent\Collection|User[] $referred
 * @property-read int|null $referred_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\Laravel\Cashier\Subscription[] $subscriptions
 * @property-read int|null $subscriptions_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Vendor[] $vendors
 * @property-read int|null $vendors_count
 * @method static \Database\Factories\UserFactory factory(...$parameters)
 * @method static \Illuminate\Database\Eloquent\Builder|User newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|User newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|User query()
 * @method static \Illuminate\Database\Eloquent\Builder|User whereAffiliateTag($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereClientId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereEmailVerifiedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereLastActiveAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User wherePmLastFour($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User wherePmType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereReferredBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereRememberToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereRole($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereStripeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereTrialEndsAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereUpdatedAt($value)
 * @mixin \Eloquent
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
 * @property string|null $opening
 * @property string|null $opening_type
 * @property-read mixed $payables
 * @property-read mixed $previous_due
 * @method static Builder|Vendor newModelQuery()
 * @method static Builder|Vendor newQuery()
 * @method static Builder|Vendor query()
 * @method static Builder|Vendor whereAddress($value)
 * @method static Builder|Vendor whereCity($value)
 * @method static Builder|Vendor whereClientId($value)
 * @method static Builder|Vendor whereCompanyName($value)
 * @method static Builder|Vendor whereCountry($value)
 * @method static Builder|Vendor whereCreatedAt($value)
 * @method static Builder|Vendor whereEmail($value)
 * @method static Builder|Vendor whereId($value)
 * @method static Builder|Vendor whereName($value)
 * @method static Builder|Vendor whereOpening($value)
 * @method static Builder|Vendor whereOpeningType($value)
 * @method static Builder|Vendor wherePhone($value)
 * @method static Builder|Vendor wherePhoto($value)
 * @method static Builder|Vendor whereState($value)
 * @method static Builder|Vendor whereStreet1($value)
 * @method static Builder|Vendor whereStreet2($value)
 * @method static Builder|Vendor whereUpdatedAt($value)
 * @method static Builder|Vendor whereUserId($value)
 * @method static Builder|Vendor whereWebsite($value)
 * @method static Builder|Vendor whereZipPost($value)
 * @mixin \Eloquent
 */
	class Vendor extends \Eloquent {}
}

