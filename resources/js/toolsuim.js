$(function() {
    "use strict";
    if ($(".grade").length) {
        restructureWithSelect2("grade");
    }
    if ($(".jabatan").length) {
        restructureWithSelect2("jabatan");
    }
    if ($(".properties").length) {
        restructure("properties");
    }
    if ($(".fungsi").length) {
        restructureAplikasiFungsi();
    }
    if ($("#eakses1").length && $("#eakses2").length) {
        toggleAksesFungsi($("#eakses1").val(), "1");
        toggleAksesFungsi($("#eakses2").val(), "2");
    }
    if ($("#send-all").length) {
        $("#send-all").on("click", function() {
            $(this).before(
                '<input type="hidden" name="tanggal" value="' +
                    $('input[name="tanggal"]').val() +
                    '">'
            );
            $(this).before('<input type="hidden" name="send_all" value="1">');
            (FormObj = this.form), (SwalOptions.text = "Kirim semua data?");
            Swal.fire(SwalOptions).then(result => {
                if (result.value) {
                    FormObj.submit();
                    showLoading();
                }
            });
            return false;
        });
    }
    if ($("#send-selected").length) {
        $("#send-selected").on("click", function() {
            var isChecked = 0;
            $('input[name="check[]"]').each(function() {
                if ($(this).is(":checked")) {
                    ++isChecked;
                }
            });
            if (isChecked > 0) {
                $(this).before(
                    '<input type="hidden" name="tanggal" value="' +
                        $('input[name="tanggal"]').val() +
                        '">'
                );
                (FormObj = this.form),
                    (SwalOptions.text = "Kirim data yang dipilih?");
                Swal.fire(SwalOptions).then(result => {
                    if (result.value) {
                        FormObj.submit();
                        showLoading();
                    }
                });
            } else {
                Swal.fire("Alert", "Tidak ada data yang dipilih", "warning");
            }
            return false;
        });
    }
});

function restructureWithSelect2(selector) {
    let len = $("." + selector).length - 1;
    len = len < 0 ? 0 : len;
    $("." + selector).each(function(i) {
        $(this).prop("id", selector + i);
        $(this)
            .find(".add")
            .prop("id", "add" + i);
        $(this)
            .find(".rmv")
            .prop("id", "rmv" + i);
        $(this)
            .find('select[name="' + selector + '[]"]')
            .select2();
        $("." + selector)
            .find("#add" + i)
            .off("click")
            .on("click", function() {
                let num = new Number(len + 1),
                    cloneDom = $("#" + selector + len);
                $("#" + selector + len)
                    .find('select[name="' + selector + '[]"]')
                    .select2("destroy");
                let newDom = cloneDom.clone().prop("id", selector + num);
                cloneDom.after(newDom);
                $("#" + selector + num)
                    .find('input[type="text"]')
                    .val("")
                    .find('input[type="checkbox"], input[type="radio"]')
                    .prop("checked", false);
                $("#" + selector + num + " option:first").prop(
                    "selected",
                    true
                );
                restructureWithSelect2(selector);
            });
        $("." + selector)
            .find("#rmv" + i)
            .off("click")
            .on("click", function() {
                $(this)
                    .parent()
                    .parent()
                    .parent()
                    .remove();
                restructureWithSelect2(selector);
            });
        if (len == 0) {
            $("." + selector)
                .find("#add" + i)
                .show();
            $("." + selector)
                .find("#rmv" + i)
                .hide();
        } else {
            if (i < len) {
                $("." + selector)
                    .find("#add" + i)
                    .hide();
                $("." + selector)
                    .find("#rmv" + i)
                    .show();
            } else {
                $("." + selector)
                    .find("#add" + i)
                    .show();
                $("." + selector)
                    .find("#rmv" + i)
                    .show();
            }
        }
    });
}

