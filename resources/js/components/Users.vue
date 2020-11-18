<template>
    <div class="content">
        <div class="justify-content-between row ml-1 mr-1 mb-2">
            <div>
                <h3> User </h3>
            </div>
            <div>
                User Management / Users
            </div>
        </div>
        <div class="animated fadeIn">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">
                            <table class="table table-hover table-hover">
                                <thead class="table-dark">
                                    <tr>
                                        <th>Name</th>
                                        <th>Email</th>
                                        <th>Role</th>
                                        <th>Created At</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="user in users" :key="user.id" v-bind:id="user.id" @click="editModal(user)" style="cursor: pointer;">
                                        <td class="text-capitalize">{{ user.firstname + ' ' + user.lastname }}</td>
                                        <td>{{ user.email }}</td>
                                        <td>{{ user.role.role }}</td>
                                        <td>{{ user.created_at }}</td>
                                    </tr>
                                </tbody>
                            </table>
                            <button class="btn btn-sm btn-primary pull-right" @click="showModal()">
                                <span class="fa fa-plus"></span>
                                Add User
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="showModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Add Role</h5>
                    </div>
                    <div class="modal-body">
                        <form @submit.prevent="addUser()">
                            <div class="form-group">
                                <label for="" class="font-weight-bold">Firstname</label>
                                <input type="text" class="form-control text-capitalize" placeholder="Firtname" v-model="store.firstname" required>
                            </div>
                            <div class="form-group">
                                <label for="" class="font-weight-bold">Lastname</label>
                                <input type="text" class="form-control text-capitalize" placeholder="Lastname" v-model="store.lastname" required>
                            </div>
                            <div class="form-group">
                                <label for="" class="font-weight-bold">Email</label>
                                <input type="email" class="form-control" placeholder="Email Address" v-model="store.email" required>
                            </div>
                            <div class="form-group">
                                <label for="" class="font-weight-bold">Role</label>
                                <select class="form-control text-capitalize" v-model="store.role" required>
                                    <option v-for="role in roles" :key="role.id" :value="role.id">
                                        {{ role.role }}
                                    </option>
                                </select>
                            </div>
                            <button type="submit" class="btn btn-primary pull-right ml-1">
                                Save
                            </button>
                            <button type="button" class="btn btn-secondary pull-right" data-dismiss="modal">
                                Cancel
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Update Role</h5>
                    </div>
                    <div class="modal-body">
                        <form @submit.prevent="update(selectedId)">
                            <div class="form-group">
                                <label for="" class="font-weight-bold">Firstname</label>
                                <input type="text" class="form-control text-capitalize" placeholder="Firtname" v-model="edit.firstname">
                            </div>
                            <div class="form-group">
                                <label for="" class="font-weight-bold">Lastname</label>
                                <input type="text" class="form-control text-capitalize" placeholder="Lastname" v-model="edit.lastname">
                            </div>
                            <div class="form-group">
                                <label for="" class="font-weight-bold">Email</label>
                                <input type="email" class="form-control" placeholder="Email Address" v-model="edit.email">
                            </div>
                            <div class="form-group">
                                <label for="" class="font-weight-bold">Role</label>
                                <select class="form-control text-capitalize" v-model="edit.role" required>
                                    <option v-for="role in roles" :key="role.id" :value="role.id">
                                        {{ role.role }}
                                    </option>
                                </select>
                            </div>
                            <button type="button" class="btn btn-danger" @click="destroy(selectedId)">
                                Delete
                            </button>
                            <button type="submit" class="btn btn-primary pull-right ml-1">
                                Update
                            </button>
                            <button type="button" class="btn btn-secondary pull-right" data-dismiss="modal">
                                Cancel
                            </button>
                        </form>
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
                users: [],
                roles: [],
                store: {
                    firstname: null,
                    lastname: null,
                    email: null,
                    role: null
                },
                edit: {
                    firstname: null,
                    lastname: null,
                    email: null,
                    role: null,
                },
                selectedId: null,
            }
        },

        mounted() {
            this.loadUsers();
            this.loadRoles();
        },

        methods: {
            loadUsers() {
                axios.get('/api/users')
                .then((response) => {
                    this.users = response.data.data;
                })
                .catch(function(error) {
                    Vue.swal({
                        icon: 'error',
                        title: 'Opps..',
                        text: error,
                    })
                });
            },

            loadRoles() {
                axios.get('/api/roles')
                .then((response) => {
                    this.roles = response.data.data;
                })
                .catch(function(error) {
                    Vue.swal({
                        icon: 'error',
                        title: 'Opps..',
                        text: error,
                    })
                });
            },

            showModal(){
                this.store.role = '1';
                $('#showModal').modal('show');
            },

            addUser() {
                var _this = this;
                axios.post('/api/users', _this.store)
                .then(function (response) {
                    _this.loadUsers();
                    $('#showModal').modal('hide');
                    _this.store.firstname = null;
                    _this.store.lastname = null;
                    _this.store.email = null;
                    _this.store.role = null;
                    Vue.swal({
                        icon: 'success',
                        title: 'Added',
                        text: response.data.success,
                    })
                })
                .catch(function (error) {
                    Vue.swal({
                        icon: 'error',
                        title: 'Opps..',
                        text: error,
                    })
                })
            },

            editModal(user) {
                if (user.role.role != "Administrator") {
                    var _this = this;
                    _this.edit.firstname = user.firstname;
                    _this.edit.lastname = user.lastname;
                    _this.edit.email = user.email;
                    _this.edit.role = user.role.id;
                    this.selectedId = user.id;
                    $('#editModal').modal('show');
                }
                else {
                    Vue.swal({
                        icon: 'error',
                        title: 'Opps..',
                        text: 'Adminstrator role cannot be updated/deleted.',
                    })
                }
            },

            update(selectedId) {
                var _this = this;
                axios.put(`/api/users/${selectedId}`, _this.edit)
                .then(function (response) {
                    _this.loadUsers();
                    $('#editModal').modal('hide');
                    Vue.swal({
                        icon: 'success',
                        title: 'Updated',
                        text: response.data.success,
                    })
                })
                .catch(function (error) {
                    Vue.swal({
                        icon: 'error',
                        title: 'Opps..',
                        text: error,
                    })
                });
            },

            destroy(selectedId) {
                Vue.swal({
                    icon: 'warning',
                    title: 'Are you sure, do you want to remove it?',
                    showCancelButton: true,
                    confirmButtonText: `Delete`,
                }).then((result) => {

                    if (result.isConfirmed) {
                        axios.delete(`/api/users/${selectedId}`)
                        .then(function (response) {
                            $('#editModal').modal('hide');
                            $('#'+selectedId).remove();
                            Vue.swal({
                                icon: 'success',
                                title: 'Deleted',
                                text: response.data.success,
                            })
                        })
                        .catch(function (error) {
                            Vue.swal({
                                icon: 'error',
                                title: 'Opps..',
                                text: error,
                            })
                        });
                    }
                })
            },
        }
    }
</script>
