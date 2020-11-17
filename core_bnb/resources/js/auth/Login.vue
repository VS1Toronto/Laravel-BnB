<template>
    <div class="w-50 m-auto">
        <div class="card card-body">
            <form>


                <div class="form-group">
                    <label for="email">E-mail</label>
                    <input  
                        type="text" 
                        name="email" 
                        placeholder="Enter your e-mail"
                        class="form-control"
                        v-model="email"
                        v-bind:class="[{'is-invalid': errorFor('email')}]"
                    />
                    <v-errors v-bind:errors="errorFor('email')"></v-errors>
                </div>


                <div class="form-group">
                    <label for="email">Password</label>
                    <input  
                        type="password" 
                        name="password" 
                        placeholder="Enter your password"
                        class="form-control"
                        v-model="password"
                        v-bind:class="[{'is-invalid': errorFor('password')}]"
                    />
                    <v-errors v-bind:errors="errorFor('password')"></v-errors>
                </div>

                <button 
                        type="submit" 
                        class="btn btn-primary btn-lg btn-block" 
                        v-bind:disabled="loading"
                        v-on:click.prevent="login"
                    >Login
                </button>

                <hr />

                <div>
                    No account yet?
                    <router-link v-bind:to="{name: 'register'}" class="font-weight-bold">Register</router-link>
                </div>


                <div>
                    Forgotten password?
                    <router-link v-bind:to="{name: 'reset'}" class="font-weight-bold">Reset password</router-link>
                </div>

            </form>
        </div>
    </div>
</template>


<script>
import validationErrors from "../shared/mixins/validationErrors";
import { logIn } from "./../shared/utils/auth";

export default {
    mixins: [validationErrors],
    data() {
        return {
            email: null,
            password: null,
            loading: false          //  This is a flag used to show on a component that something is loading and it disables the submit button when it is true
        };
    },
    methods: {
        async login() {
            this.loading = true;
            this.errors = null;     //  This is incase the next request is successful while the previous request was not so it doesnt keep displaying old errors before every request

            try {
                await axios.get('http://leedavidsoncontentmanagementsystem1.com/CodeLaravel7/public/sanctions/csrf-cookie');
                await axios.post("http://leedavidsoncontentmanagementsystem1.com/CodeLaravel7/public/login", {
                    email: this.email,
                    password: this.password
                });
                
                logIn();
                this.$store.dispatch("loadUser");
                this.$router.push({ name: "home" });    //  If we get to this point redirect the user to the home page
            }   catch(error) {
                this.errors = error.response && error.response.data.errors;
            }
            this.loading = false;
        }
    }
};
</script>