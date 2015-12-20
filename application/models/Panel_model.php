<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * User_model class.
 *
 * @extends CI_Model
 */
class Panel_model extends CI_Model {

    /**
     * __construct function.
     *
     * @access public
     * @return void
     */
    public function __construct() {

        parent::__construct();
        $this->load->database();

    }

    /**
     * create_user function.
     *
     * @access public
     * @param mixed $name
     * @param mixed $surname
     * @param mixed $email
     * @param mixed $password
     * @param mixed $imei
     * @param mixed $status
     * @param mixed $web
     * @return bool true on success, false on failure
     */
    public function create_user($name,$surname, $email, $password,$imei,$status,$web) {

        $data = array(
            'name'   => $name,
            'surname'   => $surname,
            'email'      => $email,
            'password'   => $this->hash_password($password),
            'imei'      => $imei,
            'status'      => $status,
            'web'      => $web,
            'created_at' => date('Y-m-j H:i:s'),
        );

        return $this->db->insert('users', $data);
    }

    /**
     * update_user function.
     *
     * @access public
     * @param mixed $idusers
     * @param mixed $name
     * @param mixed $surname
     * @param mixed $email
     * @param mixed $imei
     * @return bool true on success, false on failure
     */
    public function update_user($idusers,$name,$surname, $email,$imei) {
        $this->db->set('name',$name);
        $this->db->set('surname',$surname);
        $this->db->set('email',$email);
        $this->db->set('imei',$imei);
        $this->db->where('idusers', $idusers);
        return $this->db->update('users');
    }

    /**
     * search_user function.
     *
     * @access public
     * @param mixed $email
     * @param mixed $perpage
     * @param mixed $segment
     * @return bool true on success, false on failure
     */
    public function search_user($email,$perpage,$segment) {
        $this->db->select("idusers,name,surname,email,status,web");
        $this->db->like('email',$email);
        $this->db->from("users");
        $this->db->limit($perpage,$segment); // sql sorgumuzu limitleyelim
        $query=$this->db->get();
        return $query->result();
    }

    /**
     * user_lists function.
     *
     * @access public
     * @param mixed $perpage
     * @param mixed $segment
     * @return bool true on success, false on failure
     */
    public function user_lists($perpage,$segment){
        $this->db->select("idusers,name,surname,email,status,web");
        $this->db->from("users");
        $this->db->limit($perpage,$segment); // sql sorgumuzu limitleyelim
        $query=$this->db->get();
        return $query->result();
    }

    /**
     * user_map_lists function.
     *
     * @access public
     * @param mixed $idusers
     * @return bool true on success, false on failure
     */
    public function user_map_lists($idusers){
        $this->db->select("idlocations,idusers,latitude,longitude,time");
        $this->db->from("locations");
        $this->db->where("idusers",$idusers);
        $query=$this->db->get();
        return $query->result();
    }

    /**
     * user_map_now function.
     *
     * @access public
     * @param mixed $idusers
     * @return bool true on success, false on failure
     */
    public function user_map_now($idusers){
        $this->db->select("idlocationnow,idusers,latitude,longitude,time");
        $this->db->from("location_now");
        $this->db->where("idusers",$idusers);
        $query=$this->db->get();
        return $query->result();
    }

    /**
     * user_update_row function.
     *
     * @access public
     * @param mixed $idusers
     * @return bool true on success, false on failure
     */
    public function user_update_row($idusers){
        $this->db->select("idusers,name,surname,email,imei");
        $this->db->from("users");
        $this->db->where("idusers",$idusers);
        $query=$this->db->get();
        return $query->result();
    }

    /**
     * user_status function.
     *
     * @access public
     * @param mixed $idusers
     * @param mixed $status
     * @return bool true on success, false on failure
     */
    public function user_status($idusers,$status){
        $this->db->set('status',$status);
        $this->db->where('idusers', $idusers);
        return $this->db->update('users');
    }

    /**
     * user_delete function.
     *
     * @access public
     * @param mixed $idusers
     * @return bool true on success, false on failure
     */
    public function user_delete($idusers){
        $this->db->where('idusers', $idusers);
        return $this->db->delete('users');
    }

    /**
     * user_web function.
     *
     * @access public
     * @param mixed $idusers
     * @param mixed $web
     * @return bool true on success, false on failure
     */
    public function user_web($idusers,$web){
        $this->db->set('web',$web);
        $this->db->where('idusers', $idusers);
        return $this->db->update('users');
    }

    /**
     * user_count function.
     *
     * @access public
     * @param
     * @return bool true on success, false on failure
     */
    public function user_count(){
        $sql="select COUNT(idusers) AS toplam from users";
        $query=$this->db->query($sql);
        $sonuc=$query->result();
        return $sonuc[0]->toplam;
    }

    /**
     * user_date_search function.
     *
     * @access public
     * @param mixed $idusers
     * @param mixed $starttime
     * @param mixed $endtime
     * @return bool true on success, false on failure
     */
    public function user_date_search($idusers,$starttime,$endtime){
        $this->db->select("idlocations,idusers,latitude,longitude,time");
        $this->db->from("locations");
        $this->db->where("idusers",$idusers);
        $this->db->where('time >',date('Y-m-d', strtotime($starttime)));
        $this->db->where('time <',date('Y-m-d', strtotime($endtime)));
        $query=$this->db->get();
        return $query->result();
    }


    /**
     * user_search_count function.
     *
     * @access public
     * @param   $email
     * @return bool true on success, false on failure
     */
    public function user_search_count($email){
        $sql="select COUNT(idusers) AS toplam from users where email LIKE '%{$email}%'";
        $query=$this->db->query($sql);
        $sonuc=$query->result();
        return $sonuc[0]->toplam;
    }

    /**
     * password_change function.
     *
     * @access public
     * @param mixed $password
     * @param mixed $idusers
     * @return bool true on success, false on failure
     */
    public function password_change($password,$idusers) {
        //return $this->db->where('id', $userId)->update("users", array('firstName' => $newFirstName));
        $this->db->set('password',$this->hash_password($password));
        $this->db->where('idusers', $idusers);
        return $this->db->update('users');
    }

    /**
     * hash_password function.
     *
     * @access private
     * @param mixed $password
     * @return string|bool could be a string on success, or bool false on failure
     */
    private function hash_password($password) {

        return password_hash($password, PASSWORD_BCRYPT);
    }
}