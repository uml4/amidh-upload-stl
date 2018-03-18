jQuery(function($) {

    var
        $customers_list     = $('#bookly-customers-list'),
        $filter             = $('#bookly-filter'),
        $check_all_button   = $('#bookly-check-all'),
        $customer_dialog    = $('#bookly-customer-dialog'),
        $add_button         = $('#bookly-add'),
        $delete_button      = $('#bookly-delete'),
        $delete_dialog      = $('#bookly-delete-dialog'),
        $delete_button_no   = $('#bookly-delete-no'),
        $delete_button_yes  = $('#bookly-delete-yes'),
        $remember_choice    = $('#bookly-delete-remember-choice'),
        remembered_choice,
        row
        ;

    $( "#appointment_date" ).datepicker({ 'setDate': 'today' ,dateFormat: "yy-mm-dd"}
           
            );
    /**
     * Init DataTables.
     */
    var dt = $customers_list.DataTable({
        order: [[ 0, 'asc' ]],
        info: false,
        searching: false,
        lengthChange: false,
        pageLength: 25,
        pagingType: 'numbers',
        processing: true,
        responsive: true,
        serverSide: true,
        ajax: {
            url : ajaxurl,
            type: 'POST',
            data: function (d) {
                return $.extend({}, d, {
                    action: 'bookly_get_patients',
                    csrf_token : BooklyL10n.csrf_token,
                    filter: $filter.val()
                });
            }
        },
        columns: [
            { data: 'full_name', render: $.fn.dataTable.render.text(), visible: BooklyL10n.first_last_name == 0 },
            { data: 'phone', render: $.fn.dataTable.render.text() },
            { data: 'email', render: $.fn.dataTable.render.text() },
            { data: 'notes', render: $.fn.dataTable.render.text() },
            { data: 'created_date', render: $.fn.dataTable.render.text() },
            { data: 'total_pictures' },
            {
                responsivePriority: 1,
                orderable: false,
                searchable: false,
                render: function ( data, type, row, meta ) {
                    return '<a href="'+BooklyL10n.url+'&todetail=1&sc='+row.id+'&p=0'+'" class="btn btn-default" ><i class="glyphicon glyphicon-edit"></i> Add picture</a>';
                }
            },
            {
                responsivePriority: 1,
                orderable: false,
                searchable: false,
                render: function ( data, type, row, meta ) {
                    return '<input type="checkbox" value="' + row.id + '">';
                }
            }
        ],
        dom: "<'row'<'col-sm-6'l><'col-sm-6'f>>" +
            "<'row'<'col-sm-12'tr>>" +
            "<'row pull-left'<'col-sm-12 bookly-margin-top-lg'p>>",
        language: {
            zeroRecords: BooklyL10n.zeroRecords,
            processing:  BooklyL10n.processing
        }
    });

    /**
     * Select all customers.
     */
    $check_all_button.on('change', function () {
        $customers_list.find('tbody input:checkbox').prop('checked', this.checked);
    });

    /**
     * On customer select.
     */
    $customers_list.on('change', 'tbody input:checkbox', function () {
        $check_all_button.prop('checked', $customers_list.find('tbody input:not(:checked)').length == 0);
    });

    /**
     * Edit customer.
     */
    $customers_list.on('click', 'button', function () {
        row = dt.row($(this).closest('td'));
    });

    /**
     * New customer.
     */
    $add_button.on('click', function () {
        row = null;
    });


    var mediaUploader;

    $('#upload-button').click(function (e) {
        e.preventDefault();
        // If the uploader object has already been created, reopen the dialog
        if (mediaUploader) {
            mediaUploader.open();
            return;
        }
        // Extend the wp.media object
        mediaUploader = wp.media.frames.file_frame = wp.media({
            title: 'Choose Image',
            button: {
                text: 'Choose Image'
            }, multiple: false});

        // When a file is selected, grab the URL and set it as the text field's value
        mediaUploader.on('select', function () {
            var attachment = mediaUploader.state().get('selection').first().toJSON();
            $('#bookly_cus_stl_file_link').val(attachment.url);
        });
        // Open the uploader dialog
        mediaUploader.open();
    });


  $('#save-patient-record').click(function (e) {
        e.preventDefault();
        var customer_id =  $('#ah_customer_id').val();
       // var stl_link =  $('#bookly_cus_stl_file_link').val();
        var appointment_date = $( "#appointment_date" ).val();
        
        if(appointment_date == ''){
            alert('Please select your appointment date');
            return ;
        }
        
        if(customer_id == '' ) {
            alert('Please select your customer');
            return ;
        }
        
        if(stl_link == '') {
            alert('Please select your file');
            return ;
        }
        var data = {};
        data.customer_id = customer_id;
    //    data.stl_link = stl_link;
        data.medical_comment = $('#medical_comment').val();
        data.appointment_date = appointment_date;
        
        $.ajax({
            url  : BooklyL10n.ajaxurl,
            type : 'POST',
            data : {
                action       : 'bookly_save_check_appointment',
                csrf_token   : BooklyL10n.csrf_token,
                data         : data,
            },
            dataType : 'json',
            success  : function(response) {
             //   ladda.stop();
                $customer_dialog.modal('hide');
                if (response.success) {
                    dt.ajax.reload(null, false);
                } else {
                    alert(response.data.message);
                }
            }
        });
        
        
        
        
    });

$('#save-patient-detail-record').click(function (e) {
        e.preventDefault();
        var customer_staff_id =  $('#customer-staff-id').val();
        var stl_link =  $('#bookly_cus_stl_file_link').val();
     
        
       
        
        if(customer_staff_id == '' ) {
            alert('There are something wrong , please go back.');
            return ;
        }
        
        if(stl_link == '') {
            alert('Please select your file');
            return ;
        }
        var data = {};
        data.customer_staff_id = customer_staff_id;
        data.stl_link = stl_link;
        data.medical_comment = $('#medical_comment').val();
        
        $.ajax({
            url  : BooklyL10n.ajaxurl,
            type : 'POST',
            data : {
                action       : 'bookly_save_appointment_detail',
                csrf_token   : BooklyL10n.csrf_token,
                data         : data,
            },
            dataType : 'json',
            success  : function(response) {
             //   ladda.stop();
                $customer_dialog.modal('hide');
                if (response.success) {
                    location.reload();
                    
                } else {
                    alert(response.data.message);
                }
            }
        });
        
        
        
        
    });


    /**
     * On show modal.
     */
    $customer_dialog.on('show.bs.modal', function () {
        $('#bookly_cus_stl_file_link').val();
    });

    /**
     * Delete customers.
     */
    $delete_button.on('click', function () {
        if (remembered_choice === undefined) {
            $delete_dialog.modal('show');
        } else {
            deleteCustomers(this, remembered_choice);
        }}
    );

    $delete_button_no.on('click', function () {
        if ($remember_choice.prop('checked')) {
            remembered_choice = false;
        }
        deleteCustomers(this, false);
    });

    $delete_button_yes.on('click', function () {
        if ($remember_choice.prop('checked')) {
            remembered_choice = true;
        }
        deleteCustomers(this, true);
    });

    function deleteCustomers(button, with_wp_user) {
        var ladda = Ladda.create(button);
        ladda.start();

        var data = [];
        var $checkboxes = $customers_list.find('tbody input:checked');
        $checkboxes.each(function () {
            data.push(this.value);
        });

        $.ajax({
            url  : ajaxurl,
            type : 'POST',
            data : {
                action       : 'bookly_delete_patient_appointments',
                csrf_token   : BooklyL10n.csrf_token,
                data         : data,
                with_wp_user : with_wp_user ? 1 : 0
            },
            dataType : 'json',
            success  : function(response) {
                ladda.stop();
                $delete_dialog.modal('hide');
                if (response.success) {
                    dt.ajax.reload(null, false);
                } else {
                    alert(response.data.message);
                }
            }
        });
    }

    /**
     * On filters change.
     */
    $filter.on('keyup', function () { dt.ajax.reload(); });
});
