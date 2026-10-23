<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class subscription extends MY_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->model('product_model');
        $this->load->model('order_model');
        $this->load->model('setting_model');
    }

    public function index()
    {
        $tid = (int) $this->tenant_id;
        $tenant = $this->db->where('id', $tid)->get('saas_tenants')->row_array();
        $plan   = !empty($tenant['plan_id'])
            ? $this->db->where('id', (int) $tenant['plan_id'])->get('saas_plans')->row_array()
            : null;

        $all_plans = $this->db->where('is_active', 1)
                              ->order_by('sort_order', 'ASC')
                              ->order_by('price', 'ASC')
                              ->get('saas_plans')
                              ->result_array();

        $subscriptions = $this->db->select('s.*, p.name as plan_name, p.price as plan_price, p.billing_cycle')
                                  ->from('saas_subscriptions s')
                                  ->join('saas_plans p', 'p.id = s.plan_id', 'left')
                                  ->where('s.tenant_id', $tid)
                                  ->order_by('s.id', 'DESC')
                                  ->get()
                                  ->result_array();

        $payments = $this->db->select('pay.*, p.name as resolved_plan_name')
                             ->from('saas_payments pay')
                             ->join('saas_plans p', 'p.id = pay.plan_id', 'left')
                             ->where('pay.tenant_id', $tid)
                             ->order_by('pay.id', 'DESC')
                             ->get()
                             ->result_array();

        $products_used = $this->product_model->count_all();
        $orders_used   = $this->order_model->count_all();

        $data = [
            'title'          => 'Subscription & Billing | Admin',
            'active_menu'    => 'saas_subscription',
            'active_submenu' => 'subscription',
            'tenant'         => $tenant,
            'current_plan'   => $plan,
            'all_plans'      => $all_plans,
            'subscriptions'  => $subscriptions,
            'payments'       => $payments,
            'products_used'  => $products_used,
            'orders_used'    => $orders_used
        ];

        $this->render('subscription/index', $data);
    }

    public function upgrade()
    {
        if ($this->input->method() !== 'post') {
            redirect('subscription');
            return;
        }

        $plan_id = (int) $this->input->post('plan_id');
        $gateway = trim($this->input->post('gateway', TRUE) ?: 'sandbox');

        $plan = $this->db->where('id', $plan_id)->where('is_active', 1)->get('saas_plans')->row_array();
        if (!$plan) {
            $this->session->set_flashdata('error', 'Selected subscription plan is invalid or inactive.');
            redirect('subscription');
            return;
        }

        $tid = (int) $this->tenant_id;
        $tenant = $this->db->where('id', $tid)->get('saas_tenants')->row_array();
        if (!$tenant) {
            redirect('subscription');
            return;
        }

        $duration_days = max(1, (int) ($plan['duration_days'] ?? 30));
        $current_exp = !empty($tenant['subscription_expires_at']) && strtotime($tenant['subscription_expires_at']) > time()
            ? strtotime($tenant['subscription_expires_at'])
            : time();
        $starts_at  = date('Y-m-d H:i:s');
        $expires_at = date('Y-m-d H:i:s', strtotime("+{$duration_days} days", $current_exp));

        $amount   = (float) $plan['price'];
        $currency = $plan['currency'] ?: ($tenant['currency_code'] ?? 'USD');

        $order_number = 'ORD-UPG-' . date('YmdHis') . '-' . rand(100, 999);
        $sub_number   = 'SUB-UPG-' . date('YmdHis') . '-' . rand(100, 999);
        $txn_ref      = 'TXN-UPG-' . strtoupper(substr(md5($order_number), 0, 10));

        $payload = [
            'upgrade_tenant_id' => $tid,
            'owner_name'        => $tenant['admin_name'] ?? 'Store Owner',
            'owner_email'       => $tenant['admin_email'] ?? '',
            'owner_phone'       => $tenant['admin_phone'] ?? '',
            'business_name'     => $tenant['business_name'] ?? 'My Store',
            'store_slug'        => $tenant['slug'] ?? 'fashion-store',
            'plan_id'           => $plan_id,
            'template'          => $tenant['template'] ?? 'fashion',
            'currency_code'     => $currency
        ];

        $this->db->insert('saas_subscriptions', [
            'subscription_number' => $sub_number,
            'tenant_id'           => $tid,
            'plan_id'             => $plan_id,
            'template_key'        => $tenant['template'] ?? 'fashion',
            'status'              => 'active',
            'amount'              => $amount,
            'currency'            => $currency,
            'billing_cycle'       => $plan['billing_cycle'] ?? 'monthly',
            'start_date'          => $starts_at,
            'end_date'            => $expires_at
        ]);
        $sub_id = $this->db->insert_id();

        $this->db->insert('saas_payments', [
            'order_number'    => $order_number,
            'subscription_id' => $sub_id,
            'tenant_id'       => $tid,
            'plan_id'         => $plan_id,
            'gateway'         => $gateway,
            'transaction_id'  => $txn_ref,
            'amount'          => $amount,
            'currency'        => $currency,
            'payment_status'  => 'paid',
            'customer_name'   => $tenant['admin_name'] ?? 'Store Owner',
            'customer_email'  => $tenant['admin_email'] ?? '',
            'customer_phone'  => $tenant['admin_phone'] ?? '',
            'business_name'   => $tenant['business_name'] ?? 'My Store',
            'store_slug'      => $tenant['slug'] ?? 'fashion-store',
            'chosen_template' => $tenant['template'] ?? 'fashion',
            'setup_payload'   => json_encode($payload),
            'paid_at'         => $starts_at
        ]);

        $this->db->where('id', $tid)->update('saas_tenants', [
            'plan_id'                 => $plan_id,
            'subscription_id'         => $sub_id,
            'payment_status'          => 'paid',
            'amount_paid'             => $amount,
            'payment_method'          => $gateway,
            'transaction_id'          => $txn_ref,
            'subscription_status'     => 'active',
            'subscription_expires_at' => $expires_at,
            'status'                  => 'active'
        ]);

        $this->session->set_flashdata('success', 'Subscription upgraded/renewed to "' . html_escape($plan['name']) . '"! Valid until ' . date('d M Y', strtotime($expires_at)) . '.');
        redirect('subscription');
    }
}
