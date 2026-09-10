<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class order extends MY_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->model('order_model');
    }

    public function track()
    {
        $order = NULL;
        $searched = FALSE;

        if ($this->input->get('order_number')) {
            $searched     = TRUE;
            $order_number = trim($this->input->get('order_number'));
            $email        = trim($this->input->get('email'));

            $found = $this->order_model->get_by_order_number($order_number);
            if ($found && (empty($email) || strtolower($found['customer_email']) === strtolower($email))) {
                $order = $found;
            }
        }

        $data = [
            'title'       => 'Order Tracking - ' . $this->site_name,
            'active_page' => 'track',
            'searched'    => $searched,
            'order'       => $order
        ];

        $this->render('order/track', $data);
    }
}
