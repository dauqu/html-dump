<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Payu extends CI_Controller {
    public function __construct() {
        parent::__construct();
        $this->load->helper('url');
    }
    public function index(){
        $this->load->view('payment.payumoney.payu');
    }
    public function check(){

        // all values are required
        $amount =  $this->input->post('payble_amount');
        $product_info = $this->input->post('product_info');
        $customer_name = $this->input->post('customer_name');
        $customer_emial = $this->input->post('customer_email');
        $customer_mobile = $this->input->post('mobile_number');
        $customer_address = $this->input->post('customer_address');

        //payumoney details


        $MERCHANT_KEY = "SYMBk2HQ"; //change  merchant with yours
        $SALT = "dxmk9SZZ9y";  //change salt with yours

        $txnid = substr(hash('sha256', mt_rand() . microtime()), 0, 20);
        //optional udf values
        $udf1 = '';
        $udf2 = '';
        $udf3 = '';
        $udf4 = '';
        $udf5 = '';

        $hashstring = $MERCHANT_KEY . '|' . $txnid . '|' . $amount . '|' . $product_info . '|' . $customer_name . '|' . $customer_emial . '|' . $udf1 . '|' . $udf2 . '|' . $udf3 . '|' . $udf4 . '|' . $udf5 . '||||||' . $SALT;
        $hash = strtolower(hash('sha512', $hashstring));

        $success = base_url() . 'Status';
        $fail = base_url() . 'Status';
        $cancel = base_url() . 'Status';


        $data = array(
            'mkey' => $MERCHANT_KEY,
            'tid' => $txnid,
            'hash' => $hash,
            'amount' => $amount,
            'name' => $customer_name,
            'productinfo' => $product_info,
            'mailid' => $customer_emial,
            'phoneno' => $customer_mobile,
            'address' => $customer_address,
            'action' => "https://test.payu.in", //for live change action  https://secure.payu.in
            'sucess' => $success,
            'failure' => $fail,
            'cancel' => $cancel
        );
        $this->load->view('confirmation', $data);
    }

    // function for payumoney status
    public function index() {
        $status = $this->input->post('status');
        if (empty($status)) {
            redirect('My_controller');
        }

        $firstname = $this->input->post('firstname');
        $amount = $this->input->post('amount');
        $txnid = $this->input->post('txnid');
        $posted_hash = $this->input->post('hash');
        $key = $this->input->post('key');
        $productinfo = $this->input->post('productinfo');
        $email = $this->input->post('email');
        $salt = "dxmk9SZZ9y"; //  Your salt
        $add = $this->input->post('additionalCharges');
        If (isset($add)) {
            $additionalCharges = $this->input->post('additionalCharges');
            $retHashSeq = $additionalCharges . '|' . $salt . '|' . $status . '|||||||||||' . $email . '|' . $firstname . '|' . $productinfo . '|' . $amount . '|' . $txnid . '|' . $key;
        } else {

            $retHashSeq = $salt . '|' . $status . '|||||||||||' . $email . '|' . $firstname . '|' . $productinfo . '|' . $amount . '|' . $txnid . '|' . $key;
        }
        $data['hash'] = hash("sha512", $retHashSeq);
        $data['amount'] = $amount;
        $data['txnid'] = $txnid;
        $data['posted_hash'] = $posted_hash;
        $data['status'] = $status;
        if($status == 'success'){
            $this->load->view('success', $data);
        }
        else{
            $this->load->view('fail', $data);
        }

    }

}
