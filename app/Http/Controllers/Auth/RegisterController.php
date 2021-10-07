<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\MetaSetting;
use App\Models\PaymentMethod;
use App\Providers\RouteServiceProvider;
use App\Models\User;
use Artisan;
use Enam\Acc\Models\Ledger;
use Illuminate\Auth\Events\Registered;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;


    protected $redirectTo = RouteServiceProvider::HOME;


    public function __construct()
    {
        $this->middleware('guest');
    }


    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:4'],
        ]);
    }

    public function register(Request $request)
    {
        $this->validator($request->all())->validate();

        event(new Registered($user = $this->create($request->all())));

        $this->guard()->login($user);
        if (!Ledger::query()->exists()) {

            Artisan::call('db:seed --class=AccountingSeeder');
            PaymentMethod::create(['name' => 'Cash']);
            PaymentMethod::create(['name' => 'Bank Transfer']);
            PaymentMethod::create(['name' => 'Credit Card']);
            PaymentMethod::create(['name' => 'Visa Card']);
            PaymentMethod::create(['name' => 'Cheque']);

            MetaSetting::query()->updateOrCreate(['key' => 'email'], ['value' => $user->email]);
            Customer::create(['name' => Customer::WALK_IN_CUSTOMER]);

        }
        if ($response = $this->registered($request, $user)) {
            return $response;
        }

        return $request->wantsJson()
            ? new JsonResponse([], 201)
            : redirect($this->redirectPath());
    }


    protected function create(array $data)
    {

        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'client_id' => User::getNextUserID()]);
        // email data
        $email_data = array(
            'name' => $data['name'],
            'email' => $data['email'],
        );
        $affiliate_tag = strtolower(preg_replace("/\s+/", "", $user->name)) . '' . $user->id;
        $user->affiliate_tag = $affiliate_tag;
        $user->save();
        Mail::send('mail.welcome_email', $email_data, function ($message) use ($email_data) {
            $message->to($email_data['email'], $email_data['name'])
                ->subject('Welcome to InvoicePedia')
                ->from('invoicepedia@gmail.com', 'InvoicePedia.com');
        });


        return $user;

    }

    protected function registered(Request $request, $user)
    {
        if (array_key_exists('invoicepedia_affiliate', $_COOKIE)) {
            $affiliate_tag = $_COOKIE['invoicepedia_affiliate'];
            if (User::query()->where('affiliate_tag', $affiliate_tag)->exists()) {
                $user->update(['referred_by' => $affiliate_tag]);
            }
        }
    }

}
