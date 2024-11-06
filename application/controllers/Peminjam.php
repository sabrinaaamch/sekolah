<?php
class Peminjam extends CI_Controller
{

	public function __construct()
	{
		parent::__construct();
		if (null == $this->session->level) {
			redirect('auth');
		} else {
			if ($this->session->level != "Peminjam") {
				redirect('auth', 'refresh');
			}
		}
		$this->load->helper('tgl_indo');
	}

	public function index()
	{
		$data['title'] = 'Peminjaman Lab';
		$data['user'] = $this->session->userdata('id_user');
		$data['username'] = $this->session->userdata('username');

		$data['ruangan'] = $this->m_siplabs->get_data('ruangan')->result();
		// $data['ruangan'] = $this->db->get('ruangan')->result();
		$this->load->view('templates/header', $data);
		$this->load->view('peminjam/dashboard', $data);
		$this->load->view('templates/footer');
	}

	// PINJAM
	public function pinjam()
	{
		$id_user = $this->input->post('id_user');
		$id_ruangan = $this->input->post('id_ruangan');
		$jam_mulai = $this->input->post('jam_mulai');
		$jam_berakhir = $this->input->post('jam_berakhir');
		$tanggal = $this->input->post('tanggal');
		$keterangan = $this->input->post('keterangan');

		$array = [
			'id_peminjaman' => null,
			'id_user' => $id_user,
			'id_ruangan' => $id_ruangan,
			'jam_mulai' => $jam_mulai,
			'jam_berakhir' => $jam_berakhir,
			'tanggal' => $tanggal,
			'keterangan' => $keterangan,
			'status_peminjaman' => 0
		];

		$cek_user = $this->db->query('SELECT * FROM peminjaman WHERE id_user=' . $id_user . ' AND status_peminjaman=1' . ' OR status_peminjaman=0')->row_array();
		$waktu_sekarang = date('H:i');
		$durasi = strtotime($jam_berakhir) - strtotime($jam_mulai);

		if ($cek_user) {
			$this->session->set_flashdata('message', '<div class="alert alert-warning alert-dismissible">
				<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
				<h5><i class="icon fas fa-ban"></i> Gagal meminjam!</h5>
				<span	>Anda masih meminjam ruangan, tolong selesaikan peminjam yang sedang berjalan terlebih dahulu!</span></div>');
			redirect('peminjam');
		} elseif (strtotime($jam_mulai) < strtotime($waktu_sekarang)) {
			$this->session->set_flashdata('message', '<div class="alert alert-warning alert-dismissible">
					<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
					<h5><i class="icon fas fa-ban"></i> Gagal meminjam!</h5>
					<span>Waktu mulai tidak boleh kurang dari waktu sekarang!</span></div>');
			redirect('peminjam');
		} elseif ($durasi > 5 * 3600) { // 5 jam dalam detik
			$this->session->set_flashdata('message', '<div class="alert alert-warning alert-dismissible">
					<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
					<h5><i class="icon fas fa-ban"></i> Gagal meminjam!</h5>
					<span>Waktu berakhir tidak boleh lebih dari 5 jam dari waktu mulai!</span></div>');
			redirect('peminjam');
		} elseif ($durasi < 30 * 60) { // 30 menit dalam detik
			$this->session->set_flashdata('message', '<div class="alert alert-warning alert-dismissible">
					<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
					<h5><i class="icon fas fa-ban"></i> Gagal meminjam!</h5>
					<span>Peminjaman harus lebih dari 30 menit!</span></div>');
			redirect('peminjam');
		} else {
			$pinjam = $this->m_siplabs->add_data('peminjaman', $array);
			if ($pinjam) {
				$this->session->set_flashdata('message', '<div class="alert alert-success alert-dismissible">
					<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
					<h5><i class="icon fas fa-check"></i> Berhasil meminjam!</h5>
					<span>Menunggu konfirmasi dari admin!</span></div>');
				redirect('peminjam');
			} else {
				$this->session->set_flashdata('message', '<div class="alert alert-danger alert-dismissible">
					<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
					<h5><i class="icon fas fa-ban"></i> Gagal meminjam!</h5>
					<span>Hubungi admin untuk detailnya!</span></div>');
				redirect('peminjam');
			}
		}

		// $tanggalformatted = date_create($tanggal);

		// $admin = $this->db->get_where('user', ['level' => 'Admin'])->row_array();

		// $url = 'https://api.whatsapp.com/send?phone=+62' . $admin['no_telp'] . '&text=Assalumalaikum%20Admin.%0A%0ARequest%20Peminjaman%20dengan%20Info%0Ausername%20%3A%20' . $username . '%0Ajam%20mulai%20%3A%20' . $jam_mulai . '%0Ajam%20selesai%20%3A%20' . $jam_berakhir . '%0Atanggal%20%3A%20' . date_format($tanggalformatted, 'd / m / Y') . '%0Aketerangan%20%3A%20' . $keterangan;
		// redirect($url);
	}

	public function batalpinjam($id_user, $id_ruangan)
	{
		$batalpinjam = $this->db->update('peminjaman', ['status_peminjaman' => 3], ['id_user' => $id_user, 'id_ruangan' => $id_ruangan]);
		if ($batalpinjam) {
			$this->session->set_flashdata('message', '<div class="alert alert-success alert-dismissible">
				<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
				<h5><i class="icon fas fa-check"></i> Dibatalkan!</h5></div>');
			redirect('peminjam');
		} else {
			$this->session->set_flashdata('message', '<div class="alert alert-danger alert-dismissible">
				<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
				<h5><i class="icon fas fa-ban"></i> Gagal membatalkan peminjaman!</h5>
				<span>Hubungi admin untuk detailnya!</span></div>');
			redirect('peminjam');
		}
	}

	public function jadwal()
	{
		$data['title'] = 'Jadwal';

		$data['id_user'] = $this->session->userdata('id_user');
		$data['username'] = $this->session->userdata('username');
		$data['jadwal'] = $this->db->query("SELECT * FROM jadwal INNER JOIN peminjaman on jadwal.id_peminjaman=peminjaman.id_peminjaman INNER JOIN user on peminjaman.id_user=user.id_user INNER JOIN ruangan on peminjaman.id_ruangan = ruangan.id_ruangan ORDER BY peminjaman.tanggal ASC")->result();
		$this->load->view('templates/header', $data);
		$this->load->view('peminjam/jadwal', $data);
		$this->load->view('templates/footer');
	}
}
