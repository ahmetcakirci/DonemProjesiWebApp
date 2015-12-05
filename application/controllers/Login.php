<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller {
    /**
     * __construct function.
     *
     * @access public
     * @return void
     */
    public function __construct() {

        parent::__construct();
        $this->load->library(array('session'));
        $this->load->helper(array('url'));
        $this->load->model('login_model');
    }

    public function index() {
        if($_SESSION['logged_in']){
            redirect(site_url('panel/main'));
        }else{
            redirect(site_url('login/sign_in'));
        }
    }

    /**
     * sign_in function.
     *
     * @access public
     * @return void
     */
    public function sign_in() {

        // create the data object
        $data = new stdClass();

        // load form helper and validation library
        $this->load->helper('form');
        $this->load->library('form_validation');

        // set validation rules
        $this->form_validation->set_rules('email', 'EMail', 'trim|required|valid_email');
        $this->form_validation->set_rules('password', 'Password', 'required');

        if ($this->form_validation->run() == false) {

            // validation not ok, send validation errors to the view
            $this->load->view('header');
            $this->load->view('user/login/login');
            $this->load->view('footer');

        } else {

            // set variables from the form
            $email = $this->input->post('email');
            $password = $this->input->post('password');

            if ($this->login_model->resolve_user_login($email, $password)) {

                $user_id = $this->login_model->get_user_id_from_username($email);
                $user    = $this->login_model->get_user($user_id);

                // set session user datas
                $_SESSION['idusers']      = (int)$user->idusers;
                $_SESSION['name']     = (string)$user->name;
                $_SESSION['surname']     = (string)$user->surname;
                $_SESSION['imei']     = (string)$user->imei;
                $_SESSION['logged_in']    = (bool)true;

                // user login ok
                redirect(site_url('panel/main'));

            } else {

                // login failed
                $data->error = 'Wrong username or password.';

                // send error to the view
                $this->load->view('header');
                $this->load->view('user/login/login', $data);
                $this->load->view('footer');

            }

        }

    }

    /**
     * logout function.
     *
     * @access public
     * @return void
     */
    public function logout() {

        // create the data object
        $data = new stdClass();

        if (isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true) {

            // remove session datas
            foreach ($_SESSION as $key => $value) {
                unset($_SESSION[$key]);
            }

            // user logout ok
            $this->load->view('header');
            $this->load->view('user/logout/logout_success', $data);
            $this->load->view('footer');

        } else {

            // there user was not logged in, we cannot logged him out,
            // redirect him to site root
            redirect('/');

        }

    }

}