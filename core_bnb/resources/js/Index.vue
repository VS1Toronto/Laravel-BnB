<template>
    <div>
        <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
            <div class="container">
                <router-link class="navbar-brand" v-bind:to="{name: 'home'}">Laravel BnB</router-link>

                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarsExampleDefault"
                    aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarsExampleDefault">
                    <ul class="navbar-nav mr-auto">
                        <li class="nav-item">
                            <router-link class="nav-link active"  v-bind:to="{name: 'home'}">Home</router-link>
                        </li>
                    </ul>
                    <div>
                        <ul class="navbar-nav mr-auto">
                            <!-- Authentication Links -->
                            <li class="nav-item" v-if="isLoggedIn">
                                <!-- <router-link></router-link> creates an <a></a> tag -->
                                <!-- -->
                                <router-link class="nav-link active"  v-bind:to="{name: 'basket'}">
                                    Basket
                                    <span v-if="itemsInBasket" class="badge badge-secondary">{{ itemsInBasket }}</span>
                                </router-link>
                            </li>

                            <li class="nav-item" v-if="!isLoggedIn">
                                <!-- <router-link></router-link> creates an <a></a> tag -->
                                <!-- -->
                                <router-link v-bind:to="{name: 'register'}" class="nav-link active">Register</router-link>
                            </li>

                            <li class="nav-item" v-if="!isLoggedIn">
                                <!-- <router-link></router-link> creates an <a></a> tag -->
                                <!-- -->
                                <router-link v-bind:to="{name: 'login'}" class="nav-link active">Login</router-link>
                            </li>

                            <li class="nav-item" v-if="isLoggedIn">
                                <!-- <router-link></router-link> creates an <a></a> tag -->
                                <!-- -->
                                <a href="#" v-on:click.prevent="logout" class="nav-link active" >Logout</a>
                            </li>
                        </ul>
                    </div>
                </div>

            </div>
        </nav>


        <div class="container mt-4 mb-4 pr-4 pl-4">

            <!-- --------------------------------------------------------------------------------------- -->
            <!-- Example left for reference to show link on page -->
            <!-- -->
            <!-- <router-link v-bind:to="{name: 'index'}">Index</router-link> -->
            <!-- --------------------------------------------------------------------------------------- -->

            <router-view></router-view>
        </div>

    </div>
</template>


<script>
import { mapState, mapGetters } from "vuex";

//-----------------------------------------------------------------------------------------------------------------------
//  Commented out as we dont need to access the logOut method this way instead we 
//  are dispatching an action targetting the logout action in the Vuex store.js
//
//  import { logOut } from "./shared/utils/auth";
//-----------------------------------------------------------------------------------------------------------------------


