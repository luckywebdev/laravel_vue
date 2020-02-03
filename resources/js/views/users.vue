<template>

    <div>
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0 text-dark">Users</h1>
                    </div><!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                            <li class="breadcrumb-item active">Users</li>
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
                                <h3 class="card-title">User Table</h3>

                                <div class="card-tools">
                                   <button class="btn btn-success" data-toggle="modal" data-target="#addNew" @click="openModalWindow">Add New <i class="fas fa-user-plus fa-fw"></i></button>
                                </div>
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body table-responsive p-0" style="height: 300px;">
                                <table class="table table-hover">
                                    <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>First Name</th>
                                        <th>Last Name</th>
                                        <th>Title</th>
                                        <th>Tel_mobile</th>
                                        <th>Email</th>
                                        <th>Role</th>
                                        <th>Modify</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr v-for="user in users" :key="user.id">
                                        <td>{{user.id}}</td>
                                        <td>{{user.first_name}}</td>
                                        <td>{{user.last_name}}</td>
                                        <td>{{user.title}}</td>
                                        <td>{{user.tel_mobile}}</td>
                                        <td>{{user.email}}</td>
                                        <td>{{user.role}}</td>
                                        <td>
                                            <a href="#" data-id="user.id" @click="editModalWindow(user)">
                                                <i class="fa fa-edit blue"></i>
                                            </a>
                                            |
                                            <a href="#" @click="deleteUser(user.id)">
                                                <i class="fa fa-trash red"></i>
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

                            <h5 v-show="!editMode" class="modal-title" id="addNewLabel">Add New User</h5>
                            <h5 v-show="editMode" class="modal-title" id="addNewLabel">Update User</h5>

                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                            </button>
                        </div>

                        <form @submit.prevent="editMode ? updateUser() : createUser()">
                        <div class="modal-body">
                            <div class="form-group">
                                <input v-model="form.first_name" type="text" name="first_name"
                                    placeholder="First Name"
                                    class="form-control" :class="{ 'is-invalid': form.errors.has('first_name') }">
                                <has-error :form="form" field="first_name"></has-error>
                            </div>
                            <div class="form-group">
                                <input v-model="form.last_name" type="text" name="last_name"
                                    placeholder="Last Name"
                                    class="form-control" :class="{ 'is-invalid': form.errors.has('last_name') }">
                                <has-error :form="form" field="last_name"></has-error>
                            </div>
                            <div class="form-group">
                                <input v-model="form.title" type="text" name="title"
                                    placeholder="Title"
                                    class="form-control" :class="{ 'is-invalid': form.errors.has('title') }">
                                <has-error :form="form" field="title"></has-error>
                            </div>
                            <div class="form-group">
                                <input v-model="form.tel_mobile" type="text" name="tel_mobile"
                                    placeholder="Tel Mobile"
                                    class="form-control" :class="{ 'is-invalid': form.errors.has('tel_mobile') }">
                                <has-error :form="form" field="tel_mobile"></has-error>
                            </div>

                            <div class="form-group">
                                <input v-model="form.email" type="email" name="email"
                                    placeholder="Email Address"
                                    class="form-control" :class="{ 'is-invalid': form.errors.has('email') }">
                                <has-error :form="form" field="email"></has-error>
                            </div>
                            

                            <div class="form-group">
                                <input v-model="form.password" type="password" name="password" id="password" placeholder="Enter password"
                                class="form-control" :class="{ 'is-invalid': form.errors.has('password') }">
                                <has-error :form="form" field="password"></has-error>
                            </div>

                            <div class="form-group">
                                <select name="role" v-model="form.role" id="role" class="form-control" :class="{ 'is-invalid': form.errors.has('role') }">
                                    <option value="">Select User Role</option>
                                    <option v-for="role in roles" :key="role.id" :value="role.slug">{{role.name}}</option>
                                </select>
                                <has-error :form="form" field="role"></has-error>
                            </div>

                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                            <button v-show="editMode" type="submit" class="btn btn-primary">Update</button>
                            <button v-show="!editMode" type="submit" class="btn btn-primary">Create</button>
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
                roles: {},
                form: new Form({
                    'id': '',
                    'first_name': '',
                    'last_name': '',
                    'title': '',
                    'tel_mobile': '',
                    'email': '',
                    'password': '',
                    'role': ''
                })
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
            this.form.put('api/user/'+this.form.id)
                .then((data)=>{
                    console.log(data);
                    Toast.fire({
                        icon: 'success',
                        title: 'User updated successfully'
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
                axios.get("api/roles").then( data => (this.roles = data.data));

                //pick data from controller and push it into users object
            },
            createUser(){
                this.$Progress.start()
                this.form.post('api/user')
                    .then((data) => {
                        console.log(data);
                    
                        Fire.$emit('AfterCreatedUserLoadIt'); //custom events

                            Toast.fire({
                            icon: 'success',
                            title: 'User created successfully'
                            })

                            this.$Progress.finish()

                            $('#addNew').modal('hide');

                    })
                    .catch(() => {
                    console.log("Error......")
                    })

        

                //this.loadUsers();
            },   
            deleteUser(id) {
                Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
                }).then((result) => {
                    
                if (result.value) {
                    //Send Request to server
                    this.form.delete('api/user/'+id)
                        .then((response)=> {
                                Swal.fire(
                                'Deleted!',
                                'User deleted successfully',
                                'success'
                                )
                        this.loadUsers();

                        }).catch(() => {
                            Swal.fire({
                            icon: 'error',
                            title: 'Oops...',
                            text: 'Something went wrong!',
                            footer: '<a href>Why do I have this issue?</a>'
                            })
                        })
                    }

                })
            }         
        }
    }

</script>