function restructureAplikasiFungsi() {
    let len = $(".fungsi").length - 1;
    len = len < 0 ? 0 : len;
    $(".fungsi").each(function(i) {
        $(this).prop("id", "fungsi" + i);
        $(this)
            .find(".akses1")
            .prop("id", "akses1" + i);
        $(this)
            .find(".ukerakses1")
            .prop("id", "ukerakses1" + i);
        $(this)
            .find(".batalakses1")
            .prop("id", "batalakses1" + i);
        $(this)
            .find(".akses2")
            .prop("id", "akses2" + i);
        $(this)
            .find(".ukerakses2")
            .prop("id", "ukerakses2" + i);
        $(this)
            .find(".batalakses2")
            .prop("id", "batalakses2" + i);
        $(this)
            .find(".add")
            .prop("id", "add" + i);
        $(this)
            .find(".rmv")
            .prop("id", "rmv" + i);
        $(this)
            .find("#ukerakses1" + i + ", #ukerakses2" + i)
            .select2();
        $("#fungsi" + i)
            .find('select[name="akses1[]"]')
            .on("change", function() {
                if ($(this).val() == "UKER") {
                    $("#akses1" + i)
                        .removeClass("d-none")
                        .addClass("d-block")
                        .find("#ukerakses1" + i)
                        .prop("disabled", false);
                    $(this)
                        .prop("disabled", true)
                        .hide();
                }
            });
        $("#fungsi" + i)
            .find(".batalakses1")
            .on("click", function() {
                $("#fungsi" + i)
                    .find('select[name="akses1[]"]')
                    .prop("disabled", false)
                    .show();
                $("#akses1" + i)
                    .removeClass("d-block")
                    .addClass("d-none")
                    .find("#ukerakses1" + i)
                    .prop("disabled", true);
            });
        $("#fungsi" + i)
            .find('select[name="akses2[]"]')
            .on("change", function() {
                if ($(this).val() == "UKER") {
                    $("#akses2" + i)
                        .removeClass("d-none")
                        .addClass("d-block")
                        .find("#ukerakses2" + i)
                        .prop("disabled", false);
                    $(this)
                        .prop("disabled", true)
                        .hide();
                }
            });
        $("#fungsi" + i)
            .find(".batalakses2")
            .on("click", function() {
                $("#fungsi" + i)
                    .find('select[name="akses2[]"]')
                    .prop("disabled", false)
                    .show();
                $("#akses2" + i)
                    .removeClass("d-block")
                    .addClass("d-none")
                    .find("#ukerakses2" + i)
                    .prop("disabled", true);
            });
        $(".fungsi")
            .find("#add" + i)
            .off("click")
            .on("click", function() {
                $("#fungsi" + len)
                    .find("#ukerakses1" + len + ", #ukerakses2" + len)
                    .select2("destroy");
                let num = new Number(len + 1),
                    cloneDom = $("#fungsi" + len),
                    newDom = cloneDom.clone().prop("id", "fungsi" + num);
                cloneDom.after(newDom);
                cloneDom.after("<hr>");
                $("#fungsi" + num)
                    .find('input[type="text"]')
                    .val("")
                    .find('input[type="checkbox"], input[type="radio"]')
                    .prop("checked", false);
                $("#fungsi" + num + " option:first").prop("selected", true);
                restructureAplikasiFungsi();
            });
        $(".fungsi")
            .find("#rmv" + i)
            .off("click")
            .on("click", function() {
                $(this)
                    .parent()
                    .parent()
                    .remove();
                restructureAplikasiFungsi();
            });
        if (len == 0) {
            $(".fungsi")
                .find("#add" + i)
                .show();
            $(".fungsi")
                .find("#rmv" + i)
                .hide();
        } else {
            if (i < len) {
                $(".fungsi")
                    .find("#add" + i)
                    .hide();
                $(".fungsi")
                    .find("#rmv" + i)
                    .show();
            } else {
                $(".fungsi")
                    .find("#add" + i)
                    .show();
                $(".fungsi")
                    .find("#rmv" + i)
                    .show();
            }
        }
    });
}

function toggleAksesFungsi(val, fungsi) {
    $("#eakses" + fungsi).on("change", function() {
        if ($(this).val() == "UKER") {
            $("#akses" + fungsi)
                .removeClass("d-none")
                .addClass("d-block")
                .find("#ukerakses" + fungsi)
                .prop("disabled", false);
            $("#eakses" + fungsi)
                .prop("disabled", true)
                .hide();
        }
    });
    $("#batalakses" + fungsi).on("click", function() {
        $("#eakses" + fungsi)
            .prop("disabled", false)
            .show();
        $("#akses" + fungsi)
            .removeClass("d-block")
            .addClass("d-none")
            .find("#ukerakses" + fungsi)
            .prop("disabled", true)
            .hide();
    });

    if (val == "UKER") {
        $("#akses" + fungsi)
            .removeClass("d-none")
            .addClass("d-block")
            .find("#ukerakses" + fungsi)
            .prop("disabled", false);
        $("#eakses" + fungsi)
            .prop("disabled", true)
            .hide();
    }
}
