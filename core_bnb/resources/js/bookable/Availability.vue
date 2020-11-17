<template>
  <div>
    <h6 class="text-uppercase text-secondary font-weight-bolder">
      Check Availability
      <transition name="fade">
        <span v-if="noAvailability" class="text-danger">(NOT AVAILABLE)</span>
        <span v-if="hasAvailability" class="text-success">(AVAILABLE)</span>
      </transition>
    </h6>

    <div class="form-row">
      <div class="form-group col-md-6">
        <label for="from">From</label>
        <input
          type="text"
          name="from"
          class="form-control form-control-sm"
          placeholder="Start date"
          v-model="from"
          v-on:keyup.enter="check"
          v-bind:class="[{'is-invalid': errorFor('from')}]"
        />
        <v-errors v-bind:errors="errorFor('from')"></v-errors>
      </div>

      <div class="form-group col-md-6">
        <label for="to">To</label>
        <input
          type="text"
          name="to"
          class="form-control form-control-sm"
          placeholder="End date"
          v-model="to"
          v-on:keyup.enter="check"
          v-bind:class="[{'is-invalid': errorFor('to')}]"
        />
        <v-errors v-bind:errors="errorFor('to')"></v-errors>
      </div>
    </div>

    <button class="btn btn-secondary btn-block" v-on:click="check" v-bind:disabled="loading">
      <span v-if="!loading">Check!</span>
      <span v-if="loading">
        <i class="fas fa-circle-notch fa-spin"></i> Checking...
      </span>
    </button>
  </div>
</template>

<script>
import { is422 } from "./../shared/utils/response";
import validationErrors from "./../shared/mixins/validationErrors";

export default {
  mixins: [validationErrors],
  props: {                              //  Use this to pass properties to components
    bookableId: [String, Number]        //  Defined like this because sometimes vue sends back numbers and sometimes strings
  },
  data() {
    return {
      //---------------------------------------------------------------------------------------------------------------------------------
      //  These are to help hold the date entered from local storage on the dom in conjuction with 
      //  beforeCreate() { }   in the   const app = new Vue({ })   in the directory   resources/js/app.js
      //  and   loadStoredState(context) { }   in Availabilty component in directory   resources/js/bookable/Availability.vue
      //
      from: this.$store.state.lastSearch.from,    
      to: this.$store.state.lastSearch.to,       
      //---------------------------------------------------------------------------------------------------------------------------------
      
      loading: false,
      status: null      //  This is the response from running the single action controller BookableAvailabilityController.php
    };
  },
  methods: {
    async check() {
      this.loading = true;
      this.errors = null;

      this.$store.dispatch("setLastSearch", {
        from: this.from,
        to: this.to
      });

      try {
        this.status = (await axios.get(
          `http://leedavidsoncontentmanagementsystem1.com/CodeLaravel7/public/api/bookables/${this.bookableId}/availability?from=${this.from}&to=${this.to}`
        )).status;
        this.$emit("availability", this.hasAvailability);   //  This has to be in both try and catch blocks
      } catch (err) {
        if (is422(err)) {
          this.errors = err.response.data.errors;
        }

        this.status = err.response.status;
        this.$emit("availability", this.hasAvailability);   //  This has to be in both try and catch blocks
      }

      this.loading = false;
    }
  },
  computed: {
    hasErrors() {
      return 422 === this.status && this.errors !== null;
    },
    hasAvailability() {
      return 200 === this.status;
    },
    noAvailability() {
      return 404 === this.status;
    }
  }
};
</script>


<!-- -------------------------------------------------------------------------------------------------------->
<!-- The   scoped   tag ensures this styling is not global styling and instead only affects this component -->
<!-- -->
<style scoped>
label {
  font-size: 0.7rem;
  text-transform: uppercase;
  color: gray;
  font-weight: bolder;
}

.is-invalid {
  border-color: #FF2800;
  background-image: none;
}

.invalid-feedback {
  color: #FF2800;
}
</style>