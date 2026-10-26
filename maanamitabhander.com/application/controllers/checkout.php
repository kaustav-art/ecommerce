<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class checkout extends MY_Controller {

    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        $items           = Static_template_data::get('cart_items');
        $summary         = Static_template_data::get('cart_summary');
        $gateways        = Static_template_data::get('gateways');
        $addresses       = Static_template_data::get('addresses');
        $default_address = $addresses[0] ?? NULL;

        $data = [
            'title'           => 'Checkout - ' . $this->site_name,
            'active_page'     => 'checkout',
            'cart_items'      => $items,
            'cart_summary'    => $summary,
            'gateways'        => $gateways,
            'default_address' => $default_address,
            'shipping_method' => 'standard',
            'mrp_total'       => $summary['mrp_total'],
            'discount_total'  => $summary['mrp_discount'],
            'total_savings'   => $summary['total_savings']
        ];

        $this->render('checkout/index', $data);
    }

    public function payment()
    {
        $items           = Static_template_data::get('cart_items');
        $summary         = Static_template_data::get('cart_summary');
        $gateways        = Static_template_data::get('gateways');
        $addresses       = Static_template_data::get('addresses');
        $default_address = $addresses[0] ?? NULL;

        $data = [
            'title'           => 'Payment - ' . $this->site_name,
            'active_page'     => 'checkout',
            'cart_items'      => $items,
            'cart_summary'    => $summary,
            'gateways'        => $gateways,
            'default_gateway' => 'cod',
            'cod_eligible'    => TRUE,
            'non_cod_items'   => [],
            'default_address' => $default_address,
            'shipping_method' => 'standard',
            'mrp_total'       => $summary['mrp_total'],
            'discount_total'  => $summary['mrp_discount'],
            'total_savings'   => $summary['total_savings']
        ];

        $this->render('checkout/payment', $data);
    }

    public function select_address()
    {
        $address_id = (int) $this->input->post('address_id', TRUE);
        $addresses  = Static_template_data::get('addresses');
        $addr       = $addresses[0] ?? NULL;
        foreach ($addresses as $a) {
            if ((int)$a['id'] === $address_id) {
                $addr = $a;
                break;
            }
        }
        return $this->json_response([
            'success' => true,
            'address' => $addr,
            'message' => 'Delivery address selected.'
        ]);
    }

    public function get_addresses()
    {
        $addresses = Static_template_data::get('addresses');
        return $this->json_response([
            'success'      => true,
            'addresses'    => $addresses,
            'selected_id'  => $addresses[0]['id'] ?? 1,
            'is_logged_in' => true
        ]);
    }

    public function save_address()
    {
        $addresses = Static_template_data::get('addresses');
        $addr      = $addresses[0];
        return $this->json_response([
            'success' => true,
            'address' => $addr,
            'message' => 'Delivery address saved (Template Demo Mode)!'
        ]);
    }

    public function create_order_ajax()
    {
        $common_order = Static_template_data::get('common_order');
        $order_number = $common_order['order_number'] ?? 'ORD-2026-88412';
        return $this->json_response([
            'success'      => true,
            'gateway'      => 'cod',
            'order_number' => $order_number,
            'redirect_url' => site_url('account/order/' . $order_number)
        ]);
    }

    public function verify_razorpay_ajax()
    {
        $common_order = Static_template_data::get('common_order');
        $order_number = $common_order['order_number'] ?? 'ORD-2026-88412';
        return $this->json_response([
            'success'      => true,
            'order_number' => $order_number,
            'redirect_url' => site_url('account/order/' . $order_number)
        ]);
    }

    public function confirm_stripe_ajax()
    {
        $common_order = Static_template_data::get('common_order');
        $order_number = $common_order['order_number'] ?? 'ORD-2026-88412';
        return $this->json_response([
            'success'      => true,
            'order_number' => $order_number,
            'redirect_url' => site_url('account/order/' . $order_number)
        ]);
    }

    public function process()
    {
        $common_order = Static_template_data::get('common_order');
        $order_number = $common_order['order_number'] ?? 'ORD-2026-88412';
        redirect('account/order/' . $order_number);
    }
}
