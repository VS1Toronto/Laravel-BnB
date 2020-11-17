import VueRouter from "vue-router";
import Basket from "./basket/Basket.vue";
import Bookable from "./bookable/Bookable";
import Bookables from "./bookables/Bookables";
import Review from "./review/Review";



const routes = [
    {
        path: "/",
        component: Bookables,
        name: "home",
    },
    {
        path: "/bookable/:id",  //  :id   this is telling vue in this view you expect a parameter in the page
        component: Bookable,
        name: "bookable" 
    },
    {
        path: "/review/:id",
        component: Review,
        name: "review"
    },
    {
        path: "/basket",
        component: Basket,
        name: "basket"
    },
    {
        path: "/auth/login",
        component: require("./auth/Login").default,  //  Here we demonstrate using old node syntax to register a component instead of the ES 6 way of importing the component at the top of the script
        name: "login"
    },
    {
        path: "/auth/register",
        component: require("./auth/Register").default,  //  Here we demonstrate using old node syntax to register a component instead of the ES 6 way of importing the component at the top of the script
        name: "register"
    }
];

const router = new VueRouter({

    //---------------------------------------------------------------------------------------------------
    //  Shorthand for     routes: routes,
    //
    routes, 
    //---------------------------------------------------------------------------------------------------    

    //---------------------------------------------------------------------------------------------------
    //  This gets rid of the   #   symbol in the url bar which modern browsers no longer need
    //
    mode: "history",
    //---------------------------------------------------------------------------------------------------    
});


//-------------------------------------------------------------------------------------------------------
//  This makes this available in     resources/js/app.js
//
export default router;
//-------------------------------------------------------------------------------------------------------