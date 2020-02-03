<template>

    <div>
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0 text-dark">Departments</h1>
                    </div><!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                            <li class="breadcrumb-item active">Departments</li>
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
                                <h3 class="card-title">Departments Table</h3>

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
                                        <th>Name</th>
                                        <th>Description</th>
                                        <th>Modify</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr v-for="user in users" :key="user.id">
                                        <td>{{user.id}}</td>
                                        <td>{{user.name}}</td>
                                        <td>{{user.description}}</td>
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

                            <h5 v-show="!editMode" class="modal-title" id="addNewLabel">Add New Department</h5>
                            <h5 v-show="editMode" class="modal-title" id="addNewLabel">Update Department</h5>

                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                            </button>
                        </div>

                        <form @submit.prevent="editMode ? updateUser() : createUser()">
                        <div class="modal-body">
                            <div class="form-group">
                                <input v-model="form.name" type="text" name="name"
                                    placeholder="Name"
                                    class="form-control" :class="{ 'is-invalid': form.errors.has('name') }">
                                <has-error :form="form" field="name"></has-error>
                            </div>
                            <div class="form-group">
                                <input v-model="form.description" type="text" name="description"
                                    placeholder="Description"
                                    class="form-control" :class="{ 'is-invalid': form.errors.has('description') }">
                                <has-error :form="form" field="description"></has-error>
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
                form: new Form({
                    'id': '',
                    'name': '',
                    'description': ''
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
            this.form.put('api/department/'+this.form.id)
                .then((data)=>{
                    console.log(data);
                    Toast.fire({
                        icon: 'success',
                        title: 'Department updated successfully'
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
                axios.get("api/department").then( data => (this.users = data.data));

                //pick data from controller and push it into users object
            },
            createUser(){
                this.$Progress.start()
                this.form.post('api/department')
                    .then((data) => {
                        console.log(data);
                    
                        Fire.$emit('AfterCreatedUserLoadIt'); //custom events

                            Toast.fire({
                            icon: 'success',
                            title: 'Department created successfully'
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
                    this.form.delete('api/department/'+id)
                        .then((response)=> {
                                Swal.fire(
                                'Deleted!',
                                'Department deleted successfully',
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
