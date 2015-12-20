<?php
namespace gpstakipsistemi\lib\type
{
    /*
    *@Package GPSTAKİPSİSTEMİ
    *@Author Ahmet ÇAKIRCI <ahmetcakirci@gmail.com>
    *@Version 1.0
    *@Description
    *@Copyright
    *@Date October 2015
    */
    use gpstakipsistemi\lib\database\DB;
    class method
    {
        public function __construct(){}
        public function login($email,$password,$imei){
            $result=array();
            $count=DB::getVar("Select count(idusers) as count From users WHERE email=? and imei=?",array($email,$imei));
            if($count>0){
                $getRow= DB::getRow("Select * From users WHERE email=? and imei=?",array($email,$imei));
                if($this->verify_password_hash($password,$getRow->password))
                {
                    if((int)$getRow->status==1){
                        $result['success']=true;
                        $result['message']='Başarılı giriş yapıldı.';
                        $result['properties']=array(array('idusers'=>$getRow->idusers,
                                                    'name'=>$getRow->name,
                                                    'surname'=>$getRow->surname));
                    }else{
                        $result['success']=false;
                        $result['message']='Pasif durumda olduğu için giriş yapamamaktasınız!';
                        $result['properties']=array();
                    }
                }
                else
                {
                    $result['success']=false;
                    $result['message']='İlgili kullanıcının şifresi yanlıştır!';
                    $result['properties']=array();
                }
            }
            else
            {
                $result['success']=false;
                $result['message']='İlgili kullanıcı sistemde kayıtlı bulunmamaktadır!';
                $result['properties']=array();
            }
            return $result;
        }

        public function location_now($iduser,$latitude,$longitude){
            $result=array();
            $count=DB::getVar("Select count(idusers) as count From users WHERE idusers=?",array($iduser));
            if($count>0){
                $getCount= DB::getVar("Select count(idusers) as count From location_now WHERE idusers=?",array($iduser));
                if($getCount>0)
                {
                    $getLocCount= DB::getVar("Select count(idusers) as count From locations WHERE idusers=? and time>DATE_SUB(NOW(), INTERVAL 5 MINUTE)",array($iduser));
                    if($getLocCount==0){
                        DB::InsertOrUpdate("Insert Into locations(idusers,latitude,longitude,time) VALUES(?,?,?,NOW())",array($iduser,$latitude,$longitude));
                    }

                    $update=DB::InsertOrUpdate("Update location_now Set latitude=?,longitude=?,time=NOW() Where idusers=?",array($latitude,$longitude,$iduser));
                    $result['success']=true;
                    $result['message']='İşlem başarılı';
                }
                else
                {
                    $getLocCount= DB::getVar("Select count(idusers) as count From locations WHERE idusers=? and time>DATE_SUB(NOW(), INTERVAL 5 MINUTE)",array($iduser));
                    if($getLocCount==0){
                        DB::InsertOrUpdate("Insert Into locations(idusers,latitude,longitude,time) VALUES(?,?,?,NOW())",array($iduser,$latitude,$longitude));
                    }

                    $insert=DB::InsertOrUpdate("Insert Into location_now(idusers,latitude,longitude,time) VALUES(?,?,?,NOW())",array($iduser,$latitude,$longitude));
                    $result['success']=true;
                    $result['message']='İşlem başarılı';
                }
            }
            else
            {
                $result['success']=false;
                $result['message']='İlgili kullanıcı sistemde kayıtlı bulunmamaktadır!';
            }
            return $result;
        }

        public function locations($iduser){
            $result=array();
            $count=DB::getVar("Select count(idusers) as count From users WHERE idusers=?",array($iduser));
            if($count>0){
                $getAll= DB::get("Select * From locations WHERE idusers=?",array($iduser));

                $result['success']=true;
                $result['message']='İşlem başarılı.';
                $result['locations']=array();
                foreach($getAll as $row){
                    array_push ($result['locations'],array('latitude'=>$row->latitude, 'longitude'=>$row->longitude,'time'=>$row->time));
                }
            }
            else
            {
                $result['success']=false;
                $result['message']='İlgili kullanıcı sistemde kayıtlı bulunmamaktadır!';
                $result['locations']=array();
            }
            return $result;
        }

        private function verify_password_hash($password, $hash) {

            return password_verify($password, $hash);
        }
    }
}