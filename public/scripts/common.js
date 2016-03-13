// Global Variables
var MAIN_PATH = window.location.origin;

// Document Ready
jQuery(document).ready(function ($) {
    // Bootstrap
    $(".alert").alert();
    $(".inputmask").inputmask();
    $('.btn-loading').attr('data-loading-text', 'Cargando...');
    $(".btn-loading").click(function () {
        $(this).button("loading");
    });
    $("[data-role='popover']").popover({
        placement: "top",
        html: true
    });
    $("[data-role='tooltip'], [data-rol='tooltip-bottom']").tooltip({
        placement: "bottom"
    });
    $("[data-role='tooltip-top']").tooltip({
        placement: "top"
    });
    $("[data-role='tooltip-right']").tooltip({
        placement: "right"
    });
    $("[data-role='tooltip-left']").tooltip({
        placement: "left"
    });
    $('[data-role="colorpicker"]').colorpicker();
    setTimeout(function () {
        $(".page-alert").fadeOut();
    }, 3000);
    $("select").chosen({
        no_results_text: "No se ha encontrado",
        width: "100%"
    }); 
    //Formstone
    $("[type=radio], [type=checkbox]:not(.toggle)").picker();
    $("[type=checkbox].toggle").picker({
        toggle: true
    });
    $(".boxer").boxer({
        fixed: true,
        formatter: formatCaptions
    });
    //$("select:not(.optional)").selecter();
    //$("select.optional").selecter({
    //    label: 'Seleccione...'
    //});
    $("[data-role='stepper']").stepper();
    // Prevent Default 
    $("a").click(function (e) {
        var attr = $(this).attr('href');
        if (attr == '#')
            e.preventDefault();
    });
    // Datatable
    $('.datatable tfoot th.search').each(function () {
        var title = $('.datatable thead th').eq($(this).index()).text();
        $(this).html('<input class="form-control" type="text" placeholder="' + title + '" />');
    });
    var table = $('.datatable').DataTable({
        language: {
            url: MAIN_PATH + '/scripts/datatables-es.json'
        },
        columnDefs: [{
            orderable: false,
            searchable: false,
            targets: $(this).find('tr').length ? $(this).find('tr')[0].cells.length - 1 : -1
        }]
    });
    $('.datatable tfoot th').each(function (index) {
        var cell = $(this);
        cell.find('input').on('keyup change', function () {
            var idx = cell.parent('tr').children().index(cell);
            $(this).closest('.datatable').DataTable().column(idx).search(this.value).draw();
        });
    });

    // DateTime Picker
    $('[data-role="datepicker"]').datetimepicker({
        language: 'es-CR',
        pickTime: false,
        format: 'DD/MM/YYYY'
    });
    $('[data-role="timepicker"]').datetimepicker({
        language: 'es-CR',
        pickDate: false,
        format: 'hh:mm A'
    });
    // Scroll Link
    $('.scroll-link').click(function (e) {
        e.preventDefault();
        var target = $(this).attr('href');
        var position = $(target).offset();
        var distance = position.top;
        $('body,html').animate({ scrollTop: distance }, 500);
    });
    // Confirm Delete
    $('.confirm-action').click(function (e) {
        e.preventDefault();
        var msg = $(this).attr('data-message');
        if (msg === undefined)
            msg = "Realmente deseas continuar?";

        var link = $(this).attr('href');
        bootbox.setDefaults({
            title: "Confirmación",
            locale: "es"
        });
        bootbox.confirm(msg, function (result) {
            if (result == false || result === null) return;

            if (link !== undefined)
                window.location.href = link;
            else
                $(this).closest('form').submit();
        });
        $('.bootbox-confirm .modal-dialog').addClass('modal-sm');
    });
    // Clone Field
    $('.clone').click(function(e) {
        e.preventDefault();

        $me = $(this);
        $field = $($me.attr('data-field')).last();

        $clone = $field.clone();
        $clone.find('input').val('');
        $clone.find('textarea').val('');

        $field.after($clone);
    });
    // Check Calendar Availability
    $('#check-availability').click(function () {
        var start_date = $('[name="start_date"]').val();
        var start_time = $('[name="start_time"]').val();
        var end_date = $('[name="end_date"]').val();
        var end_time = $('[name="end_time"]').val();

        var start_datetime = moment(start_date + start_time, "DD/MM/YYYYhh:mm A").format("YYYYMMDDHHmm");
        var end_datetime;

        if (typeof end_date === "undefined" || typeof end_time === "undefined")
            end_datetime = moment(start_date + start_time, "DD/MM/YYYYhh:mm A").add('minutes', 30).format("YYYYMMDDHHmm");
        else
            end_datetime = moment(end_date + end_time, "DD/MM/YYYYhh:mm A").format("YYYYMMDDHHmm");

        var url = MAIN_PATH + "/admin/calendar/check/" + start_datetime + "/" + end_datetime;
        $.getJSON(url, function (data) {
            if (data.events > 0 || data.appointments > 0) {
                var msj = "La fecha y hora indicada coincide con: ";
                if (data.appointments > 0)
                    msj += data.appointments + " cita(s)";
                if (data.appointments > 0 && data.events > 0)
                    msj += " y ";
                if (data.events > 0)
                    msj += data.events + " evento(s)";
                msj += "<br/>Realmente desea continuar?"

                bootbox.dialog({
                    message: msj,
                    title: "Advertencia",
                    buttons: {
                        ok: {
                            label: "Continuar",
                            className: "btn-info",
                            callback: function () {
                                $("form").submit();
                            }
                        },
                        cancel: {
                            label: "Cancelar",
                            className: "btn-default"
                        }
                    }
                });
            }
            else {
                $("form").submit();
            }
        }).fail(function () {
            bootbox.alert({
                message: "Error de conexión. No se pudo verificar la disponibilidad.",
                title: "Error"
            });
        });

    });
    // Generate Random Password
    $('.random-pass').click(function () {
        var length = $(this).attr('data-length');
        var input = $(this).attr('data-input');

        var keylist = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz1234567890";
        var pass = '';

        for (i = 0; i < length; i++)
            pass += keylist.charAt(Math.floor(Math.random() * keylist.length));

        $(input).val(pass).attr('type', 'text');
    });
    // Show / Hidden
    $('[data-hidden]').click(function (e) {
        var target = $(this).attr('data-hidden');
        if ($(this).is(":checked"))
            $(target).css('display', 'block');
        else
            $(target).css('display', 'none');
    });
    $('[data-hidden]').each(function (e) {
        var target = $(this).attr('data-hidden');
        if ($(this).is(":checked"))
            $(target).css('display', 'block');
        else
            $(target).css('display', 'none');
    });
    // Scroll Link
    $('.scroll-link').click(function (e) {
        e.preventDefault();
        var target = $(this).attr('href');
        var position = $(target).offset();
        var distance = position.top;
        $('body,html').animate({ scrollTop: distance }, 500);
    });
});

