<section id="app">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row justify-content-center">
                <div class="col-md-7">
                    <div class="card card-success card-outline">
                        <div class="card-body box-profile">
                            <div class="alert alert-success " v-show="alert.success.status" style="display: none;">
                                <span v-html="alert.success.content"></span>
                            </div>
                            <div class="text-center">
                                <img class="profile-user-img img-fluid img-circle" src="<?= !empty($session->administrator_image) ?  getenv('UPLOAD_URL') . URL_IMG_PROFILE . $session->administrator_image : getenv('UPLOAD_URL') . '_default.jpeg' ?>" alt="User profile picture">
                            </div>
                            <h3 class="profile-username text-center">{{modal.form.administrator_name}}</h3>
                            <p class="text-muted text-center"></p>
                            <strong><i class="fas fa-user mr-1"></i> Nama</strong>
                            <p class="text-muted">
                                {{modal.form.administrator_name}}
                            </p>
                            <hr>
                            <strong><i class="fas fa-at mr-1"></i> Email</strong>
                            <p class="text-muted">
                                {{modal.form.administrator_email}}
                            </p>
                            <hr>

                            <a href="#" class="btn btn-warning float-right" onclick="app.update()">
                                <i class="fas fa-pencil-alt mr-1"></i>
                                <b>Ubah Profile</b>
                            </a>
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
                                    <input type="text" class="form-control" v-model="modal.form.administrator_name" placeholder="Nama">
                                    <small class="text-danger administrator_name alertMessage"></small>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <label>Email</label>
                                    <input readonly type="text" class="form-control" v-model="modal.form.administrator_email" placeholder="Email Karyawan">
                                    <small class="text-danger administrator_email alertMessage"></small>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <label for="">Foto Profile</label>
                                    <input ref="myFiles" @change="uploadImage()" type="file" class="form-control" name="rewardImageFilename" placeholder="" id="myFiles">
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button onclick="app.save()" :disabled="button.formBtn.disabled" class="btn btn-primary" id="submitModal">{{ modal.data.btnTitle }}</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modalAddUpdatePassword" role="dialog" aria-labelledby="modalAddUpdatePassword" aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="modalAddUpdatePasswordTitle">{{modal.data.title}}</h4>
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
                                    <label>Password Lama</label>
                                    <input type="password" class="form-control" v-model="modal.form_password.password_old" placeholder="Password Lama">
                                    <small class="text-danger password_old alertMessage"></small>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <label>Password Baru</label>
                                    <input type="password" class="form-control" v-model="modal.form_password.password_new" placeholder="Password Baru">
                                    <small class="text-danger password_new alertMessage"></small>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <label>Konfirmasi Password Baru</label>
                                    <input type="password" class="form-control" v-model="modal.form_password.password_conf" placeholder="Konfirmasi Password Baru">
                                    <small class="text-danger password_conf alertMessage"></small>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button onclick="app.savePassword()" :disabled="button.formBtn.disabled" class="btn btn-primary">{{ modal.data.btnTitle }}</button>
                </div>
            </div>
        </div>
    </div>
</section>

<script>
    $(document).ready(function() {
        app.start();
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
                        administrator_id: '',
                        administrator_name: '',
                        administrator_email: '',
                        administrator_username: '',
                        administrator_image: '',
                    },
                    form_password: {
                        password_old: '',
                        password_new: '',
                        password_conf: ''
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
            start() {
                let id = '<?php echo $session->administrator_id; ?>'

                $.ajax({
                    url: window.location.origin + '/service/user/detailProfile',
                    method: 'GET',
                    data: {
                        id: id
                    },
                    success: function(response) {
                        if (response.status == 200) {
                            let data = response.data.results;

                            app.modal.form = data;
                        }
                    }
                });
            },
            openModal() {
                $('#modalAddUpdate').modal()
            },
            openModalPassword() {
                $('#modalAddUpdatePassword').modal()
            },
            update() {
                this.modal.data.title = "Update Data Diri";
                this.modal.data.btnTitle = "Simpan";
                this.modal.data.btnAction = "update";

                this.openModal();
            },
            updatePassword() {
                this.modal.data.title = "Update Password";
                this.modal.data.btnTitle = "Simpan";
                this.modal.data.btnAction = "update";

                this.openModalPassword();
            },
            save() {
                $('.alertMessage').text('')

                let actionUrl = window.location.origin + '/service/user/updateProfile'

                $.ajax({
                    url: actionUrl,
                    method: 'POST',
                    data: this.modal.form,
                    success: function(response) {
                        if (response.status == 200) {
                            app.alert.success.content = response.message;
                            app.alert.success.status = true;

                            $('#modalAddUpdate').modal('hide');

                            setTimeout(() => {
                                app.alert.success.status = false;
                                location.reload()
                            }, 2000);
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
                            }, 3000);
                        }
                    },
                })
            },
            savePassword() {
                $('.alertMessage').text('')

                let actionUrl = window.location.origin + '/service/user/updatePassword'

                $.ajax({
                    url: actionUrl,
                    method: 'POST',
                    data: this.modal.form_password,
                    success: function(response) {
                        if (response.status == 200) {
                            app.alert.success.content = response.message;
                            app.alert.success.status = true;

                            $('#modalAddUpdatePassword').modal('hide');

                            setTimeout(() => {
                                app.alert.success.status = false;
                                location.reload()
                            }, 2000);
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
                            }, 3000);
                        }
                    },
                })
            },
            uploadImage() {
                $('#submitModal').html('<span class="spinner-border spinner-border-sm" aria-hidden="true"></span> Memuat...')

                let formData = new FormData();
                let image = this.$refs.myFiles.files[0]

                formData.append('file', image);

                $.ajax({
                    url: window.location.origin + '/service/user/uploadImage',
                    method: 'POST',
                    data: formData,
                    cache: false,
                    processData: false,
                    contentType: false,
                    success: function(response) {
                        if (response.status == 200) {
                            let data = response.data;

                            app.modal.form.administrator_image = data.name;

                            setTimeout(function() {
                                app.button.formBtn.disabled = false;
                                $('#submitModal').html('Simpan');
                            }, 3000);
                        }
                    },
                    error: function(res) {
                        let response = res.responseJSON;
                        app.button.formBtn.disabled = false;
                        $('#submitModal').html('Simpan');
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
        }
    }).mount('#app');
</script>