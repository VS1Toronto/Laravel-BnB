<template>
    <div>
        <success v-if="success">Congratulations on your purchase!</success>     <!-- If the success flag is true display this anf if not display the form in the else -->
        <div class="row" v-else>
            <div class="col-md-8" v-if="itemsInBasket">                         <!-- Only display if Vuex component itemsInBasket is true meaning it has a value because theres something in it -->

                <div class="row">
                    <div class="col-md-6 form-group">
                        <label for="first_names">First Names</label>
                        <input type="text" 
                            class="form-control" 
                            name="first_names" 
                            v-model="customer.first_names"
                            v-bind:class="[{'is-invalid': errorFor('customer.first_names')}]"
                        />
                        <v-errors v-bind:errors="errorFor('customer.first_names')"></v-errors>
                    </div>
                    <div class="col-md-6 form-group">
                        <label for="last_name">Last Name</label>
                        <input 
                            type="text" 
                            class="form-control" 
                            name="last_name" 
                            v-model="customer.last_name" 
                            v-bind:class="[{'is-invalid': errorFor('customer.last_name')}]"
                        />
                        <v-errors v-bind:errors="errorFor('customer.last_name')"></v-errors>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12 form-group">
                        <label for="email">Email</label>
                        <input 
                            type="text" 
                            class="form-control" 
                            name="email" 
                            v-model="customer.email" 
                            v-bind:class="[{'is-invalid': errorFor('customer.email')}]"
                        />
                        <v-errors v-bind:errors="errorFor('customer.email')"></v-errors>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 form-group">
                        <label for="street">Street</label>
                        <input 
                            type="text" 
                            class="form-control" 
                            name="street" 
                            v-model="customer.street" 
                            v-bind:class="[{'is-invalid': errorFor('customer.street')}]"
                        />
                        <v-errors v-bind:errors="errorFor('customer.street')"></v-errors>
                    </div>
                    <div class="col-md-6 form-group">
                        <label for="city">City</label>
                        <input 
                            type="text" 
                            class="form-control" 
                            name="city" 
                            v-model="customer.city" 
                            v-bind:class="[{'is-invalid': errorFor('customer.city')}]"
                        />
                        <v-errors v-bind:errors="errorFor('customer.city')"></v-errors>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 form-group">
                        <label for="country">Country</label>
                        <input 
                            type="text" 
                            class="form-control" 
                            name="country" 
                            v-model="customer.country" 
                            v-bind:class="[{'is-invalid': errorFor('customer.country')}]"
                        />
                        <v-errors v-bind:errors="errorFor('customer.country')"></v-errors>
                    </div>
                    <div class="col-md-4 form-group">
                        <label for="state">State</label>
                        <input 
                            type="text" 
                            class="form-control" 
                            name="state" 
                            v-model="customer.state" 
                            v-bind:class="[{'is-invalid': errorFor('customer.state')}]"
                        />
                        <v-errors v-bind:errors="errorFor('customer.state')"></v-errors>
                    </div>
                    <div class="col-md-2 form-group">
                        <label for="zip">Zip Code</label>
                        <input 
                            type="text" 
                            class="form-control" 
                            name="zip" 
                            v-model="customer.zip" 
                            v-bind:class="[{'is-invalid': errorFor('customer.zip')}]"
                        />
                        <v-errors v-bind:errors="errorFor('customer.zip')"></v-errors>
                    </div>
                </div>

                <hr />

                <!-- Although this form does not have a form tag so that the "submit" button -->
                <!-- does not submit it when pressed it is still good practice to ensure this -->
                <!-- by adding   prevent   to the on click in the button below   v-on:click.prevent="book" -->
                <!-- -->
                <div class="row">
                    <div class="col-md-12 form-group">
                        <button type="submit" 
                        class="btn btn-lg btn-primary btn-block"
                        v-on:click.prevent="book"
                        v-bind:disabled="loading"   
                        >Book Now</button>
                    </div>
                </div>
            </div>
            <div class="col-md-8" v-else>    <!-- Display if Vuex component itemsInBasket is false meaning it has no value because theres nothing in it -->
                <div class="jumbotron jumbotron-fluid text-center">    <!-- jumbotron-fluid   means take advantage of all the space available --> 
                    <h1>Empty</h1>
                </div>
            </div>


            <div class="col-md-4">                              
                <div class="d-flex justify-content-between">    <!-- This puts two elements side by side on the same row -->
                    <h6 class="text-uppercase text-secondary font-weight-bolder">Your Cart</h6>
                    <h6 class="badge badge-secondary text-uppercase">
                        <span v-if="itemsInBasket">Items {{ itemsInBasket }}</span>
                        <span v-else>Empty</span>
                    </h6>
                </div>

                <transition-group name="fade">
                    <div v-for="item in basket" v-bind:key="item.bookable.id">
                        <div class="pt-2 pb-2 border-top d-flex justify-content-between">
                            <span>
                                <router-link v-bind:to="{name: 'bookable', params: {id: item.bookable.id}}"
                                >{{ item.bookable.title }}</router-link>
                            </span>

                            <span>
                                <span class="font-weight-bold">${{ item.price.total }}</span>
                            </span>
                        </div>

                        <div class="pt-2 pb-2 d-flex justify-content-between">
                            <span>From {{ item.dates.from }}</span>
                            <span>To {{ item.dates.to}}</span>
                        </div>

                        <div class="pt-2 pb-2 text-right">
                            <button class="btn btn-sm btn-outline-secondary" 
                            v-on:click="$store.dispatch('removeFromBasket', item.bookable.id)"
                            >
                                <i class="fas fa-trash-alt"></i>
                            </button>
                        </div>
                    </div>
                </transition-group>
            </div>
        </div>

    </div>
</template>


<script>
import { mapGetters, mapState } from "vuex";
import validationErrors from "./../shared/mixins/validationErrors";

export default {
    mixins: [validationErrors],     //  Custom validation error script in directory   resources/js/shared/mixins
    data() {
        return {
            loading: false,
            bookingAttempted: false,
            customer: {             //  Customer Object used in Template above
                first_names: null,
                last_name: null,
                email: null,
                street: null,
                city: null,
                country: null,
                state: null,
                zip: null
            }
        };
    },
    computed: {
        ...mapGetters(["itemsInBasket"]),

        ...mapState({               //  This is bound to the Vuex State and gets the computed properties of the items in the basket 
            basket: state => state.basket.items
        }),
        success() {
            return !this.loading && 0 === this.itemsInBasket && this.bookingAttempted;
        }
    },
    methods: {
        async book() {
            this.loading = true;
            this.bookingAttempted = false;
            this.errors = null;

            try {                                               //  Here we try to make a booking
                await axios.post(`http://leedavidsoncontentmanagementsystem1.com/CodeLaravel7/public/api/checkout` , {
                    customer: this.customer,                    //  Object
                    bookings: this.basket.map(basketItem => ({  //  Data from   basket:   in   computed:   above 
                        bookable_id: basketItem.bookable.id,
                        from: basketItem.dates.from,
                        to: basketItem.dates.to
                    }))
                });
                this.$store.dispatch("clearBasket");
        } catch (error) {
            this.errors = error.response && error.response.data.errors;
        }

        this.loading = false;
        this.bookingAttempted = true;
        }
    },
};
</script>


<style scoped>

h6.badge {
  font-size: 100%; 
}

a {
    color: black;
}

</style>