<template>

    <div>
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0 text-dark">User Department Assign</h1>
                    </div><!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                            <li class="breadcrumb-item active">User Department Assign</li>
                        </ol>
                    </div><!-- /.col -->
                </div><!-- /.row -->
            </div><!-- /.container-fluid -->
        </div>
        <!-- /.content-header -->

        <!-- Main content -->
        <div class="content">

            <div class="container-fluid">

                <div class="row">

                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">User Department Assign Table</h3>

                                <div class="card-tools">
                                </div>
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body table-responsive p-0" style="height: 300px;">
                                <table class="table table-hover">
                                    <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Name</th>
                                        <th>Department</th>
                                        <th>Modify</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr v-for="user in users" :key="user.id">
                                        <td>{{user.id}}</td>
                                        <td>{{user.first_name}} {{ user.last_name}}</td>
                                        <td>{{user.department}}</td>
                                        <td>
                                            <a href="#" data-id="user.id" @click="editModalWindow(user)">
                                                <i class="fa fa-edit blue"></i>
                                            </a>
                                        </td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                            <!-- /.card-body -->
                        </div>
                        <!-- /.card -->
                    </div>

                    <div class="modal fade" id="addNew" tabindex="-1" role="dialog" aria-labelledby="addNewLabel" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered" role="document">
                        <div class="modal-content">
                        <div class="modal-header">

                            <h5 v-show="editMode" class="modal-title" id="addNewLabel">Assign Department</h5>

                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                            </button>
                        </div>

                        <form @submit.prevent="editMode ? updateUser() : createUser()">
                        <div class="modal-body">
                            <div class="form-group">
                                <label class="typo__label">Name</label>
                                <input v-model="form.first_name" type="text" name="first_name"
                                    placeholder="Name"
                                    class="form-control" :class="{ 'is-invalid': form.errors.has('first_name') }">
                                <has-error :form="form" field="first_name"></has-error>
                            </div>
                            <div class="form-group">
                                <b-form-group label="Department Select">
                                    <!-- prop `add-on-change` is needed to enable adding tags vie the `change` event -->
                                    <b-form-tags v-model="value" size="lg" add-on-change no-outer-focus class="mb-2">
                                        <template v-slot="{ tags, inputAttrs, inputHandlers, disabled, removeTag }">
                                        <ul v-if="tags.length > 0" class="list-inline d-inline-block mb-2">
                                            <li v-for="tag in tags" :key="tag" class="list-inline-item">
                                            <b-form-tag
                                                @remove="removeTag(tag)"
                                                :title="tag"
                                                :disabled="disabled"
                                                variant="info"
                                            >{{ tag }}</b-form-tag>
                                            </li>
                                        </ul>
                                        <b-form-select
                                            v-bind="inputAttrs"
                                            v-on="inputHandlers"
                                            :disabled="disabled || availableOptions.length === 0"
                                            :options="availableOptions">
                                            <template v-slot:first>
                                            <!-- This is required to prevent bugs with Safari -->
                                            <option disabled value="">Choose a department...</option>
                                            </template>
                                        </b-form-select>
                                        </template>
                                    </b-form-tags>
                                </b-form-group>
                            </div>
                            <input type="hidden" name="department" v-model="value">

                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                            <button v-show="editMode" type="submit" class="btn btn-primary">Assign</button>
                        </div>

                        </form>

                        </div>
                    </div>
                    </div>
                </div>  
            </div>
            <!-- /.container-fluid -->

        </div>
        <!-- /.content -->

    </div>

</template>

<script>

    export default {

        data() {

            return {
                editMode: false,
                users: {},
                departments: {},
                options: [],
                value: [],
                form: new Form({
                    'id': '',
                    'first_name': '',
                    'department': ''
                })
            }

        },
        computed: {
            availableOptions() {
                return this.options.filter(opt => this.value.indexOf(opt) === -1)
            }
        },

        created() {
            this.loadUsers();

            Fire.$on('AfterCreatedUserLoadIt',()=>{ //custom events fire on
                this.loadUsers();
            }); 
        },

        methods: {
            editModalWindow(user){
            this.form.clear();
            this.editMode = true
            this.form.reset();
            $('#addNew').modal('show');
            this.form.fill(user)
            },
            updateUser(){
                this.form.department = this.value;
                this.form.put('api/user_department/'+this.form.id)
                .then((data)=>{
                    Toast.fire({
                        icon: 'success',
                        title: 'User assigned successfully'
                        })

                        Fire.$emit('AfterCreatedUserLoadIt');

                        $('#addNew').modal('hide');
                })
                .catch(()=>{
                    console.log("Error.....")
                })
            },
            openModalWindow(){
                this.editMode = false
                this.form.reset();
                $('#addNew').modal('show');
            },

            loadUsers() {
                axios.get("api/user").then( data => (this.users = data.data));
                axios.get("api/department").then( data => {
                    this.departments = data.data;
                    this.options = this.departments.map(function(val, index){
                        return val.name;
                    });
                });
                //pick data from controller and push it into users object
            }         
        }
    }

</script>