export default {
    data() {
        return {
            lastSearch: this.$store.state.lastSearch
        };
    },
    computed: {

        //  ...   is an operator that deconstructs every element of the mapState object and adds it
        //        as a new element to the   computed:   properties object to allow you to add more computed
        //        properties below it in the   computed:   properties object   require('./bootstrap');
        //
        //        ...   takes all the properties from all the objects in
        //              computed: { }  properties and turns them into one object that can be sent on
        //
        //
        //        HOW TO GET THE STATE DATA WHEN CHANGED TO THE VIEW IN REAL TIME FOR THE USER TO SEE ON SCREEN
        //
        //
        //        STEP 1
        //
        //        ...mapState   is effectively a bridge between Vuex and Vue through   computed :   properties        
        //        without this then the Vuex properties may be changed through mutations but Vue will not show
        //        those changes in real time and will always be out of sync however with this bridge the two are
        //        in sync and you can now use the computed properties 
        //
        //
        //        STEP 2
        //
        //        To complete the bridge and show changes to the user through the Vuex and Vue components in real
        //        time persistently we use local storage as a database for the data on the DOM for the user session
        //        to access this we use :
        //
        //                               actions: {}   in the Vuex   store.js   file
        //
        //                               actions: {context}   receive a parameter called a context
        //
        //                               actions: {context, payload}   can receive a second parameter called a payloadS
        //
        //        EXAMPLE :              actions: {
        //                                   setLastSearch(context, payload) {
        //                                       context.commit('setLastSearch', payload);
        //                                       localStorage.setItem('lastSearch', JSON.stringify(payload));
        //                               }
        //
        //        Parameter 1: context Object   -   these actions have a parameter context object which can be used to commit a mutation 
        //        Parameter 2: payload          -   and they can have a parameter called a payload which they can use to read the payload inside the action
        //
        //        Saving the data to Local Storage   -       localStorage.setItem('lastSearch', JSON.stringify(payload));        
        //
        //                                                   'lastSearch' is the KEY
        //                                                   payload      is the VALUE   which must be changed to a JSON String using stringify() to be read        
        //
        //
        //        In the Availability.vue component          methods: {
        //                                                        async check() {
        //                                                        this.loading = true;
        //                                                        this.errors = null;
        //
        //                                                        this.$store.dispatch("setLastSearch", {
        //                                                            from: this.from,
        //                                                            to: this.to
        //                                                        });
        //
        //
        //                                                    you use a   dispatch   to call an   action   rather than a   commit   to call a   mutation   but still with the same payload                                                   
        //
        //
        //
        //        In the store.js
        //
        //                                                    mutations: {
        //                                                       setLastSearch(state, payload) {
        //                                                            state.lastSearch = payload;
        //                                                        }
        //                                                    },
        //                                                    actions: {
        //                                                        setLastSearch(context, payload) {
        //                                                                context.commit('setLastSearch', payload);
        //                                                                localStorage.setItem('lastSearch', JSON.stringify(payload));
        //                                                        },
        //
        //
        //                                                    in   store.js   there is a   mutations: {}   and an   actions: {}   and we are calling the actions: {}   from the Availability.vue component
        //
        //        CALLING THIS ACTION WITH THE   CONTEXT = 'setLastSearch'
        //                          AND WITH THE   PAYLOAD = JSON.stringify(payload)
        //
        //                          NOT ONLY SETS THE   MUTATION   through   context.commit()   for the Vuex and Vue
        //                          BUT ALSO SETS THE   ACTION     through   localStorage.setItem()   which means the payload values are stored in local storage as an Object which are then changed to JSON String through stringify() 
        //                                                         which means they are after this operation and in this example they are   from:   and   to:   values
        //
        //
        //        IN LOCAL STORAGE THE VALUES REMAIN EVEN IF THE PAGE IS REFRESHED UNLESS YOU INPUT NEW VALUES IN THE AVALABILITY COMPONENTS FROM AND TO FIELDS WHICH WOULD THEN REPLACE THE STORED VALUES IN LOCAL STORAGE
        //
        //
        //        STEP 3
        //       
        //        To now complete the action of loading the stored state from local storage to certain properties
        //        we use the action   loadStoredState(context)   this is not done automatically and is called from
        //        the lifecycle hook method   beforeCreate()   in the directory   resources/js/app.js   in the component
        //        const app = new Vue({ )}
        //
        //        We can do this in    resources/js/app.js    because the store object   const store = new Vuex.Store(storeDefinition);
        //        is created in the code some lines before   const app = new Vue({ )}   and some lines of code before that at the top of 
        //        the   resources/js/app.js   script it is all initialised in Bootstrap with this line   require('./bootstrap');   which means
        //        we can use anything i.e. axios or local storage etc - see LAST STEP FOR CODE EXAMPLE BELOW FROM DIRECTORY   resources/js/app.js
        //
        //
        //        ---------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
        //        actions: {
        //          setLastSearch(context, payload) {
        //          context.commit('setLastSearch', payload);
        //          localStorage.setItem('lastSearch', JSON.stringify(payload));
        //        },
        //            
        //        //---------------------------------------------------------------------------------------------
        //        //  This gets called from   resources/js/app.js   and is using the local storage
        //        //  to keep the last search in the   From   and   To   boxes so that the user doesnt
        //        //  have to keep re-typing the date that they already entered for each successive search
        //        //
        //        loadStoredState(context) {
        //        const lastSearch = localStorage.getItem('lastSearch');
        //        if(lastSearch) {
        //              context.commit('setLastSearch', JSON.parse(lastSearch));
        //              }
        //        }
        //        //---------------------------------------------------------------------------------------------
        //        }
        //
        //        ---------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
        //
        //
        //
        //        ---------------------------------------------------------------------
        //        LAST STEP FOR CODE EXAMPLE BELOW FROM DIRECTORY   resources/js/app.js
        //        --------------------------------------------------------------------- 
        //
        //
        //        const app = new Vue({
        //          el: '#app',
        //
        //          //---------------------------------------------------------------------------------------------------
        //          //  ES6 horthand for     routes: routes,
        //          //
        //          router, 
        //          //---------------------------------------------------------------------------------------------------
        //
        //
        //          //---------------------------------------------------------------------------------------------------
        //          //  ES6 shorthand for     store: store,
        //          //
        //          store, 
        //          //---------------------------------------------------------------------------------------------------
        //
        //
        //          //---------------------------------------------------------------------------------------------------
        //          //  Here we tell Vue it should know about the component Index.vue
        //          //
        //          components: {
        //              "index": Index
        //          },
        //          //---------------------------------------------------------------------------------------------------
        //
        //
        //          //---------------------------------------------------------------------------------------------------
        //          //  This is using the local storage to keep the last search in the   From   and   To   boxes 
        //          //  so that the user doesnt have to keep re-typing the date that they already entered for each 
        //          //  successive search and can do this because the   Availability,vue   component has access to
        //          //  $store   and so since   const app = new Vue({ });   is also a vue component it can access it
        //          //  here too
        //          //
        //          beforeCreate() {
        //              this.$store.dispatch("loadStoredState");
        //          }
        //          //---------------------------------------------------------------------------------------------------
        //
        //          });
        //
        //
        ...mapState({
            lastSearchComputed: "lastSearch",

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
        ...mapGetters({
            itemsInBasket: 'itemsInBasket'
        }),
        somethingElse() {
        return 1 + 2;
        }
    },
    methods: {

        //---------------------------------------------------------------------------------------------------------------
        //  LOGOUT METHOD
        //
        //  This has to be async because if you logout you have to tell the backend that it has 
        //  to destroy a session so you have to call a   logout endpoint   in order to acheive this
        //
        async logout() {
            try {
                axios.post("http://leedavidsoncontentmanagementsystem1.com/CodeLaravel7/public/logout");

                //-------------------------------------------------------------------------------------------------------
                //  logOut()   is a function that is an action in the Vuex store.js and so instead of
                //              using an import statement and then calling the logout action in the Vuex
                //              store.js we can instead just dispatch an action here to acheive the same
                //
                this.$store.dispatch("logout");
                //-------------------------------------------------------------------------------------------------------
            } catch(error) {
                this.$store.dispatch("logout");
            }
        }
        //---------------------------------------------------------------------------------------------------------------
    }
};
</script>
