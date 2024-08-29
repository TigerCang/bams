<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class Konfigurasi extends Seeder
{
    public function run()
    {
        $konfig_data = [
            ['idunik' => 'b0c4fcd6818f7d963e8c06016239fb169944732ded49cf704b5e22abf16b8666', 'mode' => 'A', 'param' => 'jumlah setuju', 'nilai' => '1',], //jumlah persetujuan
            ['idunik' => 'a1ca5822259fef0cf8ec00df94b4714ac4169c4976ac3fed23612ebd9bbe00c2', 'mode' => 'A', 'param' => 'acc anggaran', 'nilai' => '1',], //acc anggaran
            ['idunik' => '432bc2d2b04ecd8559513dd022e6e353dfd945d1de0e4088078f6db0a9e44fb2', 'mode' => 'A', 'param' => 'acc minta barang', 'nilai' => '1',], //acc permintaan item
            ['idunik' => '44eb294e6dbd9fd40651e00cab84497004a905b8535a13e7b680a61cdd461058', 'mode' => 'A', 'param' => 'konf pilih suplier', 'nilai' => '1',], //mulai pilih suplier
            ['idunik' => '1b3db7ea042cd2164d47d4ba9c0c48fadfb777bd38d16f783e81921ec657f6bc', 'mode' => 'A', 'param' => 'acc sales order', 'nilai' => '1',], //acc sales order
            ['idunik' => 'b782e57ef4a171d14f1148d95470ffb72e766b903f450fbd769a81a4ea21a34d', 'mode' => 'A', 'param' => 'acc tiketts', 'nilai' => '1',], //acc tiket ts
            ['idunik' => 'b5a9d9a96ef169b2bec7b1e381409f71673016da83c57360d8bfb67fe89db4c1', 'mode' => 'A', 'param' => 'acc invoice', 'nilai' => '1',], //acc invoice
            ['idunik' => '4e64dc5197b8d915de3113f825be0af0b909d43083bd7b964044bc3b75f648f4', 'mode' => 'B', 'param' => 'folder kas', 'sub_param' => '/lampiran kas', 'nilai' => '2025',], //bukti transaksi kas
            ['idunik' => 'e626bd458c13844752c223e8b3140656dddfa341a851b17475301e00e8aa4148s', 'mode' => 'B', 'param' => 'folder hrd', 'sub_param' => '/lampiran hrd', 'nilai' => '2025',], //bukti transaksi hrd
        ];

        foreach ($konfig_data as $data) {
            $this->db->table('m_konfigurasi')->insert($data);
        }
    }
}
