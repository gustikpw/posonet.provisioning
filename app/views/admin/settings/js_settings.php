<script src="<?php echo base_url('assets/inspinia271/js/plugins/dataTables/datatables.min.js') ?>"></script>


<script>
    $(document).ready(function() {
        getRekening();

        $('[name="level"]').load("<?= site_url('getselect/get_enum_values/users/level') ?>");
        $('[name="id_karyawan"]').load("<?= site_url('getselect/pilih_mul/karyawan/id_karyawan/nama_lengkap') ?>");


        tableUsers = $('#tableUsers').DataTable({
            "processing": true, //Feature control the processing indicator.
            "serverSide": true, //Feature control DataTables' server-side processing mode.
            "order": [], //Initial no order.
            // Load data for the table's content from an Ajax source
            "ajax": {
                "url": "<?php echo site_url('settings/ajax_list')?>",
                "type": "POST"
            },
            //Set column definition initialisation properties.
            "columnDefs": [
            {
                "targets": [ -1 ], //last column
                "orderable": false, //set not orderable
            },
            ],

            // pageLength: 25,
            info: false,
            paging: false,
            responsive: true,
            dom: '<"html5buttons"B>lTfgitp',
            buttons: [
                {
                text: '<span class="text-success"><i class="fa fa-plus"></i> Tambah</span>',
                action: function ( e, dt, node, config ) {
                    adds();
                }
                },
                
            ]

        });
    });

    var save_method;

    function reload_table(){
    table.ajax.reload(null,false); //reload datatable ajax
    }

    function adds()
    {
        save_method = 'add';
        $('#form')[0].reset(); // reset form on modals
        $('[name="id_paket"]').val('');
        $('#myModal').modal('show'); // show bootstrap modal
        $('.help-block').empty();
        $('.fokus').focus();
        $('.modal-title').text('Add <?php echo ucwords(str_replace('_',' ',$active)); ?>'); // Set Title to Bootstrap modal title
    }

    function getRekening(){
        $.get("<?= site_url('settings/get_rekening') ?>",
        function(data, status) {
            $('[name="nama_bank"]').val(data[0]);
            $('[name="no_rekening"]').val(data[2]);
            $('[name="nama_pemilik_pekening"]').val(data[1]);

            console.log(data);
        }, 'json');


    }

    function save(settings){
        if(settings == 'rekening'){
            $.post(
                "<?= site_url('settings/save_rekening') ?>", {
                    bank: $('[name="nama_bank"]').val(),
                    norek: $('[name="no_rekening"]').val(),
                    nama_pemilik_pekening: $('[name="nama_pemilik_pekening"]').val(),
                },
                function(data, status) {
                    if (status) {
                        console.log(data.message);
                        alert(data.message);
                        $("#btnSaveRek").text('Saved').attr('disabled',true);
                    }
                },
                'json')
            }
            if(settings == 'users'){
                console.log($("form_users").serialize());
                $.ajax({
                    url: "<?= site_url('settings/save_users') ?>",
                    type: "POST",
                    data: $("formUsers").serialize(),
                    dataType: "JSON",
                    success: function(data) {
                        if (data.status) {
                            console.log(data.message);
                            alert(data.message);
                            $("#btnSaveUsers").text('Saved').attr('disabled',true);
                        }
                    },
                    error: function(e){

                    }
                });

            }
    }

    function upperCase() {
        const x = document.getElementById("bank");
        x.value = x.value.toUpperCase();
    }
</script>