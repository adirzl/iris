$(function() {
            "use strict";
            $.ajaxSetup({
                headers: {
                    "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content")
                }
            });
            let windowClosed = false,
                leavePageMessage = "Leaving current page...";
            $("html").on("mouseleave", function() {
                windowClosed = true;
            });
            $(document).bind("keydown", function(e) {
                if (e.ctrlKey || e.keyCode == 17 || e.keyCode == 87) {
                    windowClosed = true;
                }
                if (e.keyCode == 91 || e.keyCode == 18) {
                    windowClosed = false;
                }
                if (
                    e.keyCode == 116 ||
                    ((e.ctrlKey || e.keyCode == 17) && e.keyCode == 82)
                ) {
                    windowClosed = false;
                }
            });
            $(document).on("click", "a", function() {
                windowClosed = false;
            });
            $(document).on("click", "button", function() {
                windowClosed = false;
            });
            $(document).on("submit", "form", function() {
                windowClosed = false;
            });
            window.addEventListener("beforeunload", function(e) {
                if (windowClosed) {
                    (e || window.event).returnValue = leavePageMessage;
                    return leavePageMessage;
                }
            });
            window.addEventListener("unload", function() {
                if (windowClosed) {
                    $.post("/logout");
                }
            });

            // Accept only alphabet character.
            $(document).on("keyup", ".alpha", function() {
                this.value = this.value.replace(/[^a-zA-Z]/g, "");
            });
            // Accept only alphabet & number.
            $(document).on("keyup", ".alphanum", function() {
                this.value = this.value.replace(/[^a-zA-Z0-9]/g, "");
            });
            // Accept only alphabet & number and allow white space.
            $(document).on("keyup", ".alphanumspace", function() {
                this.value = this.value.replace(/[^a-zA-Z0-9\s]/g, "");
            });
            // Accept only alphabet & number and allow white space.
            $(document).on("keyup", ".alphanumdash", function() {
                this.value = this.value.replace(/[^a-zA-Z0-9\-\_]/g, "");
            });
            // Accept only alphabet & number.
            $(document).on("keyup", ".alphadash", function() {
                this.value = this.value.replace(/[^a-zA-Z\-\_]/g, "");
            });
            // Replace space with underscore.
            $(document).on("keyup", ".underscore", function() {
                this.value = this.value.replace(/\s/g, "_");
            });
            // Replace space with dash.
            $(document).on("keyup", ".dashed", function() {
                this.value = this.value.replace(/\s/g, "-");
            });
            // Accept only number.
            $(document).on("keyup", ".number", function() {
                this.value = this.value.replace(/[^0-9\.]/g, "");
            });
            // Turn first character into uppercase on keyup.
            $(document).on("keyup", ".ucfirst", function() {
                this.value = ucfirst(this.value);
            });
            // Turn all character into uppercase on keyup.
            $(document).on("keyup", ".ucase", function() {
                this.value = this.value.toUpperCase();
            });
            // Turn all character into lowercase on keyup.
            $(document).on("keyup", ".lcase", function() {
                this.value = this.value.toLowerCase();
            });
            // Format value into currency on keyup.
            $(document).on("keyup", ".currency", function() {
                let comma, dot, num, regex;
                this.value = this.value.replace(/[^0-9\.\,]/g, "");
                comma = this.value.replace(/,/g, "");
                comma += "";
                (dot = comma.split(".")), (num = dot[0]), (regex = /(\d+)(\d{3})/);
                while (regex.test(num)) {
                    num = num.replace(regex, "$1,$2");
                }
                this.value = num;
            });
            // Accept for No. Surat
            $(document).on("keyup", ".nosurat", function() {
                this.value = this.value.replace(/[^a-zA-Z0-9\.\-\/]/g, "");
            });
            $(".email").inputmask("email");
            $(".ipaddr").inputmask("99[9].9[99].99[9].99[9]");

            $('a[rel="content"]').click(function() {
                window.location = $(this).prop("href");
                return false;
            });
            $('a[rel="page-content"]').click(function() {
                showLoading();
                window.location = $(this).prop("href");
                return false;
            });

            $('a[rel="action"]').click(function() {
                let title =
                    $(this).prop("title") != "" ?
                    $(this).prop("title") :
                    $(this)[0].dataset.originalTitle,
                    href = $(this).prop("href");
                SwalOptions.text = title + "?";
                Swal.fire(SwalOptions).then(result => {
                    if (result.value) {
                        showLoading();
                        window.location = href;
                    }
                });
                return false;
            });

            $('a[rel="delete"]').click(function() {
                let title =
                    $(this).prop("title") != "" ?
                    $(this).prop("title") :
                    $(this)[0].dataset.originalTitle,
                    href = $(this).prop("href");
                SwalOptions.text = title + "?";
                Swal.fire(SwalOptions).then(result => {
                    if (result.value) {
                        let formDelete = $("<form/>", {
                                action: href,
                                method: "post",
                                id: "form-delete"
                            })
                            .append(
                                $("<input>", {
                                    type: "hidden",
                                    name: "_method",
                                    value: "DELETE"
                                })
                            )
                            .append(
                                $("<input>", {
                                    type: "hidden",
                                    name: "_token",
                                    value: $('meta[name="csrf-token"]').attr("content")
                                })
                            );
                        $("body").append(formDelete);
                        $("#form-delete").submit();
                        showLoading();
                    }
                });
                return false;
            });

            $('a[rel="post-action"]').click(function() {
                let title =
                    $(this).prop("title") != "" ?
                    $(this).prop("title") :
                    $(this)[0].dataset.originalTitle,
                    href = $(this).prop("href");
                SwalOptions.text = title + "?";
                Swal.fire(SwalOptions).then(result => {
                    if (result.value) {
                        let formPostAction = $("<form/>", {
                            action: href,
                            method: "post",
                            id: "form-post"
                        }).append(
                            $("<input>", {
                                type: "hidden",
                                name: "_token",
                                value: $('meta[name="csrf-token"]').attr("content")
                            })
                        );
                        $("body").append(formPostAction);
                        $("#form-post").submit();
                        showLoading();
                    }
                });
                return false;
            });

            $('a[rel="put-action"]').click(function() {
                let title =
                    $(this).prop("title") != "" ?
                    $(this).prop("title") :
                    $(this)[0].dataset.originalTitle,
                    href = $(this).prop("href");
                SwalOptions.text = title + "?";
                Swal.fire(SwalOptions).then(result => {
                    if (result.value) {
                        let formPostAction = $("<form/>", {
                                action: href,
                                method: "post",
                                id: "form-put"
                            })
                            .append(
                                $("<input>", {
                                    type: "hidden",
                                    name: "_method",
                                    value: "PUT"
                                })
                            )
                            .append(
                                $("<input>", {
                                    type: "hidden",
                                    name: "_token",
                                    value: $('meta[name="csrf-token"]').attr("content")
                                })
                            );
                        $("body").append(formPostAction);
                        $("#form-put").submit();
                        showLoading();
                    }
                });
                return false;
            });

            $(".logout").click(function(e) {
                e.preventDefault();
                $("#form-logout").submit();
                return false;
            });

            $(".save").click(function() {
                $(this).before('<input type="hidden" name="save" value="1">');
                (FormObj = this.form), (SwalOptions.text = "Submit?");
                Swal.fire(SwalOptions).then(result => {
                    if (result.value) {
                        showLoading();
                        FormObj.submit();
                    }
                });
                return false;
            });

            $(".save-close").click(function() {
                (FormObj = this.form), (SwalOptions.text = "Submit?");
                Swal.fire(SwalOptions).then(result => {
                    if (result.value) {
                        showLoading();
                        FormObj.submit();
                    }
                });
                return false;
            });

            $(".save-send").click(function() {
                $(this).before('<input type="hidden" name="send" value="1">');
                (FormObj = this.form), (SwalOptions.text = "Submit?");
                Swal.fire(SwalOptions).then(result => {
                    if (result.value) {
                        showLoading();
                        FormObj.submit();
                    }
                });
                return false;
            });

            $(".reset").click(function() {
                (FormObj = this.form), (SwalOptions.text = "Reset?");
                Swal.fire(SwalOptions).then(result => {
                    if (result.value) {
                        FormObj.reset();
                    }
                });
                return false;
            });

            $(".filter-reset").click(function() {
                (FormObj = this.form), (SwalOptions.text = "Reset?");
                Swal.fire(SwalOptions).then(result => {
                    if (result.value) {
                        doReset();
                    }
                });
                return false;
            });

            $(".export-file").click(function() {
                showLoading();
                let url = $(this).prop("href"),
                    filter = $(".form-filter").serializeArray();
                $.ajax({
                    url: url,
                    data: filter,
                    method: "post",
                    xhrFields: { responseType: "blob" },
                    success: function(data, status, xhr) {
                        if (xhr.status == 200) {
                            let disposition = xhr.getResponseHeader(
                                    "content-disposition"
                                ),
                                matches = /filename[^;=\n]*=((['"]).*?\2|[^;\n]*)/.exec(
                                    disposition
                                ),
                                filename =
                                matches != null && matches[1] ?
                                matches[1] :
                                "file.pdf",
                                link = document.createElement("a"),
                                objUrl = window.URL.createObjectURL(data);
                            link.href = objUrl;
                            link.download = filename;
                            document.body.append(link);
                            link.click();
                            link.remove();
                            window.URL.revokeObjectURL(link);
                            $(".loading-page").fadeOut();
                        } else {
                            Swal.fire("Error", xhr.statusText, "error").then(result => {
                                $(".loading-page").fadeOut();
                            });
                        }
                    },
                    error: function(xhr) {
                        Swal("Error", xhr.statusText, "error").then(result => {
                            $(".loading-page").fadeOut();
                        });
                    }
                });
                return false;
            });

            $(".download-file").click(function() {
                showLoading();
                let url = $(this).prop("href");
                $.ajax({
                    url: url,
                    method: "post",
                    xhrFields: { responseType: "blob" },
                    success: function(data, status, xhr) {
                        if (xhr.status == 200) {
                            let disposition = xhr.getResponseHeader(
                                    "content-disposition"
                                ),
                                matches = /filename[^;=\n]*=((['"]).*?\2|[^;\n]*)/.exec(
                                    disposition
                                ),
                                filename =
                                matches != null && matches[1] ?
                                matches[1] :
                                "file.pdf",
                                link = document.createElement("a"),
                                objUrl = window.URL.createObjectURL(data);
                            link.href = objUrl;
                            link.download = filename;
                            document.body.append(link);
                            link.click();
                            link.remove();
                            window.URL.revokeObjectURL(link);
                            $(".loading-page").fadeOut();
                        } else { <<
                            <<
                            << < HEAD
                            Swal.fire("Error", xhr.statusText, "error").then(
                                result => {
                                    $(".loading-page").fadeOut();
                                }
                            ); ===
                            ===
                            =
                            Swal.fire("Error", xhr.statusText, "error").then(result => {
                                $(".loading-page").fadeOut();
                            }); >>>
                            >>>
                            > fd5dc0e4db9b93532ba0401ad6d01417eb00dc28
                        }
                    },
                    error: function(xhr) {
                        Swal("Error", xhr.statusText, "error").then(result => {
                            $(".loading-page").fadeOut();
                        });
                    }
                });
                return false;
            });

            $('a[rel="download-action"]').click(function() {
                let title =
                    $(this).prop("title") != "" ?
                    $(this).prop("title") :
                    $(this)[0].dataset.originalTitle,
                    href = $(this).prop("href");
                SwalOptions.text = title + "?";
                Swal.fire(SwalOptions).then(result => {
                    if (result.value) {
                        showLoading();
                        $.ajax({
                            url: href,
                            method: "post",
                            xhrFields: { responseType: "blob" },
                            success: function(data, status, xhr) {
                                if (xhr.status == 200) {
                                    let disposition = xhr.getResponseHeader(
                                            "content-disposition"
                                        ),
                                        matches = /filename[^;=\n]*=((['"]).*?\2|[^;\n]*)/.exec(
                                            disposition
                                        ),
                                        filename =
                                        matches != null && matches[1] ?
                                        matches[1] :
                                        "file.pdf",
                                        link = document.createElement("a"),
                                        objUrl = window.URL.createObjectURL(data);
                                    link.href = objUrl;
                                    link.download = filename;
                                    document.body.append(link);
                                    link.click();
                                    link.remove();
                                    window.URL.revokeObjectURL(link);
                                    $(".loading-page").fadeOut();
                                } else {
                                    Swal.fire("Error", xhr.statusText, "error").then(
                                        result => {
                                            $(".loading-page").fadeOut();
                                        }
                                    );
                                }
                            },
                            error: function(xhr) {
                                Swal("Error", xhr.statusText, "error").then(result => {
                                    $(".loading-page").fadeOut();
                                });
                            }
                        });
                    }
                });
                return false;
            });

            $(document).on("submit", ".form-data", function() {
                (FormObj = this), (SwalOptions.text = "Submit?");
                Swal.fire(SwalOptions).then(result => {
                    if (result.value) {
                        FormObj.submit();
                    }
                });
                return false;
            });

            $(document).on("submit", ".form-filter", function() {
                showLoading();
                $(this).submit();
            });

            $("#perPage").change(function() {
                let i,
                    filter,
                    queryString = [],
                    uri = window.location.href.replace(BaseURI + "/", "").split("?")[0];
                if (uri.indexOf("filter") > 0) {
                    uri = uri.replace("/filter", "");
                }
                queryString.push("per_page=" + $(this).val());
                if ($(".form-filter").length) {
                    filter = $(".form-filter").serializeArray();
                    for (i = 0; i < filter.length; i++) {
                        if (filter[i].value !== "" && filter[i].name !== "_token")
                            queryString.push(filter[i].name + "=" + filter[i].value);
                    }
                }
                showLoading();
                window.location = BaseURI + "/" + uri + "?" + queryString.join("&");
            });

            <<
            <<
            << < HEAD
            $('input[name="check_all"]').on('click', function() { ===
                ===
                =
                $('input[name="check_all"]').on("click", function() { >>>
                    >>>
                    > fd5dc0e4db9b93532ba0401ad6d01417eb00dc28
                    var isChecked = $(this).is(":checked");
                    $('input[name="check[]"]').each(function() {
                        $(this).prop("checked", isChecked);
                    });
                });

                if ($(".form-modal").length) {
                    $(".form-data").off("submit");
                    $(".save").off("click");
                    $(".save-close").off("click");
                    $(".form-modal").each(function(i) {
                        $(".save-modal")
                            .eq(i)
                            .off("click")
                            .on("click", function() {
                                let method = $(".form-modal")
                                    .eq(i)
                                    .attr("data-method"),
                                    action = $(".form-modal")
                                    .eq(i)
                                    .attr("data-action");
                                $(".form-modal")
                                    .eq(i)
                                    .children()
                                    .unwrap()
                                    .wrapAll(
                                        '<form name="form-modal" action="' +
                                        action +
                                        '" method="' +
                                        method +
                                        '" class="form-material form-modal" autocomplete="off"></form>'
                                    );
                                (FormObj = $(".form-modal").eq(i)[0]),
                                (SwalOptions.text = "Submit?");
                                Swal.fire(SwalOptions).then(result => {
                                    if (result.value) {
                                        showLoading();
                                        FormObj.submit();
                                    }
                                });
                                return false;
                            });
                    });
                }

                if ($('form[name="form-login"]').length) {
                    $('input[name="username"]').focus();
                }

                // Permission
                if ($(".access").length) {
                    $(".access").each(function(i) {
                        $(".access" + i).on("click", function() {
                            let checked = $(this).prop("checked");
                            $(".access-child" + i).each(function(j) {
                                $(".access-child" + i + "-" + j).prop("checked", checked);
                            });
                        });
                    });
                }
                if ($(".permissions").length) {
                    restructure("permissions");
                }
                // Options
                if ($(".options").length) {
                    restructure("options");
                }
                // Rkat Khusus
                if ($(".rkatkhusus").length) {
                    restructure("rkatkhusus");
                }
                // Rkat umum
                if ($(".rkatumum").length) {
                    restructure("rkatumum");
                }
                // Date/Month/DateRange/DateTimeRange Picker
                $(".dr-start")
                    .datepicker(DatePickerOptions)
                    .on("changeDate", function(e) {
                        let year = parseInt(
                                $(".dr-start")
                                .val()
                                .substr(0, 4)
                            ),
                            month =
                            parseInt(
                                $(".dr-start")
                                .val()
                                .substr(5, 2)
                            ) - 1,
                            day = parseInt(
                                $(".dr-start")
                                .val()
                                .substr(8, 2)
                            ),
                            dt = new Date(year, month, day);
                        $(".dr-end")
                            .datepicker("show")
                            .datepicker("setDate", dt)
                            .datepicker("setStartDate", dt);
                    });
                $(".dr-end").datepicker(DatePickerOptions);
                $(".datepick").datepicker(
                    $.removeCollection(DatePickerOptions, "startDate")
                );
                $(".monthpick").datepicker({
                    autoclose: true,
                    format: "mm-yyyy",
                    viewMode: "months",
                    minViewMode: "months"
                });
                $(".yearpick").datepicker({
                    autoclose: true,
                    format: "yyyy",
                    viewMode: "years",
                    minViewMode: "years"
                });
                if ($(".datetimepicker-input").length) {
                    $(".datetimepicker-input").each(function() {
                        if ($(this).val() != "") {
                            $(this).datetimepicker({
                                format: "HH:mm",
                                date: moment($(this).val(), "hh:mm").toDate()
                            });
                        } else {
                            $(this).datetimepicker({ format: "HH:mm" });
                        }
                    });
                }
                $(document).on("click", '[data-toggle="lightbox"]', function(e) {
                    e.preventDefault();
                    $(this).ekkoLightbox({ alwaysShowClose: true, showArrows: true });
                });
                initPlugins();
            });

            (function($, global, undefined) {
                $.addCollection = function(collection, value, key) {
                    if (value instanceof Object) {
                        $.each(value, function(k, v) {
                            collection[k] = v;
                        });
                    } else {
                        collection[key] = value;
                    }
                    return collection;
                };

                $.removeCollection = function(collection, key) {
                    if (collection instanceof Array && $.inArray(key, collection) != -1) {
                        collection.splice($.inArray(key, collection), 1);
                    }
                    if (collection.hasOwnProperty(key)) {
                        delete collection[key];
                    }
                    return collection;
                };

                $.replaceCollection = function(collection, key, value) {
                    if (collection instanceof Array && $.inArray(key, collection) != -1) {
                        collection.splice($.inArray(key, collection, value));
                    }
                    if (collection.hasOwnProperty(key)) {
                        collection[key] = value;
                    }
                    return collection;
                };
            })(jQuery, window);

            var BaseURI = $("base").prop("href"),
                ComponentHandler = {},
                FormObj,
                datePick = new Date(),
                SwalOptions = {
                    title: "Perhatian!",
                    type: "warning",
                    showCancelButton: true,
                    confirmButtonText: "Ya",
                    cancelButtonText: "Tidak"
                },
                DatePickerOptions = {
                    autoclose: true,
                    format: "yyyy-mm-dd",
                    todayHighlight: true,
                    orientation: "bottom",
                    startDate: new Date(
                        datePick.getFullYear(),
                        datePick.getMonth(),
                        datePick.getDate()
                    )
                },
                DateRangePickerOptions = {
                    timePicker: true,
                    showDropdowns: true,
                    linkedCalendars: false,
                    locale: { format: "YYYY/MM/DD h:mm:00" },
                    startDate: new Date(
                        datePick.getFullYear(),
                        datePick.getMonth(),
                        datePick.getDate()
                    )
                };

            // Initialize all related plugins
            function initPlugins() {
                if ($(".dropify").length) {
                    $(".dropify").dropify();
                }
                if ($(".tablesaw").length) {
                    $(document).trigger("enhance.tablesaw");
                }
                if ($(".select2").length) {
                    $(".select2").select2();
                }
                if ($(".custom-control").length) {
                    bsCustomFileInput.init();
                }
                if ($(".summernote").length) {
                    $(".summernote").summernote({
                        toolbar: [
                            ["style", ["bold", "italic", "underline", "clear"]],
                            ["misc", ["undo", "redo"]],
                            ["font", ["strikethrough", "superscript", "subscript"]],
                            ["fontsize", ["fontsize"]],
                            ["color", ["color"]],
                            ["para", ["ul", "ol", "paragraph"]],
                            ["height", ["height"]],
                            ["insert", ["table", "hr"]]
                        ]
                    });
                }
            }
            // Turn first character into uppercase.
            function ucfirst(str) {
                str = str.replace("-", " ");
                str = str.replace(/^([a-z])|\s+([a-z])/g, function($1) {
                    return $1.toUpperCase();
                });
                return str;
            }

            // Show loading
            function showLoading() {
                $(".loading-page").fadeIn();
            }

            // Global function to copy value from source to target.
            function copyValueTo(source, target) {
                $(target).val($(source).val());
            }

            // Global function to copy value from source to target with trigger on keyup.
            function copyValueWithTrigger(source, target) {
                $(target)
                    .val($(source).val())
                    .trigger("keyup");
            }

            // Reset form
            function doReset() {
                let formObj = $(".form-filter"),
                    dropdowns = formObj.find("select"),
                    len = dropdowns.length;
                formObj
                    .find(':input[type="text"], :input[type="password"], textarea')
                    .prop("disabled", false)
                    .val("");
                formObj
                    .find(':input[type="radio"], :input[type="checkbox"]')
                    .prop("checked", false);
                for (let i = 0; i < len; i++) {
                    dropdowns[i].selectedIndex = 0;
                    console.log(dropdowns[i]);
                    if (dropdowns[i].classList.contains("select2")) {
                        dropdowns[i].value = '';
                        dropdowns[i].dispatchEvent(new Event("change"));
                    }
                }
            }

            // Reindex duplicate form field
            function restructure(selector, handler) {
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
                    if (handler != null) {
                        ComponentHandler[handler](i);
                    }
                    $("." + selector)
                        .find("#add" + i)
                        .off("click")
                        .on("click", function() {
                            let num = new Number(len + 1),
                                cloneDom = $("#" + selector + len),
                                newDom = cloneDom.clone().prop("id", selector + num);
                            cloneDom.after(newDom);
                            $("#" + selector + num)
                                .find('input[type="text"]')
                                .val("")
                                .find('input[type="textarea"]')
                                .prop("", true)
                                .find('input[type="checkbox"], input[type="radio"]')
                                .prop("checked", false);
                            $("#" + selector + num + " option:first").prop(
                                "selected",
                                true
                            );
                            restructure(selector, handler);
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
                            restructure(selector, handler);
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

            function buildBasicBarChart(
                container,
                title,
                yAxisTitle,
                tooltipOptions,
                yAxisLabel,
                data
            ) {
                Highcharts.chart(container, {
                    chart: { type: "column" },
                    title: { text: title },
                    xAxis: {
                        categories: [
                            "Jan",
                            "Feb",
                            "Mar",
                            "Apr",
                            "May",
                            "Jun",
                            "Jul",
                            "Aug",
                            "Sep",
                            "Oct",
                            "Nov",
                            "Dec"
                        ],
                        crosshair: true
                    },
                    yAxis: { min: 0, title: { text: yAxisTitle }, labels: yAxisLabel },
                    colors: ["#2cabe3", "#152d7a"],
                    tooltip: tooltipOptions,
                    plotOptions: {
                        column: { pointPadding: 0.2, borderWidth: 0 },
                        series: { pointPadding: 0 }
                    },
                    series: data
                });
            }

            function buildSingleBarChart(
                container,
                title,
                yAxisTitle,
                tooltipOptions,
                yAxisLabel,
                data
            ) {
                Highcharts.chart(container, {
                    title: { text: title },
                    xAxis: {
                        categories: [
                            "Jan",
                            "Feb",
                            "Mar",
                            "Apr",
                            "May",
                            "Jun",
                            "Jul",
                            "Aug",
                            "Sep",
                            "Oct",
                            "Nov",
                            "Dec"
                        ],
                        crosshair: true
                    },
                    yAxis: { min: 0, title: { text: yAxisTitle }, labels: yAxisLabel },
                    tooltip: tooltipOptions,
                    plotOptions: {
                        column: { pointPadding: 0.2, borderWidth: 0 },
                        series: { pointPadding: 0 }
                    },
                    series: [{
                        type: "column",
                        colorByPoint: true,
                        data: data,
                        showInLegend: false
                    }]
                });
            }

            function buildLineChart(container, title, yAxisTitle, tooltipOptions, data) {
                Highcharts.chart(container, {
                    chart: { type: "line" },
                    title: { text: title },
                    xAxis: {
                        categories: [
                            "Jan",
                            "Feb",
                            "Mar",
                            "Apr",
                            "May",
                            "Jun",
                            "Jul",
                            "Aug",
                            "Sep",
                            "Oct",
                            "Nov",
                            "Dec"
                        ]
                    },
                    yAxis: { title: { text: yAxisTitle } },
                    legend: { enabled: true },
                    colors: ["#2cabe3", "#152d7a"],
                    plotOptions: {
                        series: {
                            cursor: "pointer",
                            marker: { lineWidth: 1 },
                            series: {
                                borderWidth: 0,
                                dataLabels: { enabled: true, format: "{point.y:.1f}%" }
                            }
                        },
                        line: { dataLabels: { enabled: true }, enableMouseTracking: true }
                    },
                    tooltip: tooltipOptions,
                    series: data
                });
            }

            function buildMultiAxesChart(container, title, yAxis, data) {
                Highcharts.chart(container, {
                    chart: { zoomType: "xy" },
                    title: { text: title },
                    xAxis: [{
                        categories: [
                            "Jan",
                            "Feb",
                            "Mar",
                            "Apr",
                            "May",
                            "Jun",
                            "Jul",
                            "Aug",
                            "Sep",
                            "Oct",
                            "Nov",
                            "Dec"
                        ],
                        crosshair: true
                    }],
                    yAxis: yAxis,
                    colors: ["#2cabe3", "#152d7a", "#ffcf00"],
                    tooltip: {
                        formatter: function() {
                            let text =
                                '<span style="font-size:10px">' + this.x + "</span><br>";
                            for (let i = 0; i < this.points.length; i++) {
                                if (this.points[i].y.toString().indexOf(".") != -1) {
                                    text +=
                                        '<span style="color:' +
                                        this.points[i].color +
                                        ';padding:0">● </span><span>' +
                                        this.points[i].series.name +
                                        ': </span><span style="font-weight:bold">' +
                                        Highcharts.numberFormat(this.points[i].y, 2) +
                                        "%</span><br>";
                                    text +=
                                        '<span style="color:#68df5f;padding:0">● </span><span>Pencapaian: </span><span style="font-weight:bold">' +
                                        Highcharts.numberFormat(
                                            this.points[i].point.persen,
                                            2
                                        ) +
                                        "%</span>";
                                } else {
                                    text +=
                                        '<span style="color:' +
                                        this.points[i].color +
                                        '">● </span><span>' +
                                        this.points[i].series.name +
                                        ': </span><span style="font-weight:bold">Rp. ' +
                                        Highcharts.numberFormat(
                                            this.points[i].y,
                                            0,
                                            ",",
                                            "."
                                        ) +
                                        "</span><br>";
                                }
                            }
                            return text;
                        },
                        shared: true,
                        useHTML: true
                    },
                    legend: { align: "center", verticalAlign: "bottom" },
                    series: data
                });

                yAxisLabels(container);
            }

            function buildPieChart(container, title, data, formatterOptions) {
                Highcharts.chart(container, {
                    chart: {
                        plotBackgroundColor: null,
                        plotBorderWidth: null,
                        plotShadow: false,
                        type: "pie"
                    },
                    title: { text: title },
                    tooltip: formatterOptions,
                    colors: ["#2cabe3", "#152d7a", "#ffcf00", "#68df5f", "#e7412a"],
                    plotOptions: {
                        pie: {
                            allowPointSelect: true,
                            cursor: "pointer",
                            colorByPoint: true,
                            dataLabels: { enabled: false },
                            showInLegend: true
                        }
                    },
                    series: [data]
                });
            }

            function yAxisLabels(el) {
                let yLabels = document.querySelectorAll("#" + el + " .highcharts-yaxis"),
                    yAxisLabels = document.querySelectorAll(
                        "#" + el + " .highcharts-yaxis-labels"
                    );
                yLabels[0].style.visibility = "hidden";
                yAxisLabels[0].style.visibility = "hidden";
            }

            function hideChartContainer(container) {
                $("." + container).hide();
            }

            function leaveChange() {
                if (document.getElementById("leave").value != "1") {
                    document.getElementById("message").innerHTML = "Pertanyaan";
                } else {
                    document.getElementById("message").innerHTML = "Jawaban";
                }
            }

            window.removeEventListener("onbeforeunload");
            window.removeEventListener("beforeunload");