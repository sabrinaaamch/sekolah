<?php
class Admin extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		if (null == $this->session->level) {
			redirect('auth');
		} else {
			if ($this->session->level != "Admin") {
				redirect('auth', 'refresh');
			}
		}
		$this->load->helper('tgl_indo');
	}

	public function index()
	{
		$data['title'] = "Beranda";
		$data['user'] = $this->session->id_user;
		$data['username'] = $this->session->username;
		$data['nama_lengkap'] = $this->session->nama_lengkap;
		$this->load->view('templates/header', $data);
		$this->load->view('admin/dashboard', $data);
		$this->load->view('templates/footer');
	}

	// NEW USER
	public function newuser()
	{
		$data['root'] = "Manajemen Pengguna";
		$data['title'] = "User Baru";
		$data['user'] = $this->session->userdata('id_user');
		$data['username'] = $this->session->userdata('username');
		$this->load->view('templates/header', $data);
		$this->load->view('admin/newuser', $data);
		$this->load->view('templates/footer');
	}

	public function accuser($id_user)
	{
		$this->db->update('user', array('status' => 1), array('id_user' => $id_user));
		$this->session->set_flashdata('message', '<div class="alert alert-success animated fadeIn" role="alert">User diterima!</div>');
		redirect('admin/newuser');
	}

	public function disaccuser($id_user)
	{
		$this->db->delete('user', array('id_user' => $id_user));
		$this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">User ditolak!</div>');
		redirect('admin/newuser');
	}

	// USERS
	public function users()
	{
		$data['root'] = "Manajemen Pengguna";
		$data['title'] = "Users";
		$data['user'] = $this->session->userdata('id_user');
		$data['username'] = $this->session->userdata('username');
		$this->load->view('templates/header', $data);
		$this->load->view('admin/users', $data);
		$this->load->view('templates/footer');
	}

	public function adduser()
	{
		$nama_lengkap = htmlspecialchars($this->input->post('nama_lengkap'));
		$username = htmlspecialchars($this->input->post('username'));
		$password = htmlspecialchars($this->input->post('password'));
		$bio = htmlspecialchars($this->input->post('bio'));
		$no_telp = htmlspecialchars($this->input->post('no_telp'));
		$nip = htmlspecialchars($this->input->post('nip'));
		$level = htmlspecialchars($this->input->post('level'));

		$cekusername = $this->db->get_where('user', ['username' => $username])->row_array();
		$ceknip = $this->db->get_where('user', ['nip' => $nip])->row_array();
		if ($cekusername) {
			$this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Username sudah ada!</div>');
			redirect('admin/users');
		} elseif ($ceknip) {
			$this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">NIP sudah ada!</div>');
			redirect('admin/users');
		} elseif ($password != $this->input->post('password2')) {
			$this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Password tidak sama!</div>');
			redirect('admin/users');
		} else {
			$this->db->insert('user', [
				'id_user' => null,
				'nama_lengkap' => $nama_lengkap,
				'username' => $username,
				'password' => sha1($password),
				'bio' => $bio,
				'no_telp' => $no_telp,
				'nip' => $nip,
				'level' => $level,
				'status' => 1
			]);
			$this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">User ditambahkan!</div>');
			redirect('admin/users');
		}
	}

	public function edituser()
	{
		$id_user = $this->input->post('id_user');
		$nama_lengkap = htmlspecialchars($this->input->post('nama_lengkap'));
		$username = htmlspecialchars($this->input->post('username'));
		$bio = htmlspecialchars($this->input->post('bio'));
		$no_telp = htmlspecialchars($this->input->post('no_telp'));
		$nip = htmlspecialchars($this->input->post('nip'));
		$level = htmlspecialchars($this->input->post('level'));

		$cekusername = $this->db->get_where('user', ['id_user !=' => $id_user])->row_array();
		if ($cekusername['username'] != $username) {
			$array = [
				'nama_lengkap' => $nama_lengkap,
				'username' => $username,
				'bio' => $bio,
				'no_telp' => $no_telp,
				'nip' => $nip,
				'level' => $level
			];
			$this->db->update('user', $array, ['id_user' => $id_user]);
			$this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">User diubah!</div>');
			redirect('admin/users');
		} else {
			$this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Username sudah ada!</div>');
			redirect('admin/users');
		}
	}

	public function deleteuser($id_user)
	{
		$cekpeminjaman = $this->db->get_where('user', ['id_user' => $id_user])->row_array();
		if ($cekpeminjaman) {
			$this->db->delete('peminjaman', ['id_user' => $id_user]);
		}

		$this->db->delete('user', ['id_user' => $id_user]);
		$this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">User dihapus!</div>');
		redirect('admin/users');
	}

	// REQUEST
	public function request()
	{
		$data['root'] = "Kelola Peminjaman";
		$data['title'] = "Peminjaman";
		$data['user'] = $this->session->userdata('id_user');
		$data['username'] = $this->session->userdata('username');
		$this->load->view('templates/header', $data);
		$this->load->view('admin/request', $data);
		$this->load->view('templates/footer');
	}

	public function accrequest($id_peminjaman)
	{

		$cekpeminjaman = $this->db->get_where('peminjaman', ['id_peminjaman' => $id_peminjaman])->row_array();

		$nowtime = strtotime(date('H:i:s')) + strtotime(date('Y-m-d'));

		$dbstart = strtotime($cekpeminjaman['jam_mulai']) + strtotime($cekpeminjaman['tanggal']);
		$dbend = strtotime($cekpeminjaman['jam_berakhir']) + strtotime($cekpeminjaman['tanggal']);

		if ($nowtime > $dbstart && $nowtime < $dbend || $nowtime > $dbstart + 300 && $nowtime < $dbend + 300) {
			$ruangan = $cekpeminjaman['id_ruangan'];
			$cekjadwal = $this->db->query('SELECT * FROM jadwal INNER JOIN peminjaman, ruangan 
			WHERE jadwal.id_peminjaman=peminjaman.id_peminjaman
			AND peminjaman.id_ruangan=ruangan.id_ruangan
			AND status_jadwal=1
			AND peminjaman.id_ruangan=' . $ruangan)->row_array();

			if ($cekjadwal) {
				$this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Gagal diterima, jadwal bentrok!</div>');
				redirect('admin/request');
			} else {
				$this->db->update('ruangan', ['status_ruangan' => 'Dipakai'], ['id_ruangan' => $cekpeminjaman['id_ruangan']]);
				$this->db->update('peminjaman', array('status_peminjaman' => 1), array('id_peminjaman' => $id_peminjaman));
				$this->db->insert('jadwal', array(
					'id_jadwal' => null,
					'id_peminjaman' => $id_peminjaman,
					'status_jadwal' => 1
				));
				$this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Request diterima!</div>');
				redirect('admin/request');
			}
		} elseif ($nowtime < $dbstart) {
			$ruangan = $cekpeminjaman['id_ruangan'];
			$cekjadwal = $this->db->query('SELECT * FROM jadwal INNER JOIN peminjaman, ruangan 
			WHERE jadwal.id_peminjaman=peminjaman.id_peminjaman
			AND peminjaman.id_ruangan=ruangan.id_ruangan
			AND status_jadwal=2
			AND peminjaman.id_ruangan=' . $ruangan)->row_array();

			$dbone = strtotime($cekjadwal['jam_mulai']) + strtotime($cekjadwal['jam_berakhir']) + strtotime($cekjadwal['tanggal']);

			$dbtwo = strtotime($cekpeminjaman['jam_mulai']) + strtotime($cekpeminjaman['jam_berakhir']) + strtotime($cekpeminjaman['tanggal']);

			if ($dbone == $dbtwo) {
				$this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Gagal diterima, jadwal bentrok!</div>');
				redirect('admin/request');
			} else {
				$this->db->update('peminjaman', array('status_peminjaman' => 2), array('id_peminjaman' => $id_peminjaman));
				$this->db->insert('jadwal', array(
					'id_jadwal' => null,
					'id_peminjaman' => $id_peminjaman,
					'status_jadwal' => 2
				));
				$this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Request diterima!</div>');
				redirect('admin/request');
			}
		} else {
			$this->db->insert('jadwal', array(
				'id_jadwal' => null,
				'id_peminjaman' => $id_peminjaman,
				'status_jadwal' => 1
			));
			$this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Request diterima!</div>');
			redirect('admin/request');
		}
	}

	public function disaccrequest($id_peminjaman)
	{
		$disaccrequest = $this->db->update('peminjaman', array('status_peminjaman' => 3), array('id_peminjaman' => $id_peminjaman));
		if ($disaccrequest) {
			$this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Request ditolak!</div>');
			redirect('admin/request');
		} else {
			$this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Request gagal ditolak!</div>');
			redirect('admin/request');
		}
	}

	// JADWAL
	public function jadwal()
	{
		$data['root'] = "Kelola Peminjaman";
		$data['title'] = "Jadwal";
		$data['user'] = $this->session->userdata('id_user');
		$data['username'] = $this->session->userdata('username');
		$this->load->view('templates/header', $data);
		$this->load->view('admin/jadwal', $data);
		$this->load->view('templates/footer');
	}

	public function accjadwal($id_jadwal)
	{
		$accjadwal = $this->db->update('jadwal', array('status_jadwal' => 1), array('id_jadwal' => $id_jadwal));
		if ($accjadwal) {
			$this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Jadwal diterima!</div>');
			redirect('admin/jadwal');
		} else {
			$this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">' . $this->db->error() . '</div>');
			redirect('admin/jadwal');
		}
	}

	public function hapusjadwal($id_jadwal)
	{
		$hapusjadwal = $this->db->delete('jadwal', array('id_jadwal' => $id_jadwal));
		if ($hapusjadwal) {
			$this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Jadwal dihapus!</div>');
			redirect('admin/jadwal');
		} else {
			$this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">' . $this->db->error() . '</div>');
			redirect('admin/jadwal');
		}
	}

	public function resetjadwal($id_jadwal)
	{
		$resetjadwal = $this->db->update('jadwal', array('status_jadwal' => 0), array('id_jadwal' => $id_jadwal));
		if ($resetjadwal) {
			$this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Jadwal direset!</div>');
			redirect('admin/jadwal');
		}
	}

	// MY PROFILE
	public function myprofile($id_user)
	{
		$data['root'] = "Pengaturan";
		$data['title'] = "Profil Saya";
		$data['user'] = $this->session->userdata('id_user');
		$data['username'] = $this->session->userdata('username');
		$data['profile'] = $this->m_siplabs->getwhere('user', array('id_user' => $id_user))->result();
		$this->load->view('templates/header', $data);
		$this->load->view('admin/myprofile', $data);
		$this->load->view('templates/footer');
	}

	public function editprofil()
	{
		$id_user = $this->input->post('id_user');
		$username = $this->input->post('username');
		$nama_lengkap = $this->input->post('nama_lengkap');
		$bio = $this->input->post('bio');
		$no_telp = $this->input->post('no_telp');
		$nip = $this->input->post('nip');
		$uploaded = $_FILES['image']['name'];
		$imagetype = end(explode('.', $uploaded));
		$image = uniqid() . '.' . $imagetype;

		$cekusername = $this->db->get_where('user', ['id_user' != $id_user])->row_array();
		if ($cekusername['username'] != $username) {
			if (!empty($uploaded)) {
				$config['upload_path'] = './files/userprofil/';
				$config['allowed_types'] = 'gif|jpg|png|jpeg';
				$config['max_size']  = '10000';
				$config['file_name'] = $image;

				$this->load->library('upload', $config);

				if (!$this->upload->do_upload('image')) {
					$this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">' . $this->upload->display_errors() . '</div>');
					redirect('admin/myprofile/' . $id_user);
				} else {
					$userdata = $this->db->get_where('user', ['id_user' => $id_user])->row_array();
					if (!empty($userdata['image'])) {
						$path = 'files/userprofil/' . $userdata['image'];
						unlink($path);
					}

					$array = [
						'username' => $username,
						'nama_lengkap' => $nama_lengkap,
						'bio' => $bio,
						'nip' => $nip,
						'no_telp' => $no_telp,
						'image' => $image
					];
					$this->upload->do_upload($image);
					$this->db->update('user', $array, ['id_user' => $id_user]);
					$this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Sukses</div>');
					redirect('admin/myprofile/' . $id_user);
				}
			} else {
				$array = [
					'username' => $username,
					'nama_lengkap' => $nama_lengkap,
					'bio' => $bio,
					'nip' => $nip,
					'no_telp' => $no_telp
				];
				$this->db->update('user', $array, ['id_user' => $id_user]);
				$this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Sukses</div>');
				redirect('admin/myprofile/' . $id_user);
			}
		} else {
			$this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Username sudah ada!</div>');
			redirect('admin/myprofile/' . $id_user);
		}
	}

	public function aksigantipass()
	{
		$id_user = $this->input->post('id_user');
		$password_lama = $this->input->post('password_lama');
		$password_baru = $this->input->post('password_baru');
		$password_baru2 = sha1($password_baru);

		$cekpassword = $this->db->get_where('user', ['id_user' => $id_user])->row_array();
		if ($cekpassword['password'] != sha1($password_lama)) {
			$this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Password salah!</div>');
			redirect('admin/myprofile/' . $id_user);
		} else {
			$this->db->update('user', ['password' => $password_baru2], ['id_user' => $id_user]);
			$this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Sukses!</div>');
			redirect('admin/myprofile/' . $id_user);
		}
	}

	// SITE SETTINGS
	public function sitesetting()
	{
		$data['root'] = "Pengaturan";
		$data['title'] = "Pengaturan situs";
		$data['user'] = $this->session->userdata('id_user');
		$data['username'] = $this->session->userdata('username');
		$data['site'] = $this->db->get('site')->result();
		$data['ruangan'] = $this->db->get('ruangan')->result();
		$this->load->view('templates/header', $data);
		$this->load->view('admin/site', $data);
		$this->load->view('templates/footer');
	}

	public function editsite()
	{
		$id_site = $this->input->post('id_site');
		$title = $this->input->post('title');

		$ceksite = $this->db->get_where('site', ['id_site' => $id_site])->row_array();

		$config['upload_path'] = './files/site/';
		$config['allowed_types'] = 'gif|jpg|png|jpeg';
		$config['file_ext_tolower'] = TRUE;
		$config['remove_space'] = TRUE;
		$config['file_name'] = uniqid();

		$this->load->library('upload', $config);

		if (!$this->upload->do_upload('logo')) {
			$logo = ['file_name' => $ceksite['logo']];
		} else {
			if (null !== $ceksite['logo']) {
				$path = 'files/site/' . $ceksite['logo'];
				unlink($path);
			}
			$logo = $this->upload->data();
		}

		if (!$this->upload->do_upload('icon')) {
			$icon = ['file_name' => $ceksite['icon']];
		} else {
			if (null !== $ceksite['icon']) {
				$path = 'files/site/' . $ceksite['icon'];
				unlink($path);
			}
			$icon = $this->upload->data();
		}

		$array = [
			'title' => $title,
			'logo' => $logo['file_name'],
			'icon' => $icon['file_name']
		];

		$this->upload->do_upload();
		$this->db->update('site', $array, ['id_site' => $id_site]);
		redirect('admin/sitesetting', 'refresh');
	}

	// RUANGAN
	public function ruangan()
	{
		$data['title'] = "Data Ruangan";
		$data['user'] = $this->session->userdata('id_user');
		$data['username'] = $this->session->userdata('username');
		$data['ruangan'] = $this->db->get('ruangan')->result();

		$this->load->view('templates/header', $data);
		$this->load->view('admin/ruangan', $data);
		$this->load->view('templates/footer');
	}

	public function tambahruangan()
	{
		$kode_ruangan = $this->input->post('kode_ruangan');
		$nama_ruangan = $this->input->post('nama_ruangan');
		$uploaded = $_FILES['image']['name'];
		$imagetype = end(explode('.', $uploaded));
		$image = uniqid() . '.' . $imagetype;

		$config['upload_path'] = './files/site/';
		$config['allowed_types'] = 'jpg|png|jpeg';
		$config['max_size'] = '10000'; // 10MB
		$config['file_name'] = $image;

		$this->load->library('upload', $config);

		if (!$this->upload->do_upload('image')) {
			$this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">' . $this->upload->display_errors() . '</div>');
			redirect('admin/ruangan');
		} else {
			$array = [
				'kode_ruangan' => $kode_ruangan,
				'nama_ruangan' => $nama_ruangan,
				'image' => $image,
				'status_ruangan' => 'Nganggur'
			];
			$this->upload->do_upload($image);
			$this->db->insert('ruangan', $array);
			$this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Sukses</div>');
			redirect('admin/ruangan');
		}
	}

	public function ubahruangan()
	{
		$id_ruangan = $this->input->post('id_ruangan');
		$kode_ruangan = $this->input->post('kode_ruangan');
		$nama_ruangan = $this->input->post('nama_ruangan');
		$uploaded = $_FILES['image']['name'];
		$imagetype = end(explode('.', $uploaded));
		$image = uniqid() . '.' . $imagetype;

		$cekruangan = $this->db->get_where('ruangan', ['id_ruangan' => $id_ruangan])->row_array();

		if (!empty($uploaded)) {
			$config['upload_path'] = './files/site/';
			$config['allowed_types'] = 'jpg|png|jpeg';
			$config['max_size'] = '10000'; // 10MB
			$config['file_name'] = $image;

			$this->load->library('upload', $config);

			if (!$this->upload->do_upload('image')) {
				$this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">' . $this->upload->display_errors() . '</div>');
				redirect('admin/ruangan');
			} else {
				$ruangan = $this->db->get_where('ruangan', ['id_ruangan' => $id_ruangan])->row_array();
				if (!empty($ruangan['image'])) {
					$path = 'files/site/' . $ruangan['image'];
					unlink($path);
				}

				$array = [
					'kode_ruangan' => $kode_ruangan,
					'nama_ruangan' => $nama_ruangan,
					'image' => $image
				];
				$this->upload->do_upload($image);
				$this->db->update('ruangan', $array, ['id_ruangan' => $id_ruangan]);
				$this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Sukses</div>');
				redirect('admin/ruangan');
			}
		} else {
			$array = [
				'kode_ruangan' => $kode_ruangan,
				'nama_ruangan' => $nama_ruangan
			];
			$this->db->update('ruangan', $array, ['id_ruangan' => $id_ruangan]);
			$this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Sukses</div>');
			redirect('admin/ruangan');
		}
	}

	public function hapusruangan($id_ruangan)
	{
		$cekpeminjaman = $this->db->get_where('peminjaman', ['id_ruangan' => $id_ruangan])->row_array();
		if ($cekpeminjaman) {
			$this->db->delete('peminjaman', ['id_ruangan' => $id_ruangan]);
		}

		$ruangan = $this->db->get_where('ruangan', ['id_ruangan' => $id_ruangan])->row_array();
		if (!empty($ruangan['image'])) {
			$path = 'files/site/' . $ruangan['image'];
			unlink($path);
		}

		$this->db->delete('ruangan', ['id_ruangan' => $id_ruangan]);
		$this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Data dihapus!</div>');
		redirect('admin/ruangan');
	}
}
