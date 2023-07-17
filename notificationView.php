<section id="app">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title"><?= isset($title) ? $title : '' ?></h4>
                            <ol class="breadcrumb float-sm-right">
                                <?php
                                if (isset($arrBreadcrumbs) && !empty($arrBreadcrumbs)) {
                                    $c = 1;
                                    foreach ($arrBreadcrumbs as $breadcrumbs => $linkBreadcrumbs) {
                                        if (count($arrBreadcrumbs) == $c) {
                                            echo '<li class="breadcrumb-item active" aria-current="page">' . $breadcrumbs . '</li>';
                                        } else {
                                            $linkBreadcrumbs = ($linkBreadcrumbs == '#') ? '#' :  base_url() . '/' . $linkBreadcrumbs;
                                            echo '<li class="breadcrumb-item"><a href="' . $linkBreadcrumbs . '">' . $breadcrumbs . '</a></li>';
                                        }
                                        $c++;
                                    }
                                }
                                ?>
                            </ol>
                        </div>
                        <div class="card-content">
                            <div id="pageLoader">
                                <div class="text-center text-muted d-flex align-center justify-content-center bg-grey-light p-2">
                                    <div class="spinner-border text-info spinner-border-sm" role="status" style="margin-right: 8px;margin-top: 2px;">
                                        <span class="sr-only">&nbsp;</span>
                                    </div>
                                    <span>Sedang memuat informasi, mohon tunggu beberapa saat...</span>
                                </div>
                            </div>
                            <div class="card-body card-dashboard">
                                <div class="col-12">
                                    <div class="alert alert-success " v-show="alert.success.status" style="display: none;">
                                        <span v-html="alert.success.content"></span>
                                    </div>
                                </div>
                                <div id="table"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="modalAddUpdate" role="dialog" aria-labelledby="modalAddUpdate" aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="modalAddUpdateTitle">{{modal.data.title}}</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form class="form form-horizontal mx-3" action="">
                        <div class="alert alert-danger" v-show="alert.danger.status" style="display: none;">
                            <span v-html="alert.danger.content"></span>
                        </div>
                        <div class="form-body">
                            <div class="row">
                                <div class="col-md-12">
                                    <label>Judul</label>
                                    <input type="text" class="form-control" v-model="modal.form.notification_title" placeholder="Judul">
                                    <small class="text-danger notification_title alertMessage"></small>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <label>Deskripsi</label>
                                    <input type="text" class="form-control" v-model="modal.form.notification_description" placeholder="Deskripsi">
                                    <small class="text-danger notification_description alertMessage"></small>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <label>Gambar</label>
                                    <input ref="myFiles" @change="uploadImage()" type="file" class="form-control" placeholder="">
                                    <small class="text-danger notification_image alertMessage"></small>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button onclick="app.save()" :disabled="button.formBtn.disabled" class="btn btn-primary">{{ modal.data.btnTitle }}</button>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="modalShowImage" tabindex="-1" role="dialog" aria-labelledby="modalShowImage" aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalShowImageTitle">{{image.title}}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
                <div class="modal-body text-center">
                    <img v-bind:src="image.src">
                </div>
            </div>
        </div>
    </div>
</section>

