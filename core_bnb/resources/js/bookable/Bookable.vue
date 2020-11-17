<template>
    <div class="row">
        <div class="col-md-8 pb-4">
            <div class="card">
                <div class="card-body">
                    <div v-if="!loading">
                        <h2>{{ bookable.title }}</h2>
                        <hr />
                        <article>{{ bookable.description }}</article>
                    </div>
                    <div v-else>Loading...</div>
                </div>
            </div>
            <review-list v-bind:bookable-id="this.$route.params.id"></review-list>
        </div>


        <div class="col-md-4 pb-4">
            <availability
                v-bind:bookable-id="this.$route.params.id"
                v-on:availability="checkPrice($event)"
                class="mb-4"
            ></availability>
            

            <transition name="fade">
                <!-- v-if="price"   means the button will only render and appear on screen if there is a price -->
                <!-- -->
                <price-breakdown v-if="price" :price="price" class="mb-4"></price-breakdown>
            </transition>
        

            <transition name="fade">             
                <div class="nav-item" v-if="isLoggedIn">
                    <!-- v-if="price"   means the button will only render and appear on screen if there is a price -->
                    <!-- -->
                    <button 
                            class="btn btn-outline-secondary btn-block" 
                            v-if="price"
                            v-on:click="addToBasket"
                            v-bind:disabled="inBasketAlready"
                        >Book Now
                    </button>
                </div>
                <div v-else class="text-uppercase text-secondary font-weight-bolder">Please login to complete purchase</div>
            </transition>

            <div class="nav-item" v-if="isLoggedIn">
                <!-- v-if="price"   means the button will only render and appear on screen if there is a price -->
                <!-- -->
                <button 
                    class="btn btn-outline-secondary btn-block"
                    v-if="inBasketAlready"
                    v-on:click="removeFromBasket"
                    >Remove From Basket
                </button>
            </div>


        <div v-if="inBasketAlready" class="mt-4 text-muted warning">Seems like you've added this object to the basket already. If you want to change booking dates please remove from the basket first.</div>
        </div>
    </div>
</template>


<script>
import Availability from "./Availability";
import ReviewList from "./ReviewList";
 
//-------------------------------------------------------------------------------------------------------------------------------------------------------
//  Had to make this a Global Component in directory   resources/js/app/js   because for some reason it wont pick up
//
//  import PriceBreakdown from "./PriceBreakdown";
//-------------------------------------------------------------------------------------------------------------------------------------------------------

import { mapState } from "vuex";


export default {
    components: {
        Availability,
        ReviewList
    },
    data() {
        return {
            bookable: null,
            loading: false,
            price: null
        };
    },
    created() {
        this.loading = true;
        //----------------------------------------------------------------------------------------------------------------------------------------------- 
        //  Read and display the parameter passed on this route
        //
        //  console.log(this.$route.params.id);
        //-----------------------------------------------------------------------------------------------------------------------------------------------     
        
        axios
            .get(`http://leedavidsoncontentmanagementsystem1.com/CodeLaravel7/public/api/bookables/${this.$route.params.id}`).then(response => {
                this.bookable =  response.data.data;    // Using resources nests properties so .data.data needed here
                this.loading = false;
        });
    },
    computed: {    
        ...mapState({
            lastSearch: "lastSearch",

            //-----------------------------------------------------------------------------------------------------------   
            //  "isLoggedIn"    is a Global State so it is available to be made into a computed property on this Index 
            //                  component
            //
            //                  This is used above in the template nav element section to either display the login link 
            //                  or not depending if the user is logged in or not                
            //
            isLoggedIn: "isLoggedIn"   
            //-----------------------------------------------------------------------------------------------------------         
        }),
        inBasketAlready() {
            if(null === this.bookable) {
                return false;
            }

        return this.$store.getters.inBasketAlready(this.bookable.id);
        }
    },
    methods: {
        async checkPrice(hasAvailability) {
        if (!hasAvailability) {
            this.price = null;
            return;
        }

        try {
            this.price = (await axios.get(
            `http://leedavidsoncontentmanagementsystem1.com/CodeLaravel7/public/api/bookables/${this.bookable.id}/price?from=${this.lastSearch.from
            }&to=${this.lastSearch.to}`
        )).data.data;
            } catch (err) {
                this.price = null;
            }
        },
        //-----------------------------------------------------------------------------------------------------------------------------------------------         
        //  This function is called from the Book Now button in the
        //  template above and this function adds this bookable to the Vuex store
        //
        addToBasket() {     
            this.$store.dispatch("addToBasket", {
                bookable: this.bookable,
                price: this.price,
                dates: this.lastSearch      //  This comes from the Vuex bindings so we are using its Global State property lastSearch to get the dates
            });
        },
        //-----------------------------------------------------------------------------------------------------------------------------------------------     
    

        removeFromBasket() {
        this.$store.dispatch("removeFromBasket", this.bookable.id);
        }
    }
};
</script>


<style scoped>
    .warning {
        font-size: 0.7rem;
    }
</style>