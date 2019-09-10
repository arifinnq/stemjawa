<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Welcome extends CI_Controller {
	
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
	public function index()
	{
		$this->load->view('welcome_message');

	}


	function cekKamus($kata){
		// cari di database
		$sql  = $this->db->query("SELECT * FROM tbtembung WHERE tembung = '$kata' LIMIT 1");
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
			return $__kata; // Jika ada balik
			}
		}
		//ma, ka, sa, pa, a
		if(preg_match("/^([mksp]a|a)/",$kata)){ 
			$__kata = preg_replace("/^([mksp]a|a)/","",$kata);
			if($this->cekKamus($__kata)){
			return $__kata; // Jika ada balik
			}
		}
		//pra, tar
		if(preg_match("/^(pra|tar)/",$kata)){ 
			$__kata = preg_replace("/^(pra|tar)/","",$kata);
			if($this->cekKamus($__kata)){
			return $__kata; // Jika ada balik
			}
		}
		// kuma, kami, kapi
		if(preg_match("/^(kuma|kami|kapi)/",$kata)){ 
			$__kata = preg_replace("/^(kuma|kami|kapi)/","",$kata);
			if($this->cekKamus($__kata)){
			return $__kata; // Jika ada balik
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
			return $__kata__; // Jika ada balik
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
			return $__kata;
				}
			}
		
		// ake, ane, ke, ana, na, ku, mu, en
		if(preg_match("/(ake|ane|ke|ana|na|ku|mu|en|an|ne)$/",$kata)){ // Cek Suffixes
			$__kata = preg_replace("/(ake|ane|ke|ana|na|ku|mu|en|an|ne)$/","",$kata);
			if($this->cekKamus($__kata)){ // Cek Kamus
			return $__kata;
				}
			}

		return $tempkata;

	}

	function hapus_konfiks($kata){
		$tempkata = $kata;
		$akhiran = "i|e|a|an|ana|ake";
		
		/* —— Tentukan Tipe Gabungan Akhiran dan Awalan ————*/
		// ka, pa, m, di
		if(preg_match("/^(ka|pa|m|di)/",$kata)){ 
			$__kata = preg_replace("/^(ka|pa|m|di)/","",$kata);
			$__kata = preg_replace("/(".$akhiran.")$/","",$__kata);
			if($this->cekKamus($__kata)){ // Cek Kamus
			return $__kata;
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
				return $__kata__; // Jika ada balik
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
				return $__kata__; // Jika ada balik
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
			return $__kata; // Jika ada balik
			}
		
		}

		//in
		if(preg_match("/(in)/",$kata)){ 
			$__kata = preg_replace("/(in)/","",$kata);
			if($this->cekKamus($__kata)){
			return $__kata; // Jika ada balik
			}
		
		}
		
		//kum
		if(preg_match("/(kum)/",$kata)){ 
			$__kata = preg_replace("/(kum)/","p",$kata);
			if($this->cekKamus($__kata)){
			return $__kata; // Jika ada balik
			}
		}

		//gum
		if(preg_match("/(gum)/",$kata)){ 
			$__kata = preg_replace("/(gum)/","b",$kata);
			if($this->cekKamus($__kata)){
			return $__kata; // Jika ada balik
			}
		}

		//um
		if(preg_match("/(um)/",$kata)){ 
			$__kata = preg_replace("/(um)/","",$kata);
			if($this->cekKamus($__kata)){
			return $__kata; // Jika ada balik
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

			return $__kata__."-".$__kata__;		   	
		   }

		   if ($__kata[0]!=$__kata[1]) {
   			  $__kata__ = '';
			  $__kata__ .=$this->stemjawa($__kata[0]); // Jika Ada kembalikan
			  $__kata__ .="-".$this->stemjawa($__kata[1]); // Jika Ada kembalikan

			return $__kata__;		   	
		   }

		}

		if (substr($kata,1,2)==substr($kata,3,4)||substr($kata,1,2)!=substr($kata,3,4)) {
			if($this->cekKamus($__kata=substr($kata,2))){
			return $__kata; // Jika ada balik
			}	
		}

		$dumpsubstr=substr($kata,2,3);
		if(preg_match("/(".$dumpsubstr.")/",$kata)){ 
			// var_dump($dumpsubstr);die();	
			$__kata = preg_replace("/(".$dumpsubstr.")/","",$kata);
			if($this->cekKamus($__kata)){
			return $__kata; // Jika ada balik
			}
		}

		return $tempkata;
	}

	function stemjawa($kata){
		$tempkata = $kata;
		
		/* 1. Cek Kata di Kamus jika Ada SELESAI */
		if($this->cekKamus($kata)){ // Cek Kamus
		return $kata; // Jika Ada kembalikan
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

		return $kata;
		
	}

	function mulai(){
		$katas="rajapati ing pereng wilis rumangsane anggone ngliyep isih durung patiya suwe nalika nggantere telpun gegem kang tumumpang kenap cilik kuwi nggugah turune gragaban telpun gage disaut sing kacetha ing layar handphone nomer telpun omah nitik kodhe areane pawongan sing lagi ngebel kuwi saka wewengkon tulungagung disawang sakeplasan penuduhe wektu ing telpun seluler kasebut ngatonake angka halo sinten nggih halo dhik setyawan iki aku dhik aku amongdenta pangapura sing gedhe ya nek telpunku ngagetake anggonmu sare swarane pawongan ing sabrang kana oh mas amongdenta ta tak kira sapa ora dadi ngapa malah aku maturnuwun dene wis digugah piye mas enek apa kok njanur gunung ngebel aku pitakone setyawan karo njenggelek kemule disingkap dhik apa kowe bisa tindak menyang widarakandhang saiki uga penting banget dhik sik mas widarakandhang ki sisih ngendi aku kok rada lali alah kuwi lho kantor kecamatan sendhang munggah pratelon manahilan menggok nengen lokasine neng ndhuwur dhewe swarane pawongan ing sabrang kana aweh pituduh tenan ya dhik dakenteni tekamu iki maeng anggotaku sing tugas piket mentas entuk lapuran menawa neng widarakandhang ana rajapati penake awake dhewe langsung ketemu neng lokasi wae ya swarane priya kuwi nyrateg setyawan ngringkesi kemule dheweke banjur menyang jedhing saperlu adus lan amek wudhu lebar nindakake shalat subuh setyawan banjur budhal nunggang honda supra x lurung gedhe kediri menyang tulungagung isih sepi hawane atis nanging jaket lulang clana jins sepatu kets dalah helm tutupan iku wis cukup ngangetake awake sing kuru mung butuh wektu setengah jam lakune setyawan wis ngambah kukubaning kabupaten tulungagung mungkur ngliwati kreteg ngujang kang tumelung ana sandhuwure kali brantas setyawan menggok nengen kendharaane digelak daya daya enggala tekan papan kang dituju lakune mbandhang pandom spidho metere nyenggol angka ora ngentekake wektu telung prapat jam lakune setyawan wis mlebu wewengkoning kecamatan sendhang lurung padesan sing diambah saya suwe saya munggah mesine sepedhah motor ngeden ngeden setyawan nyuda presneleng amrih tarikane gas luwih entheng saya dhuwur dalan sing diambah pedhut esuk kang tumurun saka pucuking gunung wilis tansaya kandel hawane tansaya adhem pating trecep kiwa tengene dalan sing diliwati akeh akehe isih wujud lemah kothong kang thinukulan gegrumbulan lan maneka wit witan klebu jati lan cengkeh setyawan arang kadhing simpangan karo kendharaan tarah wancine isih esuk banget upamaa papagan karo kendharaan paling mung sepedhah motore bakul bakul sing lagi padha budhal menyang pasar kecamatan tandhane yen kuwi mau sepedhah motore bakul pernah jok mburi dipasangi obrog isi krambil pitik buwah utawa sayuran lurung aspalan sing diambah setyawan iku wekasane cuthel ing sangisore perengan lan kasambung dening dalan lemah sing luwih ciyut upama ditlusur terus mbokmenawa dalan lemah kuwi munggah nganti tekan pucuke gunung kana nanging watara sepuluh meter sadurunge entek entekane aspal mau ana lurung mlebu ing sisih tengene dalan setyawan banjur ngenggokake sepedhah motore menyang gang makadaman sing dalane ndeder kuwi swasanane wiwit repet repet tumuju padhang nalika dheweke markir kendharaane ing lokasi rajapati wis ana sawatara anggota pulisi pakeyan preman sing pinuju ngupengi kunarpa weruh tekane setyawan komisaris pulisi amongdenta gita gita anggone mapagake kae dhik kunarpane isih dititipriksa anggotaku anggotaku wis miwiti olah tkp ning posisine kunarpa durung di owahi kok ayo pirsanana kana setyawan nyedhak mbrobos tali garis pulisi werna kuning sing dipasang malangi dalan sawatara anggota reserse lan unit identifikasi sing lagi nandangi olah tkp rada nyisih aweh enggon setyawan melu nitipriksa jisim layon kuwi wis ketara pucet njrebabah mujur ngalor anggane isih kebungkus jas udan nanging tita yen kurban menganggo busana bathik clanane diwingkis wates dhengkul sikile nyeker lan sirahe Ah sirah kuwi remuk setyawan jengkeng nyetitekake nggon perangan tatu kalamangsa sirahe nengklang nengkleng kareben bisa nyawang tatu iku saka maneka arah drijine uga kober ndudul ndudul sirahe kunarpa mesthi wae sawise dheweke masang sarung tangan saka karet setyawan ganti nyetitekake kiwa tengene kunarpa ora tinemu sisa sisane getih mblambang utawa muncratan isen isening sirah ora adoh saka gumlethake jisim ana sepedhah motor yamaha jupiter z ing kahanan rubuh njekangkang sepedhah motor iku isih gres rupane ireng meles mawa kombinasi stiker rupa emas setyawan banjur menyat nyedhaki kendharaan kuwi ora ana perangan sing rusak rubuhe sepedhah motor sajake disebabake dening amblese jagang merga lemahe teles kunci kontake isih cemanthel ana jok sajake nalika kurban kuwi diperjaya dheweke mentas wae mbukak jok lan durung kober njabut kuncine helm standar werna ireng kontal sawatara meter spone njebeber merga posisine mlumah ana sacedhake helm setyawan nemokake dhompet kulit werna ireng kang isih ngecemes banyu dhompet diiling ilingi sedhela banjur dilebokake sake jaket piye dhik apa kowe wis nemokake titikan awal pitakone amongdenta sawise nyaketi setyawan setyawan ora tumuli wangsulan bathuke njengkerut alise gathuk kaya lagi mikir perkara sing serius cetha nek wong iki tiwas merga diprajaya ora mati merga tiba saka sepedhah motore sapa sing merjaya durung bisa dakkira kira ning sing cetha durjanane wengis banget celathune setyawan bener dhik iki pancen rajapati sing wengis mbokmenawa kawengisane durjana ngluwihi sato galak komisaris amongdenta nanggapi saka pangiraku rajapati iki kedadeyan wingi sore utawa saora orane wanci surup surya merga kahanane kunarpa wis pucet lan ora seger maneh ning puceting jisim kuwi rak bisa uga krana kegrujug banyu udan ta dhik sebab meh sewengi natas udane ngrecih terange lagi ngarepake subuh iki mau mula getihe kurban ya wis ilang wong wis kentir bareng karo iline banyu udan saka ndhuwur kono rak iya ta bisa uga mengkono mas lan ya Jalaran udan sing ora terang terang mau awake dhewe dadi kangelan nggoleki tlacaking durjana awit tabeting durjana wis ilang kesiram banyu udan komisaris amongdenta nggresah ujare aku wis mbadhe nek iki mesthi golonganing kasus sing rumit mula aku banjur keraya raya nilpun menyang kediri kuwi pamrihku supaya dhik setyawan kersa sabiyantu ngudhari wewadining rajapati iki kowe ngerti dhik aku durung suwe dibenum ana wewengkon kene yen ora tumuli bisa miyak rajapati iki kondhiteku ana sangarepe kapolres bakal kucem ing kene aku mung saderma udhu panemu lan urun pemikiran adhedhasar analisisku mas ning sing tandang gawe neng lapangan tetepa penjenengan sarta andhahan penjenengan kang dumadi saka anggota reserse lan unit identifikasi kuwi iya aku ngerti ning jroning swasana sing kaya mengkene iki aku banget mbutuhake analisis analisismu kuwi dhik sebab kowe wis kondhang nduweni analisa sing landhep kanggo miyak kadurjanan sapa sing ora ngakoni kawaskithane dhetektip setyawan sing dialembana mesem ing bang wetan srengengene saya munjuk kencar kencar sorote sing kuning pindhane emas sinangling nampeg njenggelege gunung wilis kang katon ijo royo royo mbaka sethithik pedhute sumilak njalari atising hawa dadi rada suda dhik nek saka pandugamu kira kira gegamane durjana sing kanggo mrejaya kurban kuwi jinis apa amongdenta nyoba nggathukake pangira irane dhewe karo pangira irane setyawan nek ndulu tatune anggone mrejaya genah nganggo gegaman kang anteb utawa bisa uga anteb tur landhep mbuh kuwi linggis wesi gligen wadung utawa ganco amongdenta manggut manggut nuli kira kira motife apa ya dhik aku durung bisa matur mas sebab upama durjanane melik marang bandhane kurban nyatane sepedhah motore isih wutuh kuncine cemanthel nek durjanane kepengin nggawa mlayu rak gampang banget ta lagi wae setyawan mingkem dumadakan keprungu pamberunge mesin sepedhah motor mara susul sumusul mesine nggembor nggembor ngunggahi lurung makadaman sawise njagang kendharaane rong meter saka garis pulisi nom noman nenem kalungan keplek lan nyangklek rangsel kuwi tranyak tranyak mrepegi amongdenta hadhuh matek aku saka ngendi wartawan wartawan iku krungu nek neng kene ana rajapati celathune amongdenta karo njambaki rambute dhewe";
		$kata = explode(" ",$katas);
		$stemming ="";
		echo "teks asli : ".$katas."<br><br>"; 
		$jumlah = count($kata);
		for( $i =0; $i < $jumlah; $i++){
		$stemming .= $this->stemjawa($kata[$i])."<br/> ";//Memasukkan kata ke fungsi Algoritma
		}
		echo "teks stem : ".$stemming."<br><br>";
		$this->load->view('welcome_message');
	}

	// function cekData(){
	// 	// cari di database
	// 	$sql  = $this->db->query("SELECT * FROM tbartikel")->result();
		
	// 	$katas = "";
	// 	foreach ($sql as $kata) {
	// 		$katas .=$kata->isi;
	// 	}
	// 	$kata = explode(" ",$katas);
	// 	$jumlah = count($kata);
	// 	echo $jumlah;
	// }
}
