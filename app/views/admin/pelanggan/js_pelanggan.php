<script src="<?= base_url('assets/inspinia271/js/plugins/dataTables/datatables.min.js') ?>"></script>
<script src="<?= base_url('assets/inspinia271/js/plugins/bootstrapTour/bootstrap-tour.min.js') ?>"></script>
<script src="<?= base_url('assets/inspinia271/js/plugins/datapicker/bootstrap-datepicker.js') ?>"></script>
<script src="<?= base_url('assets/inspinia271/js/plugins/select2/select2.full.min.js') ?>"></script>
<!-- <script src="</?php //echo base_url('assets/inspinia271/js/plugins/chosen/chosen.jquery.js') ?>"></script> -->

<script>
  var save_method, wilMethod, pdf_data;

  $(function() {
    getSelect();
  });

  function getSelect() {
    $('[name="id_wilayah"]').load("<?= site_url('getselect/pilih_mul/wilayah/id_wilayah/wilayah') ?>");
    $('[name="id_paket"]').load("<?= site_url('getselect/pilih_mul_dua/paket/id_paket/tarif/nama_paket') ?>");
    $('[name="status"]').load("<?= site_url('getselect/get_enum_values/pelanggan/status') ?>");
  }

  var id_wilayah = $('[name="id_wilayah"]').select2({
    placeholder: "Pilih Wilayah Pelanggan Berdomisili",
    width: "100%",
    // dropdownParent : $('.myModal')
  });
  var id_paket = $('[name="id_paket"]').select2({
    placeholder: "Pilih Paket Berlangganan",
    width: "100%",
    // dropdownParent : $('#myModal')
  });
  var zstatus = $('[name="status"]').select2({
    placeholder: "Pilih Status Berlangganan",
    width: "100%",
    // dropdownParent : $('#myModal')
  });

  var table, pdfdata;
  $(document).ready(function() {
    $('.btnFokus').focus(); // fokus ke field ketika tombol tambah di klik
    $('.date').datepicker({
      todayBtn: "linked",
      keyboardNavigation: true,
      forceParse: false,
      calendarWeeks: true,
      autoclose: true,
      format: "yyyy-mm-dd",
      language: 'id'
    });

    $("[name='id_wilayah']").on("change", function() {
      if (save_method == 'add') {
        getCode(id_wilayah.val());
      } else if (save_method == 'update' && wilMethod == 'on') {
        getCode(id_wilayah.val());
      }
    });

    table = $('#table').DataTable({
      processing: true, //Feature control the processing indicator.
      serverSide: true, //Feature control DataTables' server-side processing mode.
      order: [], //Initial no order.
      // Load data for the table's content from an Ajax source
      ajax: {
        url: "<?= site_url('pelanggan/ajax_list') ?>",
        type: "POST",
        data: function(d) {
          pdf_data = d;
        }
      },
      // scrollY:        "500px",
      // scrollX:        true,
      // scrollCollapse: true,
      // paging:         false,
      // fixedColumns:   true,
      //Set column definition initialisation properties.
      columnDefs: [{
          visible: false,
          targets: [3], //last column
          // orderable: false, //set not orderable
        },
        {
          targets: [-1], //last column
          orderable: false, //set not orderable
        },
      ],

      // Grouping
      // drawCallback: function(settings) {
      //   var api = this.api();
      //   var rows = api.rows({
      //     page: 'current'
      //   }).nodes();
      //   var last = null;

      //   api.column(3, {
      //     page: 'current'
      //   }).data().each(function(group, i) {
      //     if (last !== group) {
      //       $(rows).eq(i).before(
      //         '<tr class="group bg-default"><td colspan="9" class="font-bold">' + group + '</td></tr>'
      //       );

      //       last = group;
      //     }
      //   });
      // },

      pageLength: 25,
      // responsive: true,
      dom: '<"html5buttons"B>lTfgitp',
      buttons: [{
          // text: '<span class="text-success" id="step1"><i class="fa fa-plus"></i> Tambah</span>',
          // action: function(e, dt, node, config) {
          //   adds();
          // }
          text: 'DyingGasp',
          action: function(e, dt, node, config) {
            table.search('DyingGasp').draw();
          }
        },

        {
          extend: 'print',
          exportOptions: {
            columns: [1, 2, 3, 4, 5, 6, 7]
          },
          customize: function(win) {
            $(win.document.body).addClass('white-bg');
            $(win.document.body).css('font-size', '10px');

            $(win.document.body).find('table')
              .addClass('compact')
              .css('font-size', 'inherit');
          }
        }
      ]

    });

    <?php
    if (isset($_GET['search'])) {
      echo "table.search('" . html_escape($this->input->get('search')) . "').draw();";
    }
    ?>

    $("input").change(function() {
      $(this).parent().parent().removeClass('has-error');
      $(this).next().empty();
    });
    $("textarea").change(function() {
      $(this).parent().parent().removeClass('has-error');
      $(this).next().empty();
    });
  });
