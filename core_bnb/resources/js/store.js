import { isLoggedIn, logOut } from "./shared/utils/auth";
import { defaultsDeep } from "lodash";

export default {
    state: {
        lastSearch: {
            from: null,
            to: null
        },
        basket: {
            items: []
        },
        isLoggedIn: false,
        user: {}            //  We need this object because we want the user data to be loaded every time the appliaction is booted
    },
    mutations: {            //  Mutations change the state of the data
        setLastSearch(state, payload) {
            state.lastSearch = payload;
        },
        addToBasket(state, payload) {
            state.basket.items.push(payload);       //  STATE has basket, BASKET has items, and we PUSH payload into items
        },
        removeFromBasket(state, payload) {
            state.basket.items = state.basket.items.filter(item => item.bookable.id !== payload);       //  This will keep everything that is not the payload in the basket and get rid of the payload
        },
        setBasket(state, payload) {             //  This sets all the items
            state.basket = payload;
        },
        setUser(state, payload) {
            state.user = payload;
        },
        setLoggedIn(state, payload) {
            state.isLoggedIn = payload;
        }
    },
    actions: {       //  Actions can have side effects or asynchronous operations
        setLastSearch(context, payload) {
            context.commit('setLastSearch', payload);
            localStorage.setItem('lastSearch', JSON.stringify(payload));
        },

        //--------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
        //  This gets called from   resources/js/app.js   and is using the local storage
        //  to keep the last search in the   From   and   To   boxes so that the user doesnt
        //  have to keep re-typing the date that they already entered for each successive search
        //
        loadStoredState(context) {
            const lastSearch = localStorage.getItem('lastSearch');
            if (lastSearch) {
                context.commit('setLastSearch', JSON.parse(lastSearch));
            }

            //----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
            // This is using the setBasket Mutation to set all items in the basket
            //
            const basket = localStorage.getItem('basket');
            if (basket) {
                context.commit('setBasket', JSON.parse(basket));
            }
            //----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------

            //----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
            //  To avoid the delay in the header bar options appearing when we refresh we set the mutation   setLoggedIn   and call the function   isLoggedIn()   
            //
            context.commit("setLoggedIn", isLoggedIn());
            //----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------

        },
        //--------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
    

        addToBasket({ commit, state }, payload) {       //  Here we use ES6 functionality to pass an Object so that we have access to its properties
            // context.state, context.commit

            //  The context variable above has a State which can be
            //  read and a commit() method which a used to commit a mutation
            //
            commit('addToBasket', payload);
            localStorage.setItem('basket', JSON.stringify(state.basket));
        },
        removeFromBasket({ commit, state }, payload) {
            commit('removeFromBasket', payload);
            localStorage.setItem('basket', JSON.stringify(state.basket));
        },
        clearBasket({ commit, state }, payload) {
            commit("setBasket", { items: [] });
            localStorage.setItem("basket", JSON.stringify(state.basket));
        },
        async loadUser({ commit, dispatch }) {
            if (isLoggedIn()) {
                try {
                    const user = (await axios.get("http://leedavidsoncontentmanagementsystem1.com/CodeLaravel7/public/user")).data;
                    commit("setUser", user);
                    commit("setLoggedIn", true);
                } catch (error) {
                    dispatch("logout");
                }
            }
        },
        logout({ commit }) {
            commit("setUser", {});
            commit("setLoggedIn", false);
            logOut();
        }
    },
    //------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
    //  GETTERS PROPERTY
    //
    //  The simplest explanation of this   getters: {}   property
    //  it is the same as computed: {}   properties only for Vuex
    //
    getters: {
        itemsInBasket: (state) => state.basket.items.length,

        //--------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
        //  This is a HIGHER FUNCTION it is a function within a function
        //  that returns a function and this process is known as Compostion
        //
        //  This was moved here from Bookable.vue component to have just this single function that can be 
        //  accessed anywhere in the application rather than having lots of these individual functions everywhere
        //
        inBasketAlready(state) {
            return function (id) {
                //------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------         
                //  This returns the result of whether the basket has anything in it or not and uses the   
                //  reduce()   method to turn any result into a counted number of cells of the array of objects
                //
                return state.basket.items.reduce(
                    (result, item) => result || item.bookable.id === id,
                    false
                );
                //------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------ 
            }
        }
    }
    //------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
};