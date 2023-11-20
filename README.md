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

