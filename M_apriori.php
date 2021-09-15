<?php
defined('BASEPATH') OR exit('No direct script access allowed');


class M_apriori extends CI_Model {

    // Get Apriori & filter support / confidence
    public function get($filter1, $filter2)
    {
        if(empty($filter1) && empty($filter2))
        {
        $query = $this->db->query("SELECT diagnosa_pasien.jenis_kelamin as jk, diagnosa_pasien.kategori_usia as usia, diagnosa_pasien.diagnosa diag, concat(diagnosa_pasien.jenis_kelamin, diagnosa_pasien.kategori_usia, diagnosa_pasien.diagnosa) as jk_katUsia, COUNT(diagnosa_pasien.id_diagnosa_pasien) as total_kasus, 
        ROUND((COUNT(diagnosa_pasien.id_diagnosa_pasien) / (SELECT COUNT(*) FROM diagnosa_pasien))*100, 1) as support,
        ROUND((COUNT(diagnosa_pasien.id_diagnosa_pasien) / (SELECT COUNT(*) FROM diagnosa_pasien WHERE diagnosa_pasien.jenis_kelamin=jk))*100, 1) as confidence
        FROM diagnosa_pasien
        GROUP BY concat(diagnosa_pasien.jenis_kelamin, diagnosa_pasien.kategori_usia, diagnosa_pasien.diagnosa)")->result();

        return $query;
        } else {
      
      $query = $this->db->query("SELECT jk, usia, diag, support, confidence FROM(
        SELECT diagnosa_pasien.jenis_kelamin as jk, diagnosa_pasien.kategori_usia as usia, diagnosa_pasien.diagnosa diag, concat(diagnosa_pasien.jenis_kelamin, diagnosa_pasien.kategori_usia, diagnosa_pasien.diagnosa) as jk_katUsia, COUNT(diagnosa_pasien.id_diagnosa_pasien) as total_kasus, 
        ROUND((COUNT(diagnosa_pasien.id_diagnosa_pasien) / (SELECT COUNT(*) FROM diagnosa_pasien))*100, 1) as support,
        ROUND((COUNT(diagnosa_pasien.id_diagnosa_pasien) / (SELECT COUNT(*) FROM diagnosa_pasien WHERE diagnosa_pasien.jenis_kelamin=jk))*100, 1) as confidence
        FROM diagnosa_pasien
        GROUP BY concat(diagnosa_pasien.jenis_kelamin, diagnosa_pasien.kategori_usia, diagnosa_pasien.diagnosa))t1 
        WHERE support >= $filter1 AND confidence >= $filter2")->result();

        return $query; 
        }
    }

   
}