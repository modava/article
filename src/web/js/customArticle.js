$(function () {
    "use strict";

    var btn_del = '.btn-del';

    function setPopovers() {
        $(btn_del).each(function () {
            popoverBtnDel($(this));
        });
    }

    function popoverBtnDel(el) {
        var url = el.attr('data-url') || null;
        if (url === null) {
            console.log('Empty url!');
            return false;
        }
        var title = el.attr('title') || null,
            data_title = el.attr('data-title') || "Bạn thực sự muốn xóa?",
            btn_success_class = el.attr('btn-success-class') || null,
            btn_cancel_class = el.attr('btn-cancel-class') || null,
            btn_cancel = $('<button class="btn btn-warning mr-5' + (btn_cancel_class !== null ? ' ' + btn_cancel_class : '') + '">Cancel</button>'),
            btn_success = $('<a href="' + url + '" class="btn btn-success' + (btn_success_class !== null ? ' ' + btn_success_class : '') + '">Yes</a>'),
            content = $('<div></div>').append(btn_cancel, btn_success);
        btn_cancel.on('click', function () {
            el.popover('hide');
        });
        el.on('show.bs.popover', function () {
            $('body').find(btn_del).not(el).each(function () {
                $(this).popover('hide');
            });
        }).removeAttr('title').popover({
            html: true,
            title: data_title,
            content: content,
            template: '<div class="popover popover-" role="tooltip">' +
                '<div class="arrow"></div>' +
                '<div class="alert alert-warning alert-dismissible fade show mb-0 p-1" role="alert">' +
                '<h5 class="alert-heading popover-header text-red"></h5>' +
                '<div class="popover-body text-center pb-0"></div>' +
                '<button type="button" class="close" data-dismiss="alert" aria-label="Close">' +
                '<span aria-hidden="true">×</span>' +
                '</button>' +
                '</div>' +
                '</div>'
        }).attr('title', title);
    }

    $('body').on('load-body', function () {
        setPopovers();
    }).trigger('load-body');
    $('body').on('click', '.form-search .btn-action-search', function (e) {
        e.preventDefault();
        var btn = $(this),
            values = btn.attr('data-value') || null,
            data_btn = btn.attr('data-btn') || null,
            form = btn.closest('.form-search');
        try {
            values = JSON.parse(values);
        } catch (ex) {
        }
        if (values !== null && typeof values === "object" && Object.keys(values).length > 0) {
            Object.keys(values).forEach(function (k) {
                form.find('*[name="' + k + '"]').val(values[k]);
            });
        }
        form.find('.btn_search').val(data_btn);
        form.trigger('submit');
        return false;
    }).on('click', '.clear-value', function (e) {
        e.stopImmediatePropagation();
        e.preventDefault();

        let input = $(this).closest('.input-group').find('input, select');

        if (input.hasClass('data-krajee-daterangepicker')) {
            input.trigger('cancel.daterangepicker');
        } else {
            input.val('').trigger('change');
        }
    }).on('change paste keyup', '.alert-max-length', function () {
        var el = $(this),
            val = el.val() || "",
            max_length = el.attr('alert-max-length') || null,
            alert_content = el.attr('alert-content') || 'Chỉ nên để tối đa ' + max_length + ' ký tự',
            alert_el = el.parent().find('.alert-content');
        if (max_length === null || alert_el.length <= 0) return;
        if (val.trim().split(' ').length > parseInt(max_length)) alert_el.text(alert_content).show();
        else alert_el.text('').hide();
    });
    $('body .custom-counter').each(function () {
        var label = $(this),
            ipt = label.attr('ipt-counter') || null,
            content = label.closest('.counter-content').find('.counter') || null;
        if (ipt === null || $(ipt).length <= 0) ipt = $('#' + label.attr('for'));
        if (content.length <= 0) return;
        ipt.on('change paste keyup', function () {
            content.text($(this).val().length);
        }).trigger('change');
    });
});