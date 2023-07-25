        <?= $this->extend("layouts/template"); ?>

        <?= $this->section("content"); ?>

        <!-- info kegiatan -->
        <h3>Info Kegiatan</h3>
        <p>Informasi Kegiatan Siswa Bulan ini: </p>
        <ul>
            <li>10 Agustus - Masa Orientasi Siswa</li>
            <li>17 Agustus - Upacara Kemerdekaan</li>
        </ul>
        <p>Informasi Kegiatan Siswa Bulan Depan: </p>
        <ul>
            <li>12 September - Ujian Tengah Semester</li>
        </ul>
        <?= $this->endSection(); ?>