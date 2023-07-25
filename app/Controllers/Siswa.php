<?php

namespace App\Controllers;

use CodeIgniter\RESTful\ResourceController;

class Siswa extends ResourceController
{
    public function __construct()
    {
        $this->model = new \App\Models\User();
    }
    /**
     * Return an array of resource objects, themselves in array format
     *
     * @return mixed
     */
    public function index()
    {
        $dataSiswa = $this->model->where('role', 'siswa')->findAll();
        return view('siswa/index', ['siswa' => $dataSiswa]);
    }

    /**
     * Return the properties of a resource object
     *
     * @return mixed
     */
    public function show($id = null)
    {
        $dataSiswa = $this->model->where('id', $id)->first();
        return view('siswa/show', ['siswa' => $dataSiswa]);
    }

    /**
     * Return a new resource object, with default properties
     *
     * @return mixed
     */
    public function new()
    {
        return view('siswa/form-tambah');
    }

    /**
     * Create a new resource object, from "posted" parameters
     *
     * @return mixed
     */
    public function create()
    {
        $data = [
            'name'          => $this->request->getPost('name'),
            'nis'           => $this->request->getPost('nis'),
            'email'         => $this->request->getPost('email'),
            'password'      => password_hash('pass1234', PASSWORD_BCRYPT),
            'role'          => 'siswa'
        ];
        $this->model->insert($data);

        return redirect()->to(base_url('siswa'));
    }

    /**
     * Return the editable properties of a resource object
     *
     * @return mixed
     */
    public function edit($id = null)
    {
        $dataSiswa = $this->model->where('id', $id)->first();
        return view('siswa/form-ubah', ['siswa' => $dataSiswa]);
    }

    /**
     * Add or update a model resource, from "posted" properties
     *
     * @return mixed
     */
    public function update($id = null)
    {
        $data = [
            'name' => $this->request->getVar('name'),
            'nis' => $this->request->getVar('nis'),
            'email' => $this->request->getVar('email'),
        ];
        $this->model->where('id', $id)->set($data)->update();

        return redirect()->to(base_url('siswa'));
    }

    /**
     * Delete the designated resource object from the model
     *
     * @return mixed
     */
    public function delete($id = null)
    {
        $this->model->delete($id);
        return redirect()->to(base_url('siswa'));
    }
}