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
                                    <input type="text" class="form-control" v-model="modal.form.calender_title" placeholder="Judul">
                                    <small class="text-danger calender_title alertMessage"></small>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <label>Deskripsi</label>
                                    <input type="text" class="form-control" v-model="modal.form.calender_description" placeholder="Deskripsi">
                                    <small class="text-danger calender_description alertMessage"></small>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <label>Tanggal</label>
                                    <input type="date" class="form-control" v-model="modal.form.calender_date" placeholder="Tanggal">
                                    <small class="text-danger calender_date alertMessage"></small>
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
                        calender_id: '',
                        calender_title: '',
                        calender_description: '',
                        calender_date: '',
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
            }
        },
        methods: {
            hideLoading() {
                $("#pageLoader").hide();
            },
            generateTable() {
                $("#table").dataTableLib({
                    url: window.location.origin + '/service/calendar/data/',
                    selectID: 'calender_id',
                    colModel: [{
                            display: 'Judul',
                            name: 'calender_title',
                            sortAble: true,
                            align: 'left',
                            export: true
                        },
                        {
                            display: 'Deskripsi',
                            name: 'calender_description',
                            sortAble: false,
                            align: 'left',
                            export: false
                        },
                        {
                            display: 'Tanggal',
                            name: 'calender_date',
                            sortAble: false,
                            align: 'center',
                            render: (params) => {
                                return formatTanggal(params)
                            },
                            export: true
                        },
                        {
                            display: 'Ubah',
                            name: 'calender_id',
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
                            url: window.location.origin + "/service/calendar/remove"
                        }
                    ],
                    options: {
                        limit: [10, 25, 50, 100],
                        currentLimit: 10,
                    },
                    search: true,
                    searchTitle: 'Pencarian Data Calendar',
                    searchItems: [{
                            display: 'Judul',
                            name: 'calender_title',
                            type: 'text'
                        },
                        {
                            display: 'Tanggal',
                            name: 'calender_date',
                            type: 'date'
                        },
                    ],
                    sortName: "calender_date",
                    sortOrder: "asc",
                    tableIsResponsive: true,
                    select: true,
                    multiSelect: true,
                });
            },
            openModal() {
                $('#modalAddUpdate').modal()
                $('.alertMessage').text('')
            },
            add() {
                this.modal.data.title = "Tambah Data Calendar";
                this.modal.data.btnTitle = "Tambah";
                this.modal.data.btnAction = "insert";

                app.modal.form = {
                    calender_id: '',
                    calender_title: '',
                    calender_description: '',
                    calender_date: '',
                };

                this.openModal();
            },
            update(calender_id) {
                this.modal.data.title = "Update Data Calendar";
                this.modal.data.btnTitle = "Simpan";
                this.modal.data.btnAction = "update";

                $.ajax({
                    url: window.location.origin + '/service/calendar/detail',
                    method: 'GET',
                    data: {
                        id: calender_id
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
                    '/service/calendar/add' : window.location.origin + '/service/calendar/update'

                $.ajax({
                    url: actionUrl,
                    method: 'POST',
                    data: this.modal.form,
                    success: function(response) {
                        if (response.status == 200) {
                            if (app.modal.data.btnAction == 'insert') {
                                let data = response.data.results;
                                app.modal.form = {
                                    calender_id: '',
                                    calender_title: '',
                                    calender_description: '',
                                    calender_date: '',
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

    function formatTanggal(data) {
        const d = new Date(data)
        const ye = new Intl.DateTimeFormat(['ban', 'id'], {
            year: 'numeric'
        }).format(d)
        const mo = new Intl.DateTimeFormat(['ban', 'id'], {
            month: '2-digit'
        }).format(d)
        const da = new Intl.DateTimeFormat(['ban', 'id'], {
            day: '2-digit'
        }).format(d)

        return `${da}-${mo}-${ye}`;
    }
</script>

<script>
    var arr = '#<?= $uri->getSegment(1); ?>'

    $(arr + '_menu').addClass('active')
</script>