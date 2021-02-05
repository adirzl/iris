
    $('a[rel="content"]').click(function() {
        showLoading();
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
        (FormObj = this.form), (SwalOptions.text = "Yakin Menyimpan Data?");
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
                showLoading();
                FormObj.submit();
            }
        });
        return false;
    });

    $(document).on("submit", ".form-filter", function() {
        showLoading();
        $(this).submit();
    });
