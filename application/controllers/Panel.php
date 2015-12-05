<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Panel extends CI_Controller {
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
        $this->load->model('panel_model');

        if(!$_SESSION['logged_in'])
            redirect(site_url('login/sign_in'));
    }

    public function index(){
        if($_SESSION['logged_in']){
            redirect(site_url('panel/main'));
        }else{
            redirect(site_url('login/sign_in'));
        }
    }

    public function main(){
        // create the data object
        $data = new stdClass();
        $data->header=$this->load->view('header');
        $data->context=$this->load->view('panel/main');
        $data->footer=$this->load->view('footer');
        $this->load->view('panel/panel', $data,TRUE);
    }

    public function password_change(){
        // create the data object
        $data = new stdClass();

        // load form helper and validation library
        $this->load->helper('form');
        $this->load->library('form_validation');

        // set validation rules
        $this->form_validation->set_rules('newpassword', 'New Password', 'required');
        $this->form_validation->set_rules('repassword', 'Re Password', 'required');

        // set variables from the form
        $newpassword = $this->input->post('newpassword');
        $repassword = $this->input->post('repassword');
        $idusers=(isset($_SESSION['idusers'])?$_SESSION['idusers']:null);

        if ($this->form_validation->run() == false) {

        }elseif($newpassword!=$repassword){
            $data->error = 'Girilen şifreler birbirine uymamaktadır!';
        }else {
            if ($this->panel_model->password_change($newpassword,$idusers)) {
                $data->success = 'Başarılıyla Güncellendi';
            }else{
                $data->error = 'Güncelleme başarısız oldu!';
            }
        }

        $data->header=$this->load->view('header');
        $data->context=$this->load->view('panel/settings/password_change',$data);
        $data->footer=$this->load->view('footer');
        $this->load->view('panel/panel', $data,TRUE);
    }

    public function user_add(){
        // create the data object
        $data = new stdClass();

        // load form helper and validation library
        $this->load->helper('form');
        $this->load->library('form_validation');

        // set validation rules
        $this->form_validation->set_rules('name', 'Name', 'required');
        $this->form_validation->set_rules('surname', 'Surname', 'required');
        $this->form_validation->set_rules('email', 'EMail', 'trim|required|valid_email');
        $this->form_validation->set_rules('password', 'Password', 'required');
        $this->form_validation->set_rules('imei', 'IMEI', 'required');


        if ($this->form_validation->run() == false) {

        } else {
            // set variables from the form
            $name = $this->input->post('name');
            $surname = $this->input->post('surname');
            $email = $this->input->post('email');
            $password = $this->input->post('password');
            $imei = $this->input->post('imei');
            $status=($this->input->post('status')=='status'?'1':'0');
            $web=($this->input->post('web')=='web'?'1':'0');

            if ($this->panel_model->create_user($name,$surname, $email, $password,$imei,$status,$web)) {
                $data->success = 'Başarılıyla kullanıcı eklendi!';
            }else{
                $data->error = 'Başarısız kullanıcı eklenemedi!';
            }
        }

        $data->header=$this->load->view('header');
        $data->context=$this->load->view('panel/user/user_add',$data);
        $data->footer=$this->load->view('footer');
        $this->load->view('panel/panel', $data,TRUE);
    }

    public function user_lists(){
        $data = new stdClass();

        // load form helper and validation library
        $this->load->helper('form');
        $this->load->library('form_validation');

        $this->load->library('pagination');
        $toplam=$this->panel_model->user_count();
        $config = array (
            "base_url"=>site_url()."/panel/user_lists",
            "per_page" =>10,
            "total_rows" =>$toplam,
            'uri_segment' =>3,
            'full_tag_open' =>'<nav><ul class="pagination">',
            'full_tag_close' => '</ul></nav>',
            'cur_tag_open' => '<li><a href="#" style="color:#ffffff; background-color:#258BB5;">',
            'cur_tag_close' => '</a></li>',
            'num_tag_open' => '<li>',  'num_tag_close' => '</li>',
            'prev_tag_open'=> '<li>', 'prev_tag_close'=> '<li>',
            'next_tag_open'=> ' <li>',  'next_tag_close'=> '<li>',
            'first_tag_open'=> ' <li>', 'first_tag_close'=> '<li>',
            'last_tag_open'=> ' <li>', 'last_tag_close'=> '<li>',
        );
        $data->lists=false;
        $data->user_lists = $this->panel_model->user_lists($config['per_page'],$this->uri->segment(3));
        $this->pagination->initialize($config);
        $data->links=$this->pagination->create_links();
        $data->header=$this->load->view('header');
        $data->context=$this->load->view('panel/user/user_lists',$data);
        $data->footer=$this->load->view('footer');
        $this->load->view('panel/panel', $data,TRUE);
    }

    public function user_search(){
        // create the data object
        $data = new stdClass();
        $per_page=10;
        // load form helper and validation library
        $this->load->helper('form');
        $this->load->library('form_validation');
        $this->load->library('pagination');

        // set validation rules
        $this->form_validation->set_rules('email', 'EMail', 'trim|required|valid_email');

        if ($this->form_validation->run() == false) {
            $toplam=$this->panel_model->user_count();
            $data->user_lists = $this->panel_model->user_lists($per_page,$this->uri->segment(3));
            $data->lists=false;
        } else {
            // set variables from the form
            $email = $this->input->post('email');
            $toplam=$this->panel_model->user_search_count($email);
            $data->user_lists = $this->panel_model->search_user($email,$per_page,$this->uri->segment(3));
            $data->lists=true;
        }


        $config = array (
            "base_url"=>site_url()."/panel/user_search",
            "per_page" =>$per_page,
            "total_rows" =>$toplam,
            'uri_segment' =>3,
            'full_tag_open' =>'<nav><ul class="pagination">',
            'full_tag_close' => '</ul></nav>',
            'cur_tag_open' => '<li><a href="#" style="color:#ffffff; background-color:#258BB5;">',
            'cur_tag_close' => '</a></li>',
            'num_tag_open' => '<li>',  'num_tag_close' => '</li>',
            'prev_tag_open'=> '<li>', 'prev_tag_close'=> '<li>',
            'next_tag_open'=> ' <li>',  'next_tag_close'=> '<li>',
            'first_tag_open'=> ' <li>', 'first_tag_close'=> '<li>',
            'last_tag_open'=> ' <li>', 'last_tag_close'=> '<li>',
        );

        $this->pagination->initialize($config);
        $data->links=$this->pagination->create_links();
        $data->header=$this->load->view('header');
        $data->context=$this->load->view('panel/user/user_lists',$data);
        $data->footer=$this->load->view('footer');
        $this->load->view('panel/panel', $data,TRUE);
    }

    public function user_locations(){
        $data = new stdClass();

        $idusers = trim(strip_tags($this->uri->segment(3)));

        $data->idusers=$idusers;
        $data->context=$this->load->view('panel/user/user_locations',$data);
        $this->load->view('panel/panel', $data,TRUE);
    }

    public function user_map_lists(){
        $idusers = trim(strip_tags($this->uri->segment(3)));

        $map_lists=$this->panel_model->user_map_lists($idusers);
        $places=array();
        $id=1;
        foreach( $map_lists as $index => $row){
            $title="";
            $description="";
            $lat="";
            $lng="";
            foreach ($row as $rows=>$values){
                if($rows=="idlocations"){
                    $title=$id.'. Lokasyon';
                }else if($rows=="time"){
                    $description='Tarih: '.$values;
                }else if($rows=="latitude"){
                    $lat=$values;
                }else if($rows=="longitude"){
                    $lng=$values;
                }
            }
            array_push($places,array('title'=>$title,'description'=>$description,'lat'=>$lat,'lng'=>$lng));
            $id++;
        }

        $this->output
            ->set_content_type('application/json', 'UTF-8')
            ->set_output(json_encode(array('places'=>$places)));
    }
    public function user_delete(){
        $idusers = trim(strip_tags($this->uri->segment(3)));

        if($this->panel_model->user_delete($idusers))
            $this->session->set_flashdata('success', 'Silme Kaydı Gerçekleşti.');
        else
            $this->session->set_flashdata('error', 'Silme Kaydı Gerçekleşmedi!');

        redirect(site_url('panel/user_lists'));
    }

    public function user_status(){
        $idusers = trim(strip_tags($this->uri->segment(3)));
        $status = trim(strip_tags($this->uri->segment(4)));

        if($this->panel_model->user_status($idusers,$status))
            $this->session->set_flashdata('success', 'Aktif/Pasif İşleminiz Gerçekleşti.');
        else
            $this->session->set_flashdata('error', 'Aktif/Pasif İşleminiz Gerçekleşmedi!');

        redirect(site_url('panel/user_lists'));
    }

    public function user_web(){
        $idusers = trim(strip_tags($this->uri->segment(3)));
        $web = trim(strip_tags($this->uri->segment(4)));

        if($this->panel_model->user_web($idusers,$web))
            $this->session->set_flashdata('success', 'Aktif/Pasif İşleminiz Gerçekleşti.');
        else
            $this->session->set_flashdata('error', 'Aktif/Pasif İşleminiz Gerçekleşmedi!');

        redirect(site_url('panel/user_lists'));
    }

    public function user_update(){
        // create the data object
        $data = new stdClass();

        // load form helper and validation library
        $this->load->helper('form');
        $this->load->library('form_validation');

        $idusers = trim(strip_tags($this->uri->segment(3)));
        // set validation rules
        $this->form_validation->set_rules('name', 'Name', 'required');
        $this->form_validation->set_rules('surname', 'Surname', 'required');
        $this->form_validation->set_rules('email', 'EMail', 'trim|required|valid_email');
        $this->form_validation->set_rules('imei', 'IMEI', 'required');


        if ($this->form_validation->run() == false) {

        } else {
            // set variables from the form
            $name = $this->input->post('name');
            $surname = $this->input->post('surname');
            $email = $this->input->post('email');
            $imei = $this->input->post('imei');

            if ($this->panel_model->update_user($idusers,$name,$surname, $email,$imei)) {
                $data->success = 'Başarılıyla kullanıcı düzenlendi!';
            }else{
                $data->error = 'Başarısız kullanıcı düzenlenemedi!';
            }
        }

        $data->user = $this->panel_model->user_update_row($idusers);
        $data->header=$this->load->view('header');
        $data->context=$this->load->view('panel/user/user_update',$data);
        $data->footer=$this->load->view('footer');
        $this->load->view('panel/panel', $data,TRUE);
    }
}