</script>

<script type="text/javascript">
  function tespdf() {
    $.ajax({
      url: "http://localhost/posotv.org/pelanggan/exportpdf",
      type: "POST",
      data: pdf_data,
      dataType: "JSON",
      success: function(data) {
        console.log(data);
      }
    });
  }

  function reload_table() {
    table.ajax.reload(null, false); //reload datatable ajax
  }

  function getCode(wil) {
    $.ajax({
      url: "<?= site_url('pelanggan/getcodenew/') ?>" + wil,
      type: "GET",
      dataType: "JSON",
      success: function(data) {
        $('[name="no_pelanggan"]').val(data.newCode).attr("readonly", "true");
      },
      error: function(jqXHR, textStatus, errorThrown) {
        notif('Gagal mengambil Kode Pelanggan Baru! \n' + errorThrown, 'Error', 'error');
      }
    });
  }

  function adds() {
    save_method = 'add';
    wilMethod = 'on';
    // $('#form')[0].reset(); // reset form on modals
    $('[name="id_pelanggan"]').val('');
    $('.ketupload').text('Pilih file foto ktp!');
    $('.ktpfilename').val('');
    id_wilayah.val(null);
    id_paket.val(null).trigger('change');
    zstatus.val(null).trigger('change');
    $('#myModal').modal('show'); // show bootstrap modal
    $('.help-block').empty();
    $('.form-group').removeClass('has-error');
    $('.fokus').focus();
    $('.modal-title').text('Add <?= ucwords(str_replace('_', ' ', $active)); ?>'); // Set Title to Bootstrap modal title
  }

  function save() {
    var url;
    if ($('[name="id_paket"]').val() == null || $('[name="status"]').val() == '') {
      alert('Isi kolom yang kosong! (PAKET & STATUS wajib diisi)');
      return;
    }

    $("#btnSave").text('Registering ONU...');
    $("#btnSave").attr('disabled', true);

    if (save_method == 'add') {
      url = "<?= site_url('pelanggan/save_pelanggan') ?>";
    } else {
      url = "<?= site_url('pelanggan/update_pelanggan') ?>";
    }
    // validateKtp();

    // ajax adding data to database
    $.ajax({
      url: url,
      type: "POST",
      data: new FormData(document.getElementById("form")),
      processData: false,
      contentType: false,
      cache: false,
      async: false,
      // data: $('#form').serialize(),
      dataType: "JSON",
      success: function(data) {
        if (data.status) //if success close modal and reload ajax table
        {
          $('#myModal').modal('hide');
          $('.btnFokus').focus();
          notif('Berhasil menambah/edit data!', 'Sukses', 'success');
          tbl_unconfig.destroy().clear();
          uncfg();
          setTimeout(function() {
            connection_status();
            reload_table();
          }, 5000);
        } else {
          for (var i = 0; i < data.inputerror.length; i++) {
            $('[name="' + data.inputerror[i] + '"]').parent().parent().addClass('has-error'); //select parent twice to select div form-group class and add has-error class
            $('[name="' + data.inputerror[i] + '"]').next().text(data.error_string[i]); //select span help-block class set text error string
          }
        }
        $('#btnSave').text('Register ONU'); //change button text
        $('#btnSave').attr('disabled', false); //set button enable
      },
      error: function(jqXHR, textStatus, errorThrown) {
        notif('Gagal mengUpdate data! \n' + errorThrown, 'Error', 'error');
        $('#btnSave').text('Register ONU'); //change button text
        $('#btnSave').attr('disabled', false); //set button enable
      }
    });
  }

  function edits(id) {
    $('.ketupload').text('Pilih file jika ingin mengganti foto ktp. Abaikan jika tdk ingin mengubahnya!');
    save_method = 'update';
    $('.form-group').removeClass('has-error');
    $('.help-block').empty();

    wilMethod = 'off';
    $('#form')[0].reset(); // reset form on modals
    $.ajax({
      url: "<?= site_url('pelanggan/get_edit/') ?>" + id,
      type: "GET",
      dataType: "JSON",
      success: function(data) {
        $('[name="id_pelanggan"]').val(data.id_pelanggan);
        $('[name="no_pelanggan"]').val(data.no_pelanggan);
        id_wilayah.val(data.id_wilayah).trigger('change');
        wilMethod = 'on';
        id_paket.val(data.id_paket).trigger('change');
        zstatus.val(data.status).trigger('change');
        $('[name="nama_pelanggan"]').val(data.nama_pelanggan);
        $('[name="telp"]').val(data.telp);
        $('[name="email"]').val(data.email);
        $('[name="tgl_instalasi"]').val(data.tgl_instalasi);
        $('[name="lokasi_map"]').val(decodeURIComponent(data.lokasi_map));
        $('[name="keterangan"]').val(data.keterangan);
        $('[name="no_ktp"]').val(data.no_ktp);

        //OLT
        $('[name="interface"]').val(data.gpon_olt);
        $('[name="onutype"]').val(data.onu_type);
        $('[name="service_mode"]').val(data.access_mode);
        $('[name="serial_number"]').val(data.serial_number);
        $('[name="expired"]').val(data.expired);


        $('.ktpfilename').text(data.ktp_filename);
        $('#myModal').modal('show');
        $('.modal-title').text('Edit <?= ucwords(str_replace('_', ' ', $active)); ?>');
      },
      error: function(jqXHR, textStatus, errorThrown) {
        notif('Gagal mengambil data! \n' + errorThrown, 'Error', 'error');
      }
    });
  }

  function deletes(id) {
    if (confirm('Yakin menghapus pelanggan ini?\nSebaiknya data ini diedit, buat Nama Pelanggan KOSONG & status NONAKTIF! Agar nomor pelanggan ini dapat digunakan kembali.')) {
      $.ajax({
        url: "<?= site_url('pelanggan/delete_pelanggan') ?>/" + id,
        type: "POST",
        dataType: "JSON",
        success: function(data) {
          notif('Berhasil menghapus data!', 'Sukses', 'success');
          reload_table();
          $('.btnFokus').focus();
        },
        error: function(jqXHR, textStatus, errorThrown) {
          notif('Gagal menghapus data!', 'Error', 'error');
        }
      });

    }
  }

  function views(id) {
    $.ajax({
      url: "<?= site_url('pelanggan/vget_edit/') ?>" + id,
      type: "GET",
      dataType: "JSON",
      success: function(data) {
        $('.v1').text(data.no_pelanggan);
        $('.v2').text(data.nama_pelanggan);
        $('.v3').text(data.wilayah);
        $('.v4').text(data.email);
        $('.v6').html(data.tarif);
        $('.v5').html(data.status);
        $('.v7').text(data.tgl_instalasi);
        $('.v8').text(data.telp);
        $('.v9').html(data.lokasi_map);
        $('.v10').html("<span class='text-danger'>" + data.keterangan + "</span>");
        $('.v11').html("<span class='text-default'>" + data.expired + "</span>");
        $('#DetailModal').modal('show');
        $('.modal-title').text('Detail <?= ucwords(str_replace('_', ' ', $active)); ?>');
      },
      error: function(jqXHR, textStatus, errorThrown) {
        notif('Gagal mengambil data!', 'Error', 'error');
      }
    });
  }

  function get_laporan() {
    kodewil = lapWilayah.val();
    status = '';
    link = "<?= site_url() ?>laporan/pelanggan?wilayah=" + kodewil + "&status=" + status;
    window.open(link, '', 'width=800,height=600');
  }

  function validateKtp() {
    if ($('[name="ubahfoto"]').not(':checked') && $('[name="no_ktp"]').val() == '') {
      alert('No KTP dan File KTP harus diisi!');
      return;
    }
  }

  function ubahFoto() {
    if ($('[name="ubahfoto"]').is(':checked')) {
      $('[name="ubahfoto"]').prop('checked', true);
      $('.ketupload').text('File foto ktp siap diupload!');
    } else if ($('[name="ubahfoto"]').not(':checked')) {
      $('[name="ubahfoto"]').prop('checked', true);
      $('.ketupload').text('File foto ktp siap diupload!');
    } else {
      $('[name="ubahfoto"]').prop('checked', false);
    }
  }
