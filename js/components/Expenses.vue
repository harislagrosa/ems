<template>
    <div class="content">
        <div class="justify-content-between row ml-1 mr-1 mb-2">
            <div>
                <h3> Expenses </h3>
            </div>
            <div>
                Expense Management / Expenses
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
                                        <th>Expenses Category</th>
                                        <th>Amount</th>
                                        <th>Entry Date</th>
                                        <th>Created At</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="expense in expenses" :key="expense.id" v-bind:id="expense.id" @click="editModal(expense)" style="cursor: pointer;">
                                        <td class="text-capitalize">{{ expense.category.category }}</td>
                                        <td>{{ expense.amount }}</td>
                                        <td>{{ expense.entry_date }}</td>
                                        <td>{{ expense.created_at }}</td>
                                    </tr>
                                </tbody>
                            </table>
                            <button class="btn btn-sm btn-primary pull-right" @click="showModal()">
                                <span class="fa fa-plus"></span>
                                Add Expense
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
                        <h5 class="modal-title" id="exampleModalLabel">Add Expense</h5>
                    </div>
                    <div class="modal-body">
                        <div class="alert alert-danger col-md-12 d-none info-danger pl-5"></div>
                        <form @submit.prevent="addExpense()">
                            <div class="form-group">
                                <label for="" class="font-weight-bold">Categories</label>
                                <select class="form-control text-capitalize" v-model="store.category" required>
                                    <option v-for="category in categories" :key="category.id" :value="category.id">
                                        {{ category.category }}
                                    </option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="" class="font-weight-bold">Amount</label>
                                <input type="number" class="form-control text-capitalize" v-model="store.amount" required min="0">
                            </div>
                            <div class="form-group">
                                <label for="" class="font-weight-bold">Entry Date</label>
                                <input type="date" class="form-control" v-model="store.entry_date" required>
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
                        <h5 class="modal-title" id="exampleModalLabel">Update Expense</h5>
                    </div>
                    <div class="modal-body">
                        <div class="alert alert-danger col-md-12 d-none info-danger-2 pl-5"></div>
                        <form @submit.prevent="update(selectedId)">
                            <div class="form-group">
                                <label for="" class="font-weight-bold">Categories</label>
                                <select class="form-control text-capitalize" v-model="edit.category" required>
                                    <option v-for="category in categories" :key="category.id" :value="category.id">
                                        {{ category.category }}
                                    </option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="" class="font-weight-bold">Amount</label>
                                <input type="number" class="form-control text-capitalize" v-model="edit.amount" required min="0">
                            </div>
                            <div class="form-group">
                                <label for="" class="font-weight-bold">Entry Date</label>
                                <input type="date" class="form-control" v-model="edit.entry_date" required>
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
                expenses: [],
                categories: [],
                store: {
                    id: this.$userId,
                    category: null,
                    amount: null,
                    entry_date: null,
                },
                edit: {
                    id: this.$userId,
                    category: null,
                    amount: null,
                    entry_date: null,
                },
                selectedId: null,
            }
        },

        mounted() {
            this.loadExpenses();
            this.loadCategories();
        },

        methods: {
            loadExpenses() {
                axios.get(`/api/expenses/${this.$userId}`)
                .then((response) => {
                    this.expenses = response.data.data;
                })
                .catch(function(error) {
                    console.log(error);
                });
            },

            loadCategories() {
                axios.get('/api/categories')
                .then((response) => {
                    this.categories = response.data.data;
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
                this.store.category = '1';
                $('#showModal').modal('show');
            },

            addExpense() {
                var _this = this;
                $('.info-danger').addClass('d-none').html('');
                axios.post('/api/expenses', _this.store)
                .then(function (response) {
                    if (response.data.errors) {
                        var error = '<ul class="mb-0">';
                        $.each(response.data.errors, function (key, value) {
                            error += '<li>'+value+'</li>';
                        });
                        error += '</ul>';
                        $('.info-danger').removeClass('d-none').html(error);
                    }
                    else {
                        _this.loadExpenses();
                        $('#showModal').modal('hide');
                        _this.store.amount = null;
                        _this.store.entry_date = null;
                        Vue.swal({
                            icon: 'success',
                            title: 'Added',
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
                })
            },

            editModal(expense) {
                var _this = this;
                _this.edit.category = expense.category.id;
                _this.edit.amount = expense.amount;
                _this.edit.entry_date = expense.entry_date;
                this.selectedId = expense.id;
                $('#editModal').modal('show');
            },

            update(selectedId) {
                var _this = this;
                $('.info-danger-2').addClass('d-none').html('');
                axios.put(`/api/expenses/${selectedId}`, _this.edit)
                .then(function (response) {
                    if (response.data.errors) {
                        var error = '<ul class="mb-0">';
                        $.each(response.data.errors, function (key, value) {
                            error += '<li>'+value+'</li>';
                        });
                        error += '</ul>';
                        $('.info-danger-2').removeClass('d-none').html(error);
                    }
                    else {
                        _this.loadExpenses();
                        $('#editModal').modal('hide');
                        _this.store.amount = null;
                        _this.store.entry_date = null;
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

            destroy(selectedId) {
                Vue.swal({
                    icon: 'warning',
                    title: 'Are you sure, do you want to remove it?',
                    showCancelButton: true,
                    confirmButtonText: `Delete`,
                }).then((result) => {

                    if (result.isConfirmed) {
                        axios.delete(`/api/expenses/${selectedId}`)
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
