<template>
    <div class="content">
        <div class="justify-content-between row ml-1 mr-1 mb-2">
            <div>
                <h3> Roles </h3>
            </div>
            <div>
                User Management / Roles
            </div>
        </div>
        <div class="animated fadeIn">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card m-0">
                        <div class="card-body table-responsive">
                            <table class="table table-hover table-hover">
                                <thead class="table-dark">
                                    <tr>
                                        <th>Role</th>
                                        <th>Description</th>
                                        <th>Created At</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="role in roles" :key="role.id" v-bind:id="role.id" @click="editModal(role)" style="cursor: pointer;">
                                        <td class="text-capitalize">{{ role.role }}</td>
                                        <td>{{ role.description }}</td>
                                        <td>{{ role.created_at }}</td>
                                    </tr>
                                </tbody>
                            </table>
                            <button class="btn btn-sm btn-primary pull-right" @click="showModal()">
                                <span class="fa fa-plus"></span>
                                Add Role
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
                        <form @submit.prevent="addRole()">
                            <div class="form-group">
                                <label for="" class="font-weight-bold">Display Name</label>
                                <input type="text" class="form-control text-capitalize" placeholder="Display Name" v-model="store.role">
                            </div>
                            <div class="form-group">
                                <label for="" class="font-weight-bold">Description</label>
                                <input type="text" class="form-control" placeholder="Description" v-model="store.description">
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
                                <label for="" class="font-weight-bold">Display Name</label>
                                <input type="text" class="form-control text-capitalize" placeholder="Display Name" v-model="edit.role">
                            </div>
                            <div class="form-group">
                                <label for="" class="font-weight-bold">Description</label>
                                <input type="text" class="form-control" placeholder="Description" v-model="edit.description">
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
        // props: [roles],
        data() {
            return {
                roles: [],
                store: {
                    role: null,
                    description: null,
                },
                edit: {
                    role: null,
                    description: null,
                },
                selectedId: null
            }
        },

        created() {
            this.loadRoles();
        },

        methods: {
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

            showModal() {
                $('#showModal').modal('show');
            },

            addRole() {
                var _this = this;
                axios.post('/api/roles', _this.store)
                .then(function (response) {
                    // this.roles.push(response.data.data);
                    // push() will add element at the end of an array
                    // option kung gustong i push nalang new data or magbasa nang bagong request
                    _this.loadRoles();
                    $('#showModal').modal('hide');
                    _this.store.role = null;
                    _this.store.description = null;
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

            editModal(role) {
                if (role.role != "Administrator") {
                    $('#editModal').modal('show');
                    this.edit.role = role.role;
                    this.edit.description = role.description;
                    this.selectedId = role.id;
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
                axios.put(`/api/roles/${selectedId}`, _this.edit)
                .then(function (response) {
                    _this.loadRoles();
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
                        axios.delete(`/api/roles/${selectedId}`)
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
