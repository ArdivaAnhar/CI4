<?php

namespace App\Controllers;

use App\Controllers\BaseController;

class AuthController extends BaseController
{
    public function __construct()
    {
        $this->model = new \App\Models\User();
    }
    public function registrasi()
    {
        return view('registrasi');
    }
    public function login()
    {
        $data = [
            'validation' => \Config\Services::validation()
        ];
        return view('login', $data);
    }


    // proses registrasi
    public function simpanRegistrasi()
    {
        // 1. Mengambil data dari input
        $data = [
            'nama'                  => $this->request->getPost('nama'),
            'email'                 => $this->request->getPost('email'),
            'password'              => $this->request->getPost('password'),
            'konfirmasi_password'   => $this->request->getPost('konfirm_pass')
        ];

        // 2. Validasi input form
        $validation = \Config\Services::validation();

        $validation->setRules([
            'nama'                  => 'required',
            'email'                 => 'required|valid_email|is_unique[users.email]',
            'password'              => 'required|min_length[8]',
            'konfirmasi_password'   => 'required|matches[password]'
        ]);

        // 3. Cek validasi
        if ($validation->run($data)) {
            // jika berhasil, simpan data dan beri pesan pada hasil
            $this->model->save([
                'name'              => $data['nama'],
                'email'             => $data['email'],
                'password'          => password_hash($data['password'], PASSWORD_BCRYPT),
                'role'              =>'siswa'
            ]);

            return redirect()->to(base_url('registrasi'))->with('sukses', 'Registrasi berhasil !');
        } else {
            // jika gagal, beri pesan gagal
            $errorMessages = $validation->getErrors();
            return redirect()->to(base_url('registrasi'))->with('gagal', $errorMessages);
        }
    }

    public function prosesLogin()
    {
        if ($this->validate($this->rulesLogin())) {
            $query = $this->model->where('email', $this->request->getPost('email'));
            $count = $query->countAllResults(false);
            $data = $query->get()->getRow();

            if ($count > 0) {
                $hashPassword = $data->password;

                if (password_verify($this->request->getPost('password'), $hashPassword)) {
                    
                    $session = [
                        'role' => $data->role,
                        'logged_in' => TRUE
                    ];
                    session()->set($session);

                    return redirect()->to(base_url('beranda'));
                } else {
                    return redirect()->to(base_url('siswa'))->with('login_failed', 'Username atau password yang anda masukkan salah !');
                }
            } else {
                return redirect()->to(base_url('siswa'))->with('login_failed', 'Username tidak ditemukan !');
            }
        } else {
            return redirect()->to(base_url('siswa'))->withInput();
        }
    }

    public function rulesLogin()
    {
        $setRules = [
            'email' => [
                'rules' => 'required|valid_email',
                'errors' => [
                    'required' => 'Email tidak boleh kosong !',
                    'valid_email' => 'Email tidak valid',
                ]
            ],
            'password'  =>[
                'rules' => 'required',
                'errors'    =>[
                    'required'  => 'Password tidak boleh kosong',
                ]
            ]
        ];

        return $setRules;
    }

    public function logout()
    {
        session()->destroy();
        return redirect()->to('/login');
    }

}