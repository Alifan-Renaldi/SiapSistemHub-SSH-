$(document).ready(function() {   
 "use strict";
 
  $.validator.setDefaults({
    submitHandler: function () {
      form.submit();
    }
  });

     $(".loader-wrapper").fadeOut("slow");

    setTimeout(function() {
      $('#alertmessage').fadeOut('slow');
    }, 5000);
    // tracking fadeout
    var lastPart = window.location.href.split("/").pop();
    if(lastPart!='tracking')
    {
        localStorage.clear();
    }
    setTimeout(function() {
        $('#message').fadeOut('slow');
    }, 5000);

    // datepicker
    $('.datepicker').datepicker({
        format: 'yyyy/mm/dd',
        autoclose: true,
        todayHighlight: true
    });
    $('.datepickerfuturedisable').datepicker({
        format: 'yyyy/mm/dd',
        autoclose: true,
        endDate: '+0d',
        todayHighlight: true
    });

    $('.datepickerpastdisable').datepicker({
        format: 'yyyy/mm/dd',
        autoclose: true,
        startDate: new Date(),
        todayHighlight: true
    }); 

    $("input").attr("autocomplete", "off");
    // customer selectize
    $('.selectized').selectize();
    // trip pending amount
    $("#t_trip_paymentstatus").change(function() {
        var selectedVal = $('option:selected', this).text();
        console.log(selectedVal);
        if (selectedVal == "pending") {
            $('.t_trip_pendingamount').css('display', 'block');

        } else {
            $('.t_trip_pendingamount').css('display', 'none');
        }
    });
    $.validator.addMethod('lessThanEqual', function(value, element, param) {
        if (this.optional(element)) return true;
        var i = parseInt(value);
        var j = parseInt($('#pendingamount').val());
        return i <= j;
    }, "");

        // Custom validation method for checkbox groups
        $.validator.addMethod("at_least_one", function(value, element) {
            const groupName = $(element).attr('name');
            const checked = $('input[name="' + groupName + '"]:checked').length > 0;
            return checked;
        }, "Field ini wajib diisi.");

        $.validator.addMethod("at_least_radio", function(value, element) {
            const groupName = $(element).attr('name');
            const checked = $('input[name="' + groupName + '"]:checked').length > 0;
            return checked;
        }, "Field ini wajib diisi.");

    // jquery validate
    $('#add_driver,#add_driversblacklist,#add_bap,#add_survey,#add_loan,#vehicle_add,#inventory_add,#handover_add,#customer_add,#login,#trip_add,#Income_Expense,#fuel,#track,#geofencesave,#trippayments,.basicvalidation,#smtpconfigtestemail').validate({
        errorClass: "invalid-feedback",
        rules: {
        	 testemailto : {
                required: true,
                 email: true,
            },
            password : {
                minlength : 5
            },
            cnfpassword : {
                minlength : 5,
                equalTo : "#password"
            },
            //Validate Data Driver
            d_name: {
                required: true,
            },
            d_nickname: {
                required: true,
            },
            d_pob: {
                required: true,
            },
            d_dob: {
                required: true,
            },
            d_married: {
                required: true,
            },
            d_education: {
                required: true,
            },
            d_mobile: {
                required: true,
                number: true,
                minlength: 9,
                maxlength: 15,
            },
            d_address: {
                required: true,
            },
            d_province: {
                required: true,
            },
            d_city: {
                required: true,
            },
            d_subdistrict: {
                required: true,
            },
            d_village: {
                required: true,
            },
            d_identityno: {
                required: true,
                number: true,
                minlength: 15,
                maxlength: 25,
            },
            d_identity_expdate: {
                required: true,
            },
            d_licenseno: {
                required: true,
                number: true,
                minlength: 10,
                maxlength: 20,
            },
            d_license_expdate: {
                required: true,
            },
            d_cardbpjs: {
                required: true,
            },
            d_ref: {
                required: true,
            },
            d_total_exp: {
                required: true,
            },
            d_doj: {
                required: true,
            },
            d_notes_blacklist: {
                required: true,
            },
            
            d_docstatus: {
                at_least_radio: true,
            },

            //Validate Data BAP
            b_supir: {
                required: true,
            },
            b_nopol: {
                required: true,
            },
            b_muatan: {
                required: true,
            },
            b_tanggal_kejadian: {
                required: true,
            },
            b_keberangkatan: {
                required: true,
            },
            b_lokasi_muat: {
                required: true,
            },
            b_lokasi_bongkar: {
                required: true,
            },
            b_lokasi_kejadian: {
                required: true,
            },
            b_estimasi_klaim: {
                required: true,
            },
            b_jenis_kasus: {
                required: true,
            },
            b_kondisi_barang: {
                required: true,
            },
            
            b_korelasi_kasus: {
                required: true,
            },
            b_realisasi_klaim: {
                required: true,
            },
            b_posisi_barang: {
                required: true,
            },
            b_potong_tagihan: {
                required: true,
            },
            b_kronologi_kejadian: {
                required: true,
            },

            //Validate Data Survey
            s_petugas: {
                required: true,
            },
            s_tanggal: {
                required: true,
            },
            s_supir: {
                required: true,
            },
            s_istri: {
                required: true,
            },
            s_pekerjaan_istri: {
                required: true,
            },
            s_telepon_istri: {
                required: true,
                number: true,
                minlength: 9,
                maxlength: 15,
            },
            s_telepon_keluarga: {
                number: true,
                minlength: 9,
                maxlength: 15,
            },
            s_alamat: {
                required: true,
            },
            s_prov: {
                required: true,
            },
            s_kab: {
                required: true,
            },
            s_kec: {
                required: true,
            },
            s_kel: {
                required: true,
            },
            s_kondisi_rumah: {
                required: true,
            },
            s_status_rumah: {
                required: true,
            },
            s_penghuni: {
                required: true,
            },
            s_menetap: {
                required: true,
            },
            s_tanggungan: {
                required: true,
            },
            s_kendaraan: {
                required: true,
            },
            s_saudara: {
                required: true,
            },

            //Validate Data Loan
            l_supir: {
                required: true,
            },
            l_nopol: {
                required: true,
            },
            l_tanggal: {
                required: true,
            },
            l_potong: {
                required: true,
            },
            l_is_status: {
                required: true,
            },
            l_nominal: {
                required: true,
            },
            l_keterangan: {
                required: true,
            },
           
           //Validate Data Vehicle
           v_legal: {
                required: true
            },
            v_registration_no: {
                required: true
            },
            v_name: {
                required: true
            },
            v_model: {
                required: true,
            },
            v_chassis_no: {
                required: true,
            },
            v_engine_no: {
                required: true,
            },
            v_uji_no: {
                required: true,
            },
            v_reg_exp_date: {
                required: true,
            },
            v_stnk_expdate: {
                required: true,
            },
            v_plat_expdate: {
                required: true,
            },
            v_kir_expdate: {
                required: true,
            },
            v_lokasi_kir: {
                required: true, 
            },
            v_notes_lokasikir: {
                required: true, 
            },
            v_group: {
                required: true,
            },
            v_is_active: {
                required: true,
            },

            //Validate Data Inventory
           iv_nopol: {
                required: true
            },
            iv_stnk: {
                    at_least_one: true
                },
            iv_kir: {
                required: true
            },
            iv_kabin: {
                required: true,
            },
            iv_dongkrak: {
                required: true,
            },
            iv_kunci: {
                required: true,
            },
            iv_stang: {
                required: true,
            },
            iv_spanner: {
                required: true,
            },
            iv_serep: {
                required: true,
            },
            iv_gantungan: {
                required: true,
            },
            iv_ramkk: {
                required: true,
            },
            iv_ramdb: {
                required: true,
            },
            iv_karpetd: {
                required: true,
            },
            iv_karpetb: {
                required: true,
            },
            iv_tambang: {
                required: true,
            },
            iv_tarpolin: {
                required: true,
            },
            iv_plastik: {
                required: true,
            },
            iv_lidah: {
                required: true,
            },
            iv_badong: {
                required: true,
            },
            iv_kojong: {
                required: true,
            },
            iv_jumlah: {
                required: true,
            },

            //Validate Data Handover
           ho_tanggal: {
                required: true
            },
            ho_lokasi: {
                    at_least_one: true
                },
            ho_nopol: {
                required: true
            },
            ho_km: {
                required: true,
            },
            ho_solar: {
                required: true,
            },
            ho_supirlama: {
                required: true,
            },
            ho_supirbaru: {
                required: true,
            },
            ho_kabin: {
                required: true,
            },
            ho_kabel: {
                required: true,
            },
            ho_lampubesar: {
                required: true,
            },
            ho_lampurem: {
                required: true,
            },
            ho_seindpn: {
                required: true,
            },
            ho_seinblk: {
                required: true,
            },
            ho_wiper: {
                required: true,
            },
            ho_spion: {
                required: true,
            },
            ho_tangki1: {
                required: true,
            },
            ho_tangki2: {
                required: true,
            },
            ho_bak: {
                required: true,
            },
            ho_pintu: {
                required: true,
            },
            ho_bandpnkr: {
                required: true,
            },
            ho_merkbankr: {
                required: true,
            },
            ho_bandpnkn: {
                required: true,
            },
            ho_merkbankn: {
                required: true,
            },
            ho_banblkkrlr: {
                required: true,
            },
            ho_merkbankrlr: {
                required: true,
            },
            ho_banblkknlr: {
                required: true,
            },
            ho_merkbanknlr: {
                required: true,
            },
            ho_banblkkrdlm: {
                required: true,
            },
            ho_merkbankrdlm: {
                required: true,
            },
            ho_banblkkndlm: {
                required: true,
            },
            ho_merkbankndlm: {
                required: true,
            },
            ho_velgdpnkr: {
                required: true,
            },
            ho_merkukuranvelgdpnkr: {
                required: true,
            },
            ho_velgdpnkn: {
                required: true,
            },
            ho_merkukuranvelgdpnkn: {
                required: true,
            },
            ho_velgblkkrlr: {
                required: true,
            },
            ho_merkukuranvelgblkkrlr: {
                required: true,
            },
            ho_velgblkknlr: {
                required: true,
            },
            ho_merkukuranvelgblknlr: {
                required: true,
            },
            ho_velgblkkrdlm: {
                required: true,
            },
            ho_merkukuranvelgblkkrdlm: {
                required: true,
            },
            ho_velgblkkndlm: {
                required: true,
            },
            ho_merkukuranvelgblkndlm: {
                required: true,
            },
            c_mobile: {
                required: true,
                number: true,
                minlength: 9,
                maxlength: 13,
            },
            c_email:{
                email: true,
                required: true,
            },
            c_address: {
                required: true,
            },
             t_customer_id: {
                required: true,
            },
            t_vechicle: {
                required: true,
            },
            t_driver: {
                required: true,
            },
            t_type: {
                required: true,
            },
            t_trip_fromlocation: {
                required: true,
            },
            t_trip_tolocation: {
                required: true,
            },
            t_start_date: {
                required: true,
            },
            t_end_date: {
                required: true,
            },
            t_trip_amount: {
                required: true,
                number: true,
                minlength: 3,
                maxlength: 6,
            },
            e_expense_amount: {
                required: true,
                number: true,
                minlength: 2,
                maxlength: 6,
            },
            ie_amount: {
                required: true,
                number: true,
                minlength: 2,
                maxlength: 6,
            },
             ie_description: {
                required: true,
            },
             ie_date: {
                required: true,
            },
             ie_type: {
                required: true,
            },
             ie_v_id: {
                required: true,
            },
            v_fuelprice: {
                required: true,
                number: true,
                minlength: 3,
                maxlength: 6,
            },
            v_fuel_quantity: {
                required: true,
                number: true,
                minlength: 1,
                maxlength: 6,
            },
            v_odometerreading: {
                required: true,
                number: true,
                minlength: 1,
            },
             v_fuelfilldate: {
                required: true,
            },
             v_fleetaddedby: {
                required: true,
            },
             v_id: {
                required: true,
            },
            v_fleetcomments: {
                 maxlength: 30,
            },
            fromdate: {
                required: true,
            },
            todate: {
                required: true,
            },
            t_vechicle: {
                required: true,
            },
             v_type: {
                required: true,
            },
            geo_name:{
                required: true,
            },
            geo_description:{
                required: true,
            },
            tp_amount:{
                lessThanEqual: true,
                required: true,
            },
            tp_notes:{
                required: true,
            },
        },
        messages: {
             
            //Messages Validate Data Driver
            d_name: {
                required: "Nama Lengkap belum terisi",
            },
            d_nickname: {
                required: "Nama Panggilan belum terisi",
            },
            d_pob: {
                required: "Tempat Lahir belum terisi",
            },
            d_dob: {
                required: "Tanggal Lahir belum terisi",
            },
            d_married: {
                required: "Status pernikahan belum terisi",
            },
            d_education: {
                required: "Pendidikan belum terisi",
            },
            d_mobile: {
                required: "Nomor Handphone belum terisi",
                number: "Please enter valid number",
            },
            d_address: {
                required: "Alamat belum terisi",
            },
            d_province: {
                required: "Provinsi belum terisi",
            },
            d_city: {
                required: "Kota/Kabupaten belum terisi",
            },
            d_subdistrict: {
                required: "Kecamatan belum terisi",
            },
            d_village: {
                required: "Kelurahan belum terisi",
            },
            d_identityno: {
                required: "NIK belum terisi",
                number: "Please enter valid number",
            },
            d_identity_expdate: {
                required: "Tanggal Berlaku KTP belum terisi",
            },
            d_licenseno: {
                required: "Nomor SIM belum terisi",
            },
            d_license_expdate: {
                required: "Tanggal Berlaku SIM belum terisi",
            },
            d_cardbpjs: {
                required: "BPJS belum terisi",
            },
            d_ref: {
                required: "Referensi belum terisi",
            },
            d_total_exp: {
                required: "Total pengalaman kerja belum terisi",
            },
            d_doj: {
                required: "Tanggal Masuk/Kontrak belum terisi",
            },
            d_notes_blacklist: {
                required: "Alasan supir di blacklist belum terisi",
            },
            d_pdf_document: {
                required: "Dokumen belum di upload",
                accept: "Hanya format PDF yang diperbolehkan"
            },
            d_docstatus: {
                at_least_radio: "Status dokumen belum terisi",
            },

            //Message Validate Data BAP
            b_supir: {
                required: "Nama Supir belum terisi",
            },
            b_nopol: {
                required: "Jenis Mobil belum terisi",
            },
             b_muatan: {
                required: "Jenis Muatan belum terisi",
            },
            b_tanggal_kejadian: {
                required: "Tanggal Kejadian belum terisi",
            },
            b_keberangkatan: {
                required: "Keberangkatan belum terisi",
            },
            b_lokasi_muat: {
                required: "Lokasi Muat belum terisi",
            },
            b_lokasi_bongkar: {
                required: "Lokasi Bongkar belum terisi",
            },
            b_lokasi_kejadian: {
                required: "Lokasi Kejadian belum terisi",
            },
            b_estimasi_klaim: {
                required: "Estimasi Klaim belum terisi",
            },
            b_jenis_kasus: {
                required: "Jenis Kasus belum terisi",
            },
            b_kondisi_barang: {
                required: "Kondisi Barang belum terisi",
            },
            b_tanggal: {
                required: "Tanggal BAP belum terisi",
            },
            b_korelasi_kasus: {
                required: "Korelasi Kasus belum terisi",
            },
            b_realisasi_klaim: {
                required: "Realisasi Klaim belum terisi",
            },
            b_posisi_barang: {
                required: "Posisi Barang belum terisi",
            },
            b_potong_tagihan: {
                required: "Potong Tagihan belum terisi",
            },
            b_kronologi_kejadian: {
                required: "Harap Melengkapi Kronologi Detail Kejadian",
            },

            //Message Validate Data Survey
            s_petugas: {
                required: "Petugas Survey belum terisi",
            },
            s_tanggal: {
                required: "Tanggal Survey belum terisi",
            },
            s_supir: {
                required: "Nama Supir belum terisi",
            },
            s_istri: {
                required: "Nama Istri belum terisi",
            },
            s_pekerjaan_istri: {
                required: "Pekerjaan Istri belum terisi",
            },
            s_telepon_istri: {
                required: "Telepon Istri belum terisi",
                number: "Please enter valid number",
            },
            s_telepon_keluarga: {
                number: "Please enter valid number",
            },
            s_alamat: {
                required: "Alamat Rumah belum terisi",
            },
            s_prov: {
                required: "Provinsi belum terisi",
            },
            s_kab: {
                required: "Kabupate/Kota belum terisi",
            },
            s_kec: {
                required: "Kecamatan belum terisi",
            },
            s_kel: {
                required: "Kelurahan belum terisi",
            },
            s_kondisi_rumah: {
                required: "Kondisi Rumah belum terisi",
            },
            s_status_rumah: {
                required: "Status Rumah belum terisi",
            },
            s_penghuni: {
                required: "Jumlah Penghuni Rumah belum terisi",
            },
            s_menetap: {
                required: "Lama Menatap di Alamat ini belum terisi",
            },
            s_tanggungan: {
                required: "Jumlah Tanggungan belum terisi",
            },
            s_kendaraan: {
                required: "Kendaraan yang Dimiliki belum terisi",
            },
            s_saudara: {
                required: "Nama Saudara/Kerabat belum terisi",
            },

            //Message Validate Data Loan
            l_supir: {
                required: "Nama Supir belum terisi",
            },
            l_nopol: {
                required: "Jenis Mobil belum terisi",
            },
             l_tanggal: {
                required: "Tanggal belum terisi",
            },
            l_potong: {
                required: "Cara Potong belum terisi",
            },
            l_nominal: {
                required: "Nominal belum terisi",
            },
            l_is_status: {
                required: "Jenis Hutang belum terisi",
            },
            l_keterangan: {
                required: "Keterangan Muat belum terisi",
            },

            //Message Validate Data Vehicle
            v_legal: {
                required: "Pemilik belum terisi",
            },
            v_registration_no: {
                required: "Nomor Polisi belum terisi",
            },
            v_reg_exp_date: {
                required: "Tahun Kendaraan belum terisi",
            },
            v_stnk_expdate: {
                required: "Tanggal Berlaku STNK belum terisi",
            },
            v_plat_expdate: {
                required: "Tanggal Berlaku Plat belum terisi",
            },
            v_kir_expdate: {
                required: "Tanggal Berlaku KIR belum terisi",
            },
            v_lokasi_kir: {
                required: "Lokasi Dishub belum dipilih",
            },
            v_notes_lokasikir: {
                required: "Lokasi Dishub belum dipilih",
            },
            v_group: {
                required: "Vehicle group is required",
            },
            v_engine_no: {
                required: "Nomor mesin belum terisi",
            },
            v_chassis_no: {
                required: "Nomor rangka belum terisi",
            },
            v_uji_no: {
                required: "Nomor uji belum terisi",
            },
            v_model: {
                required: "Model is required",
            },
            v_name: {
                required: "Jenis Mobil/Bak belum terisi",
            },
            v_type: {
                required: "Merk belum terisi",
            },
            v_is_active: {
                required: "Status Kendaraan belum terisi",
            },

            //Message Validate Data Inventory
            iv_nopol: {
                required: "Nomor Polisi belum terisi",
            },
            iv_stnk: {
                    at_least_one: "STNK belum terisi"
                },
            iv_kir: {
                required: "KIR belum terisi",
            },
            iv_kabin: {
                required: "Tempat Tidur Kabin belum terisi",
            },
            iv_dongkrak: {
                required: "Dongkrak belum terisi",
            },
            iv_kunci: {
                required: "Kunci Roda belum terisi",
            },
            iv_stang: {
                required: "Stang Kunci Roda belum terisi",
            },
            iv_spanner: {
                required: "Spanner belum terisi",
            },
            iv_serep: {
                required: "Ban Serep belum terisi",
            },
            iv_gantungan: {
                required: "Gantungan Ban Serep belum terisi",
            },
            iv_ramkk: {
                required: "Ram Kanan Kiri belum terisi",
            },
            iv_ramdb: {
                required: "Ram Depan Belakang belum terisi",
            },
            iv_karpetd: {
                required: "Karpet Depan belum terisi",
            },
            iv_karpetb: {
                required: "Karpet Belakang belum terisi",
            },
            iv_tambang: {
                required: "Tali Tambang belum terisi",
            },
            iv_tarpolin: {
                required: "Terpal Tarpolin belum terisi",
            },
            iv_plastik: {
                required: "Terpal Plastik belum terisi",
            },
            iv_lidah: {
                required: "Terpal Lidah belum terisi",
            },
            iv_badong: {
                required: "Badong belum terisi",
            },
            iv_kojong: {
                required: "Pipa Kojong belum terisi",
            },
            iv_jumlah: {
                required: "Jumlah Pipa Kojong belum terisi",
            },

            //Message Validate Data Handover
            ho_tanggal: {
                required: "Tanggal Serah Terima belum terisi",
            },
            ho_lokasi: {
                    at_least_one: "Lokasi Serah Terima belum terisi"
                },
            ho_nopol: {
                required: "Nomor Polisi belum terisi",
            },
            ho_km: {
                required: "Kilometer belum terisi",
            },
            ho_solar: {
                required: "Jumlah Solar belum terisi",
            },
            ho_supirlama: {
                required: "Supir Sebelumnya belum terisi",
            },
            ho_supirbaru: {
                required: "Supir Penggantinya belum terisi",
            },
            ho_kabin: {
                required: "Kondisi Kabin belum terisi",
            },
            ho_kabel: {
                required: "Kabel Body belum terisi",
            },
            ho_lampubesar: {
                required: "Lampu Besar Depan belum terisi",
            },
            ho_lampurem: {
                required: "Lampu Rem belum terisi",
            },
            ho_seindpn: {
                required: "Lampu Sein Depan belum terisi",
            },
            ho_seinblk: {
                required: "Lampu Sein Belakang belum terisi",
            },
            ho_wiper: {
                required: "Wiper belum terisi",
            },
            ho_spion: {
                required: "Spion Bulat belum terisi",
            },
            ho_tangki1: {
                required: "Tangki Solar 1 belum terisi",
            },
            ho_tangki2: {
                required: "Tangki Solar 2 belum terisi",
            },
            ho_bak: {
                required: "Kondisi Bak belum terisi",
            },
            ho_pintu: {
                required: "Pintu Kupu-Kupu belum terisi",
            },
            ho_bandpnkr: {
                required: "Ban Depan Kiri belum terisi",
            },
            ho_merkbankr: {
                required: "Merk Ban Depan Kiri belum terisi",
            },
            ho_bandpnkn: {
                required: "Ban Depan belum terisi",
            },
            ho_merkbankn: {
                required: "Merk Ban Depan Kanan belum terisi"
                },
            ho_banblkkrlr: {
                required: "Ban Belakang Kiri Luar belum terisi",
            },
            ho_merkbankrlr: {
                required: "Merk Ban Belakang Kiri Luar belum terisi",
            },
            ho_banblkknlr: {
                required: "Ban Belakang Kanan Luar belum terisi",
            },
            ho_merkbanknlr: {
                required: "Merk Ban Belakang Kanan Luar belum terisi",
            },
            ho_banblkkrdlm: {
                required: "Ban Belakang Kiri Dalam belum terisi",
            },
            ho_merkbankrdlm: {
                required: "Merk Ban Belakang Kiri Dalam belum terisi",
            },
            ho_banblkkndlm: {
                required: "Ban Belakang Kanan Dalam belum terisi",
            },
            ho_merkbankndlm: {
                required: "Merk Ban Belakang Kanan Dalam belum terisi",
            },
            ho_velgdpnkr: {
                required: "Velg Depan Kiri belum terisi",
            },
            ho_merkukuranvelgdpnkr: {
                required: "Merk/Ukuran Velg Depan Kiri belum terisi",
            },
            ho_velgdpnkn: {
                required: "Velg Depan Kanan belum terisi",
            },
            ho_merkukuranvelgdpnkn: {
                required: "Merk/Ukuran Velg Depan Kanan belum terisi",
            },
            ho_velgblkkrlr: {
                required: "Velg Belakang Kiri Luar belum terisi",
            },
            ho_merkukuranvelgblkkrlr: {
                required: "Merk/Ukuran Velg Belakang Kiri Luar belum terisi",
            },
            ho_velgblkknlr: {
                required: "Velg Belakang Kanan Luar belum terisi",
            },
            ho_merkukuranvelgblknlr: {
                required: "Merk/Ukuran Velg Belakang Kanan Luar belum terisi",
            },
            ho_velgblkkrdlm: {
                required: "Velg Belakang Kiri Dalam belum terisi",
            },
            ho_merkukuranvelgblkkrdlm: {
                required: "Merk/Ukuran Velg Belakang Kiri Dalam belum terisi",
            },
            ho_velgblkkndlm: {
                required: "Velg Belakang Kanan Dalam belum terisi",
            },
            ho_merkukuranvelgblkndlm: {
                required: "Merk/Ukuran Velg Belakang Kanan Dalam belum terisi",
            },
            c_mobile: {
                required: "Mobile number is required",
                number: "Please enter valid number",
            },
            c_name: {
                required: "Customer name is required",
            },
            c_email:{
                required: "Customer email is required",
            },
            c_address: {
                required: "Customer address is required",
            },
            t_vechicle: {
                required: "Choose vechicle",
            },
            t_driver: {
                required: "Choose driver",
            },
            t_type: {
                required: "Choose type of trip",
            },
            t_trip_fromlocation: {
                required: "Select trip start location",
            },
            t_trip_tolocation: {
                required: "Select trip to/end location",
            },
            t_start_date: {
                required: "Select trip start date",
            },
            t_end_date: {
                required: "Select trip to/end date",
            },
            t_trip_amount: {
                required: "Trip amount/rent is required",
                number: "Please enter valid number",
            },
            geo_name:{
                required: "Geofence name is required",
            },
            geo_description:{
                required: "Geofence description is required",
            },
             tp_amount:{
                required: "Amount is required",
                lessThanEqual : "Amount must be less than pending amount"
            },
             tp_notes:{
                required: "Payment notes is required",
            },
            ie_amount:{
                required: "Amount is required",
            },

        },
        errorElement: 'span',
        errorPlacement: function (error, element) {
          error.addClass('invalid-feedback');
          element.closest('.form-group').append(error);
        },
        highlight: function (element, errorClass, validClass) {
          $(element).addClass('is-invalid');
        },
        unhighlight: function (element, errorClass, validClass) {
          $(element).removeClass('is-invalid');
        },
        errorPlacement: function(error, element) {
                // Custom error placement untuk select2
                if (element.hasClass('select2-vehicle') || element.hasClass('select2') || element.hasClass('select2-driver1') || element.hasClass('select2-driver2') || element.hasClass('select2-prov') || element.hasClass('select2-city') || element.hasClass('select2-subdistrict') || element.hasClass('select2-village')) {
                    error.insertAfter(element.next('.select2-container'));
                }
                // Custom error placement untuk checkbox groups
                else if (element.attr('type') === 'checkbox') {
                    if (element.attr('name') === 'v_lokasi_kir') {
                        var errorContainer = $('#lokasi_kir_error_container');
                        errorContainer.find('.invalid-feedback').remove();
                        error.appendTo(errorContainer);
                        errorContainer.show();
                    } else {
                        var container = element.closest('.checkbox-group');
                        if (container.length) {
                            container.find('.invalid-feedback').remove();
                            error.appendTo(container);
                        } else {
                            error.insertAfter(element.closest('.form-check'));
                        }
                    }
                }
                else if (element.attr('type') === 'radio') {
        const container = element.closest('.radio-group');
        if (container.length) {
            container.find('.invalid-feedback').remove();
            error.appendTo(container);
        } else {
            // Fallback: cari container radio atau tempatkan setelah grup radio
            const radioGroup = element.closest('.form-check').parent();
            if (radioGroup.find('.invalid-feedback').length === 0) {
                error.insertAfter(radioGroup);
            }
        }
    }
        else {
                error.insertAfter(element);
            }
        },
            highlight: function(element, errorClass, validClass) {
                // Untuk select2
                if ($(element).hasClass('select2-vehicle') || $(element).hasClass('select2') || $(element).hasClass('select2-driver1') || $(element).hasClass('select2-driver2') || $(element).hasClass('select2-prov') || $(element).hasClass('select2-city') || $(element).hasClass('select2-subdistrict') || $(element).hasClass('select2-village')) {
                    const select2Container = $(element).next('.select2-container');
                    const select2Selection = select2Container.find('.select2-selection');
                        select2Selection.addClass('is-invalid');
                    select2Selection.removeClass('is-valid');
                }
                // Untuk checkbox groups
                else if ($(element).attr('type') === 'checkbox') {
                    const container = $(element).closest('.checkbox-group');
                    container.addClass('is-invalid');
                    container.removeClass('is-valid');
                }
                else if ($(element).attr('type') === 'radio') {
        const container = $(element).closest('.radio-group');
        if (container.length) {
            container.addClass('is-invalid');
            container.removeClass('is-valid');
        } else {
            // Fallback: highlight semua radio dalam grup yang sama
            const groupName = $(element).attr('name');
            $(`input[name="${groupName}"]`).closest('.form-check').addClass('is-invalid');
            $(`input[name="${groupName}"]`).closest('.form-check').removeClass('is-valid');
        }
    }
        else {
                $(element).addClass('is-invalid');
                $(element).removeClass('is-valid');
            }
        },
            unhighlight: function(element, errorClass, validClass) {
                // Untuk select2
                if ($(element).hasClass('select2-vehicle') || $(element).hasClass('select2') || $(element).hasClass('select2-driver1') || $(element).hasClass('select2-driver2') || $(element).hasClass('select2-prov') || $(element).hasClass('select2-city') || $(element).hasClass('select2-subdistrict') || $(element).hasClass('select2-village')) {
                    const select2Container = $(element).next('.select2-container');
                    const select2Selection = select2Container.find('.select2-selection');
                        select2Selection.removeClass('is-invalid');
                    select2Selection.addClass('is-valid');
                }
                // Untuk checkbox groups
                else if ($(element).attr('type') === 'checkbox') {
                    if ($(element).attr('name') === 'v_lokasi_kir') {
                        var errorContainer = $('#lokasi_kir_error_container');
                        errorContainer.find('.invalid-feedback').remove();
                        errorContainer.hide();
                    } else {
                        const container = $(element).closest('.checkbox-group');
                        container.removeClass('is-invalid');
                        container.addClass('is-valid');
                    }
                }
                else if ($(element).attr('type') === 'radio') {
                    const container = $(element).closest('.radio-group');
                    if (container.length) {
                        container.removeClass('is-invalid');
                        container.addClass('is-valid');
                    } else {
                        // Fallback: unhighlight semua radio dalam grup yang sama
                        const groupName = $(element).attr('name');
                        $(`input[name="${groupName}"]`).closest('.form-check').removeClass('is-invalid');
                        $(`input[name="${groupName}"]`).closest('.form-check').addClass('is-valid');
                    }
                }
                // Untuk input biasa
                else {
                    $(element).removeClass('is-invalid');
                    $(element).addClass('is-valid');
                }
            },
            submitHandler: function(form) {
                return validateAndSubmit();
            }
      });
    $("#v_registration_no").on('keypress change', function(event) {
       var data=$(this).val();
       $("#v_api_username").val(data);
    });
    
        //$('#driverslisttbl,#vehiclelisttbl,#triptbl,#custtbl,#fueltbl,#incomexpensetbl').DataTable({
           //"pageLength": 15,
           //"bLengthChange": false,
           //"bInfo": true,
           //"ordering": true
        //});
        //$('#vehiclelisttbl,#triptbl,#custtbl,#fueltbl,#incomexpensetbl').DataTable({
           //"bLengthChange": false,
           //"bInfo": true,
           //"ordering": true
        //});
        $('#bookingstbl,#vgeofencetbl,#incomexpenstbl,.datatable').DataTable({
           "bLengthChange": false,
           "pageLength" : 8,
           "bInfo": false,
           "ordering": false
        });
        $('.datatableexport').DataTable({
            "pageLength": 10,
           "bInfo": false,
           "ordering": false,
           "searching": false,
           "scrollX": true,
            dom: 'Bfrtip',
            buttons: [
            'copyHtml5',
            'excelHtml5',
            'csvHtml5',
            'pdfHtml5'
        ]
        });
        $('.datatableexportvehicle').DataTable({
            "pageLength": 10,
           "bInfo": false,
           "ordering": false,
           "searching": false,
           "scrollX": true,
            dom: 'Bfrtip',
            buttons: [
            'copyHtml5',
            'excelHtml5',
            'csvHtml5',
            'pdfHtml5'
        ]
        });

});
// expense fields
    var row = 1;
    function expense_fields() {
        row++;
        var objTo = document.getElementById('new_exp_row')
        var divtest = document.createElement("div");
        divtest.setAttribute("class", "removeclass" + row);
        var rdiv = 'removeclass' + row;
        divtest.innerHTML = '<div class="row"> <div class="col-sm-6 col-md-3 "> <div class="form-group"> <input type="text" class="form-control" id="e_expense_type" required="true" name="e_expense_type[]" value="" placeholder="Expense Type"> </div> </div> <div class="col-sm-6 col-md-3 "> <div class="form-group"> <input type="text" class="form-control" id="e_expense_desc" required="true" name="e_expense_desc[]" value="" placeholder="Expense description"> </div> </div> <div class="col-sm-3 col-md-3"> <div class="form-group"> <input type="text" class="form-control" id="e_expense_amount" required="true" name="e_expense_amount[]" value="" placeholder="Value"> </div> </div> <div class="col-sm-3 col-md-3"> <div class="input-group-btn"> <button class="btn btn-danger" type="button" onclick="remove_expense_fields(' + row + ');"> <span class="fe fe-minus" aria-hidden="true"></span> </button> </div> </div> </div> <div class="clear"></div>';
        objTo.appendChild(divtest)
    }
    // remove expense fields
    function remove_expense_fields(rid) {
        $('.removeclass' + rid).remove();
    }

