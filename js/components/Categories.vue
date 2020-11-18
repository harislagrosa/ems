<template>
    <div class="content">
        <div class="justify-content-between row ml-1 mr-1 mb-2">
            <div>
                <h3> Categories </h3>
            </div>
            <div>
                Expense Management / Expense Categories
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
                                        <th>Display Name</th>
                                        <th>Description</th>
                                        <th>Created At</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="category in categories" :key="category.id" v-bind:id="category.id" @click="editModal(category)" style="cursor: pointer;">
                                        <td class="text-capitalize">{{ category.category }}</td>
                                        <td>{{ category.description }}</td>
                                        <td>{{ category.created_at }}</td>
                                    </tr>
                                </tbody>
                            </table>
                            <button class="btn btn-sm btn-primary pull-right" @click="showModal()">
                                <span class="fa fa-plus"></span>
                                Add Categories
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
                        <h5 class="modal-title" id="exampleModalLabel">Add Category</h5>
                    </div>
                    <div class="modal-body">
                        <form @submit.prevent="addCategory()">
                            <div class="form-group">
                                <label for="" class="font-weight-bold">Display Name</label>
                                <input type="text" class="form-control text-capitalize" placeholder="Display Name" v-model="store.category">
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
                        <h5 class="modal-title" id="exampleModalLabel">Update Category</h5>
                    </div>
                    <div class="modal-body">
                        <form @submit.prevent="update(selectedId)">
                            <div class="form-group">
                                <label for="" class="font-weight-bold">Display Name</label>
                                <input type="text" class="form-control text-capitalize" placeholder="Display Name" v-model="edit.category">
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
        data: function() {
            return {
                categories: [],
                store: {
                    category: null,
                    description: null,
                },
                edit: {
                    category: null,
                    description: null,
                },
                selectedId: null
            }
        },

        mounted() {
            this.loadCategories();
        },

        methods: {
            loadCategories() {
                axios.get('/api/categories')
                    .then((response) => {
                        this.categories = response.data.data;
                    })
                    .catch(function(error) {
                        console.log(error);
                    });
            },

            showModal() {
                $('#showModal').modal('show');
            },

            addCategory() {
                var _this = this;
                axios.post('/api/categories', _this.store)
                .then(function (response) {
                    // this.category.push(response.data.data);
                    // push() will add element at the end of an array
                    // option kung gustong i push nalang new data or magbasa nang bagong request
                    _this.loadCategories();
                    $('#showModal').modal('hide');
                    _this.store.category = null;
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

            editModal(category) {
                $('#editModal').modal('show');
                this.edit.category = category.category;
                this.edit.description = category.description;
                this.selectedId = category.id;
            },

            update(selectedId) {
                var _this = this;
                axios.put(`/api/categories/${selectedId}`, _this.edit)
                .then(function (response) {
                    _this.loadCategories();
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
                        axios.delete(`/api/categories/${selectedId}`)
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
