<?php
/**
 * Class PaypalController
 *
 
* @category ElanceBD
*
* @package Elancebd
* @author  Risfat <md@risfbd.com>
* @license https://risfbd.com Risfat
* @link    https://risfbd.com

 */
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Invoice;
use App\Item;
use Carbon\Carbon;
use Srmklive\PayPal\Services\ExpressCheckout;
use App\SiteManagement;
use Illuminate\Support\Facades\Redirect;
use Session;
use App\Helper;
use Auth;
use DB;
use App\Package;
use Illuminate\Support\Facades\Mail;
use App\Proposal;
use App\EmailTemplate;
use App\Mail\FreelancerEmailMailable;
use App\Mail\EmployerEmailMailable;
use App\job;

/**
 * Class PaypalController
 *
 */
class PaypalController extends Controller
{

    /**
     * Defining scope of the variable
     *
     * @access public
     * @var    array $provider
     */
    protected $provider;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->provider = new ExpressCheckout();
        $email_settings = SiteManagement::getMetaValue('settings');
        if (!empty($email_settings[0]['email'])) {
            config(['mail.username' => $email_settings[0]['email']]);
        }
    }

    /**
     * Get index.
     *
     * @param mixed $request $req->attr
     *
     * @return \Illuminate\Http\Response
     */
    public function getIndex(Request $request)
    {
        if (Auth::user()) {
            $response = [];
            if (session()->has('code')) {
                $response['code'] = session()->get('code');
                session()->forget('code');
            }
            if (session()->has('message')) {
                $response['message'] = session()->get('message');
                session()->forget('message');
            }
            $error_code = session()->get('code');
            Session::flash('payment_message', $response);
            $product_type = session()->get('type');
            if (Auth::user()->getRoleNames()[0] == "employer") {
                if ($product_type == 'project') {
                    return Redirect::to('employer/jobs/hired');
                } else {
                    return Redirect::to('employer/dashboard/post-job');
                }
            }
            if (Auth::user()->getRoleNames()[0] == "freelancer") {
                session()->forget('type');
                return Redirect::to('jobs');
            }
        } else {
            abort(404);
        }
    }

    /**
     * Get express checkout.
     *
     * @param mixed $request $req->attr
     *
     * @return \Illuminate\Http\Response
     */
    public function getExpressCheckout(Request $request)
    {
        if (Auth::user()) {
            //$recurring = ($request->get('mode') === 'recurring') ? true : false;
            $recurring = false;
            $success = true;
            $cart = $this->getCheckoutData($recurring, $success);
            $payment_detail = array();
            try {
                $response = $this->provider->setExpressCheckout($cart, $recurring);
                return redirect($response['paypal_link']);
            } catch (\Exception $e) {
                $invoice = $this->createInvoice($cart, 'Invalid', $payment_detail);
                session()->put(['code' => 'danger', 'message' => "Error processing PayPal payment for Order $invoice->id!"]);
            }
        } else {
            abort(404);
        }
    }

    /**
     * Get Express Checkout Success.
     *
     * @param mixed $request $req->attr
     *
     * @return \Illuminate\Http\Response
     */
    public function getExpressCheckoutSuccess(Request $request)
    {
        if (Auth::user()) {
            //$recurring = ($request->get('mode') === 'recurring') ? true : false;
            $recurring = false;
            $token = $request->get('token');
            $PayerID = $request->get('PayerID');
            $success = false;
            $cart = $this->getCheckoutData($recurring, $success);
            // Verify Express Checkout Token
            $response = $this->provider->getExpressCheckoutDetails($token);
            if (in_array(strtoupper($response['ACK']), ['SUCCESS', 'SUCCESSWITHWARNING'])) {
                if ($recurring === true) {
                    $response = $this->provider->createMonthlySubscription($response['TOKEN'], 9.99, $cart['subscription_desc']);
                    if (!empty($response['PROFILESTATUS']) && in_array($response['PROFILESTATUS'], ['ActiveProfile', 'PendingProfile'])) {
                        $status = 'Processed';
                    } else {
                        $status = 'Invalid';
                    }
                } else {
                    // Perform transaction on PayPal
                    $payment_status = $this->provider->doExpressCheckoutPayment($cart, $token, $PayerID);
                    $status = $payment_status['PAYMENTINFO_0_PAYMENTSTATUS'];
                }
                $payment_detail = array();
                $payment_detail['payer_name'] = $response['FIRSTNAME'] . " " . $response['LASTNAME'];
                $payment_detail['payer_email'] = $response['EMAIL'];
                $payment_detail['seller_email'] = $payment_status['PAYMENTINFO_0_SELLERPAYPALACCOUNTID'];
                $payment_detail['currency_code'] = $response['CURRENCYCODE'];
                $payment_detail['payer_status'] = $response['PAYERSTATUS'];
                $payment_detail['transaction_id'] = $payment_status['PAYMENTINFO_0_TRANSACTIONID'];
                $payment_detail['sales_tax'] = $response['TAXAMT'];
                $payment_detail['invoice_id'] = $response['INVNUM'];
                $payment_detail['shipping_amount'] = $response['SHIPPINGAMT'];
                $payment_detail['handling_amount'] = $response['HANDLINGAMT'];
                $payment_detail['insurance_amount'] = $response['INSURANCEAMT'];
                $payment_detail['paypal_fee'] = $payment_status['PAYMENTINFO_0_FEEAMT'];
                $payment_detail['payment_date'] = $payment_status['TIMESTAMP'];
                $payment_detail['product_qty'] = $cart['items'][0]['qty'];
                $invoice = $this->createInvoice($cart, $status, $payment_detail);
                if ($invoice->paid) {
                    session()->put(['code' => 'success', 'message' => "Thank you for your subscription"]);
                } else {
                    session()->put(['code' => 'danger', 'message' => "Error processing PayPal payment for Order $invoice->id!"]);
                }
                return redirect('paypal/redirect-url');
            } else {
                abort(404);
            }
        }
    }


    /**
     * Get Express Checkout Success.
     *
     * @param mixed $recurring $recurring
     * @param mixed $success   $recurring
     *
     * @return \Illuminate\Http\Response
     */
    protected function getCheckoutData($recurring, $success)
    {
        if (Auth::user()) {
            if (session()->has('product_id')) {
                $id = session()->get('product_id');
                $title = session()->get('product_title');
                $price = session()->get('product_price');
            }
            $user_id = Auth::user()->id;
            if ($success == true) {
                DB::table('orders')->insert(
                    ['user_id' => $user_id, 'product_id' => $id, 'invoice_id' => null, 'status' => 'pending', 'created_at' => \Carbon\Carbon::now(), 'updated_at' => \Carbon\Carbon::now()]
                );
                session()->put(['custom_order_id' => DB::getPdo()->lastInsertId()]);
            }
            $random_number = Helper::generateRandomCode(4);
            $unique_code = strtoupper($random_number);
            $data = [];
            $order_id = Invoice::all()->count() + 1;
            if ($recurring === true) {
                $data['items'] = [
                    [
                        'name' => 'Monthly Subscription ' . config('paypal.invoice_prefix') . ' #' . $order_id,
                        'price' => 0,
                        'qty' => 1,
                    ],
                ];
                $data['return_url'] = url('/paypal/ec-checkout-success?mode=recurring');
                $data['subscription_desc'] = 'Monthly Subscription ' . config('paypal.invoice_prefix') . ' #' . $order_id;
            } else {
                $data['items'] = [
                    [
                        'product_id' => $id,
                        'subscriber_id' => $user_id,
                        'name' => $title,
                        'price' => $price,
                        'qty' => 1,
                    ],

                ];
                $data['return_url'] = url('/paypal/ec-checkout-success');
            }
            $data['invoice_id'] = config('paypal.invoice_prefix') . '_' . $unique_code . '_' . $order_id;
            $data['invoice_description'] = "Order #$order_id Invoice";
            $data['cancel_url'] = url('/');
            $total = 0;
            foreach ($data['items'] as $item) {
                $total += $item['price'] * $item['qty'];
            }
            $data['total'] = $total;

            return $data;
        } else {
            abort(404);
        }
    }

    /**
     * Create invoice
     *
     * @param mixed $cart           cart
     * @param mixed $status         status
     * @param mixed $payment_detail payment_detail
     *
     * @return \Illuminate\Http\Response
     */
    protected function createInvoice($cart, $status, $payment_detail)
    {
        //create invoice
        $invoice = new Invoice();
        $invoice->title = filter_var($cart['invoice_description'], FILTER_SANITIZE_STRING);
        $invoice->price = $cart['total'];
        $invoice->payer_name = filter_var($payment_detail['payer_name'], FILTER_SANITIZE_STRING);
        $invoice->payer_email = filter_var($payment_detail['payer_email'], FILTER_SANITIZE_EMAIL);
        $invoice->seller_email = filter_var($payment_detail['seller_email'], FILTER_SANITIZE_EMAIL);
        $invoice->currency_code = filter_var($payment_detail['currency_code'], FILTER_SANITIZE_STRING);
        $invoice->payer_status = filter_var($payment_detail['payer_status'], FILTER_SANITIZE_STRING);
        $invoice->transaction_id = filter_var($payment_detail['transaction_id'], FILTER_SANITIZE_STRING);
        $invoice->invoice_id = filter_var($payment_detail['invoice_id'], FILTER_SANITIZE_STRING);
        $invoice->shipping_amount = $payment_detail['shipping_amount'];
        $invoice->handling_amount = $payment_detail['handling_amount'];
        $invoice->insurance_amount = $payment_detail['insurance_amount'];
        $invoice->sales_tax = 0;
        $invoice->payment_mode = filter_var('paypal', FILTER_SANITIZE_STRING);
        $invoice->paypal_fee = $payment_detail['paypal_fee'];
        if (!strcasecmp($status, 'completed') || !strcasecmp($status, 'Processed')) {
            $invoice->paid = 1;
        } else {
            $invoice->paid = 0;
        }
        $product_type = session()->get('type');
        $invoice->type = $product_type;
        $invoice->save();
        $invoice_id = DB::getPdo()->lastInsertId();
        // create item
        collect(
            $cart['items']
        )->each(
            function ($product) use ($invoice) {
                $product_price = $invoice->price - $invoice->sales_tax;
                $item = DB::table('items')->select('id')->where('subscriber', $product['subscriber_id'])->first();
                if (!empty($item)) {
                    $item = Item::find($item->id);    
                } else {
                    $item = new Item();
                }
                $item->invoice_id = filter_var($invoice->id, FILTER_SANITIZE_NUMBER_INT);
                $item->product_id = filter_var($product['product_id'], FILTER_SANITIZE_NUMBER_INT);
                $item->subscriber = $product['subscriber_id'];
                $item->item_name = filter_var($product['name'], FILTER_SANITIZE_STRING);
                $item->item_price = $product_price;
                $item->item_qty = filter_var($product['qty'], FILTER_SANITIZE_NUMBER_INT);
                $item->save();
                $last_order_id = session()->get('custom_order_id');
                DB::table('orders')
                    ->where('id', $last_order_id)
                    ->update(['status' => 'completed']);
            }
        );
        if (Auth::user()) {
            if ($product_type == 'package') {
                if (session()->has('product_id')) {
                    $package_item = \App\Item::where('subscriber', Auth::user()->id)->first();
                    $id = session()->get('product_id');
                    $package = \App\Package::find($id);
                    if (!empty($package->badge_id) && $package->badge_id != 0) {
                        $option = !empty($package->options) ? unserialize($package->options) : '';
                        $expiry = !empty($option) ? $package_item->created_at->addDays($option['duration']) : '';
                        $expiry_date = !empty($expiry) ? Carbon::parse($expiry)->toDateTimeString() : '';
                        $user = \App\User::find(Auth::user()->id);
                        $user->badge_id = $package->badge_id;
                        $user->expiry_date = $expiry_date;
                        $user->save();
                    }
                }    
            }
        }
        // send mail
        if ($product_type == 'project') {
            $id = session()->get('product_id');
            $proposal_obj = new Proposal();
            $proposal =  Proposal::find($id);
            $job = \App\Job::find($proposal->job->id);
            $freelancer = User::find($proposal->freelancer_id);
            $employer = User::find($job->user_id);
            if (!empty($freelancer->email)) {
                $email_params = array();
                $template = DB::table('email_types')->select('id')->where('email_type', 'freelancer_email_hire_freelancer')->get()->first();
                if (!empty($template->id)) {
                    $template_data = EmailTemplate::getEmailTemplateByID($template->id);
                    $email_params['project_title'] = $job->title;
                    $email_params['hired_project_link'] = url('job/'.$job->slug);
                    $email_params['name'] = Helper::getUserName($freelancer->id);
                    $email_params['link'] = url('profile/'.$freelancer->slug);
                    $email_params['employer_profile'] = url('profile/'.$employer->slug);
                    $email_params['emp_name'] = Helper::getUserName($employer->id);
                    Mail::to($freelancer->email)
                        ->send(
                            new FreelancerEmailMailable(
                                'freelancer_email_hire_freelancer',
                                $template_data,
                                $email_params
                            )
                        );
                }
            }
            $proposal_obj->assignJob($id);
        } elseif ($product_type == 'package') {
            $id = session()->get('product_id');
            $item = DB::table('items')->where('product_id', $id)->get()->toArray();
            $package =  Package::where('id', $item[0]->product_id)->first();
            $user = User::find($item[0]->subscriber);
            $role = $user->getRoleNames()->first();
            $package_options = unserialize($package->options);
            if (!empty($invoice)) {
                if ($package_options['duration'] === 'Quarter') {
                    $expiry_date = $invoice->created_at->addDays(4);
                } elseif ($package_options['duration'] === 'Month') {
                    $expiry_date = $invoice->created_at->addMonths(1);
                } elseif ($package_options['duration'] === 'Year') {
                    $expiry_date = $invoice->created_at->addYears(1);
                }
            }
            if ($role === 'employer') {
                if (!empty($user->email)) {
                    $email_params = array();
                    $template = DB::table('email_types')->select('id')->where('email_type', 'employer_email_package_subscribed')->get()->first();
                    if (!empty($template->id)) {
                        $template_data = EmailTemplate::getEmailTemplateByID($template->id);
                        $email_params['employer'] = Helper::getUserName($user->id);
                        $email_params['employer_profile'] = url('profile/'.$user->slug);
                        $email_params['name'] = $package->title;
                        $email_params['price'] = $package->cost;
                        $email_params['expiry_date'] = !empty($expiry_date) ? Carbon::parse($expiry_date)->format('M d, Y') : '';
                        Mail::to(Auth::user()->email)
                            ->send(
                                new EmployerEmailMailable(
                                    'employer_email_package_subscribed',
                                    $template_data,
                                    $email_params
                                )
                            );
                    }
                }
            } elseif ($role === 'freelancer') {
                if (!empty(Auth::user()->email)) {
                    $email_params = array();
                    $template = DB::table('email_types')->select('id')->where('email_type', 'freelancer_email_package_subscribed')->get()->first();
                    if (!empty($template->id)) {
                        $template_data = EmailTemplate::getEmailTemplateByID($template->id);
                        $email_params['freelancer'] = Helper::getUserName($user->id);
                        $email_params['freelancer_profile'] = url('profile/'.$user->slug);
                        $email_params['name'] = $package->title;
                        $email_params['price'] = $package->cost;
                        $email_params['expiry_date'] = !empty($expiry_date) ? Carbon::parse($expiry_date)->format('M d, Y') : '';
                        Mail::to(Auth::user()->email)
                            ->send(
                                new FreelancerEmailMailable(
                                    'freelancer_email_package_subscribed',
                                    $template_data,
                                    $email_params
                                )
                            );
                    }
                }
            }
        }
        session()->forget('product_id');
        session()->forget('product_title');
        session()->forget('product_price');
        session()->forget('custom_order_id');
        return $invoice;
    }
}