// AllCheck
$(".all-check").click(function (e) {
    var check = $(this).attr("data-check");
    if ($(this).is(":checked")) {
        $("." + check + ":checkbox:not(:checked)").attr("checked", "checked");
    } else {
        $("." + check + ":checkbox:checked").removeAttr("checked");
    }
});

// Boxer
function formatCaptions($target) {
	return '<strong>' + $target.attr("title") + '</strong>';
}

// Navbar
function toggleNavbar() {
    var height = $(window).height();
    var scrolled = $(window).scrollTop();
    var percent = scrolled / height;

    $('.navbar-inverse[data-toggle="navbar"]').css('background', 'rgba(82,188,191, ' + percent + ')');
}
$(window).scroll(function(e){
    toggleNavbar();
});

//-----------------------------------------------------
// Dropper Events
//-----------------------------------------------------
        
function onStartDropper(e, files) {
    $dropperqueue = $($(this).attr('data-queue'));

    var html = '';
    for (var i = 0; i < files.length; i++) {
	    html += '<li class="col-xs-6 col-md-3" data-index="' + files[i].index + '"><a class="item" href="#" title="'
             + files[i].name + '"><i class="fa fa-circle-o-notch fa-spin fa-4x"></i><div class="filename" >' 
             + files[i].name + '</div><div class="progress">En espera</div></a></li>';
    }

    $dropperqueue.prepend(html);
}

