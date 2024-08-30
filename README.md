# PosoNet.Provisioning
 App for Inet
# Requirements
- Xampp with php 7.3.x
- Composer
- Python 3.8.10 (support windows 7)

 1. composer update
 2. edit config.php
 3. edit database.php
 4. 

ALTER TABLE pelanggan
ADD cvlan VARCHAR(10);
ADD stb_username VARCHAR(50);
ADD stb_password VARCHAR(50);

# Edit view pelanggan add
- v_pelanggan = add p.vlan_profile, p.cvlan, p.no_ktp,

# please run query to set default vlan-profile and cvlan. may different in your olt
- UPDATE pelanggan SET vlan_profile='netmedia143', cvlan='143'

# update tabel pelanggan, pada kolom 'ont_phase_state' tambahkan ,'Registering'

# tambahkan tabel 'olt_interfaces'
CREATE TABLE `olt_interfaces` (
	`id` INT(11) NOT NULL AUTO_INCREMENT,
	`gpon_olt` VARCHAR(50) NULL DEFAULT NULL COLLATE 'latin1_swedish_ci',
	PRIMARY KEY (`id`) USING BTREE
)
COLLATE='latin1_swedish_ci'
ENGINE=InnoDB
AUTO_INCREMENT=9

# ubah tabel pelanggan pada 'id_wilayah,id_paket,no_pelanggan' set Default to NULL

# ganti query v_pelanggan menjadi
SELECT `p`.`id_pelanggan` AS `id_pelanggan`,`p`.`no_pelanggan` AS `no_pelanggan`,`p`.`nama_pelanggan` AS `nama_pelanggan`,
`p`.`alamat` AS `alamat`,`w`.`wilayah` AS `wilayah`,`t`.`nama_paket` AS `nama_paket`,`t`.`tarif` AS `tarif`,
`p`.`tgl_instalasi` AS `tgl_instalasi`,`p`.`expired` AS `expired`,`p`.`serial_number` AS `serial_number`,
`p`.`lokasi_map` AS `lokasi_map`,`p`.`telp` AS `telp`,`p`.`status` AS `status`,`p`.`keterangan` AS `keterangan`,
`p`.`id_wilayah` AS `id_wilayah`,`p`.`id_paket` AS `id_paket`,`w`.`kode_wilayah` AS `kode_wilayah`,
`p`.`email` AS `email`, ktp_filename, p.gpon_olt, p.gpon_onu,p.remote_web_state, p.onu_db, p.distance, p.vlan_profile, p.cvlan, p.no_ktp,
p.ont_phase_state, t.mikrotik_profile,p.name,p.username,p.`password`,p.onu_type,p.description,p.active_connection,IF(p.expired < CURDATE(),'Expired','Active') AS status_berlangganan
FROM `pelanggan` `p` 
left join `paket` `t` 
ON `p`.`id_paket` = `t`.`id_paket` 
left join `wilayah` `w`
ON `p`.`id_wilayah` = `w`.`id_wilayah` 
ORDER BY `p`.`id_pelanggan` DESC 

# update v_expired
add v.expired AFTER v.ont_phase_state

# add data in table settings
- option_id = 20, option_name = bri_bank, option_value = BRI
- option_id = 21, option_name = bri_no_rekening, option_value = 
- option_id = 22, option_name = bri_nama_pemilik_rekening, option_value = 

# add data in table settings
- option_id = 30, option_name = tg_base_url, option_value = 'https://api.telegram.org/'
- option_id = 31, option_name = tg_token_bot, option_value = ''
- option_id = 32, option_name = tg_username_bot, option_value = ''
- option_id = 33, option_name = tg_chat_id_admin, option_value = ''
- option_id = 34, option_name = tg_chat_id_teknisi, option_value = ''
- option_id = 35, option_name = tg_chat_id_group, option_value = ''


# (2024-07-25) add line on v_pelanggan after "AS status_berlangganan"
- ,p.odp_number, p.odp_location

# (2024-07-25) add line on v_onu_los after "v.ont_phase_state"
- ,v.odp_number, v.odp_location, v.lokasi_map