<script>
    $(document).ready(function() {
        app.generateTable();
        app.hideLoading();
    })

    let app = Vue.createApp({
        data: function() {
            return {
                button: {
                    formBtn: {
                        disabled: false
                    }
                },
                modal: {
                    data: {
                        title: "",
                        btnTitle: "",
                        btnAction: "",
                    },
                    form: {
                        notification_id: '',
                        notification_title: '',
                        notification_description: '',
                        notification_image: '',
                    }
                },
                alert: {
                    success: {
                        status: false,
                        content: '',
                    },
                    danger: {
                        status: false,
                        content: '',
                    }
                },
                image: {
                    title: '',
                    src: '',
                    width: 0
                }
            }
        },
        methods: {
            hideLoading() {
                $("#pageLoader").hide();
            },
            generateTable() {
                $("#table").dataTableLib({
                    url: window.location.origin + '/service/notification/data',
                    selectID: 'notification_id',
                    colModel: [{
                            display: 'Gambar',
                            name: '',
                            sortAble: false,
                            align: 'center',
                            action: {
                                function: 'show_image',
                                icon: 'fas fa-eye',
                                class: 'info',
                                style: 'info'
                            }
                        }, {
                            display: 'Judul Notifikasi',
                            name: 'notification_title',
                            sortAble: true,
                            align: 'left',
                            export: true
                        },
                        {
                            display: 'Deskripsi',
                            name: 'notification_description',
                            sortAble: false,
                            align: 'left',
                            export: false
                        },
                        {
                            display: 'Tanggal',
                            name: 'notification_datetime',
                            sortAble: false,
                            align: 'left',
                            export: false
                        },
                        {
                            display: 'Ubah',
                            name: 'notification_id',
                            sortAble: false,
                            align: 'center',
                            render: (params) => {
                                return `<a onclick="app.update(${params})" class="text-warning">  <i class="far fa-edit"></i> </a> `;
                            }
                        },
                    ],
                    buttonAction: [{
                            display: 'Tambah',
                            icon: 'fa-plus',
                            style: "primary",
                            action: "add"
                        },
                        {
                            display: 'Hapus',
                            icon: 'fa-trash',
                            style: "danger",
                            action: "remove",
                            url: window.location.origin + "/service/notification/remove"
                        }
                    ],
                    options: {
                        limit: [10, 25, 50, 100],
                        currentLimit: 10,
                    },
                    search: true,
                    searchTitle: 'Pencarian Data Notifikasi',
                    searchItems: [{
                            display: 'Judul',
                            name: 'notification_title',
                            type: 'text'
                        },
                        {
                            display: 'Tanggal',
                            name: 'notification_date',
                            type: 'date'
                        },
                    ],
                    sortName: "notification_datetime",
                    sortOrder: "desc",
                    tableIsResponsive: true,
                    select: true,
                    multiSelect: true,
                });
            },
            openModal() {
                $('#modalAddUpdate').modal()
                $('.alertMessage').text('')
            },
            uploadImage() {
                let formData = new FormData();
                let image = this.$refs.myFiles.files[0]

                formData.append('file', image);

                $.ajax({
                    url: window.location.origin + '/service/notification/uploadImage',
                    method: 'POST',
                    data: formData,
                    cache: false,
                    processData: false,
                    contentType: false,
                    success: function(response) {
                        if (response.status == 200) {
                            let data = response.data;
                            app.modal.form.notification_image = data.name;
                            app.button.formBtn.disabled = false;
                        }
                    },
                    error: function(res) {
                        let response = res.responseJSON;
                        app.button.formBtn.disabled = false;

                        if (response.status == 400 && response.message == "validationError") {
                            let resValidation = Object.values(response.data.validationMessage);

                            if (resValidation.length > 0) {
                                app.alert.danger.content = `<ul>`;
                                resValidation.forEach((data) => {
                                    app.alert.danger.content +=
                                        `<li> ${data} </li>`;
                                });
                                app.alert.danger.content += `</ul>`;
                                app.alert.danger.status = true;

                                setTimeout(() => {
                                    app.alert.danger.status = false;
                                }, 3000);
                            }

                        }
                    },
                });
            },
            add() {
                this.modal.data.title = "Tambah Data Notifikasi";
                this.modal.data.btnTitle = "Tambah";
                this.modal.data.btnAction = "insert";

                app.modal.form = {
                    notification_id: '',
                    notification_title: '',
                    notification_description: '',
                    notification_image: '',
                };

                this.openModal();
            },
            view(url) {
                this.image.title = "Gambar Notifikasi";
                this.image.src = url

                $('#modalShowImage').modal()
            },
            update(notification_id) {
                this.modal.data.title = "Update Data Notifikasi";
                this.modal.data.btnTitle = "Simpan";
                this.modal.data.btnAction = "update";

                $.ajax({
                    url: window.location.origin + '/service/notification/detail',
                    method: 'GET',
                    data: {
                        id: notification_id
                    },
                    success: function(response) {
                        if (response.status == 200) {
                            let data = response.data.results;

                            app.modal.form = data;
                        }
                    }
                });

                this.openModal();
            },
            save() {
                let actionUrl = this.modal.data.btnAction == 'insert' ? window.location.origin +
                    '/service/notification/add' : window.location.origin + '/service/notification/update'

                $.ajax({
                    url: actionUrl,
                    method: 'POST',
                    data: this.modal.form,
                    success: function(response) {
                        if (response.status == 200) {
                            if (app.modal.data.btnAction == 'insert') {
                                let data = response.data.results;
                                app.modal.form = {
                                    notification_id: '',
                                    notification_title: '',
                                    notification_description: '',
                                    notification_image: '',
                                };
                            }
                            app.alert.success.content = response.message;
                            app.alert.success.status = true;

                            $('#modalAddUpdate').modal('hide');

                            setTimeout(() => {
                                app.alert.success.status = false;
                            }, 5000);
                            app.generateTable();
                        }
                    },
                    error: function(res) {
                        let response = res.responseJSON;

                        if (response.status == 400 && response.message == "validationError") {
                            $.each(response.data.validationMessage, function(key, val) {
                                $('.' + key).text(val)
                            })
                        } else {
                            app.alert.danger.content = response.data;
                            app.alert.danger.status = true;

                            setTimeout(() => {
                                app.alert.danger.status = false;
                            }, 5000);
                        }
                    },

                })
            }
        },
        mounted() {}
    }).mount('#app');

    function add() {
        app.add()
    }

    function show_image(param) {
        app.view(param.notification_image_url)
    }
</script>

<script>
    var arr = '#<?= $uri->getSegment(1); ?>'

    $(arr + '_menu').addClass('active')
</script>