function onStartUpload(e, file) {
    $dropperqueue = $($(this).attr('data-queue'));

    $dropperqueue.find("li[data-index=" + file.index + "]").find(".progress")
        .html('<div class="progress-bar" role="progressbar" aria-valuenow="0" aria-valuemin="0" ' 
        + 'aria-valuemax="100" style="width: 0%;">0%</div>');
}

function onProgressDropper(e, file, percent) {
    $dropperqueue = $($(this).attr('data-queue'));

    $dropperqueue.find("li[data-index=" + file.index + "]")
	    .find(".progress-bar").text(percent + "%").attr({'aria-valuenow': percent, 'style': 'width: ' + percent + '%;'});
}

function onCompleteDropper(e, file, response) {
    $dropperqueue = $($(this).attr('data-queue'));
    $dropperlist = $($(this).attr('data-list'));
    $target = $dropperqueue.find("li[data-index=" + file.index + "]");

    if (response.trim() === "" || response.toLowerCase().indexOf("error") > -1) {
        $target.find(".progress").remove();
	    $target.find("i").attr('class', 'fa fa-file-o fa-4x');
        $target.find(".item").append('<small class="text-danger" title="' + response.trim() + '">' + response.trim() + '</small>');
        $target.prepend('<button class="close" type="button" title="Eliminar" >&times;</a>').click(function(e) {
            e.preventDefault();
            $(this).closest('li').remove();
        });
    } else {
        var data = JSON.parse(response);
        var title = file.name + ' - ' + data.date;

        $target.find(".progress").remove();
        $target.find(".item").attr({ 'href': data.url, 'title': title });
        $target.find(".item").append('<small class="text-muted">' + data.date + '</small>');

        switch (data.type) {
            case 'pdf':
                $target.find("i").attr('class', 'fa fa-file-pdf-o fa-4x');
                break;
            case 'doc': case 'docx':
                $target.find("i").attr('class', 'fa fa-file-word-o fa-4x');
                break;
            case 'xls': case 'xlsx':
                $target.find("i").attr('class', 'fa fa-file-excel-o fa-4x');
                break;
            case 'ppt': case 'pptx':
                $target.find("i").attr('class', 'fa fa-file-powerpoint-o fa-4x');
                break;
            case 'txt':
                $target.find("i").attr('class', 'fa fa-file-text-o fa-4x');
                break;
            case 'rar': case 'zip': case '7z':
                $target.find("i").attr('class', 'fa fa-file-archive-o fa-4x');
                break;
            case 'mp3': case 'wma': case 'm4a': case 'ogg': case 'wav':
                $target.find("i").attr('class', 'fa fa-file-audio-o fa-4x');
                break;
            case 'mp4': case 'mkv': case '3gp': case 'flv': case 'wmv': case 'avi': 
            case 'mpg': case 'mpeg': case 'mov': case 'm4v':
                $target.find("i").attr('class', 'fa fa-file-video-o fa-4x');
                break;
            case 'jpg': case 'png': case 'bmp':case 'gif':
                if (data.image === undefined)
                    $target.find("i").attr('class', 'fa fa-file-picture-o fa-4x');
                else {
                    $target.find(".item").addClass('boxer').attr('data-gallery', 'gallery');
                    $target.find(".item").attr('href', data.image);
                    $target.find(".item").prepend('<img src="' + data.image + '" alt="' + file.name + '"/>');
                    $target.find("i").remove();
                    $target.find(".filename").remove();
                }
                break;
            default:
                $target.find("i").attr('class', 'fa fa-file-o fa-4x');
                break;
        }
        
        $target.prepend('<a class="close" href="' + data.delete + '" title="Eliminar" >&times;</a>');
        $target.prependTo($dropperlist);
	}
}

function onErrorDropper(e, file, error) {
    $dropperqueue = $($(this).attr('data-queue'));
    $target = $dropperqueue.find("li[data-index=" + file.index + "]");
    
    $target.find(".progress").remove();
    $target.find("i").attr('class', 'fa fa-warning fa-4x');
    $target.find(".filename").append('<small class="text-danger" title="' + error.trim() + '">' + error.trim() + '</small>');
}
