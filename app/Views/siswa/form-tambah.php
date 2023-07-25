<?= $this->extend("layouts/template"); ?>

<?= $this->section("content"); ?>
<div class="container my-3 w-50">
    <div class="card">
        <div class="card-header">
            <h3>Tambah Siswa</h3>
        </div>
        <div class="card-body">
            <form action="<?= base_url('siswa') ?>" method="POST">
                <?php csrf_field(); ?>
                <ul class="list-group">
                    Nama <input type="text" name="name" required>
                    NIS <input type="text" name="nis" required>
                    Email <input type="email" name="email" required>
                </ul>
                <hr>
                <a href="<?= base_url('siswa') ?>" class="btn btn-danger">Kembali</a>
                <input type="submit" value="Simpan" class="btn btn-primary">
            </form>
        </div>
    </div>
</div>
<?= $this->endSection(); ?>