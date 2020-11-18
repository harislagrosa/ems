<template>
    <div class="content">
        <div class="justify-content-between row ml-1 mr-1 mb-2">
            <div>
                <h3> Settings </h3>
            </div>
            <div>
                Expense Management / Account Settings
            </div>
        </div>
        <div class="animated fadeIn">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">

                            <div class="alert alert-danger col-md-12 password-danger pl-5 d-none"></div>
                            <div class="alert alert-success col-md-12 password-success pl-5 d-none"></div>

                            <form @submit.prevent="updatePassword()">
                                <div class="col-12">
                                    <div class="form-group">
                                        <label for="">Old Password</label>
                                        <input v-model="edit.old_password" type="password" class="form-control" required autocomplete="on">
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="form-group">
                                        <label for="">Password</label>
                                        <input v-model="edit.password" type="password" class="form-control" required autocomplete="on">
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="form-group">
                                        <label for="">Confirm Password</label>
                                        <input v-model="edit.password_confirmation" type="password" class="form-control" required autocomplete="on">
                                    </div>
                                </div>
                                <button type="submit" class="btn bg-flat-color-5 text-light pull-right mr-3 btn-submit">
                                    <i class="fa fa-save"></i>
                                    <span>Change Password</span>
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
</template>

<script>
    export default {
        data: function() {
            return {
                edit: {
                    id: this.$userId,
                    old_password: null,
                    password: null,
                    password_confirmation: null,
                },
            }
        },

        methods: {

            updatePassword() {
                var _this = this;
                $('.password-danger').addClass('d-none').html('');
                $('.password-success').addClass('d-none').html('');
                axios.put(`/api/settings/${this.$userId}`, _this.edit)
                .then(function (response) {
                    if (response.data.errors) {
                        var error = '<ul class="mb-0">';
                        $.each(response.data.errors.password, function (key, value) {
                            error += '<li>'+value+'</li>';
                        });
                        error += '</ul>';
                        $('.password-danger').removeClass('d-none').html(error);
                    }

                    if (response.data.error) {
                        $('.password-danger').removeClass('d-none').html('<ul class="mb-0"><li>'+response.data.error+'</li></ul>');
                    }

                    if (response.data.success) {
                        _this.edit.old_password = null;
                        _this.edit.password = null;
                        _this.edit.password_confirmation = null;
                        $('.password-success').removeClass('d-none').html('<ul class="mb-0"><li>'+response.data.success+'</li></ul>');
                        Vue.swal({
                            icon: 'success',
                            title: 'Updated',
                            text: response.data.success,
                        })
                    }
                })
                .catch(function (error) {
                    Vue.swal({
                        icon: 'error',
                        title: 'Opps..',
                        text: error,
                    })
                });
            },

        }
    }
</script>
