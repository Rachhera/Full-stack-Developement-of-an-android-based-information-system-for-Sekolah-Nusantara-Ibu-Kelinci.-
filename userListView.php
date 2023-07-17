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
                                    <label>Nama</label>
                                    <input type="text" class="form-control" v-model="modal.form.user_name" placeholder="Nama User">
                                    <small class="text-danger user_name alertMessage"></small>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <label>Email</label>
                                    <input type="text" class="form-control" v-model="modal.form.user_email" placeholder="Email User">
                                    <small class="text-danger user_email alertMessage"></small>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <label>No Telp</label>
                                    <input type="text" class="form-control" v-model="modal.form.user_mobilephone" placeholder="No Telp">
                                    <small class="text-danger user_mobilephone alertMessage"></small>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <label>Jenis Kelamin</label>
                                    <select name="" class="form-control" v-model="modal.form.user_gender">
                                        <option value="" disabled selected>--PILIH--</option>
                                        <option value="Laki-laki">Laki-laki</option>
                                        <option value="Perempuan">Perempuan</option>
                                    </select>
                                    <small class="text-danger user_gender alertMessage"></small>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <label>Tempat Lahir</label>
                                    <input type="text" class="form-control" v-model="modal.form.user_birth_place" placeholder="Tempat Lahir">
                                    <small class="text-danger user_birth_place alertMessage"></small>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <label>Tanggal Lahir</label>
                                    <input type="date" class="form-control" v-model="modal.form.user_birth_date" placeholder="Tanggal Lahir">
                                    <small class="text-danger user_birth_date alertMessage"></small>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <label>Alamat</label>
                                    <textarea name="" class="form-control" v-model="modal.form.user_address" placeholder="Alamat"></textarea>
                                    <small class="text-danger user_address alertMessage"></small>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <label>Nama Ibu Kandung</label>
                                    <input type="text" class="form-control" v-model="modal.form.user_mother_name" placeholder="Nama Ibu Kandung">
                                    <small class="text-danger user_mother_name alertMessage"></small>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <label>Nama Ayah</label>
                                    <input type="text" class="form-control" v-model="modal.form.user_father_name" placeholder="Nama Ayah">
                                    <small class="text-danger user_father_name alertMessage"></small>
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
                        user_id: '',
                        user_name: '',
                        user_email: '',
                        user_mobilephone: '',
                        user_gender: '',
                        user_birth_place: '',
                        user_birth_date: '',
                        user_address: '',
                        user_mother_name: '',
                        user_father_name: '',
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
                    url: window.location.origin + '/service/user/getDataUser/',
                    selectID: 'user_id',
                    colModel: [{
                            display: 'Nama',
                            name: 'user_name',
                            sortAble: true,
                            align: 'left',
                            export: true
                        },
                        {
                            display: 'Email',
                            name: 'user_email',
                            sortAble: false,
                            align: 'left',
                            export: false
                        },
                        {
                            display: 'Jenis Kelamin',
                            name: 'user_gender',
                            sortAble: false,
                            align: 'left',
                            export: false
                        },
                        {
                            display: 'No Telp',
                            name: 'user_mobilephone',
                            sortAble: false,
                            align: 'left',
                            export: false
                        },
                        {
                            display: 'Tanggal Registrasi',
                            name: 'user_registration_datetime',
                            sortAble: false,
                            align: 'left',
                            export: false
                        },
                        {
                            display: 'Alamat',
                            name: 'user_address',
                            sortAble: false,
                            align: 'left',
                            export: false
                        },
                        {
                            display: 'Status User',
                            name: 'user_status',
                            sortAble: false,
                            align: 'center',
                            render: (params) => {
                                return params == '1' ? '<span class="text-success" title="Aktif" data-toggle="tooltip"><i class="fas fa-lightbulb"></i></span>' : '<span class="text-danger" title="Non Aktif" data-toggle="tooltip"><i class="fas fa-lightbulb"></i></span>'
                            },
                            export: true
                        },
                        {
                            display: 'Ubah',
                            name: 'user_id',
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
                            display: 'Aktifkan',
                            icon: 'fas fa-lightbulb',
                            style: "success",
                            action: "active",
                            url: window.location.origin + "/service/user/active"
                        },
                        {
                            display: 'Non Aktifkan',
                            icon: 'fas fa-lightbulb',
                            style: "warning",
                            action: "nonactive",
                            url: window.location.origin + "/service/user/nonactive"
                        }, {
                            display: 'Hapus',
                            icon: 'fa-trash',
                            style: "danger",
                            action: "remove",
                            url: window.location.origin + "/service/user/remove"
                        }
                    ],
                    options: {
                        limit: [10, 25, 50, 100],
                        currentLimit: 10,
                    },
                    search: true,
                    searchTitle: 'Pencarian Data User',
                    searchItems: [{
                            display: 'Nama',
                            name: 'user_name',
                            type: 'text'
                        },
                        {
                            display: 'Email',
                            name: 'user_email',
                            type: 'text'
                        },
                    ],
                    sortName: "user_registration_datetime",
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
            add() {
                this.modal.data.title = "Tambah Data User";
                this.modal.data.btnTitle = "Tambah";
                this.modal.data.btnAction = "insert";

                app.modal.form = {
                    user_id: '',
                    user_name: '',
                    user_email: '',
                    user_mobilephone: '',
                    user_gender: '',
                    user_birth_place: '',
                    user_birth_date: '',
                    user_address: '',
                    user_mother_name: '',
                    user_father_name: '',
                };

                this.openModal();
            },
            update(user_id) {
                this.modal.data.title = "Update Data User";
                this.modal.data.btnTitle = "Simpan";
                this.modal.data.btnAction = "update";

                $.ajax({
                    url: window.location.origin + '/service/user/detail',
                    method: 'GET',
                    data: {
                        id: user_id
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
                    '/service/user/add' : window.location.origin + '/service/user/update'

                $.ajax({
                    url: actionUrl,
                    method: 'POST',
                    data: this.modal.form,
                    success: function(response) {
                        if (response.status == 200) {
                            if (app.modal.data.btnAction == 'insert') {
                                let data = response.data.results;
                                app.modal.form = {
                                    user_id: '',
                                    user_name: '',
                                    user_email: '',
                                    user_mobilephone: '',
                                    user_gender: '',
                                    user_birth_place: '',
                                    user_birth_date: '',
                                    user_address: '',
                                    user_mother_name: '',
                                    user_father_name: '',
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
</script>

<script>
    var arr = '#<?= $uri->getSegment(1); ?>'

    $(arr + '_menu').addClass('active')
</script>