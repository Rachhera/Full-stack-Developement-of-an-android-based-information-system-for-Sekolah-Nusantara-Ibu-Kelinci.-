<section id="app">
    <div class="row">
        <div class="col-lg-3 col-6">
            <div class="small-box bg-info">
                <div class="inner">
                    <h3>{{data.register_user}}</h3>
                    <p>Total User Registrasi</p>
                </div>
                <div class="icon">
                    <i class="ion ion-person-add"></i>
                </div>
                <a href="/user" class="small-box-footer">Info lebih lanjut <i class="fas fa-arrow-circle-right"></i></a>
            </div>
        </div>
    </div>
</section>

<script>
    $(document).ready(function() {
        app.dashboardData();
    })

    let app = Vue.createApp({
        data: function() {
            return {
                data: {
                    register_user: 0
                }
            }
        },
        methods: {
            dashboardData() {
                $.ajax({
                    url: window.location.origin + '/service/dashboard/data',
                    method: 'GET',
                    data: {},
                    success: function(response) {
                        if (response.status == 200) {
                            let data = response.data.results;

                            app.data = data;
                        }
                    }
                });
            },
        },
        mounted() {}
    }).mount('#app');
</script>
<script>
    <?php $uri = service('uri'); ?>
    let url = window.location.href

    var arr = '<?= $uri->getSegment(1); ?>'
    if (arr == '') {
        $('#dashboard_menu').addClass('active')
    } else {
        $('#' + arr + '_menu').addClass('active')
    }
</script>