<template>
    <div style="padding: 1.25rem">
        <h6 class="text-uppercase text-secondary font-weight-bolder pt-4">Review List</h6>
        <div v-if="loading">Loading...</div>
        <div v-else>
            <!-- d-none   hides the reviews on a small screen and -->
            <!-- d-md-block   has them re-appear when md rating point is reached on a larger screen -->
            <!-- -->
            <div class="border-bottom d-none d-md-block" v-for="(review, index) in reviews" v-bind:key="index">
                <div class="row pt-4">
                    <div class="col-md-6">VS1Toronto</div>
                    <div class="col-md-6 d-flex justify-content-end">
                        {{ review.rating }}

                        <!-- v-bind:rating   changed to   v-bind:value   in order to use v-model -->
                        <!-- -->
                        <star-rating v-bind:value="review.rating" class="fa-lg"></star-rating>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">{{ review.created_at | fromNow }}</div>  <!-- fromNow is a filter -->
                </div>
                <div class="row pt-4 pb-4">
                    <div class="col-md-12">{{ review.content }}</div>
                </div>
            </div>
        </div>
    </div>
</template>


<script>

//----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
//  COMMENTED OUT as this filter has now been made Global in resources/js/app.js
//
//  The ./ relative path is not necessary here because the Moment module is in the node modules directory
//
//  import moment from "moment"
//----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------

export default {
    //  props()   Use this method to pass properties to components
    //
    props: {
        bookableId: [String, Number]   //  Defined like this because sometimes vue sends back numbers and sometimes strings
    },

    //  data()   method has to always return an object
    //
    data() {
        return {
            loading: false,     //  This will be signaling if we are loading something from the API
            reviews: null       //  This will be populated with the data loaded from the server
        }
    },

    //  created()    this lifecycle method is the method to use when triggering the loading from the server
    //
    created() {
        this.loading = true;    //  Signals on screen we are loading something from the API
        axios.get(`http://leedavidsoncontentmanagementsystem1.com/CodeLaravel7/public/api/bookables/${this.bookableId}/reviews`)    //  use Axios to get something from a particular URL
        .then(response => this.reviews = response.data.data)     //  response.data   is the data actually returned from the server but our data also has a property of the JSON called data so we need response.data.data
        .then(() => (this.loading = false));
    },


    //------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
    //  COMMENTED OUT as this filter has now been made Global in resources/js/app.js
    //
    //  filters:    this allows us to use moment() functions in the template
    //
    //  filters:    has been made Global by adding it to resources/js/app.js
    //
    //  filters: {
    //      fromNow(value) {
    //      return moment(value).fromNow();
    //      }
    //  }
    //------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
}
</script>