</script>

<script>
  var tbl_unconfig;

  function uncfg() {
    tbl_unconfig = $('#tb-unconfig').DataTable({
      ajax: {
        'url': "<?= site_url('api_rest_client/newunconfig') ?>",
        'dataSrc': function(d) {
          if (d.status != '200') {
            $('#unconfig').hide();
          } else {
            notif(d.message, 'Founds', 'success');
            $('.uncfg').text(d.message);
            $('#unconfig').show()
            //setelah data uncfg ditampilkan, kirim perintah utk proses reconfig/pindah port jika ada
            if(d.reconfig > 0 || d.pindah_port > 0){
              reconfig();
            }
          }
          return d.data
        }
      },
      searching: false,
      paging: false,
      info: false
    });


  }

  function reconfig() {
    notif('Memulai Reconfig.. Tunggu beberapa saat...', 'Reconfig', 'info');

    $.ajax({
      url: "<?= site_url('api_rest_client/reconfig') ?>",
      type: "POST",
      dataType: "JSON",
      success: function(data) {
        notif(data.message, 'Reconfig success', 'success');
      },
      error: function(jqXHR, textStatus, errorThrown) {
        notif('Gagal Reconfig!', 'Error', 'error');
        console.log(textStatus);
      }
    });
  }

  function onutype() {
    $.ajax({
      url: "<?= site_url('api_rest_client/onutype') ?>",
      type: "POST",
      dataType: "JSON",
      success: function(data) {
        $('[name="onutype"]').html(data.data);
        $('[name="rep_onutype"]').html(data.data);
      },
      error: function(jqXHR, textStatus, errorThrown) {
        notif('Gagal mengambil OnuType!', 'Error', 'error');
      }
    });
  }

  function regis(interface, model, sn) {
    console.log(interface + model + sn)
    $('#form')[0].reset(); // reset form on modals
    $('[name="interface"]').val(interface);
    $('[name="serial_number"]').val(sn);
    adds()
  }

  function delonu(gpon_onu, permanent = 'no') {
    if (permanent == 'yes') {
      msg = 'Data pelanggan di Database & OLT akan dihapus secara permanent! Yakin?';
    } else {
      msg = 'Data pelanggan di OLT akan dihapus dan akan dikonfigurasi secara otomatis!';
    }
    // if (confirm('Yakin menghapus pelanggan ini?\nSebaiknya data ini diedit, buat Nama Pelanggan KOSONG & status NONAKTIF! Agar nomor pelanggan ini dapat digunakan kembali.')) {
    if (confirm('Perhatian! ' + msg)) {
      $.post("<?= site_url('api_rest_client/no_onu') ?>", {
          gpon_onu: gpon_onu,
          permanent: permanent,
        },
        function(data, status) {
          if (status) notif(data.message, 'Sukses', 'success');
          reload_table();
          setTimeout(function() {
            // Code to be executed after the delay
            tbl_unconfig.destroy().clear();
            uncfg()
          }, 2000);
        },
        'json'
      );
    }
  }

  function show_raw_content(mode, data) {
    if (mode == 'attenuation') {
      url = "<?= site_url('api_rest_client/raw_attenuation') ?>";
    }
    if (mode == 'iphost') {
      url = "<?= site_url('api_rest_client/raw_iphost') ?>";
    }
    if (mode == 'wanip') {
      url = "<?= site_url('api_rest_client/raw_wanip') ?>";
    }
    if (mode == 'detail-info') {
      url = "<?= site_url('api_rest_client/raw_detailinfo') ?>";
    }
    if (mode == 'onu-run') {
      url = "<?= site_url('api_rest_client/raw_onu_runcfg') ?>";
    }
    if (mode == 'card') {
      url = "<?= site_url('api_rest_client/raw_card') ?>";
    }
    if (mode == 'vlan-summary') {
      url = "<?= site_url('api_rest_client/raw_vlan_summary') ?>";
    }
    if (mode == 'gpon-profile-vlan') {
      url = "<?= site_url('api_rest_client/raw_gpon_onu_profile_vlan') ?>";
    }
    if (mode == 'gpon-profile-tcont') {
      url = "<?= site_url('api_rest_client/raw_gpon_profile_tcont') ?>";
    }
    if (mode == 'gpon-profile-traffic') {
      url = "<?= site_url('api_rest_client/raw_gpon_profile_traffic') ?>";
    }
    if (mode == 'onu-type') {
      url = "<?= site_url('api_rest_client/raw_onu_type') ?>";
    }
    if (mode == 'ip-route') {
      url = "<?= site_url('api_rest_client/raw_ip_route') ?>";
    }

    $.post(url, {
        data: data,
      },
      function(data, status) {
        $('#rawdata').html(data.data);
        $('#exampleModalLabel').html(data.header);
        $('#exampleModal').modal('show');
      },
      'json'
    );
  }

  function reboot(gpon_onu) {
    $.post(
      "<?= site_url('api_rest_client/reboot') ?>", {
        gpon_onu: gpon_onu
      },
      function(data, status) {
        if (status) notif(data.message, 'Sukses', 'success');
      })
  }

  function restore_factory(gpon_onu) {
    if (confirm('Data SSID akan hilang\nSebaiknya dicatat data SSID pada pelanggan sebelum mereset ONU!')) {
      $.post(
        "<?= site_url('api_rest_client/restore_factory') ?>", {
          gpon_onu: gpon_onu
        },
        function(data, status) {
          if (status) notif(data.message, 'Sukses', 'success');
        })
    }
  }

  function remote(gpon_onu, remote_state) {
    $.post(
      "<?= site_url('api_rest_client/remote_onu') ?>", {
        gpon_onu: gpon_onu,
        remote_state: remote_state,
        host_id: '1',
      },
      function(data, status) {
        if (status) {
          notif(data.message, 'Remote Web', 'success');
          if (remote_state == 'enable') window.open(data.link, '_blank');
          // if (remote_state == 'enable') {
          //   $('#remoteOnuModal').modal('show');
          //   $('#frmx').attr('src', data.link);
          //   $('#closeRemote').attr('onclick', "remote('" + gpon_onu + "','disable')");
          // } else {
          //   $('#remoteOnuModal').modal('hide');
          // }
          reload_table();
        } else notif('Error preparing remote web', 'Remote Web', 'error');
      },
      'json')
  }

  function onustate() {
    $.post(
      "<?= site_url('api_rest_client/onustate') ?>",
      function(data, status) {
        if (status) {
          // $('.v_online').html(data.online);
          $('.v_offline').html(data.offline);
          $('.v_los').html(data.los);
          $('.v_ont').html(data.total);
          reload_table();
        } else notif('Error getting ontphase', 'Status ONT', 'error');
      },
      'json')
  }

  var tbl_offline;

  function offline() {
    tbl_offline = $('#tb-offline').DataTable({
      ajax: {
        'url': "<?= site_url('api_rest_client/offline') ?>",
        'dataSrc': function(d) {
          if (d.status != '200') {
            $('#offline').hide();
          } else {
            $('#offline').show()
            return d.data
          }
        }
      },
      searching: true,
      paging: true,
      info: false
    });
  }

  function expired() {
    // tbl_expired.destroy().clear();

    tbl_expired = $('#tb-expired').DataTable({
      ajax: {
        'url': "<?= site_url('api_rest_client/expired') ?>",
        'dataSrc': function(d) {
          if (d.status != '200') {
            $('#expired').hide();
          } else {
            $('#expired').show()
            return d.data
          }
        }
      },
      searching: false,
      paging: false,
      info: false
    });
  }

  function setExpired() {
    $.get("<?= site_url('api_rest_client/setToExpire') ?>", function(data, status) {
      if (status) console.log('Merubah paket profile di router');
    });

  }

  function los() {
    tbl_los = $('#tb-los').DataTable({
      ajax: {
        'url': "<?= site_url('api_rest_client/los') ?>",
        'dataSrc': function(d) {
          if (d.status != '200') {
            $('#los').hide();
          } else {
            $('#los').show()
          }
          return d.data
        }
      },
      searching: false,
      paging: false,
      info: false
    });
  }

  function connection_status() {
    $.get("<?= site_url('api_mikrotik/all_ppp_active') ?>",
      function(data, status) {
        console.log("Message: " + data.message + "\nStatus: " + status);
      }, 'json');
  }

  function extendPaket(gpon_onu) {
    $.post(
      "<?= site_url('api_rest_client/getExtendPaket') ?>", {
        gpon_onu: gpon_onu
      },
      function(data, status) {
        $('#extendPaketLabel').html('Perpanjang Paket ' + data.name + ' | ' + data.gpon_onu);
        $('[name="md_nama_paket"]').val(data.nama_paket);
        $('[name="md_gpon_onu"]').val(data.gpon_onu);
        $('[name="md_tgl_expired"]').val(data.expired);
        $('#extendPaket').modal('show');
      }, 'json')
  }

  function setTgl(param) {
    $("[name='md_tgl_expired']").val(param);
  }

  function setExtendPaket() {
    $("#btnSaveExtendPaket").text('Processing...');
    $('#btnSaveExtendPaket').attr('disabled', true);
    $.post(
      "<?= site_url('api_rest_client/setExtendPaket') ?>", {
        gpon_onu: $('[name="md_gpon_onu"]').val(),
        expired: $('[name="md_tgl_expired"]').val(),
      },
      function(data, status) {
        if (status) {
          $('#extendPaket').modal('hide');
          notif(data.message, 'Perpanjang Paket', 'success');
          reload_table();
          $("#btnSaveExtendPaket").text('Perpanjang');
          $('#btnSaveExtendPaket').attr('disabled', false);
        }
      },
      'json')
  }

  function update_onurx() {
    notif('Please wait a few seconds...', 'Updating on progress', 'success');
    $.get("<?= site_url('api_rest_client/pon_power_onurx') ?>",
      function(data, status) {
        notif(data.message, 'Updating power ONU Rx', 'success');
        console.log("Message: " + data.message + "\nStatus: " + status);
      }, 'json');
  }

  function getReplaceOnt(gpon_onu) {
    $.post(
      "<?= site_url('api_rest_client/getReplaceOnt') ?>", {
        gpon_onu: gpon_onu
      },
      function(data, status) {
        $('[name="rep_gpon_onu"]').val(data.gpon_onu);
        $('[name="rep_onutype"]').val(data.onu_type);
        $('[name="rep_name"]').val(data.name);
        $('[name="rep_old_sn"]').val(data.serial_number);
        $('#replaceOntModal').modal('show');
      }, 'json')
  }

  function setReplaceOnt() {
    $("#btnSaveReplaceOnt").text('Processing...');
    $('#btnSaveReplaceOnt').attr('disabled', true);
    $.post(
      "<?= site_url('api_rest_client/replaceOnt') ?>", {
        gpon_onu: $('[name="rep_gpon_onu"]').val(),
        rep_onutype: $('[name="rep_onutype"]').val(),
        rep_new_sn: $('[name="rep_new_sn"]').val(),
      },
      function(data, status) {
        if (status) {
          $('#replaceOntModal').modal('hide');
          notif(data.message, 'Replace ONT successfull', 'success');
          reload_table();
          $("#btnSaveReplaceOnt").text('Replace ONT');
          $('#btnSaveReplaceOnt').attr('disabled', false);
        }
      },
      'json')
  }

  function makeTickets(gpon_onu) {
    $.post(
      "<?= site_url('api_rest_client/getTicketsD') ?>", {
        gpon_onu: gpon_onu
      },
      function(data, status) {
        if (status) {
          $('[name="tic_gpon_onu"]').val(gpon_onu);
          $('[name="tic_scripts"]').val(data.teks);
          navigator.clipboard.writeText(data.teks);
          $('#ticketsModal').modal('show');
          // $('#ticketsModal').modal('hide');
          // notif(data.message, 'Tickets successfull', 'success');
          // $("#btnSaveTickets").text('Make Ticket');
          // $('#btnSaveTickets').attr('disabled', false);
        }
      },
      'json')
  }

  function getTickets() {
    $("#btnSaveTickets").text('Processing...');
    $('#btnSaveTickets').attr('disabled', true);
    $.post(
      "<?= site_url('api_rest_client/getTickets') ?>", {
        gpon_onu: $('[name="tic_gpon_onu"]').val(),
        tic_keluhan: $('[name="tic_keluhan"]').val(),
      },
      function(data, status) {
        if (status) {
          $('[name="tic_scripts"]').text(data.teks);
          navigator.clipboard.writeText(data.teks);
          // $('#ticketsModal').modal('hide');
          // notif(data.message, 'Tickets successfull', 'success');
          $("#btnSaveTickets").text('Make Ticket');
          $('#btnSaveTickets').attr('disabled', false);
        }
      },
      'json')
  }

  function copyText() {
    // Get the text field
    var copyText = document.getElementById("skrip");

    // Select the text field
    copyText.select();
    copyText.setSelectionRange(0, 99999); // For mobile devices

    // Copy the text inside the text field
    navigator.clipboard.writeText(copyText.value);

    // Alert the copied text
    // alert("Copied the text: " + copyText.value);
  }



  let wamode = false;

  function modewa(x) {
    wamode = !wamode;
    console.log(wamode);
  }

  $(document).ready(function() {
    connection_status();
    setExpired();
    onustate();
    uncfg();
    onutype();
    expired();
    offline();
    los();
  });

  setInterval(function() {
    connection_status();
    tbl_offline.destroy().clear();
    tbl_expired.destroy().clear();
    tbl_unconfig.destroy().clear();
    tbl_los.destroy().clear();
    onustate();
    offline();
    expired();
    uncfg();
    los();
  }, 300000); //ms
</script>
</body>

</html>