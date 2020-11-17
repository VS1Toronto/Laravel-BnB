<template>
    <div class="w-50 m-auto">
        <div class="card card-body">
            <form>


                <div class="form-group">
                    <label for="name">Name</label>
                    <input
                        type="text"
                        name="name"
                        placeholder="Enter your name"
                        class="form-control"
                        v-model="user.name"
                        v-bind:class="[{'is-invalid': errorFor('name')}]"
                    />
                    <v-errors v-bind:errors="errorFor('name')"></v-errors>
                </div>


                <div class="form-group">
                    <label for="email">E-mail</label>
                    <input
                        type="text"
                        name="email"
                        placeholder="Enter your e-mail"
                        class="form-control"
                        v-model="user.email"
                        v-bind:class="[{'is-invalid': errorFor('email')}]"
                    />
                    <v-errors v-bind:errors="errorFor('email')"></v-errors>
                </div>


                <div class="form-group">
                    <label for="password">Password</label>
                    <input
                        type="password"
                        name="password"
                        placeholder="Enter your password"
                        class="form-control"
                        v-model="user.password"
                        v-bind:class="[{'is-invalid': errorFor('password')}]"
                    />
                    <v-errors :errors="errorFor('password')"></v-errors>
                </div>

                
                <div class="form-group">
                    <label for="password_confirmation">Re-type Password</label>
                    <input
                        type="password"
                        name="password_confirmation"
                        placeholder="Confirm your password"
                        class="form-control"
                        v-model="user.password_confirmation"
                        v-bind:class="[{'is-invalid': errorFor('password_confirmation')}]"
                    />
                    <v-errors v-bind:errors="errorFor('password_confirmation')"></v-errors>
                </div>

                <button 
                        type="submit" 
                        class="btn btn-primary btn-lg btn-block" 
                        v-bind:disabled="loading"
                        v-on:click.prevent="register"
                    >Register
                </button>

                <hr />

                <div>
                    Already have an account?
                    <router-link v-bind:to="{name: 'login'}" class="font-weight-bold">Login</router-link>
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
            user: {
                name: null,
                email: null,
                password: null,
                password_confirmation: null
            },

            loading: false          //  This is a flag used to show on a component that something is loading and it disables the submit button when it is true
        };
    },
    methods: {
        async register() {
            this.loading = true;
            this.errors = null;     //  This is incase the next request is successful while the previous request was not so it doesnt keep displaying old errors before every request

            try {
                const response = await axios.post("http://leedavidsoncontentmanagementsystem1.com/CodeLaravel7/public/register", this.user);   //  This endpoint   /register   is a built in endpoint in Laravel so that is how we can use it here
                
                if(201 == response.status) {    //  We still want to login the user here because what the   /register   endpoint above does in Laravel is actually authenticates the user
                    logIn();
                    this.$store.dispatch("loadUser");
                    this.$router.push({ name: "home" });    //  If we get to this point redirect the user to the home page
                }
            }   catch(error) {
                this.errors = error.response && error.response.data.errors;
            }
            this.loading = false;
        }
    }
};
</script>