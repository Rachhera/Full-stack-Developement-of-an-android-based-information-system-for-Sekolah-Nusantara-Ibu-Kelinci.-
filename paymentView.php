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
                                    <div class="alert alert-danger " v-show="alert.danger.status" style="display: none;">
                                        <span v-html="alert.danger.content"></span>
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
                                    <label>Deskripsi</label>
                                    <input type="text" class="form-control" v-model="modal.form.payment_description" placeholder="Deskripsi">
                                    <small class="text-danger payment_description alertMessage"></small>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <label>Tanggal Tempo</label>
                                    <input type="date" class="form-control" v-model="modal.form.payment_date" placeholder="">
                                    <small class="text-danger payment_date alertMessage"></small>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <label>Biaya</label>
                                    <input type="text" class="form-control" v-model="modal.form.payment_amount" placeholder="Biaya">
                                    <small class="text-danger payment_amount alertMessage"></small>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <label>Biaya Tambahan</label>
                                    <input type="text" class="form-control" v-model="modal.form.payment_amount_additional" placeholder="Biaya Tambahan">
                                    <small class="text-danger payment_amount_additional alertMessage"></small>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <label>User</label>
                                    <select id="user_id" @change="child_list()" data-placeholder="Pilih User" class="form-control" aria-hidden="true">
                                        <option value="">--PILIH--</option>
                                        <option v-for="item in user" :value="item.user_id"> {{item.user_name}} </option>
                                    </select>
                                    <small class="text-danger payment_user_id alertMessage"></small>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <label>Anak User</label>
                                    <select id="user_child_id" data-placeholder="Pilih Anak User" class="form-control" aria-hidden="true">
                                        <option value="">--PILIH--</option>
                                        <option v-for="item in user_child" :value="item.user_child_id"> {{item.user_child_name}} </option>
                                    </select>
                                    <small class="text-danger payment_user_child_id alertMessage"></small>
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
                        payment_id: '',
                        payment_user_id: '',
                        payment_user_child_id: '',
                        payment_description: '',
                        payment_amount: '',
                        payment_amount_additional: '',
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
                },
                user: [],
                user_child: [],
            }
        },
        methods: {
            hideLoading() {
                $("#pageLoader").hide();
            },
            generateTable() {
                $("#table").dataTableLib({
                    url: window.location.origin + '/service/payment/data',
                    selectID: 'payment_id',
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
                        },
                        {
                            display: 'Status Pembayaran',
                            name: 'payment_status_name',
                            sortAble: false,
                            align: 'left',
                        },
                        {
                            display: 'Aksi',
                            name: 'payment_button_action',
                            sortAble: false,
                            align: 'center',
                        },
                        {
                            display: 'Total',
                            name: 'payment_amount',
                            sortAble: false,
                            align: 'left',
                        },
                        {
                            display: 'Tambahan',
                            name: 'payment_amount_additional',
                            sortAble: false,
                            align: 'left',
                        },
                        {
                            display: 'Deskripsi',
                            name: 'payment_description',
                            sortAble: false,
                            align: 'left',
                            export: false
                        },
                        {
                            display: 'Nama User',
                            name: 'payment_user_name',
                            sortAble: false,
                            align: 'left',
                            export: false
                        },
                        {
                            display: 'Nama Anak',
                            name: 'payment_user_child_name',
                            sortAble: false,
                            align: 'left',
                            export: false
                        },
                        {
                            display: 'Tanggal Tempo',
                            name: 'payment_date',
                            sortAble: false,
                            align: 'left',
                            render: (params) => {
                                return formatTanggal(params)
                            },
                        },
                        {
                            display: 'Ubah',
                            name: 'payment_id',
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
                            url: window.location.origin + "/service/payment/remove"
                        }
                    ],
                    options: {
                        limit: [10, 25, 50, 100],
                        currentLimit: 10,
                    },
                    search: true,
                    searchTitle: 'Pencarian Data Pembayaran',
                    searchItems: [{
                        display: 'Tanggal',
                        name: 'payment_date',
                        type: 'date'
                    }, ],
                    sortName: "payment_date",
                    sortOrder: "asc",
                    tableIsResponsive: true,
                    select: true,
                    multiSelect: true,
                });
            },
            openModal() {
                this.child_list()
                $('#modalAddUpdate').modal()
                $('.alertMessage').text('')
            },
            add() {
                this.modal.data.title = "Tambah Data Pembayaran";
                this.modal.data.btnTitle = "Tambah";
                this.modal.data.btnAction = "insert";

                app.modal.form = {
                    payment_id: '',
                    payment_user_id: '',
                    payment_user_child_id: '',
                    payment_description: '',
                    payment_amount: '',
                    payment_amount_additional: '',
                };

                this.openModal();
            },
            view(url) {
                this.image.title = "Gambar Bukti Pembayaran";
                this.image.src = url

                $('#modalShowImage').modal()
            },
            update(payment_id) {
                this.modal.data.title = "Update Data Pembayaran";
                this.modal.data.btnTitle = "Simpan";
                this.modal.data.btnAction = "update";

                $.ajax({
                    url: window.location.origin + '/service/payment/detail',
                    method: 'GET',
                    data: {
                        id: payment_id
                    },
                    success: function(response) {
                        if (response.status == 200) {
                            let data = response.data.results;
                            let user_id = data.payment_user_id
                            let child_id = data.payment_user_child_id

                            $('#user_id').val(user_id)
                            $('#user_child_id').val(child_id)

                            app.modal.form = data;
                        }
                    },
                });

                this.openModal();
            },
            save() {
                this.modal.form.payment_user_id = $('#user_id').val()
                this.modal.form.payment_user_child_id = $('#user_child_id').val()

                let actionUrl = this.modal.data.btnAction == 'insert' ? window.location.origin +
                    '/service/payment/add' : window.location.origin + '/service/payment/update'

                $.ajax({
                    url: actionUrl,
                    method: 'POST',
                    data: this.modal.form,
                    success: function(response) {
                        if (response.status == 200) {
                            if (app.modal.data.btnAction == 'insert') {
                                let data = response.data.results;
                                app.modal.form = {
                                    payment_id: '',
                                    payment_user_id: '',
                                    payment_user_child_id: '',
                                    payment_description: '',
                                    payment_amount: '',
                                    payment_amount_additional: '',
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
            },
            approve(payment_id) {
                Swal.fire({
                    title: 'Perhatian!',
                    text: "Anda yakin approve pembayaran ini?",
                    icon: 'warning',
                    showCancelButton: true,
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Ok',
                    cancelButtonText: 'Batal'
                }).then((result) => {
                    if (result.value) {
                        $.ajax({
                            url: window.location.origin + '/service/payment/approve',
                            method: 'POST',
                            data: {
                                id: payment_id
                            },
                            success: function(response) {
                                if (response.status == 200) {
                                    app.alert.success.content = response.message;
                                    app.alert.success.status = true;

                                    setTimeout(() => {
                                        app.alert.success.status = false;
                                    }, 5000);
                                    app.generateTable();
                                }
                            },
                            error: function(res) {
                                app.alert.danger.content = res.responseJSON.message;
                                app.alert.danger.status = true;

                                setTimeout(() => {
                                    app.alert.danger.status = false;
                                }, 5000);
                                app.generateTable();
                            },

                        })
                    }
                })
            },
            get_user() {
                $.ajax({
                    url: window.location.origin + '/service/payment/user_list',
                    method: 'GET',
                    success: function(response) {
                        if (response.status == 200) {
                            app.user = response.data.results;
                        }
                    },
                });
            },
            child_list() {
                let user_id = $('#user_id').val();

                $.ajax({
                    url: window.location.origin + '/service/payment/user_child_list',
                    method: 'GET',
                    data: {
                        id: user_id
                    },
                    success: function(response) {
                        if (response.status == 200) {
                            app.user_child = response.data.results;
                        }
                    },
                });
            }
        },
        mounted() {
            this.get_user()
            this.child_list()
        }
    }).mount('#app');

    function add() {
        app.add()
    }

    function approve(payment_id) {
        app.approve(payment_id)
    }

    function show_image(param) {
        app.view(param.payment_image_url)
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