function alertmessage(msg,type) {
    if(type==1) {
        const Toast = Swal.mixin({toast: true,position: 'top',showConfirmButton: false,timer: 5000});
        Toast.fire({
          type: 'success',
          title: msg
        });
    }
    if(type==2) {
         const Toast = Swal.mixin({toast: true,position: 'top',showConfirmButton: false,timer: 5000});
        Toast.fire({
          type: 'error',
          title: msg
        });
    }
}

$('#showgeofencemodel').on('click', function(e){
    e.preventDefault();
    var geo_area = $('#geo_area').val();
    if (geo_area === "") {
          alertmessage('Please select area in map',2);
    } else {
        $('#modal-geofence').modal('show');
    }
});


$('.geofenceviewpopup').on('click', function(e){
    e.preventDefault();
    var base = $('#base').val();
    $.ajax({
        type: "post",
        data: {'id':$(this).data('id')},
        url: base+"geofence/geofence_get",
        dataType: 'json',
        success: function (result) {
            if(result=='false') {
                 alertmessage('Failed to fetch geo data',2);
            } else {
                console.log(result);
                var center = result[0].split(",");
                var latcenter = parseFloat(center[0]);
                var logcenter = parseFloat(center[1]);
                var mapProp = {
                   center:new google.maps.LatLng(latcenter,logcenter),
                   zoom:18,
                   mapTypeId:google.maps.MapTypeId.ROADMAP,
                    scrollwheel: true,
                    gestureHandling: 'cooperative'
                };
                var map = new google.maps.Map(document.getElementById("googleMap"),mapProp);  

                var AreaCoords = new Array();
                $.each( result, function( key, val ) {
                    var val = val.split(",");
                    var lat = parseFloat(val[0]);
                    var log = parseFloat(val[1]);
                  AreaCoords.push(new google.maps.LatLng(lat, log));
                });
                console.log(AreaCoords)
                var tourplan = new google.maps.Polyline({
                   path:AreaCoords,
                   strokeColor:"#0817FA",
                   strokeOpacity:0.6,
                   strokeWeight:2
                });           
                tourplan.setMap(map);
                $('#geofencepopupmodel').modal('show');
            }
        }
    });
});

$('.logodelete').on('click', function(){
   $.ajax({
    url: 'logodelete',
    type: 'post',
    dataType: 'json',
    data: '',
    success: function(response){ 
      location.reload();
    }
  });
 });


$('.todayreminderread').on('click', function(e){
   e.preventDefault();
    var base = $('#base').val();
    var rid = $(this).data('id');
    $.ajax({
        type: "post",
        data: {'r_id':rid},
        url: base+"dashboard/remindermark",
        dataType: 'json',
        success: function (result) {
            if(result==1) {
                $('#'+rid).remove();
                alertmessage('Reminder marked as read',1);
            } else {
                alertmessage('Something went wrong',2);
            }
        }
    });
});