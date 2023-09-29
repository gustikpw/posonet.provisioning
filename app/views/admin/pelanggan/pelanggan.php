<div class="wrapper wrapper-content">
    <div class="container">


        <div class="row">
            <div class="col-md-12">
                <div class="ibox float-e-margins">
                    <div class="ibox-title">
                        <h5><?php echo ucwords(str_replace('_', ' ', $active)); ?></h5>
                        <div class="ibox-tools">
                            <button class="btn btn-xs" data-toggle="modal" data-target="#exampleModal">Recent Request</button>
                            <!-- <button class="btn btn-xs btn-primary v_online">online -</button> -->
                            <a href="#divoffline" class="btn btn-xs v_offline">offline -</a>
                            <button class="btn btn-xs btn-danger v_los">LOS -</button>
                            <button class="btn btn-xs btn-info v_ont">total -</button>
                            <div class="btn-group">
                                <button type="button" class="btn btn-xs dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    OLT Info<span class="fa fa-info"> <span class="caret"></span>
                                </button>
                                <ul class="dropdown-menu">
                                    <li><a href="javascript:void(0)" onclick="show_raw_content('card','')">Show Card</a></li>
                                    <li><a href="javascript:void(0)" onclick="show_raw_content('vlan-summary','')">Show VLAN Summary</a></li>
                                    <li><a href="javascript:void(0)" onclick="show_raw_content('gpon-profile-vlan','')">Show Profile VLAN</a></li>
                                    <li><a href="javascript:void(0)" onclick="show_raw_content('gpon-profile-tcont','')">Show Profile Tcont</a></li>
                                    <li><a href="javascript:void(0)" onclick="show_raw_content('gpon-profile-traffic','')">Show Profile Traffic</a></li>
                                    <li><a href="javascript:void(0)" onclick="show_raw_content('onu-type','')">Show ONU Type</a></li>
                                    <li><a href="javascript:void(0)" onclick="show_raw_content('ip-route','')">Show IP Route</a></li>
                                    <li><a href="javascript:void(0)" onclick="show_raw_content('detail-info','')">Backup Config</a></li>
                                </ul>
                            </div>
                            <div class="btn-group">
                                <button type="button" class="btn btn-xs dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    WhatsApp<span class="fa fa-info"> <span class="caret"></span>
                                </button>
                                <ul class="dropdown-menu">
                                    <li><a href="javascript:void(0)" onclick="whatsapp('vlan-summary','')">Scan QR</a></li>
                                    <li><a href="javascript:void(0)" onclick="whatsapp('card','')">Reconnect</a></li>

                                </ul>
                            </div>
                            <div class="btn-group">
                                <button type="button" class="btn btn-xs dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    Manual<span class="fa fa-info"> <span class="caret"></span>
                                </button>
                                <ul class="dropdown-menu">
                                    <li><a href="javascript:void(0)" onclick="update_onurx()">Update OnuRx dBm</a></li>
                                    <li><a href="javascript:void(0)" onclick="reconfig()">Proses Pindah Port / Reconfig</a></li>
                                    <li><a href="javascript:void(0)" onclick="onustate()">ONU State</a></li>

                                </ul>
                            </div>
                            <a class="collapse-link">
                                <i class="fa fa-chevron-up"></i>
                            </a>

                        </div>
                    </div>
                    <div class="ibox-content">
                        <div class="xtable-responsive" id="unconfig" style="display:none">
                            <table class="table table-condensed table-hover" id="tb-unconfig">
                                <thead class="bg-info">
                                    <tr>
                                        <th class="uncfg">Unconfig found(s)</th>
                                        <th>Interface</th>
                                        <th>Model</th>
                                        <th>S/N</th>
                                        <th>Name</th>
                                        <th>OnuType</th>
                                        <th>Paket</th>
                                    </tr>
                                </thead>
                                <tbody>

                                </tbody>
                            </table>
                        </div>
                        <div class="xtable-responsive" id="los" style="display:none">
                            <table class="table table-condensed table-hover" id="tb-los">
                                <thead>
                                    <tr>
                                        <th class="text-danger">LOS</th>
                                        <th>Interface</th>
                                        <th>Name</th>
                                        <th>Cause</th>
                                    </tr>
                                </thead>
                                <tbody>

                                </tbody>
                            </table>
                        </div>

                        <div class="xtable-responsive " id="expired" style="display:none">
                            <table class="table table-condensed table-hover" id="tb-expired">
                                <thead>
                                    <tr>
                                        <th class="text-warning ">EXPIRED</th>
                                        <th>Interface</th>
                                        <th>Nama</th>
                                        <th>Expire</th>
                                    </tr>
                                </thead>
                                <tbody>

                                </tbody>
                            </table>
                        </div>

                        <div class="xtable-responsive" id="step4">
                            <table class="table table-condensed table-hover" id="table">
                                <thead>
                                    <tr>
                                        <th>Action</th>
                                        <th>Interface</th>
                                        <th>Nama</th>
                                        <th>Tgl Instalasi</th>
                                        <th>ontPhase</th>
                                        <th>dBm</th>
                                        <th>meter</th>
                                        <th>Paket</th>
                                        <th>Expire</th>
                                        <th>Tarif</th>
                                        <th>Status</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                <div class="ibox float-e-margins" id="divoffline">
                    <div class="ibox-title">
                        <h5>
                            <div class="text-uppercase v_offline"></div>
                        </h5>
                        <div class="ibox-tools">
                            <a class="collapse-link">
                                <i class="fa fa-chevron-up"></i>
                            </a>
                        </div>
                    </div>
                    <div class="ibox-content">

                        <div class="xtable-responsive" id="offline" style="display:none">
                            <table class="table table-condensed table-hover" id="tb-offline">
                                <thead>
                                    <tr>
                                        <th class="text-info">OFFLINE</th>
                                        <th>Interface</th>
                                        <th>Name</th>
                                        <th>Cause</th>
                                    </tr>
                                </thead>
                                <tbody>

                                </tbody>
                            </table>
                        </div>

                    </div>
                </div>
            </div>
        </div>



        <div class="modal inmodal" id="myModal" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog" style="width:80%">
                <div class="modal-content animated fadeInDown">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                        <h4 class="modal-title">Tambah <?php echo ucwords(str_replace('_', ' ', $active)); ?> Pelanggan</h4>
                        <small class="font-bold"></small>
                    </div>
                    <div class="modal-body" id="step2">
                        <div class="row">
                            <form id="form" action="#" class="form-horizontal" enctype="multipart/form-data">
                                <input type="text" name="id_pelanggan" hidden>
                                <div class="col-md-6 b-r">
                                    <div class="form-group">
                                        <label class="col-md-3 control-label text-danger">Interface /OnuType</label>
                                        <div class="col-md-9">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <input type="text" name="interface" placeholder="Interface OLT" class="form-control">
                                                </div>
                                                <div class="col-md-6">
                                                    <select name="onutype" class="form-control">
                                                    </select>
                                                </div>
                                            </div>
                                            <span class="help-block m-b-none"></span>
                                        </div>
                                    </div>
                                    <div class="form-group"><label class="col-md-3 control-label  text-danger">Service Mode</label>
                                        <div class="col-md-9">
                                            <select name="service_mode" class="form-control">
                                                <option value="pppoe">PPPoE</option>
                                                <option value="bridge">Bridge</option>
                                            </select> <span class="help-block m-b-none"></span>
                                        </div>
                                    </div>
                                    <div class="form-group"><label class="col-md-3 control-label ">Wilayah</label>
                                        <div class="col-md-9"><select name="id_wilayah" class="form-control fokus"></select> <span class="help-block m-b-none"></span>
                                        </div>
                                    </div>
                                    <div class="form-group"><label class="col-md-3 control-label ">No Pelanggan</label>
                                        <div class="col-md-9"><input type="text" name="no_pelanggan" class="form-control" readonly> <span class="help-block m-b-none"></span>
                                        </div>
                                    </div>
                                    <div class="form-group"><label class="col-md-3 control-label">Nama Pelanggan</label>
                                        <div class="col-md-9"><input type="text" name="nama_pelanggan" placeholder="Nama Pelanggan" class="form-control"> <span class="help-block m-b-none"></span>
                                        </div>
                                    </div>

                                    <div class="form-group"><label class="col-md-3 control-label">Telepon/HP</label>
                                        <div class="col-md-9"><input type="text" name="telp" placeholder="Telepon/HP" class="form-control"> <span class="help-block m-b-none"></span>
                                        </div>
                                    </div>
                                    <div class="form-group"><label class="col-md-3 control-label">Email</label>
                                        <div class="col-md-9"><input type="text" name="email" placeholder="Email" class="form-control"> <span class="help-block m-b-none"></span>
                                        </div>
                                    </div>
                                    <div class="form-group"><label class="col-md-3 control-label">Tanggal Instalasi</label>
                                        <div class="col-md-9"><input type="text" name="tgl_instalasi" placeholder="Tanggal Instalasi" class="form-control date"> <span class="help-block m-b-none"></span>
                                        </div>
                                    </div>
                                    <div class="form-group"><label class="col-md-3 control-label  text-danger">Expired at</label>
                                        <div class="col-md-9"><input type="text" name="expired" placeholder="Paket kadaluarsa" class="form-control date"> <span class="help-block m-b-none"></span>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-6 b-r">
                                    <div class="form-group"><label class="col-md-3 control-label">Paket Berlangganan</label>
                                        <div class="col-md-9"><select name="id_paket" class="form-control"></select> <span class="help-block m-b-none"></span>
                                        </div>
                                    </div>
                                    <div class="form-group"><label class="col-md-3 control-label">Status</label>
                                        <div class="col-md-9"><select name="status" class="form-control"></select> <span class="help-block m-b-none"></span>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-3 control-label text-danger">S/N (ONT/STB)</label>
                                        <div class="col-md-9">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <input type="text" name="serial_number" placeholder="Serial Number ONT" class="form-control">
                                                </div>
                                                <div class="col-md-6">
                                                    <input type="text" name="sn_stb" placeholder="S/N STB" class="form-control">
                                                </div>
                                            </div>
                                            <span class="help-block m-b-none"></span>
                                        </div>
                                    </div>
                                    <div class="form-group"><label class="col-md-3 control-label">Lokasi Map</label>
                                        <div class="col-md-9">
                                            <textarea name="lokasi_map" rows="3" placeholder="Lokasi Map" class="form-control"></textarea>
                                            <span class="help-block m-b-none"></span>
                                        </div>
                                    </div>
                                    <div class="form-group"><label class="col-md-3 control-label">Keterangan Tagihan</label>
                                        <div class="col-md-9">
                                            <textarea name="keterangan" placeholder="Keterangan Tagihan" class="form-control"></textarea>
                                            <span class="help-block m-b-none"></span>
                                        </div>
                                    </div>
                                    <div class="form-group"><label class="col-md-3 control-label">No KTP</label>
                                        <div class="col-md-9"><input type="text" name="no_ktp" placeholder="Nomor KTP" class="form-control"> <span class="help-block m-b-none"></span>
                                        </div>
                                    </div>
                                    <div class="form-group"><label class="col-md-3 control-label">Foto KTP</label>
                                        <div class="col-md-9">
                                            <div class="input-group">
                                                <input type="file" name="file_ktp" placeholder="Foto KTP" class="form-control" onchange="ubahFoto()" aria-label="..."> <span class="help-block m-b-none"></span>
                                                <!-- <input type="text" class="form-control" aria-label="..."> -->
                                                <span class="input-group-addon">
                                                    <input type="checkbox" name="ubahfoto" aria-label="...">
                                                </span>
                                            </div><!-- /input-group -->
                                            <span class="ketupload">Pilih file jika ingin mengganti foto ktp</span><br>
                                            <span class="">Nama file KTP : </span>
                                            <span class="ktpfilename">File KTP belum ada!</span>
                                        </div>
                                    </div>
                            </form>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary" id="btnSave" onclick="save()">Regis ONU</button>
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>


    </div>

    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="exampleModalLabel">New message</h4>
                </div>
                <div class="modal-body">
                    <div id="rawdata"></div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="extendPaket" tabindex="-1" role="dialog" aria-labelledby="extendPaketLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="extendPaketLabel">New message</h4>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <form id="formExtendPaket" action="#" class="form-horizontal">
                            <input type="text" name="md_gpon_onu" hidden>
                            <div class="col-md-12">
                                <div class="form-group"><label class="col-md-3 control-label ">Paket</label>
                                    <div class="col-md-9">
                                        <input type="text" name="md_nama_paket" class="form-control m-b-sm" disabled>
                                    </div>
                                </div>
                                <div class="form-group"><label class="col-md-3 control-label ">Aktif s/d</label>
                                    <div class="col-md-9">
                                        <input type="text" name="md_tgl_expired" class="form-control m-b-sm date">
                                        <?php
                                        $tanggalSaatIni = date('Y-m-20');
                                        $tanggalSatuBulanKedepan = date('Y-m-d', strtotime($tanggalSaatIni . ' +1 month'));
                                        ?>
                                        <br>
                                        <!-- <button class="btn btn-xs btn-default" onclick="setTgl('<?= $tanggalSatuBulanKedepan ?>')"><?= $tanggalSatuBulanKedepan ?></button> -->
                                        <a href="javascript:void(0)" class="label text-danger text-bold" onclick="setTgl('<?= $tanggalSatuBulanKedepan ?>')"><?= $tanggalSatuBulanKedepan ?></a>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>

                </div>
                <div class="modal-footer">
                    <!-- <button type="button" class="btn btn-warning" id="btnSaveExtendPaketSementara" onclick="setExtendPaket()"><span class="fa fa-send-o"></span> Sementara</button> -->
                    <button type="button" class="btn btn-primary" id="btnSaveExtendPaket" onclick="setExtendPaket()"><span class="fa fa-clock"></span> Extend</button>
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>


    <div class="modal fade" id="replaceOntModal" tabindex="-1" role="dialog" aria-labelledby="replaceOntLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="replaceOntLabel">Replace ONT</h4>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <form id="formReplaceOnt" action="#" class="form-horizontal">
                            <!-- <input type="text" name="rep_gpon_onu" hidden> -->
                            <div class="col-md-12">
                                <div class="form-group"><label class="col-md-3 control-label ">Interface ONU</label>
                                    <div class="col-md-9">
                                        <input type="text" name="rep_gpon_onu" class="form-control m-b-sm" disabled>
                                    </div>
                                </div>
                                <div class="form-group"><label class="col-md-3 control-label ">Name</label>
                                    <div class="col-md-9">
                                        <input type="text" name="rep_name" class="form-control m-b-sm" disabled>
                                    </div>
                                </div>
                                <div class="form-group"><label class="col-md-3 control-label ">Old S/N</label>
                                    <div class="col-md-9">
                                        <input type="text" name="rep_old_sn" class="form-control m-b-sm" disabled>
                                    </div>
                                </div>
                                <div class="form-group"><label class="col-md-3 control-label ">New S/N</label>
                                    <div class="col-md-9">
                                        <input type="text" name="rep_new_sn" placeholder="S/N ONT Baru" class="form-control m-b-sm">
                                    </div>
                                </div>
                                <div class="form-group"><label class="col-md-3 control-label ">Onu Type</label>
                                    <div class="col-md-9">
                                        <select name="rep_onutype" class="form-control">
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" id="btnSaveReplaceOnt" onclick="setReplaceOnt()"><span class="fa fa-clock"></span> Replace ONT</button>
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>


    <div class="modal fade" id="ticketsModal" tabindex="-1" role="dialog" aria-labelledby="ticketsLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="ticketsLabel">Tickets</h4>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <form id="formReplaceOnt" action="#" class="form-horizontal">
                            <div class="col-md-12">
                                <div class="form-group"><label class="col-md-3 control-label ">Interface ONU</label>
                                    <div class="col-md-9">
                                        <input type="text" name="tic_gpon_onu" class="form-control m-b-sm" disabled>
                                    </div>
                                </div>
                                <!-- <div class="form-group"><label class="col-md-3 control-label ">Name</label>
                                    <div class="col-md-9">
                                        <input type="text" name="tic_name" class="form-control m-b-sm" disabled>
                                    </div>
                                </div> -->
                                <div class="form-group"><label class="col-md-3 control-label ">Keluhan</label>
                                    <div class="col-md-9">
                                        <input type="text" name="tic_keluhan" class="form-control m-b-sm" disabled>
                                    </div>
                                </div>
                                <div class="form-group"><label class="col-md-3 control-label ">Scripts</label>
                                    <div class="col-md-9">
                                        <textarea id="skrip" name="tic_scripts" class="form-control" rows="10"></textarea>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" onclick="copyText()">Copy Scripts</button> 
                    <!-- <button type="button" class="btn btn-primary" id="btnSaveTickets" onclick="getTickets()"><span class="fa fa-clock"></span> Send to Teknisi</button> -->
                    <button type="button" class="btn btn-primary" id="btnSendTicketGroup" onclick="sendTicket('group')"><span class="fa fa-send"></span> Send to Group</button>
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <!-- <div class="modal fade" id="remoteOnuModal" tabindex="-1" role="dialog" aria-labelledby="remoteOnuLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="remoteOnuLabel">New message</h4>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <iframe id=frmx src="" frameborder="0" class="col-md-12" allowtransparency="true"></iframe>
                    </div>

                </div>
                <div class="modal-footer">
                    <button id="closeRemote" type="button" class="btn btn-default" data-dismiss="modal" onclick="">Selesai</button>
                </div>
            </div>
        </div>
    </div> -->




    <!-- Detail Modal -->
    <!-- <div class="modal inmodal" id="DetailModal" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog" style="width:60%">

                <div class="modal-content animated fadeInDown">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                        <h4 class="modal-title">Detail </?php echo ucwords(str_replace('_', ' ', $active)); ?></h4>
                        <small class="font-bold"></small>
                    </div>
                    <div class="modal-body">
                        <div class="row m-b-lg m-t-lg">
                            <div class="col-md-8">
                                <table class="table small m-b-xs">
                                    <tbody>
                                        <tr>
                                            <td>
                                                Nomor Pelanggan <h3><strong><span class="v1">No data</span></strong></h3>
                                            </td>
                                            <td>
                                                Nama Pelanggan <h3><strong><span class="v2">No data</span></strong></h3>
                                            </td>

                                        </tr>
                                        <tr>
                                            <td class="font-bold">
                                                Wilayah <h3><strong><span class="v3">No data</span></strong></h3>
                                            </td>
                                            <td class="font-bold">
                                                Email <h3><strong><span class="v4">No data</span></strong></h3>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="font-bold">
                                                Keterangan <h3><strong><span class="v10">No data</span></strong></h3>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <div class="col-md-4">
                                <table class="table small m-b-xs">
                                    <tbody>
                                        <tr>
                                            <td>
                                                Status <strong><span class="v5">No data</span></strong>
                                            </td>
                                            <td>
                                                Tarif <strong><span class="v6">No data</span></strong>
                                            </td>

                                        </tr>
                                        <tr>
                                            <td class="font-bold">
                                                Tgl Instalasi <h3><strong><span class="v7">No data</span></strong></h3>
                                            </td>
                                            <td class="font-bold">
                                                Telepon <h3><strong><span class="v8">No data</span></strong></h3>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <div class="col-md-3">
                                <small>Lokasi Map</small>
                                <h3 class="no-margins text-danger"><span class="v9">No data</span></h3>
                                <small>Aktif Iuran</small>
                                <dt class="text-bold"><span class="v11">No data</span></dt>
                            </div>
                        </div>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-white" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div> -->

    <!-- Form Laporan -->
    <!-- <div class="modal inmodal" id="myModal_laporan" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog" style="width:80%">
                <div class="modal-dialog">
                    <div class="modal-content animated flipInY">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                            <h4 class="modal-title">Laporan </?php echo ucwords(str_replace('_', ' ', $active)); ?> Pelanggan</h4>
                            <small class="font-bold"></small>
                        </div>
                        <div class="modal-body">
                            <div class="row">
                                <form id="form_laporan" action="#" class="form-horizontal">
                                    <div class="form-group"><label class="col-md-3 control-label ">Wilayah</label>
                                        <div class="col-md-9"><select name="lap_wilayah" class="form-control fokus"></select> <span class="help-block m-b-none"></span>
                                        </div>
                                    </div>

                                    <div class="form-group"><label class="col-md-3 control-label">Tanggal Pasang</label>
                                        <div class="col-md-9"><input type="text" name="lap_tgl_pasang" placeholder="Tanggal Pasang/Instalasi" class="form-control date"> <span class="help-block m-b-none"></span>
                                        </div>
                                    </div>

                                    <div class="form-group"><label class="col-md-3 control-label">Group All</label>
                                        <div class="col-md-9">
                                            <select name="lap_group_all" class="form-control">
                                                <option value=""></option>
                                                <option value="group_all"></option>
                                            </select>
                                            <span class="help-block m-b-none"></span>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-primary" id="btnGetLaporan" onclick="get_laporan()">Lihat Laporan</button>
                            <button type="button" class="btn btn-white" data-dismiss="modal">Close</button>
                        </div>
                    </div>
                </div>
            </div> -->