<?php
/**
 * Class InvoiceSeeder.
 *
 
* @category ElanceBD
*
* @package Elancebd
* @author  Risfat <md@risfbd.com>
* @license https://risfbd.com Risfat
* @link    https://risfbd.com

 */
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

/**
 * Class InvoiceSeeder.
 *
 */
class InvoiceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('invoices')->insert(
            [
                [
                    'title' => 'Invoice No. 1',
                    'price' => '0',
                    'payer_name' => 'Test Payer',
                    'payer_email' => 'payer@gmail.com',
                    'seller_email' => 'seller@gmail.com',
                    'currency_code' => 'USD',
                    'payer_status' => 'unverified',
                    'transaction_id' => 'xxxx_xxxx_xxxx',
                    'sales_tax' => '0',
                    'invoice_id' => 'xxx_xxx',
                    'shipping_amount' => '0',
                    'handling_amount' => '0',
                    'insurance_amount' => '0',
                    'paypal_fee' => '0',
                    'payment_mode' => 'paypal',
                    'paid' => '1',
                    'type' => 'package',
                    'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                    'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
                ],
                [
                    'title' => 'Invoice No. 2',
                    'price' => '0',
                    'payer_name' => 'Test Payer',
                    'payer_email' => 'payer@gmail.com',
                    'seller_email' => 'seller@gmail.com',
                    'currency_code' => 'USD',
                    'payer_status' => 'unverified',
                    'transaction_id' => 'xxxx_xxxx_xxxx',
                    'sales_tax' => '0',
                    'invoice_id' => 'xxx_xxx',
                    'shipping_amount' => '0',
                    'handling_amount' => '0',
                    'insurance_amount' => '0',
                    'paypal_fee' => '0',
                    'payment_mode' => 'paypal',
                    'paid' => '1',
                    'type' => 'trial',
                    'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                    'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
                ],
            ]
        );
    }
}
