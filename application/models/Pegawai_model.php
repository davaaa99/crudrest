<?php

class Pegawai_model extends CI_Model{
    public function getPegawai($id = null){

        if($id == null){
            return $this->db->get('pegawai')->result();
        }else{
            return $this->db->get_where('pegawai',['id' => $id])->result();
        }
        
    }
    public function pegawaidelete($id){
        $this->db->delete('pegawai',['id'=>$id]);
        return $this->db->affected_rows();
    }

    public function createPegawai($data)
    {
        $this->db->insert('pegawai',$data);
        return $this->db->affected_rows();
    }

    public function updatePegawai($data,$id)
    {
        $this->db->update('pegawai', $data, ['id' => $id]);
        return $this->db->affected_rows();
    }

    

}
?>