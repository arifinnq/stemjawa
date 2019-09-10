<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Stemjawa extends CI_Controller {
	
	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see https://codeigniter.com/user_guide/general/urls.html
	 */

	public function __construct() {
    parent::__construct();
	$this->load->model('publicmodel');
    
    ini_set('max_execution_time', 0); 
	ini_set('memory_limit','2048M');
	}

	public function index()
	{
			// $this->load->model('model');
		$pilih_dokumen = $this->publicmodel->selectdata('tbteks order by id asc')->result_array();

		$data = array(
			'title'			=> 'Pemisahan Kata Dasar Bahasa Jawa Dengan Menggunakan Adaptasi Algoritma Nazief-Adriani',
			'titlesistem'	=> 'Pemisahan Kata Dasar Bahasa Jawa Dengan Menggunakan Adaptasi Algoritma Nazief-Adriani',
			'dokumen'	=>$pilih_dokumen,

		);

		if ($_POST) {
			$result = $this->stem($this->input->post('dokumenid'), $this->input->post('tokenizing'));
			
			$data['teks'] = $result['teks'];
			$data['stemming'] = $result['stemming'];
			$data['jumlah'] = $result['jumlah'];
			$data['totalstem'] = $result['totalstem'];
			$data['nostem'] =  $result['nostem'];

			// var_dump($data);die();
		}
		
		$this->load->view('public/header',$data);
		$this->load->view('public/dashboard');
		$this->load->view('public/footer');

	}


	function cekDB($kata){
		// cari di database
		$sql  = $this->db->query("SELECT * FROM tbtembung WHERE teks = '$kata'");
		$row = $sql->num_rows();
		// var_dump($row);die();
		return $row; 
		}

	function cekKamus($kata){
		// cari di database
		$sql  = $this->db->query("SELECT * FROM tbtembung WHERE teks = '$kata' LIMIT 1");
		$row = $sql->row();
		// var_dump($row);die();
		if(isset($row)){
		return true; // True jika ada
		}else{
		return false; // jika tidak ada FALSE
		}
		}

	function hapus_prefiks($kata){
		$tempkata = $kata;
		/* —— Tentukan Tipe Awalan / Ater-ater ————*/
		//dak, ko, di, ke, pi
		if(preg_match("/^(dak|kok|di|ke|pi)/",$kata)){ 
			$__kata = preg_replace("/^(dak|kok|di|ke|pi)/","",$kata);
			if($this->cekKamus($__kata)){
			return '<span style="background:green;color:white">'.$__kata.'</span>'; // Jika ada balik
			}
		}
		//ma, ka, sa, pa, a
		if(preg_match("/^([mksp]a|a)/",$kata)){ 
			$__kata = preg_replace("/^([mksp]a|a)/","",$kata);
			if($this->cekKamus($__kata)){
			return '<span style="background:green;color:white">'.$__kata.'</span>'; // Jika ada balik
			}
		}
		//pra, tar
		if(preg_match("/^(pra|tar)/",$kata)){ 
			$__kata = preg_replace("/^(pra|tar)/","",$kata);
			if($this->cekKamus($__kata)){
			return '<span style="background:green;color:white">'.$__kata.'</span>'; // Jika ada balik
			}
		}
		// kuma, kami, kapi
		if(preg_match("/^(kuma|kami|kapi)/",$kata)){ 
			$__kata = preg_replace("/^(kuma|kami|kapi)/","",$kata);
			if($this->cekKamus($__kata)){
			return '<span style="background:green;color:white">'.$__kata.'</span>'; // Jika ada balik
			}
		}
		// m, n, ng, ny
		if(preg_match("/^(m|n|ng|ny)/",$kata)){ 
		$hurufPengganti=['m', 'b', 'c', 'd', 'f', 'g', 'h', 'j', 'k', 'l', 'm', 'n', 'p', 'r', 's', 't', 'w', 'y'];
		$__kata = preg_replace("/^(m|n|ng|ny)/","",$kata);
		// var_dump($__kata);die();
		$jumlah = count($hurufPengganti);
		for( $i =0; $i < $jumlah; $i++){
			$__kata__ = $hurufPengganti[$i].$__kata;
			if($this->cekKamus($__kata__)){
			return '<span style="background:green;color:white">'.$__kata__.'</span>'; // Jika ada balik
			}
		}
		}

		return $tempkata;

	}

	function hapus_sufiks($kata){
		$tempkata = $kata;
		/* —— Tentukan Tipe Akhiran / Penambang ————*/
		// i, e, a
		if(preg_match("/(i|e|a)$/",$kata)){ // Cek Suffixes
			$__kata = preg_replace("/(i|e|a)$/","",$kata);
			if($this->cekKamus($__kata)){ // Cek Kamus
			return '<span style="background:green;color:white">'.$__kata.'</span>'; // Jika ada balik
				}
			}
		
		// ake, ane, ke, ana, na, ni, ku, mu, en
		if(preg_match("/(ake|ane|ke|ana|na|ni|ku|mu|en|an|ne)$/",$kata)){ // Cek Suffixes
			$__kata = preg_replace("/(ake|ane|ke|ana|na|ku|mu|en|an|ne)$/","",$kata);
			if($this->cekKamus($__kata)){ // Cek Kamus
			return '<span style="background:green;color:white">'.$__kata.'</span>'; // Jika ada balik
				}
			}

		return $tempkata;

	}

	function hapus_konfiks($kata){
		$tempkata = $kata;
		$akhiran = "i|e|a|an|ana|ake|ni";
		
		/* —— Tentukan Tipe Gabungan Akhiran dan Awalan ————*/
		// ka, pa, m, di
		if(preg_match("/^(ka|pa|di|mer|m)/",$kata)){ 
			$__kata = preg_replace("/^(ka|pa|di|mer|m)/","",$kata);
			$__kata = preg_replace("/(".$akhiran.")$/","",$__kata);
			if($this->cekKamus($__kata)){ // Cek Kamus
			return '<span style="background:green;color:white">'.$__kata.'</span>'; // Jika ada balik
			}
		}

		// n
		if(preg_match("/^(n)/",$kata)){ 
			$__kata = preg_replace("/^(n)/","",$kata);
			$__kata = preg_replace("/(".$akhiran.")$/","",$__kata);
			$hurufPengganti=['m', 'b', 'c', 'd', 'f', 'g', 'h', 'j', 'k', 'l', 'm', 'n', 'p', 'r', 's', 't', 'w', 'y'];
			// var_dump($__kata);die();
			$jumlah = count($hurufPengganti);
			for( $i =0; $i < $jumlah; $i++){
				$__kata__ = $hurufPengganti[$i].$__kata;
				if($this->cekKamus($__kata__)){
			return '<span style="background:green;color:white">'.$__kata__.'</span>'; // Jika ada balik
				}
			}
		}
		
		// ng, ny
		if(preg_match("/^(ng|ny)/",$kata)){ 
			$__kata = preg_replace("/^(ng|ny)/","",$kata);
			$__kata = preg_replace("/(".$akhiran.")$/","",$__kata);
			$hurufPengganti=['m', 'b', 'c', 'd', 'f', 'g', 'h', 'j', 'k', 'l', 'm', 'n', 'p', 'r', 's', 't', 'w', 'y'];
			$jumlah = count($hurufPengganti);
			for( $i =0; $i < $jumlah; $i++){
				$__kata__ = $hurufPengganti[$i].$__kata;
				if($this->cekKamus($__kata__)){
			return '<span style="background:green;color:white">'.$__kata__.'</span>'; // Jika ada balik
				}
			}
		}

		return $tempkata;

	}

	function hapus_infiks($kata){
		$tempkata = $kata;

		/* —— Tentukan Tipe Sisipan / seselan ————*/
		// ing
		if(preg_match("/(ing)/",$kata)){ 
			$__kata = preg_replace("/(ing)/","",$kata);
			// $__kata = preg_replace("/(in)/","",$kata);
			if($this->cekKamus($__kata)){
			return '<span style="background:green;color:white">'.$__kata.'</span>'; // Jika ada balik
			}
		
		}

		//in
		if(preg_match("/(in)/",$kata)){ 
			$__kata = preg_replace("/(in)/","",$kata);
			if($this->cekKamus($__kata)){
			return '<span style="background:green;color:white">'.$__kata.'</span>'; // Jika ada balik
			}
		
		}
		
		//kum
		if(preg_match("/(kum)/",$kata)){ 
			$__kata = preg_replace("/(kum)/","p",$kata);
			if($this->cekKamus($__kata)){
			return '<span style="background:green;color:white">'.$__kata.'</span>'; // Jika ada balik
			}
		}

		//gum
		if(preg_match("/(gum)/",$kata)){ 
			$__kata = preg_replace("/(gum)/","b",$kata);
			if($this->cekKamus($__kata)){
			return '<span style="background:green;color:white">'.$__kata.'</span>'; // Jika ada balik
			}
		}

		//um
		if(preg_match("/(um)/",$kata)){ 
			$__kata = preg_replace("/(um)/","",$kata);
			if($this->cekKamus($__kata)){
			return '<span style="background:green;color:white">'.$__kata.'</span>'; // Jika ada balik
			}
		}

		return $tempkata;

	}


	function hapus_perulangan($kata){
		$tempkata = $kata;
		/* —— Tentukan Tipe Perulangan / rangkep ————*/
		if(preg_match("/(-)/",$kata)){ 
		   $__kata = explode("-",$kata);
		   if ($__kata[0]==$__kata[1]) {
			  $__kata__ =$this->stemjawa($__kata[0]); // Jika Ada kembalikan

			return '<span style="background:green;color:white">'.$__kata__."-".$__kata__.'</span>'; // Jika ada balik
		   }

		   if ($__kata[0]!=$__kata[1]) {
   			  $__kata__ = '';
			  $__kata__ .=$this->stemjawa($__kata[0]); // Jika Ada kembalikan
			  $__kata__ .="-".$this->stemjawa($__kata[1]); // Jika Ada kembalikan

			return '<span style="background:green;color:white">'.$__kata__.'</span>'; // Jika ada balik
		   }

		}

		if (substr($kata,1,2)==substr($kata,3,4)||substr($kata,1,2)!=substr($kata,3,4)) {
			if($this->cekKamus($__kata=substr($kata,2))){
			return '<span style="background:green;color:white">'.$__kata.'</span>'; // Jika ada balik
			}	
		}

		$dumpsubstr=substr($kata,2,3);
		if(preg_match("/(".$dumpsubstr.")/",$kata)){ 
			// var_dump($dumpsubstr);die();	
			$__kata = preg_replace("/(".$dumpsubstr.")/","",$kata);
			if($this->cekKamus($__kata)){
			return '<span style="background:green;color:white">'.$__kata.'</span>'; // Jika ada balik
			}
		}

		return $tempkata;
	}

	function stoplist($kata){
	$stoplist  = array("apa", "sapa", "piye", "pira", "kapan", "ngapa", "genea", "kui", "kae", "kono", "iki", "iku", "sawise", "sadurunge", "wiwit", "rikala", "nalika", "sinambi", "nganti", "yen", "janji", "saupama", "supaya", "sanadyan", "kamangka", "ing", "sabab", "jalaran", "awit", "mula", "tanpa", "lan", "sarta", "tekan", "kareben", "tinimbang", "banjur", "nanging", "malah", "kanthi", "sebab", "amarga", "lajeng", "saengga", "bareng", "supados");
	$preg_replace= preg_replace('/[^A-Za-z0-9]/', ' ', strip_tags($kata));
	$lowercase = strtolower($preg_replace);
	$result = preg_replace('/\b('.implode('|',$stoplist).')\b/','.', $lowercase);
	$__kata = str_replace(" .","",$result);

	return $__kata;
	}


	function stemjawa($kata){
		$tempkata = $kata;
		
		/* 1. Cek Kata di Kamus jika Ada SELESAI */
		if($this->cekKamus($kata)){ // Cek Kamus
			return '<span style="background:green;color:white">'.$kata.'</span>'; // Jika ada balik
		}
		/* 2. Hapus Awalan / Ater-ater */
		$kata = $this->hapus_prefiks($kata);
		
		// /* 3. Hapus Akhiran / Penambang */
		$kata = $this->hapus_sufiks($kata);
		
		// /* 4. Hapus Awalan dan Akhiran / Andhahan */
		$kata = $this->hapus_konfiks($kata);
		
		// /* 5. Hapus Sisipan / seselan */
		$kata = $this->hapus_infiks($kata);
		
		// /* 6. Hapus Perulangan / rangkep */
		$kata = $this->hapus_perulangan($kata);

		return '<span style="background:red;color:white">'.$kata.'</span>'; 
		
	}



	function mulai(){
		
		$sql  = $this->db->query("SELECT * FROM tbteks")->result();
		$dokumen = count($sql);

		// for( $i =0; $i < $dokumen; $i++){
		// $stoplist=$this->stoplist($sql[$i]->isi);
		// $kata = explode(" ",$stoplist);
		// $kataunik = array_unique($kata);

		// $stemming ="";
		// $totalstem =0;
		// $nostem=0;
		// // echo "teks asli : ".$sql[0]->isi."<br><br>"; 
		// $jumlah = count($kataunik);
		// var_dump($jumlah); die();
		// for( $a =0; $a < $jumlah; $a++){
		// $stemming .= $this->stemjawa($kata[$a])." ";//Memasukkan kata ke fungsi Algoritma
		
		//  ($this->cekDB(strip_tags($this->stemjawa($kata[$a]))) !=0 ) ? $totalstem =$totalstem +1 : $nostem =$nostem +1;
		
		// }
		// // echo "teks stem : ".$stemming."<br><br>";
		// echo "total teks : ".$jumlah."<br><br>";
		// echo "total stem : ".$totalstem." // ".($totalstem/$jumlah*100)." %<br><br>";
		// echo "tidak terstem : ".$nostem." // ".($nostem/$jumlah*100)." %<br><br>";


		// }

		$stemming ="";
		$stemming2 ="";
		for( $i =0; $i < $dokumen; $i++){
		// $stemming .=$sql[$i]->isi;
		$stemming .=$sql[$i]->isi;
		
		}
		$stoplist = $this->stoplist($stemming);
		$kata =  explode(" ",$stoplist);
		$kataunik = array_unique($kata);
		// var_dump($kataunik); die();
		$jumlah = count($kata);
		// var_dump($kataunik[0]); die();
		$totalstem =0;
		$nostem=0;
		// echo "teks asli : ".$sql[0]->isi."<br><br>"; 
		for( $a =0; $a < $jumlah; $a++){
		// $stemming2 .= $this->stemjawa($kataunik[$a])." ";//Memasukkan kata ke fungsi Algoritma
		
		 if ($this->cekDB(strip_tags($this->stemjawa($kata[$a]))) !=0 ) {
		 	$totalstem =$totalstem +1;
		 	} else { 
		 	$nostem =$nostem +1;
		   } 
		// var_dump($this->cekDB(strip_tags($this->stemjawa($kataunik[$a])))); die();
		}
		echo "teks stem : ".$stemming2."<br><br>";
		echo "total teks : ".$jumlah."<br><br>";
		echo "total stem : ".$totalstem." // ".($totalstem/$jumlah*100)." %<br><br>";
		echo "tidak terstem : ".$nostem." // ".($nostem/$jumlah*100)." %<br><br>";
		
		// var_dump($stemming); die();



		$this->load->view('welcome_message');
	}


	function stem($id,$tokenizing){
		

		$sql  = $this->db->query("SELECT * FROM tbteks WHERE id =$id")->result();
		
		$teks =$sql[0]->isi;
		if ($tokenizing == true) {
		$teks = $this->stoplist($teks);
		}
		$kata =  explode(" ",$teks);

		$jumlah = count($kata);

		$totalstem =0;
		$nostem=0;
		
		$stemming ="";
		for( $a =0; $a < $jumlah; $a++){
		$stemming .= $this->stemjawa($kata[$a])." ";//Memasukkan kata ke fungsi Algoritma
		
		 if ($this->cekDB(strip_tags($this->stemjawa($kata[$a]))) !=0 ) {
		 	$totalstem =$totalstem +1;
		 	} else { 
		 	$nostem =$nostem +1;
		   } 

		}
		$data['teks'] = $teks;
		$data['stemming'] = $stemming;
		$data['jumlah'] = $jumlah;
		$data['totalstem'] = $totalstem;
		$data['nostem'] =  $nostem;
		return $data;

	}

	function kata_dasar(){
		$data_kata_dasar = $this->publicmodel->selectdata('tbtembung order by teks desc')->result_array();

			$data = array(
			'title'			=> 'Pemisahan Kata Dasar Bahasa Jawa Dengan Menggunakan Adaptasi Algoritma Nazief-Adriani',
			'titlesistem' => 'Pemisahan Kata Dasar Bahasa Jawa Dengan Menggunakan Adaptasi Algoritma Nazief-Adriani',
				'data_kata_dasar'		=> $data_kata_dasar,
			);
			
			$this->load->view('public/header',$data);
			$this->load->view('public/data_kata_dasar');
			$this->load->view('public/footer');
	}	

	function kata_stopword(){
		$data_kata_stopword = $this->publicmodel->selectdata('tbstoplist order by teks desc')->result_array();

			$data = array(
			'title'			=> 'Pemisahan Kata Dasar Bahasa Jawa Dengan Menggunakan Adaptasi Algoritma Nazief-Adriani',
			'titlesistem' => 'Pemisahan Kata Dasar Bahasa Jawa Dengan Menggunakan Adaptasi Algoritma Nazief-Adriani',
				'data_kata_stopword'		=> $data_kata_stopword,
			);
			
			$this->load->view('public/header',$data);
			$this->load->view('public/data_kata_stopword');
			$this->load->view('public/footer');
	}	

	function uji_dokumen(){
		$data_uji_dokumen = $this->publicmodel->selectdata('tbteks order by 1 desc')->result_array();

			$data = array(
			'title'			=> 'Pemisahan Kata Dasar Bahasa Jawa Dengan Menggunakan Adaptasi Algoritma Nazief-Adriani',
			'titlesistem' => 'Pemisahan Kata Dasar Bahasa Jawa Dengan Menggunakan Adaptasi Algoritma Nazief-Adriani',
				'data_uji_dokumen'		=> $data_uji_dokumen,
			);
			
			$this->load->view('public/header',$data);
			$this->load->view('public/data_uji_dokumen');
			$this->load->view('public/footer');
	}	

}
