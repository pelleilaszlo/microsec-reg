<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Profile</div>

                    <div class="card-body">

                        <div class="form-group row">
                            <label class="col-md-4 col-form-label text-md-right">Nickname</label>
                            <div class="col-md-6">
                                <input type="text" class="form-control" v-model="user_data.nickname"
                                       :class="{'is-invalid': _.get(response.error, 'nickname')}"/>
                                <error-message :response="response" field="nickname"></error-message>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-md-4 col-form-label text-md-right">Birthday</label>
                            <div class="col-md-6">
                                <input type="date" class="form-control" v-model="user_data.birthdate"
                                       :class="{'is-invalid': _.get(response.error, 'birthdate')}"/>
                                <error-message :response="response" field="birthdate"></error-message>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-md-4 col-form-label text-md-right">Password</label>
                            <div class="col-md-6">
                                <input type="password" class="form-control" v-model="user_data.password"
                                       :class="{'is-invalid': _.get(response.error, 'password')}"/>
                                <error-message :response="response" field="password"></error-message>
                            </div>
                        </div>

                        <div v-if="response.success" class="alert alert-success" role="alert">
                            {{ response.success }}
                        </div>

                        <button :disabled="loading" type="button" class="btn btn-primary text-white" @click="store">
                            Update
                        </button>

                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                response: {
                    success: null,
                    error: null
                },
                loading: false,
                user_data: {
                    name: null,
                    nickname: null,
                    birthdate: null,
                    password: null,
                }
            }
        },
        created() {
            axios.get('/user').then(response => {
                this.user_data = response.data;
            });
        },
        methods: {
            store() {
                this.loading = true;
                this.response = {
                    success: null,
                    error: null
                };
                axios.put('/user', this.user_data).then(response => {
                    this.response.success = response.data;
                }).catch(error => {
                    this.response.error = error.response.data;
                }).then(() => {
                    this.loading = false;
                });
            }
        }
    }
</script>
